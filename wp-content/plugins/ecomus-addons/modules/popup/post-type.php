<?php

namespace Ecomus\Addons\Modules\Popup;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Post_Type  {

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

	const POST_TYPE         = 'ecomus_popup';
	const TAXONOMY_TAB_TYPE = 'ecomus_popup_type';


	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
			// Make sure the post types are loaded for imports
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 50 );

		add_action( 'import_start', array( $this, 'register_post_type' ), 30 );
		$this->register_post_type();

		add_filter( 'single_template', array( $this, 'load_canvas_template' ) );

	}

	/**
	 * Register popup post type
     *
	 * @since 1.0.0
     *
     * @return void
	 */
	public function register_post_type() {
		if(post_type_exists(self::POST_TYPE)) {
			return;
		}

		register_post_type( self::POST_TYPE, array(
			'description'         => esc_html__( 'Theme Popup', 'ecomus-addons' ),
			'labels'              => array(
				'name'                  => esc_html__( 'Theme Popup', 'ecomus-addons' ),
				'singular_name'         => esc_html__( 'Theme Popup', 'ecomus-addons' ),
				'menu_name'             => esc_html__( 'Theme Popup', 'ecomus-addons' ),
				'all_items'             => esc_html__( 'Theme Popup', 'ecomus-addons' ),
				'add_new'               => esc_html__( 'Add New', 'ecomus-addons' ),
				'add_new_item'          => esc_html__( 'Add New Popup', 'ecomus-addons' ),
				'edit_item'             => esc_html__( 'Edit Popup', 'ecomus-addons' ),
				'new_item'              => esc_html__( 'New Popup', 'ecomus-addons' ),
				'view_item'             => esc_html__( 'View Popup', 'ecomus-addons' ),
				'search_items'          => esc_html__( 'Search popup', 'ecomus-addons' ),
				'not_found'             => esc_html__( 'No popup found', 'ecomus-addons' ),
				'not_found_in_trash'    => esc_html__( 'No popup found in Trash', 'ecomus-addons' ),
				'filter_items_list'     => esc_html__( 'Filter popups list', 'ecomus-addons' ),
				'items_list_navigation' => esc_html__( 'Popup list navigation', 'ecomus-addons' ),
				'items_list'            => esc_html__( 'Popup list', 'ecomus-addons' ),
			),
			'supports'            => array( 'title', 'editor', 'elementor' ),
			'public'              => true,
			'rewrite'             => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'show_in_menu'        => false,
		) );

	}

	public function register_admin_menu() {
		add_submenu_page(
			'ecomus_dashboard',
			esc_html__( 'Theme Popup', 'ecomus-addons' ),
			esc_html__( 'Theme Popup', 'ecomus-addons' ),
			'edit_pages',
			'edit.php?post_type=' . self::POST_TYPE . ''
		);

	}

	function load_canvas_template( $single_template ) {
		global $post;

		if( 'ecomus_popup' == $post->post_type ) {
			return ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';
		}

		return $single_template;
	}
}