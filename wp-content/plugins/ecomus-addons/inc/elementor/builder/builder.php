<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Modules
 */
class Builder {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;

	private static $is_elementor;
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
		$this->includes();
		$this->disable_customizer();
		add_action( 'init', array( $this, 'actions') );
		add_action( 'wp', array( $this, 'frontend'), 1 );

		// Remove sidebar
		add_action( 'widgets_init', array( $this, 'remove_sidebar' ), 11 );
	}

	/**
	 * Includes files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		\Ecomus\Addons\Auto_Loader::register( [
			'Ecomus\Addons\Elementor\Builder\Settings'                => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/settings.php',
			'Ecomus\Addons\Elementor\Builder\Post_Type'               => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/post-type.php',
			'Ecomus\Addons\Elementor\Builder\Helper'                  => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/helper.php',
			'Ecomus\Addons\Elementor\Builder\Elementor_Settings'      => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/elementor-settings.php',
			'Ecomus\Addons\Elementor\Builder\Footer'                  => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/footer.php',
			'Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait' => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/traits/product-id-trait.php',
			'Ecomus\Addons\Elementor\Builder\Base_Products_Renderer'  => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/classes/base-products-renderer.php',
			'Ecomus\Addons\Elementor\Builder\Current_Query_Renderer'  => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/classes/current-query-renderer.php',
			'Ecomus\Addons\Elementor\Builder\Products_Renderer'       => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/classes/products-renderer.php',
			'Ecomus\Addons\Elementor\Builder\Product'                 => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/product.php',
			'Ecomus\Addons\Elementor\Builder\Product_Archive'         => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/product-archive.php',
			'Ecomus\Addons\Elementor\Builder\Cart_Page'               => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/cart-page.php',
			'Ecomus\Addons\Elementor\Builder\Checkout_Page'           => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/checkout-page.php',
			'Ecomus\Addons\Elementor\Builder\Not_Found_Page'          => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/not-found-page.php',
			'Ecomus\Addons\Elementor\Builder\Widgets'                 => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/inc/widgets.php',
		] );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function actions() {
		if( is_admin() ) {
			\Ecomus\Addons\Elementor\Builder\Settings::instance();
		}

		if( $this->is_elementor() ) {
			\Ecomus\Addons\Elementor\Builder\Post_Type::instance();
			\Ecomus\Addons\Elementor\Builder\Footer::instance();
			\Ecomus\Addons\Elementor\Builder\Widgets::instance();

			if( class_exists('Elementor\Core\Base\Module') ) {
				\Ecomus\Addons\Elementor\Builder\Elementor_Settings::instance();
			}
		}
	}

	/**
	 * Add Frontend
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function frontend() {
		if( $this->is_elementor() ) {
			$terms = \Ecomus\Addons\Elementor\Builder\Helper::ecomus_get_terms();

			if( ( is_singular('product') || ( is_singular('ecomus_builder') && in_array( 'product', $terms ) ) ) && get_option( 'ecomus_product_builder_enable', false ) ) {
				\Ecomus\Addons\Elementor\Builder\Product::instance();
			}

			if( ( \Ecomus\Addons\Helper::is_catalog() || ( is_singular('ecomus_builder') && in_array( 'archive', $terms ) ) ) && get_option( 'ecomus_product_archive_builder_enable', false ) ) {
				\Ecomus\Addons\Elementor\Builder\Product_Archive::instance();
			}

			if( ( ( function_exists('is_cart') && is_cart() ) || ( is_singular('ecomus_builder') && in_array( 'cart_page', $terms ) ) ) && get_option( 'ecomus_cart_page_builder_enable', false ) ) {
				\Ecomus\Addons\Elementor\Builder\Cart_Page::instance();
			}

			if( ( ( function_exists('is_checkout') && is_checkout() && empty( $wp->query_vars['order-pay'] ) && ! isset( $_GET['key'] ) ) || ( is_singular('ecomus_builder') && in_array( 'checkout_page', $terms ) ) ) && get_option( 'ecomus_checkout_page_builder_enable', false ) ) {
				\Ecomus\Addons\Elementor\Builder\Checkout_Page::instance();
			}

			if( ( is_404() || ( is_singular('ecomus_builder') && in_array( '404_page', $terms ) ) ) && get_option( 'ecomus_404_page_builder_enable', false ) ) {
				\Ecomus\Addons\Elementor\Builder\Not_Found_Page::instance();
			}
		}
	}

	public function is_elementor() {
		if ( isset( self::$is_elementor ) ) {
			return self::$is_elementor;
		}

		self::$is_elementor = true;
		if( ! class_exists('\Elementor\Plugin') ) {
			self::$is_elementor = false;
		}

		return self::$is_elementor;
	}

	public function disable_customizer() {
		if( get_option( 'ecomus_product_builder_enable', false ) ) {
			// Disable single product customizer settings
			add_filter( 'ecomus_load_single_product_layout', '__return_false' );
			add_filter( 'ecomus_get_single_product_settings', '__return_false' );
			add_filter( 'ecomus_product_bought_together_elementor', '__return_false' );
			add_filter( 'ecomus_dynamic_pricing_discounts_position_elementor', '__return_false' );
			add_filter( 'ecomus_single_product_sidebar_panel', '__return_false' );
		}

		if( get_option( 'ecomus_product_archive_builder_enable', false ) ) {
			// Disable Archive product customizer settings
			add_filter( 'ecomus_shop_header_elements', '__return_empty_array' );
			add_filter( 'ecomus_shop_header_elementor', '__return_false' );
			add_filter( 'ecomus_top_categories_elementor', '__return_false' );
			add_filter( 'ecomus_product_catalog_elementor', '__return_false' );
			add_filter( 'ecomus_catalog_view_layout', '__return_false' );
			add_filter( 'ecomus_load_catalog_layout', '__return_false' );
			add_filter( 'ecomus_catalog_toolbar_elementor', '__return_false' );
			add_filter( 'ecomus_taxonomy_description_elementor', '__return_false' );
			add_filter( 'ecomus_catalog_toolbar_option_elementor', '__return_false' );
			add_filter( 'ecomus_pagination_elementor', '__return_false' );
			add_filter( 'ecomus_product_filter_widgets_elementor', '__return_false' );
			add_filter( 'ecomus_product_catalog_sidebar_panel', '__return_false' );
			add_filter( 'ecomus_navigation_bar_filter_elementor', '__return_false' );
		}
	}

	public function remove_sidebar() {
		if( get_option( 'ecomus_product_builder_enable', false ) ) {
			unregister_sidebar( 'single-product-sidebar' );
			unregister_sidebar( 'single-product-extra-content' );
		}

		if( get_option( 'ecomus_product_archive_builder_enable', false ) ) {
			unregister_sidebar( 'catalog-sidebar' );
			unregister_sidebar( 'catalog-filters-sidebar' );
		}
	}
}