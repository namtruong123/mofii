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
 * Addons Navigation
 */
class Navigation {

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
			'Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Orders_Fake'       => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/navigation/orders-fake.php',
			'Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Orders'    	       => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/navigation/orders.php',
			'Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Product_Type' 	   => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/navigation/product-type.php',
			'Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Selected_Products' => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/navigation/selected-products.php',
			'Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Categories'		   => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/navigation/categories.php',
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
		\Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Orders_Fake::instance();
		\Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Orders::instance();
		\Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Product_Type::instance();
		\Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Selected_Products::instance();
		\Ecomus\Addons\Modules\Live_Sales_Notification\Navigation\Categories::instance();
	}

}
