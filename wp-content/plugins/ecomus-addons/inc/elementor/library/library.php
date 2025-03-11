<?php
/**
 * Ecomus Addons Library functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Library
 */
class Library {

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
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function dir_path() {
		return 'https://wpecomus.com/data/library/';
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
			'Ecomus\Addons\Elementor\Library\Templates' 			    => ECOMUS_ADDONS_DIR . 'inc/elementor/library/includes/templates.php',
			'Ecomus\Addons\Elementor\Library\Templates_Source' 		=> ECOMUS_ADDONS_DIR . 'inc/elementor/library/includes/templates_source.php',
		] );
	}


	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function add_actions() {
		\Ecomus\Addons\Elementor\Library\Templates::init();
	}
}
