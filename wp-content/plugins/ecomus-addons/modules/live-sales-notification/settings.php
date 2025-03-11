<?php

namespace Ecomus\Addons\Modules\Live_Sales_Notification;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'live_sales_notification_section' ), 110, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'live_sales_notification_settings' ), 110, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function live_sales_notification_section( $sections ) {
		$sections['ecomus_live_sales_notification'] = esc_html__( 'Live Sales Notification', 'ecomus-addons' );

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
	public function live_sales_notification_settings( $settings, $section ) {
		if ( 'ecomus_live_sales_notification' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_live_sales_notification_options',
				'title' => esc_html__( 'Live Sales Notification', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_live_sales_notification',
				'title'   => esc_html__( 'Live Sales Notification', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable Live Sales Notification', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'name'    => esc_html__( 'Exclude Pages', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_exclude_page',
				'class'   => 'wc-page-search',
				'type'    => 'multiselect',
				'default' => $this->get_product_selected( 'ecomus_live_sales_notification_exclude_page', 'page', true ),
				'options' => $this->get_product_selected( 'ecomus_live_sales_notification_exclude_page', 'page', false ),
				'custom_attributes' => array(
					'data-action' => 'woocommerce_json_search_pages',
					'data-sortable' => 'true',
					'data-minimum_input_length' => 2,
				),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Select product from', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_navigation',
				'default' => 'product-type',
				'class'   => 'ecomus_live_sales_notification_navigation wc-enhanced-select',
				'type'    => 'select',
				'options' => array(
					'orders'                   => esc_html__( 'Orders placed', 'ecomus-addons' ),
					'product-type' 			   => esc_html__( 'Product type', 'ecomus-addons' ),
					'selected-products'        => esc_html__( 'Show selected products', 'ecomus-addons' ),
					'selected-categories'      => esc_html__( 'Show product from selected category', 'ecomus-addons' ),
				),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Select product type', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_product_type',
				'default' => 'recent',
				'class'   => 'product-type-show wc-enhanced-select live-sales--condition',
				'type'    => 'select',
				'options' => array(
					'recent'       => esc_html__( 'Recently viewed', 'ecomus-addons' ),
					'featured'     => esc_html__( 'Featured', 'ecomus-addons' ),
					'best_selling' => esc_html__( 'Best Selling', 'ecomus-addons' ),
					'top_rated'    => esc_html__( 'Top Rated', 'ecomus-addons' ),
					'sale'         => esc_html__( 'On Sale', 'ecomus-addons' ),
				),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Based on the order status orders will be selected', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_order',
				'default' => 'wc-completed',
				'class'   => 'wc-enhanced-select orders-show live-sales--condition',
				'type'    => 'multiselect',
				'options' => array(
					'wc-pending'        => esc_html__( 'Pending payment', 'ecomus-addons' ),
					'wc-processing'     => esc_html__( 'Processing', 'ecomus-addons' ),
					'wc-on-hold'        => esc_html__( 'On hold', 'ecomus-addons' ),
					'wc-completed'      => esc_html__( 'Completed', 'ecomus-addons' ),
					'wc-cancelled'      => esc_html__( 'Cancelled', 'ecomus-addons' ),
					'wc-refunded'       => esc_html__( 'Refunded', 'ecomus-addons' ),
					'wc-failed'         => esc_html__( 'Failed', 'ecomus-addons' ),
					'wc-checkout-draft' => esc_html__( 'Draft', 'ecomus-addons' ),
				),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Select product', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_product',
				'class'   => 'wc-product-search selected-products-show live-sales--condition',
				'type'    => 'multiselect',
				'default' => $this->get_product_selected( 'ecomus_live_sales_notification_product', 'product', true ),
				'options' => $this->get_product_selected( 'ecomus_live_sales_notification_product', 'product', false ),
				'custom_attributes' => array(
					'data-action' => 'woocommerce_json_search_products_and_variations',
					'data-sortable' => 'true',
					'data-minimum_input_length' => 2,
				),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Select category', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_category',
				'class'   => 'wc-category-search selected-categories-show live-sales--condition',
				'type'    => 'multiselect',
				'default' => $this->get_product_selected( 'ecomus_live_sales_notification_category', 'categories', true ),
				'options' => $this->get_product_selected( 'ecomus_live_sales_notification_category', 'categories', false ),
				'custom_attributes' => array(
					'data-action' => 'woocommerce_json_search_categories',
					'data-sortable' => 'true',
					'data-minimum_input_length' => 2,
				),
			);

			$settings[] = array(
				'title'       => __( 'Virtual first name', 'ecomus-addons' ),
				'id'          => 'ecomus_live_sales_notification_name',
				'type'        => 'textarea',
				'class'   	  => 'product-type-show selected-products-show selected-categories-show live-sales--condition',
				'default'     => '',
				'custom_attributes' => array(
					'rows' => 10,
				),
				'desc_tip'    => __( 'This name will be used, when you decide to show virtual sales, Enter one name on one line', 'ecomus-addons' ),
			);

			$settings[] = array(
				'title'       => __( 'Virtual location', 'ecomus-addons' ),
				'id'          => 'ecomus_live_sales_notification_location',
				'type'        => 'textarea',
				'class'   	  => 'product-type-show selected-products-show selected-categories-show live-sales--condition',
				'default'     => '',
				'custom_attributes' => array(
					'rows' => 10,
				),
				'desc_tip'    => __( 'One location on one line eg: city, state, country if you dont have state then this will be like this
				e.g: city , , country, if you dont have city then e.g: , state, country', 'ecomus-addons' ),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Show orders placed in last', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_time',
				'type'    => 'number',
				'class'	  => 'orders-show product-type-show selected-categories-show live-sales--condition',
				'custom_attributes' => array(
					'min'  => 1,
					'step' => 1,
				),
				'default' => '1',
				'desc_tip' => esc_html__( 'E.g: 1 day: will show order placed in last one day', 'ecomus-addons' ),
			);

			$settings[] = array(
				'id'      => 'ecomus_live_sales_notification_time_type',
				'default' => 'day',
				'class'   => 'wc-enhanced-select orders-show product-type-show selected-categories-show live-sales--condition',
				'type'    => 'select',
				'options' => array(
					'hour' => esc_html__( 'Hour', 'ecomus-addons' ),
					'day'  => esc_html__( 'Day', 'ecomus-addons' ),
					'week' => esc_html__( 'Week', 'ecomus-addons' ),
				),
			);

			$settings[] = array(
				'title'   => __( 'Time passed type', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_time_passed_type',
				'default' => 'minutes',
				'class'   => 'wc-enhanced-select',
				'type'    => 'select',
				'options' => array(
					'seconds' => esc_html__( 'Seconds', 'ecomus-addons' ),
					'minutes' => esc_html__( 'Minutes', 'ecomus-addons' ),
					'hours'   => esc_html__( 'Hours', 'ecomus-addons' ),
				),
			);

			$settings[] = array(
				'name'    => esc_html__( 'How many notification to show (make sure number is grater then 1)', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_number',
				'type'    => 'number',
				'custom_attributes' => array(
					'min'  => 1,
					'step' => 1,
				),
				'default' => '10',
				'desc_tip' => esc_html__( 'For virtual orders this many notification will be created, but for original orders if it is less then this number no virtual order will be created', 'ecomus-addons' ),
			);

			$settings[] = array(
				'name'    => esc_html__( 'When to start showing popup (milliseconds)', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_time_start',
				'type'    => 'number',
				'custom_attributes' => array(
					'min'  => 0,
				),
				'default' => '6000',
				'desc_tip' => esc_html__( 'Once a person comes to page, when to start showing popup', 'ecomus-addons' ),
			);

			$settings[] = array(
				'name'    => esc_html__( 'How long to keep the popup opened (milliseconds)', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_time_keep_opened',
				'type'    => 'number',
				'custom_attributes' => array(
					'min'  => 0,
				),
				'default' => '6000',
				'desc_tip' => esc_html__( 'How long to keep the popup open', 'ecomus-addons' ),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Time gap between showing of 2 popups (milliseconds)', 'ecomus-addons' ),
				'id'      => 'ecomus_live_sales_notification_time_between',
				'type'    => 'number',
				'custom_attributes' => array(
					'min'  => 0,
				),
				'default' => '6000',
				'desc_tip' => esc_html__( 'Once a popup closes then after how much time new popup should open', 'ecomus-addons' ),
			);

			$settings[] = array(
				'id'   => 'ecomus_live_sales_notification_options',
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
			} else if( $type == 'page' ) {
				$name = get_the_title( $id );
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
		wp_enqueue_script( 'ecomus-live-sales-notification-admin', ECOMUS_ADDONS_URL . 'modules/live-sales-notification/assets/admin/live-sales-notification-admin.js' );
	}
}