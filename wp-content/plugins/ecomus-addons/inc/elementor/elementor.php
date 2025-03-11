<?php
/**
 * Integrate with Elementor.
 */

namespace Ecomus\Addons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor {
	/**
	 * Instance
	 *
	 * @access private
	 */
	private static $_instance = null;

	/**
	 * Elementor modules
	 *
	 * @var array
	 */
	public $modules = [];

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Ecomus_Addons_Elementor An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		spl_autoload_register( [ $this, 'autoload' ] );

		$this->setup_hooks();
		$this->_includes();

		\Ecomus\Addons\Elementor\Controls\AutoComplete_AjaxLoader::instance();
		\Ecomus\Addons\Elementor\Page_Settings\Controls::instance();
		\Ecomus\Addons\Elementor\Page_Settings\Frontend::instance();
		\Ecomus\Addons\Elementor\Controls\Settings_Layout::instance();
		\Ecomus\Addons\Elementor\Builder::instance();
		\Ecomus\Addons\Elementor\Library::instance();
		if ( class_exists( 'Woocommerce' ) ) {
			\Ecomus\Addons\Elementor\AJAX\Products::instance();
		}
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

		if ( 'Modules' == $module ) {
			$filename = ECOMUS_ADDONS_DIR . 'inc/elementor/modules/' . $filename . '.php';
		} elseif ( 'Widgets' == $module ) {
			$filename = ECOMUS_ADDONS_DIR . 'inc/elementor/widgets/' . $filename . '.php';
		} elseif ( 'Base' == $module ) {
			$filename = ECOMUS_ADDONS_DIR . 'inc/elementor/base/' . $filename . '.php';
		} elseif ( 'Controls' == $module ) {
			$filename = ECOMUS_ADDONS_DIR . 'inc/elementor/controls/' . $filename . '.php';
		} elseif ( 'Traits' == $module ) {
			$filename = ECOMUS_ADDONS_DIR . 'inc/elementor/widgets/traits/' . $filename . '.php';
		}

		if ( is_readable( $filename ) ) {
			include( $filename );
		}
	}

	/**
	 * Includes files which are not widgets
	 */
	private function _includes() {
		\Ecomus\Addons\Auto_Loader::register( [
			'Ecomus\Addons\Elementor\Controls\AjaxLoader'    => ECOMUS_ADDONS_DIR . 'inc/elementor/controls/autocomplete-ajaxloader.php',
			'Ecomus\Addons\Elementor\Page_Settings\Controls' => ECOMUS_ADDONS_DIR . 'inc/elementor/page-settings/controls.php',
			'Ecomus\Addons\Elementor\Page_Settings\Frontend' => ECOMUS_ADDONS_DIR . 'inc/elementor/page-settings/frontend.php',
			'Ecomus\Addons\Elementor\Controls\Settings_Layout' => ECOMUS_ADDONS_DIR . 'inc/elementor/controls/settings_layout.php',
			'Ecomus\Addons\Elementor\AJAX\Products' => ECOMUS_ADDONS_DIR . 'inc/elementor/ajax/products.php',
			'Ecomus\Addons\Elementor\Builder'  => ECOMUS_ADDONS_DIR . 'inc/elementor/builder/builder.php',
			'Ecomus\Addons\Elementor\Library'  => ECOMUS_ADDONS_DIR . 'inc/elementor/library/library.php',
		] );
	}

	/**
	 * Hooks to init
	 */
	protected function setup_hooks() {
		add_action( 'elementor/init', [ $this, 'init_modules' ] );

		// Widgets
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_styles' ] );

		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_scripts' ] );
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );

		// Register controls
		add_action( 'elementor/controls/register', [ $this, 'register_controls' ] );

		if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
			add_action( 'init', [ $this, 'register_wc_hooks' ], 5 );
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
	 * Init modules
	 */
	public function init_modules() {
		$this->modules['section-settings'] = \Ecomus\Addons\Elementor\Modules\Section_Settings::instance();
	}


	/**
	 * Register autocomplete control
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_controls( $controls_manager ) {
		$controls_manager->register( new \Ecomus\Addons\Elementor\Controls\AutoComplete() );
	}

	/**
	 * Register styles
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_styles() {
		wp_register_style( 'magnific',  ECOMUS_ADDONS_URL . 'assets/css/magnific-popup.css', array(), '1.0' );
		wp_register_style( 'ecomus-image-slide-css',  ECOMUS_ADDONS_URL . 'assets/css/image-slide.css', array(), '1.0' );
	}

	/**
	 * Register styles
	 */
	public function register_scripts() {
		wp_register_script( 'magnific', ECOMUS_ADDONS_URL . 'assets/js/plugins/jquery.magnific-popup.js', array(), '1.0', true );
		wp_register_script( 'ecomus-image-slide', ECOMUS_ADDONS_URL . 'assets/js/image-slide.js', ['jquery'], ECOMUS_ADDONS_VER, true );
		wp_register_script( 'ecomus-eventmove', ECOMUS_ADDONS_URL . 'assets/js/jquery.event.move.js', ['jquery'], ECOMUS_ADDONS_VER, true );

		wp_register_script( 'ecomus-elementor-widgets', ECOMUS_ADDONS_URL . 'assets/js/elementor-widgets.js', ['jquery', 'underscore', 'elementor-frontend', 'regenerator-runtime'], ECOMUS_ADDONS_VER, true );
	}


	/**
	 * Init Widgets
	 */
	public function init_widgets() {
		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Slides() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Image_Content_Slider() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Hero_Images() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Banner() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Heading() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Button() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Button_Carousel() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Icon_Box() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Icon_Box_Carousel() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Image_Box_Carousel() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Image_Carousel() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Image_Box_Grid() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Image_Info() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Dual_Image() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Subscribe_Box() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Subscribe_Group() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Social_Icons() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Contact_Form() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Timeline() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Store_Locations() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Instagram() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Accordion() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Navigation_Bar() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Marquee() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Countdown() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Stores_Tab() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Posts_Carousel() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Testimonial_Carousel_3() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Testimonial_Carousel() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Testimonial_Carousel_4() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Hero_Images() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Code_Discount() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Navigation_Menu() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Numbered_List() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Video_Banner() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Video_Popup() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Image_Before_After() );
		$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Shoppable_Video() );

		if ( class_exists( 'Woocommerce' ) ) {
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Brands() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Categories_Grid() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Categories_Carousel() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Product_Category_Tabs() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Featured_Product() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Products_Carousel() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Product_Grid() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Product_Tabs_Carousel() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Product_Tabs_Grid() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Lookbook_Products() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Images_Hotspot_Carousel() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Flash_Sale_Carousel() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Image_Hotspot() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Testimonial_Carousel_2() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Product_Tabs_Carousel() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Product_List() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Product_Price_Tables_Carousel() );
			$widgets_manager->register( new \Ecomus\Addons\Elementor\Widgets\Product_Recently_Viewed() );
		}

	}

	/**
	 * Add Ecomus category
	 */
	public function add_category( $elements_manager ) {
		$elements_manager->add_category(
			'ecomus-addons',
			[
				'title' => __( 'Ecomus', 'ecomus-addons' )
			]
		);

		$elements_manager->add_category(
			'ecomus-addons-footer',
			[
				'title' => __( 'Ecomus Footer', 'ecomus-addons' )
			]
		);
	}
}