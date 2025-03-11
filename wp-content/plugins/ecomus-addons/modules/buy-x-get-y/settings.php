<?php

namespace Ecomus\Addons\Modules\Buy_X_Get_Y;

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'buy_x_get_y_section' ), 190, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'buy_x_get_y_settings' ), 190, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function buy_x_get_y_section( $sections ) {
		$sections['ecomus_buy_x_get_y'] = esc_html__( 'Buy X Get Y', 'ecomus-addons' );

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
	public function buy_x_get_y_settings( $settings, $section ) {
		if ( 'ecomus_buy_x_get_y' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_buy_x_get_y_options',
				'title' => esc_html__( 'Buy X Get Y', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_buy_x_get_y',
				'title'   => esc_html__( 'Buy X Get Y', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Buy X Get Y', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'id'   => 'ecomus_buy_x_get_y_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}
}