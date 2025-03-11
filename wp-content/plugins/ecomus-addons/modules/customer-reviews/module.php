<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Customer_Reviews;

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
			'Ecomus\Addons\Modules\Customer_Reviews\Settings' => ECOMUS_ADDONS_DIR . 'modules/customer-reviews/settings.php',
			'Ecomus\Addons\Modules\Customer_Reviews\Meta_Box' => ECOMUS_ADDONS_DIR . 'modules/customer-reviews/meta-box.php',
			'Ecomus\Addons\Modules\Customer_Reviews\Frontend' => ECOMUS_ADDONS_DIR . 'modules/customer-reviews/frontend.php',
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
			\Ecomus\Addons\Modules\Customer_Reviews\Settings::instance();
		}

		if ( get_option( 'ecomus_customer_reviews_upload' ) == 'yes' ) {
			\Ecomus\Addons\Modules\Customer_Reviews\Frontend::instance();

			if ( is_admin() ) {
				\Ecomus\Addons\Modules\Customer_Reviews\Meta_Box::instance();
			}
		}
	}

}
