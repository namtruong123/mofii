<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Products_Filter;

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
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}


	/**
	 * Register widgets
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_widgets() {
		if( apply_filters( 'ecomus_product_filter_widgets_elementor', true) ) {
			\Ecomus\Addons\Auto_Loader::register( [
				'Ecomus\Addons\Modules\Products_Filter\Widget'    => ECOMUS_ADDONS_DIR . 'modules/products-filter/widget.php',
			] );

			if ( class_exists( 'WooCommerce' ) ) {
				register_widget( new \Ecomus\Addons\Modules\Products_Filter\Widget() );
			}
		}
	}

}
