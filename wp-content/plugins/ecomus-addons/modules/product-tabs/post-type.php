<?php

namespace Ecomus\Addons\Modules\Product_Tabs;

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

	const POST_TYPE     = 'ecomus_product_tab';
	const TAXONOMY_TAB_TYPE     = 'ecomus_product_tab_type';


	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
			// Make sure the post types are loaded for imports
		add_action( 'import_start', array( $this, 'register_post_type' ) );
		$this->register_post_type();

	}

	/**
	 * Register product tabs post type
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
			'description'         => esc_html__( 'Product tabs', 'ecomus-addons' ),
			'labels'              => array(
				'name'                  => esc_html__( 'Product Tabs', 'ecomus-addons' ),
				'singular_name'         => esc_html__( 'Product Tabs', 'ecomus-addons' ),
				'menu_name'             => esc_html__( 'Product Tabs', 'ecomus-addons' ),
				'all_items'             => esc_html__( 'Product Tabs', 'ecomus-addons' ),
				'add_new'               => esc_html__( 'Add New', 'ecomus-addons' ),
				'add_new_item'          => esc_html__( 'Add New Product Tabs', 'ecomus-addons' ),
				'edit_item'             => esc_html__( 'Edit Product Tabs', 'ecomus-addons' ),
				'new_item'              => esc_html__( 'New Product Tabs', 'ecomus-addons' ),
				'view_item'             => esc_html__( 'View Product Tabs', 'ecomus-addons' ),
				'search_items'          => esc_html__( 'Search product tabs', 'ecomus-addons' ),
				'not_found'             => esc_html__( 'No product tabs found', 'ecomus-addons' ),
				'not_found_in_trash'    => esc_html__( 'No product tabs found in Trash', 'ecomus-addons' ),
				'filter_items_list'     => esc_html__( 'Filter product tabss list', 'ecomus-addons' ),
				'items_list_navigation' => esc_html__( 'Product tabs list navigation', 'ecomus-addons' ),
				'items_list'            => esc_html__( 'Product tabs list', 'ecomus-addons' ),
			),
			'supports'            => array( 'title', 'editor' ),
			'rewrite'             => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'show_in_menu'        => 'edit.php?post_type=product',
			'menu_position'       => 20,
			'capability_type'     => 'page',
			'query_var'           => is_admin(),
			'map_meta_cap'        => true,
			'exclude_from_search' => false,
			'hierarchical'        => false,
			'has_archive'         => false,
			'show_in_nav_menus'   => false,
		) );

		register_taxonomy(
			self::TAXONOMY_TAB_TYPE,
			array( self::POST_TYPE ),
			array(
				'hierarchical'      => true,
				'show_ui'           => false,
				'show_in_nav_menus' => false,
				'query_var'         => is_admin(),
				'rewrite'           => false,
				'public'            => true,
				'label'             => _x( 'Product Tabs Type', 'Taxonomy name', 'ecomus-addons' ),
			)
		);
	}


}