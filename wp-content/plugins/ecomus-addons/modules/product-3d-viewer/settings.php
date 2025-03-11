<?php

namespace Ecomus\Addons\Modules\Product_3D_Viewer;

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'product_3d_viewer_section' ), 170, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'product_3d_viewer_settings' ), 10, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function product_3d_viewer_section( $sections ) {
		$sections['ecomus_product_3d_viewer'] = esc_html__( 'Product 3D Viewer', 'ecomus-addons' );

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
	public function product_3d_viewer_settings( $settings, $section ) {
		if ( 'ecomus_product_3d_viewer' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_product_3d_viewer_options',
				'title' => esc_html__( 'Product 3D Viewer', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_product_3d_viewer',
				'title'   => esc_html__( 'Product 3D Viewer', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Product 3D Viewer', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'id'   => 'ecomus_product_3d_viewer_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}
}