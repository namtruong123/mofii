<?php
/**
 * Register template builder
 */

namespace Ecomus\Addons\Elementor\Builder;

class Widgets {

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
	 * Class constructor.
	 */
	public function __construct() {
		spl_autoload_register( [ $this, 'autoload' ] );
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );

		add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_scripts' ] );

		if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
			add_action( 'init', [ $this, 'register_wc_hooks' ], 5 );
		}
	}

	/**
	 * Register styles
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_styles() {
		wp_enqueue_style( 'driff-style', get_template_directory_uri() . '/assets/css/plugins/drift-basic.css');

	}

	/**
	 * Register styles
	 */
	public function register_scripts() {
		wp_register_script( 'ecomus-product-elementor-widgets', ECOMUS_ADDONS_URL . 'inc/elementor/builder/assets/js/elementor-widgets.js', ['jquery', 'underscore', 'elementor-frontend', 'regenerator-runtime'], ECOMUS_ADDONS_VER, true );
		wp_enqueue_script( 'driff-js', get_template_directory_uri() . '/assets/js/plugins/drift.min.js', array(), '', true );

		wp_enqueue_script( 'wc-single-product' );
	}

	/**
	 * Auto load widgets
	 */
	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$path = explode( '\\', $class );
		$filename = strtolower( array_pop( $path ) );
		$filename = str_replace( '_', '-', $filename );

		$module = array_pop( $path );

		if ( 'Widgets' == $module ) {
			$filename = ECOMUS_ADDONS_DIR . 'inc/elementor/builder/widgets/' . $filename . '.php';
		} elseif ( 'Traits' == $module ) {
			$filename = ECOMUS_ADDONS_DIR . 'inc/elementor/builder/traits/' . $filename . '.php';
		}

		if ( is_readable( $filename ) ) {
			include( $filename );
		}
	}

	/**
	 * Register WC hooks for Elementor editor
	 */
	public function register_wc_hooks() {
		if ( function_exists( 'wc' ) ) {
			wc()->frontend_includes();
		}
	}


	/**
	 * Init Widgets
	 */
	public function init_widgets() {
		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Breadcrumb() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Navigation() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Images() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Category() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Rating() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Title() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Short_Description() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_SKU() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Categories() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Tag() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Badges() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Price() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Countdown() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Add_To_Cart_Form() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Sidebar() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Ask_Question() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Delivery_Return() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Share() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Data_Tabs() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Upsell() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Related() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Categories_List() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\WC_Notices() );

		if( get_option( 'ecomus_cart_tracking' ) == 'yes' ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Cart_Tracking() );
		}

		if( get_option( 'ecomus_people_view_fake' ) == 'yes' ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\People_View_Fake() );
		}

		if( get_option( 'ecomus_variation_compare_toggle' ) == 'yes' ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Variation_Compare() );
		}

		if( get_option( 'ecomus_product_bought_together' ) == 'yes'  ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_FBT() );
		}

		if( get_option( 'ecomus_product_variations_listing' ) == 'yes' ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Product_Variations_Listing() );
		}

		if( get_option( 'ecomus_advanced_linked_products' ) == 'yes' ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Advanced_Linked_Products() );
		}

		if( get_option( 'ecomus_dynamic_pricing_discounts' ) == 'yes' ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Dynamic_Pricing_Discounts() );
		}

		if( get_option( 'ecomus_recent_sales_count' ) == 'yes' ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Recent_Sales_Count() );
		}

		if( get_option( 'ecomus_linked_variant' ) == 'yes' ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Linked_Variant() );
		}

		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Archive_Products() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Products_Filter() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Products_Filter_Actived() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Archive_Product_View() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Archive_Product_Ordering() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Archive_Page_Header() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\Archive_Top_Categories() );

		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\WC_Cart() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\WC_Cart_Cross_Sell() );

		$widgets_manager->register( new \Ecomus\Addons\Elementor\Builder\Widgets\WC_Checkout() );
	}

	/**
	 * Add Ecomus category
	 */
	public function add_category( $elements_manager ) {
		$elements_manager->add_category(
			'ecomus-addons-product',
			[
				'title' => __( 'Ecomus Product', 'ecomus-addons' )
			]
		);

		$elements_manager->add_category(
			'ecomus-addons-archive-product',
			[
				'title' => __( 'Ecomus Product Archive ', 'ecomus-addons' )
			]
		);

		$elements_manager->add_category(
			'ecomus-addons-cart-page',
			[
				'title' => __( 'Ecomus Cart Page', 'ecomus-addons' )
			]
		);

		$elements_manager->add_category(
			'ecomus-addons-checkout-page',
			[
				'title' => __( 'Ecomus Checkout Page', 'ecomus-addons' )
			]
		);
	}
}