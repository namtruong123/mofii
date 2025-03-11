<?php
/**
 * Register template builder
 */

namespace Ecomus\Addons\Elementor\Builder;

class Post_Type {

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

	const POST_TYPE     = 'ecomus_builder';
	const OPTION_NAME   = 'ecomus_builder';
	const TAXONOMY_TYPE = 'ecomus_builder_type';

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 50 );

		// Make sure the post types are loaded for imports
		add_action( 'import_start', array( $this, 'register_post_type' ) );

		// Register custom post type and custom taxonomy
		$this->register_post_type();

		// Register custom post type and custom taxonomy
		$this->register_taxonomy();

		add_action('admin_init', array( $this, 'create_terms' ));

		add_filter( 'single_template', array( $this, 'load_canvas_template' ) );
	}

	/**
	 * Register portfolio post type
	 */
	public function register_post_type() {
		// Template Builder
		$labels = array(
			'name'               => esc_html__( 'Ecomus Templates Builder', 'ecomus-addons' ),
			'singular_name'      => esc_html__( 'Ecomus Template', 'ecomus-addons' ),
			'menu_name'          => esc_html__( 'Ecomus Template', 'ecomus-addons' ),
			'name_admin_bar'     => esc_html__( 'Ecomus Template', 'ecomus-addons' ),
			'add_new'            => esc_html__( 'Add New', 'ecomus-addons' ),
			'add_new_item'       => esc_html__( 'Add New Template', 'ecomus-addons' ),
			'new_item'           => esc_html__( 'New Template', 'ecomus-addons' ),
			'edit_item'          => esc_html__( 'Edit Template', 'ecomus-addons' ),
			'view_item'          => esc_html__( 'View Template', 'ecomus-addons' ),
			'all_items'          => esc_html__( 'All Elementor', 'ecomus-addons' ),
			'search_items'       => esc_html__( 'Search Templates', 'ecomus-addons' ),
			'parent_item_colon'  => esc_html__( 'Parent Template:', 'ecomus-addons' ),
			'not_found'          => esc_html__( 'No Templates found.', 'ecomus-addons' ),
			'not_found_in_trash' => esc_html__( 'No Templates found in Trash.', 'ecomus-addons' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'rewrite'             => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'supports'            => array( 'title', 'editor', 'elementor' ),
		);

		if ( ! post_type_exists( self::POST_TYPE ) ) {
			register_post_type( self::POST_TYPE, $args );
		}
	}

	public function register_admin_menu() {
		add_submenu_page(
			'ecomus_dashboard',
			esc_html__( 'Templates Builder', 'ecomus-addons' ),
			esc_html__( 'Templates Builder', 'ecomus-addons' ),
			'edit_pages',
			'edit.php?post_type=' . self::POST_TYPE . ''
		);

	}

	/**
	 * Register core taxonomies.
	 */
	public function register_taxonomy() {
		if ( taxonomy_exists( self::TAXONOMY_TYPE ) ) {
			return;
		}

		register_taxonomy(
			self::TAXONOMY_TYPE,
			array( self::POST_TYPE ),
			array(
				'hierarchical'      => false,
				'show_ui'           => false,
				'show_in_nav_menus' => false,
				'query_var'         => is_admin(),
				'rewrite'           => false,
				'public'            => false,
				'label'             => _x( 'Ecomus Builder Type', 'Taxonomy name', 'ecomus-addons' ),
			)
		);
	}

	public function create_terms() {
		$terms = array(
			'enable',
			'footer',
			'product',
			'archive',
			'cart_page',
			'checkout_page',
			'404_page',
		);

		foreach ( $terms as $term ) {
			if ( ! get_term_by( 'name', $term, self::TAXONOMY_TYPE ) ) { // @codingStandardsIgnoreLine.
				wp_insert_term( $term, self::TAXONOMY_TYPE );
			}
		}
	}

	function load_canvas_template( $single_template ) {
		global $post;

		if( 'ecomus_builder' == $post->post_type ) {
			if( has_term( 'footer', self::TAXONOMY_TYPE, $post->ID ) ) {
				return ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';
			} else {
				return ECOMUS_ADDONS_DIR . 'inc/elementor/builder/templates/header-footer.php';
			}
		}

		return $single_template;
	}
}