<?php

namespace Ecomus\Addons\Modules\Product_Variations_Listing;

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'product_variations_listing_section' ), 140, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'product_variations_listing_settings' ), 140, 2 );

		// Enqueue style and javascript
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function product_variations_listing_section( $sections ) {
		$sections['ecomus_product_variations_listing'] = esc_html__( 'Product Variations Listing', 'ecomus-addons' );

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
	public function product_variations_listing_settings( $settings, $section ) {
		if ( 'ecomus_product_variations_listing' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_product_variations_listing_options',
				'title' => esc_html__( 'Product Variations Listing', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_product_variations_listing',
				'title'   => esc_html__( 'Product Variations Listing', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Product Variations Listing', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'name'    => esc_html__( 'Products', 'ecomus-addons' ),
				'id'      => 'ecomus_product_variations_listing_products',
				'default' => 'all',
				'class'   => 'wc-enhanced-select product-variations-listing-products',
				'type'    => 'select',
				'options' => array(
					'all'    => esc_html__( 'All variable products', 'ecomus-addons' ),
					'custom' => esc_html__( 'Custom', 'ecomus-addons' ),
				),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Select products', 'ecomus-addons' ),
				'id'      => 'ecomus_product_variations_listing_product_ids',
				'class'   => 'wc-product-search custom-show product-variations--condition',
				'type'    => 'multiselect',
				'default' => $this->get_product_selected( 'ecomus_product_variations_listing_product_ids', 'product', true ),
				'options' => $this->get_product_selected( 'ecomus_product_variations_listing_product_ids', 'product', false ),
				'custom_attributes' => array(
					'data-action' => 'woocommerce_json_search_products',
					'data-sortable' => 'true',
					'data-minimum_input_length' => 2,
					'data-exclude_type' => 'simple, grouped, virtual, downloadable, external, affiliate',
				),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Select categories', 'ecomus-addons' ),
				'id'      => 'ecomus_product_variations_listing_category',
				'class'   => 'wc-category-search',
				'type'    => 'multiselect',
				'default' => $this->get_product_selected( 'ecomus_product_variations_listing_category', 'categories', true ),
				'options' => $this->get_product_selected( 'ecomus_product_variations_listing_category', 'categories', false ),
				'custom_attributes' => array(
					'data-action' => 'woocommerce_json_search_categories',
					'data-sortable' => 'true',
					'data-minimum_input_length' => 2,
				),
			);

			$settings[] = array(
				'id'      => 'ecomus_product_variations_listing_pagination',
				'title'   => esc_html__( 'Enable Pagination', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Check to enable pagination', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'id'      => 'ecomus_product_variations_listing_per_page',
				'title'   => esc_html__( 'Products per page', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Add number of products per page in case of pagination. Default value is 5', 'ecomus-addons' ),
				'type'    => 'number',
				'default' => 5,
			);

			$settings[] = array(
				'id'   => 'ecomus_product_variations_listing_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}

	/**
	 * Get product selected function
	 *
	 * @return void
	 */
	public function get_product_selected( $option, $type = 'product', $only = false ) {
		$ids = get_option( $option );
		$json_ids    = array();

		if( empty( $ids ) && ! $ids ) {
			if( $only ) {
				return '';
			} else {
				return [];
			}
		}

		foreach ( (array) $ids as $id ) {
			if( $type == 'product' ) {
				$product = wc_get_product( $id );
				$name = wp_kses_post( html_entity_decode( $product->get_formatted_name(), ENT_QUOTES, get_bloginfo( 'charset' ) ) );
			} else {
				$name = get_term_by( 'slug', $id, 'product_cat' )->name;
			}

			if( $only ) {
				$json_ids[] = $id;
			} else {
				$json_ids[ $id ] = $name;
			}
		}

		if( $only ) {
			return implode( ' ', $json_ids );
		} else {
			return $json_ids;
		}
	}

	/**
	 * Load scripts and style in admin area
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_scripts() {
		wp_enqueue_script( 'product-variations-listing-admin', ECOMUS_ADDONS_URL . 'modules/product-variations-listing/assets/admin/product-variations-listing-admin.js' );
	}
}