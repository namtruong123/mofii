<?php

namespace Ecomus\Addons\Modules\Dynamic_Pricing_Discounts;

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'dynamic_pricing_discounts_section' ), 150, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'dynamic_pricing_discounts_settings' ), 150, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function dynamic_pricing_discounts_section( $sections ) {
		$sections['ecomus_dynamic_pricing_discounts'] = esc_html__( 'Dynamic Pricing & Discounts', 'ecomus-addons' );

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
	public function dynamic_pricing_discounts_settings( $settings, $section ) {
		if ( 'ecomus_dynamic_pricing_discounts' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_dynamic_pricing_discounts_options',
				'title' => esc_html__( 'Dynamic Pricing & Discounts', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_dynamic_pricing_discounts',
				'title'   => esc_html__( 'Dynamic Pricing & Discounts', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Dynamic Pricing & Discounts', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			if( apply_filters( 'ecomus_dynamic_pricing_discounts_position_elementor', true ) ) {
				$settings[] = array(
					'name'    => esc_html__( 'Position', 'ecomus-addons' ),
					'id'      => 'ecomus_dynamic_pricing_discounts_position',
					'default' => 'above',
					'class'   => 'wc-enhanced-select dynamic-pricing-discount-position',
					'type'    => 'select',
					'options' => array(
						'above' => esc_html__( 'Above Add to Cart button', 'ecomus-addons' ),
						'below' => esc_html__( 'Below Add to Cart button', 'ecomus-addons' ),
					),
				);
			}

			$settings[] = array(
				'id'   => 'ecomus_dynamic_pricing_discounts_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}

}