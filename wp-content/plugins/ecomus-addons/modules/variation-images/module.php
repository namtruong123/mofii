<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Variation_Images;

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
		$this->actions();
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
			'Ecomus\Addons\Modules\Variation_Images\Frontend'        => ECOMUS_ADDONS_DIR . 'modules/variation-images/frontend.php',
			'Ecomus\Addons\Modules\Variation_Images\Settings'    	=> ECOMUS_ADDONS_DIR . 'modules/variation-images/settings.php',
			'Ecomus\Addons\Modules\Variation_Images\Product_Options' => ECOMUS_ADDONS_DIR . 'modules/variation-images/product-options.php',
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
		if ( is_admin() ) {
			\Ecomus\Addons\Modules\Variation_Images\Settings::instance();

			if ( get_option( 'ecomus_variation_images', 'yes' ) == 'yes' ) {
			\Ecomus\Addons\Modules\Variation_Images\Product_Options::instance();
			}
		}

		if ( get_option( 'ecomus_variation_images', 'yes' ) == 'yes' ) {
			\Ecomus\Addons\Modules\Variation_Images\Frontend::instance();
		}

	}

}
