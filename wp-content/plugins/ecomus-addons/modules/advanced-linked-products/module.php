<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Advanced_Linked_Products;

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
			'Ecomus\Addons\Modules\Advanced_Linked_Products\Frontend'     => ECOMUS_ADDONS_DIR . 'modules/advanced-linked-products/frontend.php',
			'Ecomus\Addons\Modules\Advanced_Linked_Products\Settings'     => ECOMUS_ADDONS_DIR . 'modules/advanced-linked-products/settings.php',
			'Ecomus\Addons\Modules\Advanced_Linked_Products\Product_Meta' => ECOMUS_ADDONS_DIR . 'modules/advanced-linked-products/product-meta.php',
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
			\Ecomus\Addons\Modules\Advanced_Linked_Products\Settings::instance();
		}

		if ( get_option( 'ecomus_advanced_linked_products', 'yes' ) == 'yes' ) {
			\Ecomus\Addons\Modules\Advanced_Linked_Products\Frontend::instance();

			if ( is_admin() ) {
				\Ecomus\Addons\Modules\Advanced_Linked_Products\Product_Meta::instance();
			}
		}

	}

}
