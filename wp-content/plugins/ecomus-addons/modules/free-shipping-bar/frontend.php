<?php

namespace Ecomus\Addons\Modules\Free_Shipping_Bar;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Frontend {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Has variation images
	 *
	 * @var $attributes
	 */
	protected static $attributes = null;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'woocommerce_after_mini_cart', array( $this, 'free_shipping_bar_attributes_value' ), 10 );

		$this->add_actions();
	}

	public function add_actions() {
		if ( get_option( 'ecomus_free_shipping_bar_cart_page' ) == 'yes' ) {
			add_action('woocommerce_before_cart_totals', array( $this, 'free_shipping_bar' ), 5);
		}
		if ( get_option( 'ecomus_free_shipping_bar_checkout_page' ) == 'yes' ) {
			add_action('woocommerce_checkout_before_order_review', array( $this, 'free_shipping_bar' ));
		}
		if ( get_option( 'ecomus_free_shipping_bar_mini_cart' ) == 'yes' ) {
			add_action('ecomus_before_mini_cart_content', array( $this, 'free_shipping_bar' ), 10);
		}
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'ecomus-free-shipping-bar', ECOMUS_ADDONS_URL . 'modules/free-shipping-bar/assets/free-shipping-bar.css', array(), '1.0.0' );
		wp_enqueue_script('ecomus-free-shipping-bar', ECOMUS_ADDONS_URL . 'modules/free-shipping-bar/assets/free-shipping-bar.js',  array('jquery'), '1.0.0' );
	}

	/**
	 * Get shipping amount
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function free_shipping_bar() {
		$attributes = $this->free_shipping_bar_attributes();

		wc_get_template(
			'cart/free-shipping-bar.php',
			$attributes,
			'',
			ECOMUS_ADDONS_DIR . 'modules/free-shipping-bar/templates/'
		);
	}

	/**
	 * Get shipping amount
	 *
	 * @since 1.0.0
	 *
	 * @return float
	 */
	public function get_min_amount() {
		$packages =  ! empty( WC()->cart ) ? WC()->cart->get_shipping_packages() : '';
		$min_amount = 0;
		if( ! $packages ) {
			return $min_amount;
		}
		$shipping_methods = WC()->shipping() ? WC()->shipping()->load_shipping_methods($packages[0]) : array();
		if( ! $shipping_methods ) {
			return $min_amount;
		}

		foreach ( $shipping_methods as $id => $shipping_method ) {

			if ( ! isset( $shipping_method->enabled ) || 'yes' !== $shipping_method->enabled ) {
				continue;
			}

			if ( ! $shipping_method instanceof \WC_Shipping_Free_Shipping ) {
				continue;
			}

			if ( ! in_array( $shipping_method->requires, array( 'min_amount', 'either', 'both' ) ) ) {
				continue;
			}

			$min_amount = $shipping_method->min_amount;

		}

		return $min_amount;
	}

	/**
	 * Free shipping bar attributes
	 *
	 * @since 1.0.0
	 *
	 * @return float
	 */
	public function free_shipping_bar_attributes() {
		if( isset( self::$attributes )  ) {
			return self::$attributes;
		}

		$min_amount      = (float) $this->get_min_amount();

		if( $min_amount <=0 || empty( WC()->cart->subtotal ) ) {
			return self::$attributes;
		}
		$coupons = WC()->cart->get_discount_total();
		$min_amount += $coupons;
		$current_total      = WC()->cart->subtotal;
		$amount_more = $min_amount - $current_total ;
		$message = '';
		$classes = '';
		$percent = 0;
		$percent_number = number_format($current_total/$min_amount * 100, 2, '.', '');

		if( $amount_more > 0 ) {
			$message = sprintf(__('Buy %s more to enjoy <strong>Free Shipping</strong>', 'ecomus-addons'), '<strong>' . wc_price($amount_more) .'</strong>' );
			$percent = $percent_number . '%';
		} else {
			$message = sprintf(__('Congratulations! You have got free shipping!', 'ecomus-addons'));
			$percent = '100%';
		}

		if( $percent_number >= 100 ) {
			$classes .= ' em-is-success';
		} elseif ( $percent_number >= 60 ) {
			$classes .= ' em-is-unreached';
		}

		$classes .= intval( $percent ) > 91 ? ' em-progress-full' : '';

		self::$attributes = array(
			'message'      => $message,
			'percent'      => $percent,
			'classes'      => $classes
		);

		return self::$attributes;
	}

	/**
	 * Free shipping bar attributes
	 *
	 * @since 1.0.0
	 *
	 * @return float
	 */
	public function free_shipping_bar_attributes_value() {
		$attributes = $this->free_shipping_bar_attributes();

		if ( empty($attributes) ) {
			return;
		}

		echo '<div id="ecomus-free-shipping-bar-attributes" class="screen-reader-text" data-message="'. esc_attr( $attributes['message'] ) .'" data-percent="'. esc_attr( $attributes['percent'] ) .'" data-classes="'. esc_attr( $attributes['classes'] ) .'">'. esc_html__( 'Free Shipping Bar Attributes', 'ecomus-addons' ) .'</div>';
	}

}