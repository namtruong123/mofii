<?php
/**
 * Ecomus Addons init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ecomus
 */

namespace Ecomus;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Ecomus Addons init
 *
 * @since 1.0.0
 */
class Addons {

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
		add_action( 'plugins_loaded', array( $this, 'load_templates' ) );

		add_action('init', array($this,'create_taxonomy_brands'));

	}

	/**
	 * Load Templates
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_templates() {
		$this->includes();
		spl_autoload_register( '\Ecomus\Addons\Auto_Loader::load' );

		$this->add_actions();

		add_shortcode( 'ecomus_year', array( __CLASS__, 'year' ) );
	}

	/**
	 * Includes files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		// Auto Loader
		require_once ECOMUS_ADDONS_DIR . 'autoloader.php';
		\Ecomus\Addons\Auto_Loader::register( [
			'Ecomus\Addons\Helper'                    => ECOMUS_ADDONS_DIR . 'inc/helper.php',
			'Ecomus\Addons\Product_Brands'            => ECOMUS_ADDONS_DIR . 'inc/backend/product-brand.php',
			'Ecomus\Addons\Importer'                  => ECOMUS_ADDONS_DIR . 'inc/backend/importer.php',
			'Ecomus\Addons\Theme_Settings'            => ECOMUS_ADDONS_DIR . 'inc/backend/theme-settings.php',
			'Ecomus\Addons\Widgets'                   => ECOMUS_ADDONS_DIR . 'inc/widgets/widgets.php',
			'Ecomus\Addons\Elementor'                 => ECOMUS_ADDONS_DIR . 'inc/elementor/elementor.php',
			'Ecomus\Addons\Modules'                   => ECOMUS_ADDONS_DIR . 'modules/modules.php',
			'Ecomus\Addons\WooCommerce\Products_Base' => ECOMUS_ADDONS_DIR . 'inc/woocommerce/products-base.php',
		] );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function add_actions() {
		// Before init action.
		do_action( 'before_ecomus_init' );


		\Ecomus\Addons\Theme_Settings::instance();
		if( is_admin() ) {
			\Ecomus\Addons\Importer::instance();
		}
		\Ecomus\Addons\Widgets::instance();
		if( class_exists('WooCommerce')  ) {
			\Ecomus\Addons\Modules::instance();
		}
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			\Ecomus\Addons\Elementor::instance();
		}

		// Init action.
		do_action( 'after_ecomus_init' );
	}

	public function create_taxonomy_brands() {
		\Ecomus\Addons\Product_Brands::instance();
	}

		/**
	 * Display current year
	 *
	 * @return void
	 */
	public static function year() {
		return date('Y');
	}
}
