<?php

namespace Ecomus\Addons\Modules\Advanced_Search;

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'advanced_search_section' ), 170, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'advanced_search_settings' ), 10, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function advanced_search_section( $sections ) {
		$sections['ecomus_advanced_search'] = esc_html__( 'Advanced Search', 'ecomus-addons' );

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
	public function advanced_search_settings( $settings, $section ) {
		if ( 'ecomus_advanced_search' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_advanced_search_options',
				'title' => esc_html__( 'Advanced Search', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_ajax_search_products_by_sku',
				'title'   => esc_html__( 'Search Products by SKU', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'    => 'ecomus_ajax_search_options',
				'type'  => 'sectionend',
			);

			$settings[] = array(
				'id'    => 'ecomus_ajax_search_options',
				'title' => esc_html__( 'Ajax Instant Search', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_ajax_search',
				'title'   => esc_html__( 'Ajax Instant Search', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'      => 'ecomus_ajax_search_number',
				'title'   => esc_html__( 'Limit', 'ecomus-addons' ),
				'type'    => 'number',
				'default' => '4',
			);

			$settings[] = array(
				'id'      => 'ecomus_ajax_search_products',
				'title'   => esc_html__( 'Autocomplete', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Show Products', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'checkboxgroup' => 'start',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'      => 'ecomus_ajax_search_categories',
				'desc'   => esc_html__( 'Show Categories', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'      => 'ecomus_ajax_search_posts',
				'desc'   => esc_html__( 'Show Posts', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'      => 'ecomus_ajax_search_tags',
				'desc'   => esc_html__( 'Show Tags', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'      => 'ecomus_ajax_search_pages',
				'desc'   => esc_html__( 'Show Pages', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'      => 'ecomus_ajax_search_hidden',
				'type'    => 'hidden',
				'checkboxgroup' => 'end',
			);

			$settings[] = array(
				'id'   => 'ecomus_advanced_search_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}
}