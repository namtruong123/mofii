<?php

namespace Ecomus\Addons\Modules\Free_Shipping_Bar;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings  {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'free_shipping_bar_section' ), 30, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'free_shipping_bar_settings' ), 30, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function free_shipping_bar_section( $sections ) {
		$sections['ecomus_free_shipping_bar'] = esc_html__( 'Free Shipping Bar', 'ecomus-addons' );

		return $sections;
	}

	/**
	 * Adds settings to product display settings
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings
	 * @param string $section
	 *
	 * @return array
	 */
	public function free_shipping_bar_settings( $settings, $section ) {
		if ( 'ecomus_free_shipping_bar' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_free_shipping_bar_options',
				'title' => esc_html__( 'Free Shipping Bar', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_free_shipping_bar',
				'title'   => esc_html__( 'Free Shipping Bar', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Free Shipping Bar', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'desc'    => esc_html__( 'Checkout page', 'ecomus-addons' ),
				'id'      => 'ecomus_free_shipping_bar_checkout_page',
				'default' => 'yes',
				'type'    => 'checkbox',
				'checkboxgroup' => '',
				'checkboxgroup' => 'start',
			);

			$settings[] = array(
				'desc'    => esc_html__( 'Cart page', 'ecomus-addons' ),
				'id'      => 'ecomus_free_shipping_bar_cart_page',
				'default' => 'yes',
				'type'    => 'checkbox',
				'checkboxgroup' => '',
			);

			$settings[] = array(
				'desc'    => esc_html__( 'Mini cart', 'ecomus-addons' ),
				'id'      => 'ecomus_free_shipping_bar_mini_cart',
				'default' => 'yes',
				'type'    => 'checkbox',
				'checkboxgroup' => 'end'
			);

			$settings[] = array(
				'id'   => 'ecomus_free_shipping_bar_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}

}