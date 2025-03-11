<?php

namespace Ecomus\Addons\Modules\Product_Bought_Together;

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'product_bought_together_section' ), 100, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'product_bought_together_settings' ), 100, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function product_bought_together_section( $sections ) {
		$sections['ecomus_product_bought_together'] = esc_html__( 'Product Bought Together', 'ecomus-addons' );

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
	public function product_bought_together_settings( $settings, $section ) {
		if ( 'ecomus_product_bought_together' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_product_bought_together_options',
				'title' => esc_html__( 'Product Bought Together', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_product_bought_together',
				'title'   => esc_html__( 'Product Bought Together', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Product Bought Together', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			if( apply_filters( 'ecomus_product_bought_together_elementor', true ) ) {
				$settings[] = array(
					'name'    => esc_html__( 'Position', 'ecomus-addons' ),
					'id'      => 'ecomus_product_bought_together_layout',
					'default' => '1',
					'class'   => 'wc-enhanced-select product-bought-together-layout',
					'type'    => 'select',
					'options' => array(
						'1' => esc_html__( 'Before product tabs', 'ecomus-addons' ),
						'2' => esc_html__( 'After Add to Cart button', 'ecomus-addons' ),
					),
				);
			}

			$settings[] = array(
				'id'   => 'ecomus_product_bought_together_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}

}