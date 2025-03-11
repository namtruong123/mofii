<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Linked_Variant;

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
			'Ecomus\Addons\Modules\Linked_Variant\Post_Type' => ECOMUS_ADDONS_DIR . 'modules/linked-variant/post-type.php',
			'Ecomus\Addons\Modules\Linked_Variant\Meta_Box'  => ECOMUS_ADDONS_DIR . 'modules/linked-variant/meta-box.php',
			'Ecomus\Addons\Modules\Linked_Variant\Frontend'  => ECOMUS_ADDONS_DIR . 'modules/linked-variant/frontend.php',
			'Ecomus\Addons\Modules\Linked_Variant\Settings'  => ECOMUS_ADDONS_DIR . 'modules/linked-variant/settings.php',
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
			\Ecomus\Addons\Modules\Linked_Variant\Settings::instance();
		}

		if ( get_option( 'ecomus_linked_variant' ) == 'yes' ) {
			\Ecomus\Addons\Modules\Linked_Variant\Post_Type::instance();
			\Ecomus\Addons\Modules\Linked_Variant\Frontend::instance();

			if ( is_admin() ) {
				\Ecomus\Addons\Modules\Linked_Variant\Meta_Box::instance();
			}
		}

	}

}
