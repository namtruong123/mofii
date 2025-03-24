<?php


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Allows users to add more than one gateway.
 *
 * @author Waseem
 * @since 1.2.0
 */
class Generate_Custom_Payment_Gateways extends WC_Settings_Page {


    public function __construct(){
        $this->id    = 'custom_gateways';
        $this->label = __( 'Custom Payment Gateways', 'woocommerce-custom-payment-gateway' );

        add_filter( 'woocommerce_settings_tabs_array', array($this, 'add_settings_tab'), 50 );
        add_action( 'woocommerce_settings_tabs_custom_payment', array($this, 'settings_tab') );
        add_action( 'woocommerce_update_options_custom_payment', array($this, 'update_settings') );
        add_action( 'woocommerce_admin_field_gateways_table', array($this, 'gateways_table_setting') );
        if(isset($_POST['wc_gateway_name']) && trim($_POST['wc_gateway_name']) !== ''){
            global $current_user;
            $gateways = json_decode(get_option('wpruby_generated_custom_gatwayes'), true);
            $gateways[trim($_POST['wc_gateway_name'])]['name'] = trim($_POST['wc_gateway_name']);
            $gateways[trim($_POST['wc_gateway_name'])]['created_on'] = time();
            $gateways[trim($_POST['wc_gateway_name'])]['created_by'] = $current_user->user_login;
            update_option('wpruby_generated_custom_gatwayes', json_encode($gateways));
        }
        if(isset($_GET['action']) == 'delete'){
            if(isset($_GET['gateway'])){
                $gateways = json_decode(get_option('wpruby_generated_custom_gatwayes'), true);
                $gateways = array_filter($gateways, function ($gateway) {
                    return $gateway['name'] != $_GET['gateway'];
                });
                update_option('wpruby_generated_custom_gatwayes', json_encode($gateways));
                wp_redirect(admin_url('admin.php?page=wc-settings&tab=custom_payment'));
                exit;
            }
        }
    }
    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public function add_settings_tab( $settings_tabs ) {
        $settings_tabs['custom_payment'] = __( 'Custom Payment Gateways', 'woocommerce-custom-payment-gateway' );
        return $settings_tabs;
    }
    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses $this->get_settings()
     */
    public function settings_tab() {
        $this->name = '';

        woocommerce_admin_fields( $this->get_settings() );
        $this->name = '';

    }
    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses $this->get_settings()
     */
    public function update_settings() {
        woocommerce_update_options( $this->get_settings() );
    }
    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public function get_settings()
    {

        return [

            'title_gateways_options' => [
                'title' => __( 'Settings', 'woocommerce-custom-payment-gateway' ),
                'type' => 'title',
                'id' => 'title_gateways_options'
            ],

            'show_payment_data_in_email' => [
                'title'    => __( 'Add payment info to emails', 'woocommerce-custom-payment-gateway' ),
                'desc'     => __( 'Enable this to add the payment information submitted by customers to purchase WooCommerce emails.', 'woocommerce-custom-payment-gateway' ),
                'id'       => 'show_payment_data_in_email',
                'type'     => 'checkbox',
                'default'  => 'no',
                'autoload' => true,
            ],
            'store_payment_information' => [
	            'title'    => __( 'Store Payment Information in the Database', 'woocommerce-custom-payment-gateway' ),
	            'desc'     => __( 'Please, disable this only if you are sending the payment information to an API. Otherwise, orders will have no payment information associated with them. You can also find the payment information in the order email sent to the administrator.', 'woocommerce-custom-payment-gateway' ),
	            'id'       => 'store_payment_information',
	            'type'     => 'checkbox',
	            'default'  => 'yes',
	            'autoload' => true,
            ],
	        [
                'type' => 'sectionend',
                'id' => 'title_gateways_options'
	        ],
            'title' => [
                'title' => __( 'Add new Custom Gateway', 'woocommerce-custom-payment-gateway' ),
                'type' => 'title',
                'id' => 'add_gateway'
            ],
	        [
                'type' => 'sectionend',
                'id' => 'add_gateway'
	        ],

            'name' => [
                'title'    => __( 'Gateway Name', 'woocommerce-custom-payment-gateway' ),
                'desc'     => __( 'Enter the name of the required gateway then click on Save Changes.', 'woocommerce-custom-payment-gateway' ),
                'id'       => 'wc_gateway_name',
                'type'     => 'text',
                'css'      => 'min-width:300px; margin-bottom:30px;',
                'default'  => '',
                'autoload' => true,
                'desc_tip' => true,
                'value'    => '',
            ],

            'title_gateways_table' => [
                'title' => __( 'Custom Gateways', 'woocommerce-custom-payment-gateway' ),
                'type' => 'title',
                'id' => 'add_gateways'
            ],
            [
                'type' => 'sectionend',
                'id' => 'add_gateways'
            ],
            'generated_gateways' => [
                'type' => 'gateways_table'
            ],
        ];
    }


