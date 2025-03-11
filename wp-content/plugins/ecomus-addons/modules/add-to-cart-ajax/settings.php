<?php

namespace Ecomus\Addons\Modules\Add_To_Cart_Ajax;

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'add_to_cart_ajax_section' ), 180, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'add_to_cart_ajax_settings' ), 180, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_to_cart_ajax_section( $sections ) {
		$sections['ecomus_add_to_cart_ajax'] = esc_html__( 'Add To Cart Ajax', 'ecomus-addons' );

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
	public function add_to_cart_ajax_settings( $settings, $section ) {
		if ( 'ecomus_add_to_cart_ajax' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_add_to_cart_ajax_options',
				'title' => esc_html__( 'Add To Cart Ajax', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_add_to_cart_ajax',
				'title'   => esc_html__( 'Add To Cart Ajax', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Add To Cart Ajax', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'   => 'ecomus_add_to_cart_ajax_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}
}