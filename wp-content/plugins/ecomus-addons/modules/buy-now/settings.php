<?php

namespace Ecomus\Addons\Modules\Buy_Now;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings {

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'buy_now_section' ), 100, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'buy_now_settings' ), 100, 2 );
	}

	/**
	 * Buy Now section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function buy_now_section( $sections ) {
		$sections['ecomus_buy_now'] = esc_html__( 'Buy Now', 'ecomus-addons' );

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
	public function buy_now_settings( $settings, $section ) {
		if ( 'ecomus_buy_now' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_buy_now_options',
				'title' => esc_html__( 'Buy Now', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_buy_now',
				'title'   => esc_html__( 'Buy Now', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Buy Now', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'name'    => esc_html__( 'Redirect Location', 'ecomus-addons' ),
				'id'      => 'ecomus_buy_now_redirect_location',
				'type'    => 'single_select_page',
				'default' => '',
				'args'    => array( 'post_status' => 'publish,private' ),
				'class'   => 'wc-enhanced-select-nostd',
				'css'     => 'min-width:300px;',
				'desc_tip' => esc_html__( 'Select the page where to redirect after buy now button pressed.', 'ecomus-addons' ),
			);

			$settings[] = array(
				'id'      => 'ecomus_buy_now_reset_cart',
				'title'   => esc_html__( 'Reset Cart before Buy Now', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'id'   => 'ecomus_buy_now_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}
}