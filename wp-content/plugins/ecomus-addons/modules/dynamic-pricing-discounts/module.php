<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Dynamic_Pricing_Discounts;

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
			'Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Post_Type' => ECOMUS_ADDONS_DIR . 'modules/dynamic-pricing-discounts/post-type.php',
			'Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Meta_Box'  => ECOMUS_ADDONS_DIR . 'modules/dynamic-pricing-discounts/meta-box.php',
			'Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Frontend'  => ECOMUS_ADDONS_DIR . 'modules/dynamic-pricing-discounts/frontend.php',
			'Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Settings'  => ECOMUS_ADDONS_DIR . 'modules/dynamic-pricing-discounts/settings.php',
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
			\Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Settings::instance();
		}

		if ( get_option( 'ecomus_dynamic_pricing_discounts', 'yes' ) == 'yes' ) {
			\Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Post_Type::instance();
			\Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Frontend::instance();

			if ( is_admin() ) {
				\Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Meta_Box::instance();
			}
		}

	}

}
