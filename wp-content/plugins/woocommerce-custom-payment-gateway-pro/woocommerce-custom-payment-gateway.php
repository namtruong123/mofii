<?php
/* @wordpress-plugin
 * Plugin Name:       WooCommerce Custom Payment Gateway Pro
 * Plugin URI:        https://wpruby.com/plugin/woocommerce-custom-payment-gateway-pro/
 * Description:       Make your own custom payment gateway.
 * Version:           3.1.0
 * WC requires at least: 3.0
 * WC tested up to: 9.7
 * Requires Plugins: woocommerce
 * Author:            WPRuby
 * Author URI:        https://wpruby.com
 * Text Domain:       woocommerce-custom-payment-gateway
 * Domain Path: /languages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


if (!defined('ABSPATH')) {
	exit;
}
update_option('wc_custompayment_license_key', 'weadown*-****-****-****-*********com');
update_option('wc_custompayment_license_key_license_status', 'valid');
add_filter('pre_http_request', function ($pre, $parsed_args, $url) {
	if (strpos($url, 'https://wpruby.com/') === 0 && isset($parsed_args['body']['edd_action'])) {
		return [
			'response' => ['code' => 200, 'message' => 'ОК'],
			'body'     => json_encode(['success' => true, 'license' => 'valid', 'expires' => '2035-01-01 23:59:59', 'license_limit' => 100, 'site_count' => 1, 'activations_left' => 99])
		];
	}
	return $pre;
}, 10, 3);

use Automattic\WooCommerce\Utilities\OrderUtil;
use Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController;
use Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry;

const CUSTOM_PAYMENT_CURRENT_VERSION = '3.1.0';

class Custom_Payment_Pro{

	/**
	 * The single instance of the class.
	 */
	protected static $_instance = null;
	/**
	 * @return Custom_Payment_Pro
	 */
	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/**
	 * Custom_Payment_Pro constructor.
	 */
	public function __construct() {
	    if(!$this->is_woocommerce_active()){
	        return;
        }

	    $this->load_dependencies();
	    $this->handle_license_and_updates();

		spl_autoload_register(array($this, 'load_fields'));

		add_action( 'wp_ajax_custom_payment_file_upload', [$this, 'custom_payment_file_upload'] );
		add_action( 'wp_ajax_nopriv_custom_payment_file_upload', [$this, 'custom_payment_file_upload'] );

		add_filter('woocommerce_payment_gateways', array($this,  'add_custom_payment_gateway'));
		add_action( 'plugins_loaded', array($this,  'activate_old_license') );
		add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain') );
		add_action('plugins_loaded', array($this, 'init_custom_payment_gateway'));
		add_action( 'admin_init', array($this, 'admin_css'));
		add_action( 'admin_enqueue_scripts', array($this, 'admin_js'));
		add_action( 'wp_enqueue_scripts', array($this, 'frontend_css') );
		add_action( 'add_meta_boxes', array($this, 'woocommerce_payment_information'), 1, 2 );
		add_action('woocommerce_thankyou', array($this, 'add_customer_note_to_thank_you_page'));
		add_action('woocommerce_email_order_details', array($this, 'add_payment_information_to_emails'), 10, 2);
		// support for the WCFM plugin.
		add_action( 'woocommerce_email_order_meta', array($this, 'wcfm_footer'), 10, 4 );
		// support for the WCPDF plugin.
		add_action('wpo_wcpdf_after_document', array($this, 'add_payment_information_to_invoice'), 10, 2);
		add_action( 'before_woocommerce_init', [$this, 'declare_hpos_support']);

	}



	public function declare_hpos_support()
	{
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}

	public function wcfm_footer($order, $sent_to_admin, $plain_text, $email)
	{
		if ( $email->id !== 'store-new-order' ) {
			return;
		}

		$this->add_payment_information_to_emails($order, boolval($sent_to_admin));

	}

    public function add_payment_information_to_invoice($document_type, $order) {
	    $this->add_payment_information_to_emails($order, false);
    }

	public function add_payment_information_to_emails($order, $sent_to_admin)
    {
		// Make sent_to_admin an option.
		if (get_option('show_payment_data_in_email') !== 'yes' /**  && $sent_to_admin == false*/){
		    return;
		}
        /** @var WC_Order $order */
        $order_id = $order->get_id();
        $customer_note =	$order->get_meta('woocommerce_customized_customer_note');
        $data = $order->get_meta('woocommerce_customized_payment_data');

        // In case the "Store Payment Information in the Database" was disabled.
        if (!$data && isset($GLOBALS['woocommerce_customized_payment_data'])) {
            $data = $GLOBALS['woocommerce_customized_payment_data'];
        }

        if($data){ ?>
            <h2><?php _e('Submitted Payment Information', 'woocommerce-custom-payment-gateway'); ?>:</h2>
            <table>
                <tbody>
				<?php if(isset($data['payment_method_title'])): ?>
					<tr>
						<th style="width:150px; !important;"><strong><?php _e('Payment Method', 'woocommerce-custom-payment-gateway'); ?></strong></th>
						<td>
							<?php echo $data['payment_method_title']; ?>
						</td>
					</tr>
				<?php endif; ?>
                <?php if(isset($data['data'])):
                    $this->display_data($data, true);
                else:
                    $this->display_legacy_data($data);
                endif; ?>
                </tbody>
            </table>
        <?php	}
        if($customer_note){  echo '<br>'.$customer_note; }
	}

	public function add_customer_note_to_thank_you_page($order_id){
		$order = wc_get_order($order_id);
		$customer_note =	$order->get_meta('woocommerce_customized_customer_note');
		if($customer_note){
			echo '<p>'	. $customer_note . '</p>';
		}
	}


	public function custom_payment_file_upload()
    {
        if (!isset($_GET['nonce'])) {
            die;
        }

	    if ( ! wp_verify_nonce( $_GET['nonce'], 'custom_payment_file_upload' ) ) {
		    die;
	    }

		if ( ! function_exists( 'wp_handle_upload' ) )  {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$fileKey = sanitize_text_field($_POST['file_key']);

        if (!isset($_FILES[$fileKey])) {
            die;
        }

		$uploaded_file = $_FILES[$fileKey];
		$overrides =[
            'action' => 'custom_payment_file_upload',
            'test_type' => true,
            'test_size' => true
        ];
		$move_file = wp_handle_upload( $uploaded_file, $overrides );
		if ( isset($move_file['url']) ) {
			echo $move_file['url'];

		}
		die;
	}

	public function admin_js($hook){
		if('woocommerce_page_wc-settings' === $hook){
			wp_enqueue_script( 'custompayment', plugins_url( "includes/assets/js/custompayment.js", __FILE__ ) , array( 'jquery', 'jquery-ui-sortable', 'jquery-ui-accordion' ), CUSTOM_PAYMENT_CURRENT_VERSION, true );
		}
	}

	public function frontend_css() {
		if(is_checkout()){
			wp_enqueue_script('jquery-ui-datepicker');
			wp_enqueue_script('custom_payment_front_js',plugins_url('includes/assets/js/custom-payment-front.js', __FILE__), ['jquery-ui-datepicker'], CUSTOM_PAYMENT_CURRENT_VERSION );
			wp_localize_script( 'custom_payment_front_js', 'custom_payments',
				[
					'custom_payment_upload_file_nonce' => wp_create_nonce('custom_payment_file_upload'),
				]
			);
			wp_enqueue_script('signature_pad',plugins_url('includes/assets/js/signature_pad.min.js', __FILE__) );
			wp_enqueue_style( 'jquery-ui-datepicker-style' , '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/flick/jquery-ui.css');
			wp_enqueue_style( 'custom_payment_front_css', plugins_url('includes/assets/css/front.css', __FILE__), [], CUSTOM_PAYMENT_CURRENT_VERSION );
			wp_enqueue_style( 'hint-css', plugins_url('includes/assets/css/hint.min.css', __FILE__) );
            // Blocks
            wp_enqueue_style( 'wc-custom-payment-css', plugins_url('blocks/build/style-index.css', __FILE__));
		}
	}


    public function init_custom_payment_gateway(){
		require_once 'class-woocommerce-custom-payment-gateway.php';
	    require_once plugin_dir_path(__FILE__). 'includes/class-custom-payment-logger.php';
	    require_once plugin_dir_path(__FILE__). 'includes/CustomPaymentUpgrades.php';
		require_once plugin_dir_path(__FILE__). 'includes/gateway-classes-generator.php';
		require_once plugin_dir_path(__FILE__). 'includes/fields/class-custom-payment-field.php';
		require_once plugin_dir_path(__FILE__). 'includes/fields/class-signature-field.php';
	}

    public function admin_css() {
		wp_enqueue_style( 'custom_payment_admin_css', plugins_url('includes/assets/css/admin.css', __FILE__) );
	}
    public function load_plugin_textdomain() {
		load_plugin_textdomain( 'woocommerce-custom-payment-gateway', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public function add_custom_payment_gateway( $gateways ){
		$gateways['wpruby_wc_custom'] = 'WC_Custom_Payment_Gateway';
		$stored_gateways = json_decode(get_option('wpruby_generated_custom_gatwayes'));

		if($stored_gateways){
			foreach($stored_gateways as $gateway){
				$gateway->name =  'custom_' . md5($gateway->name);
				$gateways[ $gateway->name ] =  $gateway->name;
			}
		}
		return $gateways;
	}

	public function activate_old_license(){
		if ( get_option( 'custom_payment_103_version' ) != 'upgraded' ) {
			// 1.0.3 activate the license for old customers
			if(get_option('wc_custompayment_license_key') != false){
				add_option('wc_custompayment_license_key_license_status', 'valid') or update_option('wc_custompayment_license_key_license_status', 'valid');
			}
			add_option( "custom_payment_103_version", 'upgraded' );
		}
	}

	private function is_woocommerce_active(){
		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() )
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

		return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins );
    }

	public function woocommerce_payment_information( $post_type, $post ) {
		$order = ( $post instanceof WP_Post ) ? wc_get_order( $post->ID ) : $post;

		if (!$order) {
			return;
		}

		if (isset($_GET['delete_payment']) && $_GET['delete_payment'] == 'true') {
			$order->delete_meta_data('woocommerce_customized_payment_data');
			$order->save_meta_data();
		}

		$data = $order->get_meta('woocommerce_customized_payment_data');

		$screen = wc_get_container()->get( CustomOrdersTableController::class )->custom_orders_table_usage_is_enabled()
			? wc_get_page_screen_id( 'shop-order' )
			: 'shop_order';

		if ($data) {
			add_meta_box(
				'woocommerce_customized_payment_gateway',
				__( 'Payment Information' , 'woocommerce-custom-payment-gateway'),
				array($this, 'render_woocommerce_payment_information_metabox'),
				$screen,
				'normal',
				'high'
			);
		}
	}

	public function render_woocommerce_payment_information_metabox( $order ){

        if ($order instanceof WP_Post) {
            $data = get_post_meta( $order->ID, 'woocommerce_customized_payment_data', true );
        } else {
            $data = $order->get_meta('woocommerce_customized_payment_data');
        }

		if ($data) { ?>
            <h2>Order #<?php echo $order->get_id(); ?> <?php _e('Submitted Payment Information', 'woocommerce-custom-payment-gateway'); ?>.</h2>
            <table class="wp-list-table widefat fixed striped posts">
                <tbody>
		            <?php if(isset($data['data'])):
                        $this->display_data($data);
                     else:
                        $this->display_legacy_data($data);
                   endif; ?>
                </tbody>
            </table><br>

            <a style="color:#a00;" onclick="if(!confirm('Are you sure that you want to delete payment information?')){return false;}" href="<?php echo admin_url('post.php?post='. $order->get_id() .'&action=edit&delete_payment=true') ?>">Delete Information</a>

		<?php	}
	}

	private function load_dependencies() {
		if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			include( dirname( __FILE__ ) . '/includes/EDD_SL_Plugin_Updater.php' );
		}
		if(!class_exists('WPRuby_Licence_Handler')){
			include( dirname( __FILE__ ) . '/includes/WPRuby_Licence_Handler.php' );
		}
		if(!class_exists('Generate_Custom_Payment_Gateways')){
			add_filter('woocommerce_get_settings_pages', 'wpruby_add_custom_payment_settings_tab');
			function wpruby_add_custom_payment_settings_tab($pages){
				$pages[] = include( dirname( __FILE__ ) . '/includes/classes/class-generate-custom-payment-gateways.php' );
				return $pages;
			}
		}
	}

	private function handle_license_and_updates()
    {

		$item_name = 'WooCommerce Custom Payment Gateway Pro';
        // Licence Handler
		$license_handler = new WPRuby_Licence_Handler('wc_custompayment_license_key');
		$license_handler->setPage('wc-settings');
		$license_handler->setSection('custom_payment');
		$license_handler->setReturnUrl(admin_url('admin.php?page=wc-settings&tab=checkout&section=custom_payment'));
		$license_handler->setPluginName($item_name);

        // Update Handler
		$license_key = trim( get_option( 'wc_custompayment_license_key' ) );
		$edd_updater = new EDD_SL_Plugin_Updater( 'https://wpruby.com/edd_sl/woocommerce-custom-payment-gateway', __FILE__, array(
			'version' 	=> CUSTOM_PAYMENT_CURRENT_VERSION,		// current version number
			'license' 	=> $license_key,	// license key (used get_option above to retrieve from DB)
			'item_name' => $item_name,	// name of this plugin
			'author' 	=> 'Waseem Senjer',	// author of this plugin
			'url'       => home_url()
		));
	}

	public function load_fields($class_name){
		$class_name = str_replace( '_', '-', strtolower( $class_name ) );
		$class_path = plugin_dir_path( __FILE__ ) . 'includes/fields/class-' . $class_name . '.php';
		$interface_path = plugin_dir_path( __FILE__ ) . 'includes/fields/interface-' . $class_name . '.php';
		if ( file_exists( $class_path ) ) {
			require_once( $class_path );
		}
		if ( file_exists( $interface_path ) ) {
			require_once( $interface_path );
		}
	}

	private function display_legacy_data($data) {
         foreach ($data as $key => $value) { ?>
            <tr>
                <th style="width:150px; !important;"><strong><?php echo $key; ?></strong></th>
                <td>
                    <?php if($key == "Card Number"){
                        echo str_replace(" ", "", $value);
                    }else{
                        if (strpos($value, 'data:image/png') === 0){
                            echo '<img style="width:100%; background:#ffffff; border:1px dashed #000000;" alt="signature" src="'. $value .'" />';
                        }else {
                            echo $value;
                        }
                    }
                    ?>
                </td>
            </tr>
        <?php }
	}

	/**
	 * @param array $array
	 *
	 * @return mixed|null
	 */
	private function get_label($array){
	    if(function_exists('array_key_first')){
		    return array_key_first($array);
	    }else {
		    return count($array) ? array_keys($array)[0] : null;
	    }
    }

	private function display_data( $data, $maskCreditCard = false ) {
		foreach ($data['data'] as $key => $row) {

		    $label = $this->get_label($row);
			$value = $row[$label];
		    ?>
            <tr>
                <th style="width:150px; !important;"><strong><?php echo $label; ?></strong></th>
                <td>
					<?php if($label == "Card Number"){
                        if ($maskCreditCard) {
	                        echo 'XXXX-XXXX-XXXX-'.substr(trim($value),-4);
                        }else{
                            echo $value;
                        }
					}else{
						if (strpos($value, 'data:image/png') === 0){
							echo '<img style="width:60%; background:#ffffff; border:1px dashed #000000;" alt="signature" src="'. $value .'" />';
						} elseif (strpos(strtolower($value), 'http') === 0) {
                            echo '<a class="button-secondary" href="'. $value .'" target="_blank"><span class="dashicons dashicons-download" style="margin-top:5px;"></span></a>';
						} else {
							echo $value;
						}
					}
					?>
                </td>
            </tr>
		<?php }
	}
}

add_action( 'woocommerce_blocks_loaded',  function () {

    require_once plugin_dir_path(__FILE__). 'blocks/class-custom-payment-block.php';

    add_action(
        'woocommerce_blocks_payment_method_type_registration',
        function( PaymentMethodRegistry $payment_method_registry ) {
            $payment_method_registry->register( new Custom_Payment_Block );
            $gateways = json_decode(get_option('wpruby_generated_custom_gatwayes'));
            if (!empty($gateways)) {
                foreach ($gateways as $gateway) {
                    $block = new Custom_Payment_Block(substr( 'custom_' . md5($gateway->name), 0, 22));
                    $payment_method_registry->register( $block );
                }
            }
        }
    );


});


add_action( 'before_woocommerce_init', function() {
	if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );
	}
} );

Custom_Payment_Pro::get_instance();

