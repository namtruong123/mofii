<?php

namespace Ecomus\Addons\Modules\Linked_Variant;

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'linked_variant_section' ), 190, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'linked_variant_settings' ), 190, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function linked_variant_section( $sections ) {
		$sections['ecomus_linked_variant'] = esc_html__( 'Linked Variations', 'ecomus-addons' );

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
	public function linked_variant_settings( $settings, $section ) {
		if ( 'ecomus_linked_variant' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_linked_variant_options',
				'title' => esc_html__( 'Linked Variations', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_linked_variant',
				'title'   => esc_html__( 'Linked Variations', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Linked Variations', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'id'   => 'ecomus_linked_variant_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}

}