<?php

namespace Ecomus\Addons\Modules\Product_Video;

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'product_video_section' ), 120, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'product_video_settings' ), 10, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function product_video_section( $sections ) {
		$sections['ecomus_product_video'] = esc_html__( 'Product Video', 'ecomus-addons' );

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
	public function product_video_settings( $settings, $section ) {
		if ( 'ecomus_product_video' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_product_video_options',
				'title' => esc_html__( 'Product Video', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_product_video',
				'title'   => esc_html__( 'Product Video', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Product Video', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'id'   => 'ecomus_product_video_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}
}