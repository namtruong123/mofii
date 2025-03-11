<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Product_Video;

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
		add_action('template_redirect', array( $this, 'product_single'));
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
			'Ecomus\Addons\Modules\Product_Video\Settings'   => ECOMUS_ADDONS_DIR . 'modules/product-video/settings.php',
			'Ecomus\Addons\Modules\Product_Video\Frontend'   => ECOMUS_ADDONS_DIR . 'modules/product-video/frontend.php',
			'Ecomus\Addons\Modules\Product_Video\Product_Options'    => ECOMUS_ADDONS_DIR . 'modules/product-video/product-options.php',
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
			\Ecomus\Addons\Modules\Product_Video\Settings::instance();

			if ( get_option( 'ecomus_product_video' ) == 'yes' ) {
				\Ecomus\Addons\Modules\Product_Video\Product_Options::instance();
			}
		}


	}

	/**
	 * Single Product
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_single() {
		if ( get_option( 'ecomus_product_video' ) == 'yes' && is_singular('product') ) {
			\Ecomus\Addons\Modules\Product_Video\FrontEnd::instance();
		}
	}

}
