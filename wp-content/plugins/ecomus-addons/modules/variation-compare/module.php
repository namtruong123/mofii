<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Variation_Compare;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Modules
 */
class Module {

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
		$this->includes();

		add_action('template_redirect', array( $this, 'product_single'));

		$this->add_actions();
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
			'Ecomus\Addons\Modules\Variation_Compare\Frontend'      => ECOMUS_ADDONS_DIR . 'modules/variation-compare/frontend.php',
			'Ecomus\Addons\Modules\Variation_Compare\Settings'    	=> ECOMUS_ADDONS_DIR . 'modules/variation-compare/settings.php',
			'Ecomus\Addons\Modules\Variation_Compare\Product_Options'    	=> ECOMUS_ADDONS_DIR . 'modules/variation-compare/product-options.php',
			'Ecomus\Addons\Modules\Variation_Compare\Variation_Select'    => ECOMUS_ADDONS_DIR . 'modules/variation-compare/variation-select.php',
		] );
	}

	/**
	 * Single Product
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_single() {
		if ( get_option( 'ecomus_variation_compare_toggle', 'yes' ) == 'yes' && is_singular('product') ) {
			\Ecomus\Addons\Modules\Variation_Compare\Frontend::instance();
		}
	}


	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function add_actions() {
		if ( is_admin() ) {
			\Ecomus\Addons\Modules\Variation_Compare\Settings::instance();
			\Ecomus\Addons\Modules\Variation_Compare\Product_Options::instance();
		}
	}

}
