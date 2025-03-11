<?php
/**
 * Load and register widgets
 *
 * @package Ecomus
 */

namespace Ecomus\Addons;
/**
 * Ecomus theme init
 */
class Widgets {

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
		// Include plugin files
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}


	/**
	 * Register widgets
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function register_widgets() {
		$this->includes();
		$this->add_actions();
	}

	/**
	 * Include Files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function includes() {
		\Ecomus\Addons\Auto_Loader::register( [
			'Ecomus\Addons\Widgets\Instagram_Widget'    => ECOMUS_ADDONS_DIR . 'inc/widgets/instagram.php',
			'Ecomus\Addons\Widgets\Recent_Posts_Widget' => ECOMUS_ADDONS_DIR . 'inc/widgets/recent-posts.php',
			'Ecomus\Addons\Widgets\Social_Links'        => ECOMUS_ADDONS_DIR . 'inc/widgets/socials.php',
			'Ecomus\Addons\Widgets\IconBox'             => ECOMUS_ADDONS_DIR . 'inc/widgets/icon-box/icon-box.php',
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
		register_widget( new \Ecomus\Addons\Widgets\Instagram_Widget() );
		register_widget( new \Ecomus\Addons\Widgets\Recent_Posts_Widget() );
		register_widget( new \Ecomus\Addons\Widgets\Social_Links() );
		register_widget( new \Ecomus\Addons\Widgets\IconBox() );
	}

}