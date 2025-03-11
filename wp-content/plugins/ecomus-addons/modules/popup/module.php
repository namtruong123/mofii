<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Popup;

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
		add_action('template_redirect', array( $this, 'content'));
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
			'Ecomus\Addons\Modules\Popup\FrontEnd'           => ECOMUS_ADDONS_DIR . 'modules/popup/frontend.php',
			'Ecomus\Addons\Modules\Popup\Settings'           => ECOMUS_ADDONS_DIR . 'modules/popup/settings.php',
			'Ecomus\Addons\Modules\Popup\Elementor_Settings' => ECOMUS_ADDONS_DIR . 'modules/popup/elementor-settings.php',
			'Ecomus\Addons\Modules\Popup\Post_Type'          => ECOMUS_ADDONS_DIR . 'modules/popup/post-type.php',
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
		\Ecomus\Addons\Modules\Popup\Post_Type::instance();

		if( is_admin() ) {
			\Ecomus\Addons\Modules\Popup\Settings::instance();
			if( class_exists('Elementor\Core\Base\Module') ) {
				\Ecomus\Addons\Modules\Popup\Elementor_Settings::instance();
			}
		}

	}

	/**
	 * Single Product
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function content() {
		if ( ! is_customize_preview() ) {
			\Ecomus\Addons\Modules\Popup\FrontEnd::instance();
		}
	}
}
