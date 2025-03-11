<?php
namespace Ecomus\Addons\Elementor\AJAX;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Products {
	use \Ecomus\Addons\WooCommerce\Products_Base;

	/**
	 * The single instance of the class
	 */
	protected static $instance = null;

	/**
	 * Product card layout
	 */
	protected static $product_card_layout = null;

	/**
	 * Initialize
	 */
	static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'wp_ajax_nopriv_ecomus_get_products_tab', [ $this, 'ajax_get_products_tab' ] );
		add_action( 'wp_ajax_ecomus_get_products_tab', [ $this, 'ajax_get_products_tab' ] );
		add_action( 'wc_ajax_ecomus_get_products_tab', [ $this, 'ajax_get_products_tab' ] );

		// Add to cart
		add_action( 'wc_ajax_ecomus_ajax_add_to_cart', [ $this, 'ajax_add_to_cart' ] );

		// Products without Load more button
		add_action( 'wc_ajax_ecomus_elementor_load_products', [ $this, 'elementor_load_products' ] );
	}

	/**
	 * Ajax load products tab
	 */
	public function ajax_get_products_tab() {
		if ( empty( $_POST['atts'] ) ) {
			wp_send_json_error( esc_html__( 'No query data.', 'ecomus-addons' ) );
			exit;
		}

		$output = self::render_products( $_POST['atts'] );

		wp_send_json_success( $output );
	}

	/**
	 * Ajax add to cart
	 */
	public function ajax_add_to_cart() {
		if ( empty( $_POST['action'] ) ) {
			return;
		}

		if( $_POST['action'] !== 'ecomus_ajax_add_to_cart' ) {
			return;
		}

		wc_nocache_headers();

		$products = (array) json_decode( stripslashes( $_POST['data_products'] ), true );
		$quantity = 1;
		$success = false;

		foreach ( $products as $product ) {
            if( $product['type'] == 'variable' ) {
				$variation_id  = $product['variation_id'];
				$variation  = $product['variation_attributes'];
				$adding_to_cart = wc_get_product( $variation_id );

				if ( $adding_to_cart ) {
					$product_id = $adding_to_cart->get_parent_id();
					if( false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) ) {
						wc_add_to_cart_message( array( $product_id => $quantity ), true );
						$success = true;
					}
				}
			} else {
				if( false !== WC()->cart->add_to_cart( $product['product_id'], $quantity ) ) {
					wc_add_to_cart_message( array( $product['product_id'] => $quantity ), true );
                    $success = true;
				}
			}

			if( ! $success ) {
				break;
			}
		}

		wp_send_json( $success );
		die();
	}

	/**
	 * Load products
	 *
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function elementor_load_products() {
		$settings = $_POST['settings'];

		$atts = array(
			'type'     => isset( $settings['type'] ) ? $settings['type'] : '',
			'columns'  => isset( $settings['columns'] ) ? intval( $settings['columns'] ) : '',
			'products' => isset( $settings['products'] ) ? $settings['products'] : '',
			'order'    => isset( $settings['order'] ) ? $settings['order'] : '',
			'orderby'  => isset( $settings['orderby'] ) ? $settings['orderby'] : '',
			'per_page' => isset( $settings['per_page'] ) ? intval( $settings['per_page'] ) : '',
			'limit'    => isset( $settings['limit'] ) ? intval( $settings['limit'] ) : '',
			'category' => isset( $settings['category'] ) ? $settings['category'] : '',
			'tag'      => isset( $settings['tag'] ) ? $settings['tag'] : '',
			'brand'    => isset( $settings['brand'] ) ? $settings['brand'] : '',
			'page'     => isset( $_POST['page'] ) ? $_POST['page'] : 1,
			'paginate' => true,
		);

		$settings['per_page'] = empty($settings['per_page']) ? $settings['limit']: $settings['per_page'];
		$settings['page']     = isset( $_POST['page'] ) ? $_POST['page'] : 1;
		$settings['paginate'] = true;

		$results = self::products_shortcode( $settings );

		if ( ! $results ) {
			return;
		}

		if( isset( $settings['product_card_layout'] ) ) {
			self::$product_card_layout = $settings['product_card_layout'];
		}

		$product_ids  = $results['ids'];
		$current_page = $settings['page'] + 1;
		$data_text    = 'data-text = ""';

		if ( $results['current_page'] >= $results['total_pages'] ) {
			$current_page = 0;
			$data_text    = esc_html__( 'No products were found', 'ecomus-addons' );
		}

		$products = '<div class="products-loadmore">';

		add_filter( 'ecomus_product_card_layout', [ $this, 'product_card_layout' ], 5 );

		ob_start();

		wc_setup_loop(
			array(
				'columns' => $settings['columns']
			)
		);

		self::get_template_loop( $product_ids );

		$products .= ob_get_clean();
		$products .= '<span class="page-number" data-page="' . esc_attr( $current_page ) . '" data-text="' . $data_text . '"></span>';
		$products .= '</div>';

		remove_filter( 'ecomus_product_card_layout', [ $this, 'product_card_layout' ], 5 );

		wp_send_json_success( $products );
	}

	public function product_card_layout() {
		if( self::$product_card_layout ) {
			return esc_attr( self::$product_card_layout );
	    } else {
            return \Ecomus\Addons\Helper::product_card_layout_default();
        }
	}
}