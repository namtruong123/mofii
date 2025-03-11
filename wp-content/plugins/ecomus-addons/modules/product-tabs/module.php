<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Product_Tabs;

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
		add_action('current_screen', array( $this, 'product_meta'));
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
			'Ecomus\Addons\Modules\Product_Tabs\FrontEnd'        => ECOMUS_ADDONS_DIR . 'modules/product-tabs/frontend.php',
			'Ecomus\Addons\Modules\Product_Tabs\Settings'    	=> ECOMUS_ADDONS_DIR . 'modules/product-tabs/settings.php',
			'Ecomus\Addons\Modules\Product_Tabs\Product_Meta'    => ECOMUS_ADDONS_DIR . 'modules/product-tabs/product-meta.php',
			'Ecomus\Addons\Modules\Product_Tabs\Post_Type'    		=> ECOMUS_ADDONS_DIR . 'modules/product-tabs/post-type.php',
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
		if ( get_option( 'ecomus_product_tab' ) == 'yes' && is_singular('product') && ! is_customize_preview() ) {
			\Ecomus\Addons\Modules\Product_Tabs\FrontEnd::instance();
		}
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function actions() {
		if ( get_option( 'ecomus_product_tab' ) == 'yes' ) {
			\Ecomus\Addons\Modules\Product_Tabs\Post_Type::instance();
		}

		if( is_admin() ) {
			\Ecomus\Addons\Modules\Product_Tabs\Settings::instance();
		}
	}


	/**
	 * Product Meta
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_meta() {
		if ( ! is_admin() ) {
			return;
		}

		if ( get_option( 'ecomus_product_tab' ) != 'yes' ) {
			return;
		}

		$screen = get_current_screen();
		if($screen->post_type == 'product') {
			\Ecomus\Addons\Modules\Product_Tabs\Product_Meta::instance();
		}
	}

}
