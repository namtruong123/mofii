<?php
/**
 * Ecomus Addons Modules functions and definitions.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Advanced_Search;

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
			'Ecomus\Addons\Modules\Advanced_Search\Settings'        => ECOMUS_ADDONS_DIR . 'modules/advanced-search/settings.php',
			'Ecomus\Addons\Modules\Advanced_Search\AJAX_Search'        => ECOMUS_ADDONS_DIR . 'modules/advanced-search/ajax-search.php',
			'Ecomus\Addons\Modules\Advanced_Search\Posts'        => ECOMUS_ADDONS_DIR . 'modules/advanced-search/posts.php',
			'Ecomus\Addons\Modules\Advanced_Search\Taxonomies'        => ECOMUS_ADDONS_DIR . 'modules/advanced-search/taxonomies.php',
			'Ecomus\Addons\Modules\Advanced_Search\Catalog'        => ECOMUS_ADDONS_DIR . 'modules/advanced-search/catalog.php',
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
			\Ecomus\Addons\Modules\Advanced_Search\Settings::instance();
		}

		if ( get_option( 'ecomus_ajax_search', 'yes' ) == 'yes' ) {
			\Ecomus\Addons\Modules\Advanced_Search\AJAX_Search::instance();
		}

		\Ecomus\Addons\Modules\Advanced_Search\Catalog::instance();
	}

}
