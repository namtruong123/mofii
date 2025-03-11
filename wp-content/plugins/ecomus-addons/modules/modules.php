<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Modules
 */
class Modules {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Registered modules.
	 *
	 * Holds the list of all the registered modules.
	 *
	 * @var array
	 */
	private $modules = [];

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
		$this->register( 'mega-menu' );

		$this->includes();
		add_action( 'init', [ $this, 'add_actions' ] );
		\Ecomus\Addons\Modules\Products_Filter\Module::instance();

		add_action( 'init', [ $this, 'activate' ] );

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
			'Ecomus\Addons\Modules\Base\Variation_Select'             => ECOMUS_ADDONS_DIR . 'modules/base/variation-select.php',
			'Ecomus\Addons\Modules\Products_Filter\Module'            => ECOMUS_ADDONS_DIR . 'modules/products-filter/module.php',
			'Ecomus\Addons\Modules\Size_Guide\Module'                 => ECOMUS_ADDONS_DIR . 'modules/size-guide/module.php',
			'Ecomus\Addons\Modules\Buy_Now\Module'                    => ECOMUS_ADDONS_DIR . 'modules/buy-now/module.php',
			'Ecomus\Addons\Modules\Sticky_Add_To_Cart\Module'         => ECOMUS_ADDONS_DIR . 'modules/sticky-add-to-cart/module.php',
			'Ecomus\Addons\Modules\Product_Tabs\Module'               => ECOMUS_ADDONS_DIR . 'modules/product-tabs/module.php',
			'Ecomus\Addons\Modules\Live_Sales_Notification\Module'    => ECOMUS_ADDONS_DIR . 'modules/live-sales-notification/module.php',
			'Ecomus\Addons\Modules\Variation_Images\Module'           => ECOMUS_ADDONS_DIR . 'modules/variation-images/module.php',
			'Ecomus\Addons\Modules\Product_Bought_Together\Module'    => ECOMUS_ADDONS_DIR . 'modules/product-bought-together/module.php',
			'Ecomus\Addons\Modules\Variation_Compare\Module'          => ECOMUS_ADDONS_DIR . 'modules/variation-compare/module.php',
			'Ecomus\Addons\Modules\People_View_Fake\Module'           => ECOMUS_ADDONS_DIR . 'modules/people-view-fake/module.php',
			'Ecomus\Addons\Modules\Cart_Tracking\Module'              => ECOMUS_ADDONS_DIR . 'modules/cart-tracking/module.php',
			'Ecomus\Addons\Modules\Free_Shipping_Bar\Module'          => ECOMUS_ADDONS_DIR . 'modules/free-shipping-bar/module.php',
			'Ecomus\Addons\Modules\Product_Video\Module'              => ECOMUS_ADDONS_DIR . 'modules/product-video/module.php',
			'Ecomus\Addons\Modules\Product_Variations_Listing\Module' => ECOMUS_ADDONS_DIR . 'modules/product-variations-listing/module.php',
			'Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Module'  => ECOMUS_ADDONS_DIR . 'modules/dynamic-pricing-discounts/module.php',
			'Ecomus\Addons\Modules\Advanced_Linked_Products\Module'   => ECOMUS_ADDONS_DIR . 'modules/advanced-linked-products/module.php',
			'Ecomus\Addons\Modules\Product_360_View\Module'           => ECOMUS_ADDONS_DIR . 'modules/product-360-view/module.php',
			'Ecomus\Addons\Modules\Advanced_Search\Module'            => ECOMUS_ADDONS_DIR . 'modules/advanced-search/module.php',
			'Ecomus\Addons\Modules\Product_Deals\Module'              => ECOMUS_ADDONS_DIR . 'modules/product-deals/module.php',
			'Ecomus\Addons\Modules\Popup\Module'                      => ECOMUS_ADDONS_DIR . 'modules/popup/module.php',
			'Ecomus\Addons\Modules\Add_To_Cart_Ajax\Module'           => ECOMUS_ADDONS_DIR . 'modules/add-to-cart-ajax/module.php',
			'Ecomus\Addons\Modules\Catalog_Mode\Module'    			  => ECOMUS_ADDONS_DIR . 'modules/catalog-mode/module.php',
			'Ecomus\Addons\Modules\Inventory\Module'    			  => ECOMUS_ADDONS_DIR . 'modules/inventory/module.php',
			'Ecomus\Addons\Modules\Recent_Sales_Count\Module'         => ECOMUS_ADDONS_DIR . 'modules/recent-sales-count/module.php',
			'Ecomus\Addons\Modules\Catalog_Mode\Module'    			  => ECOMUS_ADDONS_DIR . 'modules/catalog-mode/module.php',
			'Ecomus\Addons\Modules\Inventory\Module'    			  => ECOMUS_ADDONS_DIR . 'modules/inventory/module.php',
			'Ecomus\Addons\Modules\Linked_Variant\Module'    		  => ECOMUS_ADDONS_DIR . 'modules/linked-variant/module.php',
			'Ecomus\Addons\Modules\Customer_Reviews\Module'    		  => ECOMUS_ADDONS_DIR . 'modules/customer-reviews/module.php',
			'Ecomus\Addons\Modules\Buy_X_Get_Y\Module'    		      => ECOMUS_ADDONS_DIR . 'modules/buy-x-get-y/module.php',
		] );
	}


	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_actions() {
		\Ecomus\Addons\Modules\Size_Guide\Module::instance();
		\Ecomus\Addons\Modules\Buy_Now\Module::instance();
		\Ecomus\Addons\Modules\Sticky_Add_To_Cart\Module::instance();
		\Ecomus\Addons\Modules\Product_Tabs\Module::instance();
		\Ecomus\Addons\Modules\Live_Sales_Notification\Module::instance();
		\Ecomus\Addons\Modules\Variation_Images\Module::instance();
		\Ecomus\Addons\Modules\Product_Bought_Together\Module::instance();
		\Ecomus\Addons\Modules\Variation_Compare\Module::instance();
		\Ecomus\Addons\Modules\People_View_Fake\Module::instance();
		\Ecomus\Addons\Modules\Cart_Tracking\Module::instance();
		\Ecomus\Addons\Modules\Free_Shipping_Bar\Module::instance();
		\Ecomus\Addons\Modules\Product_Video\Module::instance();
		\Ecomus\Addons\Modules\Product_Variations_Listing\Module::instance();
		\Ecomus\Addons\Modules\Dynamic_Pricing_Discounts\Module::instance();
		\Ecomus\Addons\Modules\Advanced_Linked_Products\Module::instance();
		\Ecomus\Addons\Modules\Product_3D_Viewer\Module::instance();
		\Ecomus\Addons\Modules\Advanced_Search\Module::instance();
		\Ecomus\Addons\Modules\Product_Deals\Module::instance();
		\Ecomus\Addons\Modules\Popup\Module::instance();
		\Ecomus\Addons\Modules\Add_To_Cart_Ajax\Module::instance();
		\Ecomus\Addons\Modules\Catalog_Mode\Module::instance();
		\Ecomus\Addons\Modules\Inventory\Module::instance();
		\Ecomus\Addons\Modules\Recent_Sales_Count\Module::instance();
		\Ecomus\Addons\Modules\Catalog_Mode\Module::instance();
		\Ecomus\Addons\Modules\Inventory\Module::instance();
		\Ecomus\Addons\Modules\Linked_Variant\Module::instance();
		\Ecomus\Addons\Modules\Customer_Reviews\Module::instance();
	//	\Ecomus\Addons\Modules\Buy_X_Get_Y\Module::instance();
	}

	/**
	 * Register a module
	 *
	 * @param string $module_name
	 */
	public function register( $module_name ) {
		if ( ! array_key_exists( $module_name, $this->modules ) ) {
			$this->modules[ $module_name ] = null;
		}
	}

	/**
	 * Deregister a moudle.
	 * Only allow deregistering a module if it is not activated.
	 *
	 * @param string $module_name
	 */
	public function deregister( $module_name ) {
		if ( ! array_key_exists( $module_name, $this->modules ) && empty( $this->modules[ $module_name ] ) ) {
			unset( $this->modules[ $module_name ] );
		}
	}

	/**
	 * Active all registered modules
	 *
	 * @return void
	 */
	public function activate() {
		foreach ( $this->modules as $module_name => $instance ) {
			if ( ! empty( $instance ) ) {
				continue;
			}

			$classname = $this->get_module_classname( $module_name );

			if ( $classname ) {
				$this->modules[ $module_name ] = $classname::instance();
			}
		}

	}

	/**
	 * Get module class name
	 *
	 * @param string $module_name
	 * @return string
	 */
	public function get_module_classname( $module_name ) {
		$class_name = str_replace( '-', ' ', $module_name );
		$class_name = str_replace( ' ', '_', ucwords( $class_name ) );
		$class_name = 'Ecomus\\Addons\\Modules\\' . $class_name . '\\Module';

		return $class_name;
	}
}
