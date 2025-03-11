<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Sticky_Add_To_Cart;


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
			'Ecomus\Addons\Modules\Sticky_Add_To_Cart\Frontend'      => ECOMUS_ADDONS_DIR . 'modules/sticky-add-to-cart/frontend.php',
			'Ecomus\Addons\Modules\Sticky_Add_To_Cart\Settings'    	=> ECOMUS_ADDONS_DIR . 'modules/sticky-add-to-cart/settings.php',
			'Ecomus\Addons\Modules\Sticky_Add_To_Cart\Variation_Select'    => ECOMUS_ADDONS_DIR . 'modules/sticky-add-to-cart/variation-select.php',
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
		if ( get_option( 'ecomus_sticky_add_to_cart_toggle', 'yes' ) == 'yes' && is_singular('product') && ! is_customize_preview() ) {
			\Ecomus\Addons\Modules\Sticky_Add_To_Cart\Frontend::instance();
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
			\Ecomus\Addons\Modules\Sticky_Add_To_Cart\Settings::instance();
		}
	}

}