    public function gateways_table_setting()
    {
        $gateways = json_decode(get_option('wpruby_generated_custom_gatwayes'));
        $default_gateway_settings = get_option('woocommerce_custom_payment_settings');
        ?>
        <tr valign="top">
            <td class="wc_emails_wrapper" colspan="2">
                <table class="wc_emails widefat" cellspacing="0">
                    <thead>
                        <tr>
                            <?php
                                $columns = apply_filters( 'woocommerce_custom_gateways_setting_columns', array(
                                    'status'     => '',
                                    'name'       => __( 'Gateway Name', 'woocommerce' ),
                                    'id'       => __( 'ID', 'woocommerce' ),
                                    'created_by'       => __( 'Created By', 'woocommerce' ),
                                    'created_on'       => __( 'Created On', 'woocommerce' ),
                                    'actions'    => __('Actions', 'woocommerce'),
                                ) );
                                foreach ( $columns as $key => $column ) {
                                    echo '<th class="wc-email-settings-table-' . esc_attr( $key ) . '">' . esc_html( $column ) . '</th>';
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td class="wc-email-settings-table-status">
                                <?php
                                    if (is_array($default_gateway_settings) && $default_gateway_settings['enabled'] == 'yes')
                                        echo '<span class="status-enabled tips" data-tip="' . __( 'Enabled', 'woocommerce' ) . '">' . __( 'Yes', 'woocommerce' ) . '</span>';
                                    else
                                        echo '<span class="status-disabled tips" data-tip="' . __( 'Disabled', 'woocommerce' ) . '">' . __( 'No', 'woocommerce' ) . '</span>';
                                ?>
                            </td>

                            <td class="wc-email-settings-table-name">
                                <a href="<?php echo admin_url('admin.php?page=wc-settings&tab=checkout&section=custom_payment'); ?>">Custom Payment Pro</a>
                            </td>
                            <td class="wc-email-settings-table-name">
                                custom_payment
                            </td>
                            <td class="wc-email-settings-table-created_by">-</td>
                            <td class="wc-email-settings-table-created_on">-</td>
                            <td style="width:200px;">
                                <a class="button tips" href="<?php echo admin_url('admin.php?page=wc-settings&tab=checkout&section=custom_payment'); ?>"><?php _e('Configure','woocommerce'); ?></a>
                            </td>
                        </tr>
                        <?php
                        if($gateways){
                        foreach ( $gateways as $gateway_key => $gateway ) {
                            $class_name =  'custom_' . md5($gateway->name);
                            $gateway_settings = get_option('woocommerce_'.$class_name.'_settings');
                            $user = get_user_by('login', $gateway->created_by);
                            $gateway_title = (isset($gateway_settings['title']))?$gateway_settings['title']:$gateway->name;
                            echo '<tr>';
                            foreach ( $columns as $key => $column ) {

                                switch ( $key ) {
                                    case 'name' :
                                        echo '<td class="wc-email-settings-table-' . esc_attr( $key ) . '">
                                            <a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=' . strtolower( $class_name ) ) . '">' . $gateway_title . '</a>
                                        </td>';
                                    break;
                                    case 'id':
	                                    echo '<td class="wc-email-settings-table-' . esc_attr( $key ) . '">
                                            '. substr($class_name, 0, 22) .'
                                        </td>';
                                        break;
                                    case 'status' :
                                        echo '<td class="wc-email-settings-table-' . esc_attr( $key ) . '">';
                                        if($gateway_settings){
                                            if($gateway_settings['enabled'] == 'yes')
                                                echo '<span class="status-enabled tips" data-tip="' . __( 'Enabled', 'woocommerce' ) . '">' . __( 'Yes', 'woocommerce' ) . '</span>';
                                            else
                                                echo '<span class="status-disabled tips" data-tip="' . __( 'Disabled', 'woocommerce' ) . '">' . __( 'No', 'woocommerce' ) . '</span>';
                                        } else{
                                            echo '<span class="status-disabled tips" data-tip="' . __( 'Disabled', 'woocommerce' ) . '">' . __( 'No', 'woocommerce' ) . '</span>';
                                        }
                                        echo '</td>';
                                    break;
                                    case 'actions' :
                                        echo '<td style="width:200px;">
                                            <a class="button tips" data-tip="' . __( 'Configure', 'woocommerce' ) . '" href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=' . strtolower( $class_name ) ) . '">' . __( 'Configure', 'woocommerce' ) . '</a>
                                            <a style="color:red;" class="button" onclick="if(!window.confirm(\'Are you sure that you want to delete this gateway?\')) return false;" href="' . admin_url( 'admin.php?page=wc-settings&tab=custom_payment&action=delete&gateway=' . urlencode( $gateway->name ).'&noheader=true' ) . '">' . __( 'Delete', 'woocommerce' ) . '</a>
                                        </td>';
                                    break;
                                    case 'created_by' :
                                       if(!$user) {
                                           echo '<td class="wc-email-settings-table-' . esc_attr( $key ) . '">-</td>';
                                       } else {
                                           echo '<td class="wc-email-settings-table-' . esc_attr( $key ) . '">
                                            <a href="' . admin_url( 'user-edit.php?user_id=' .  $user->ID ) . '">' . $gateway->created_by . '</a>
                                        </td>';
                                       }
                                    break;
                                    case 'created_on' :
                                        echo '<td class="wc-email-settings-table-' . esc_attr( $key ) . '">
                                        '.date('d/m/Y H:i:s',$gateway->created_on).'
                                        </td>';
                                    break;
                                    default :
                                    break;
                                }
                            }

                            echo '</tr>';
                        }
                        }
                        ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <script>jQuery(function($){  $('#wc_gateway_name').val('');  })</script>
        <?php
    }
}
return new Generate_Custom_Payment_Gateways();
