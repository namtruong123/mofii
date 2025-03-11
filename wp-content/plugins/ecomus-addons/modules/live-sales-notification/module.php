<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Live_Sales_Notification;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
			'Ecomus\Addons\Modules\Live_Sales_Notification\Settings'   => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/settings.php',
			'Ecomus\Addons\Modules\Live_Sales_Notification\Frontend'   => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/frontend.php',
			'Ecomus\Addons\Modules\Live_Sales_Notification\Helper'     => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/helper.php',
			'Ecomus\Addons\Modules\Live_Sales_Notification\Navigation' => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/navigation/navigation.php',
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
			\Ecomus\Addons\Modules\Live_Sales_Notification\Settings::instance();
		}

		if ( get_option( 'ecomus_live_sales_notification' ) == 'yes' && ! is_customize_preview() ) {
			\Ecomus\Addons\Modules\Live_Sales_Notification\Helper::instance();
			\Ecomus\Addons\Modules\Live_Sales_Notification\Frontend::instance();
			\Ecomus\Addons\Modules\Live_Sales_Notification\Navigation::instance();
		}
	}

}
