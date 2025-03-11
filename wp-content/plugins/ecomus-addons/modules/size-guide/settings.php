<?php

namespace Ecomus\Addons\Modules\Size_Guide;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings {

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

	const POST_TYPE     = 'ecomus_size_guide';
	const OPTION_NAME   = 'ecomus_size_guide';


	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'woocommerce_get_sections_products', array( $this, 'size_guide_section' ), 100, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'size_guide_settings' ), 100, 2 );

		// Make sure the post types are loaded for imports
		add_action( 'import_start', array( $this, 'register_post_type' ) );

		if ( get_option( 'ecomus_size_guide', 'yes' ) != 'yes' ) {
			return;
		}

		$this->register_post_type();

		// Handle post columns
		add_filter( sprintf( 'manage_%s_posts_columns', self::POST_TYPE ), array( $this, 'edit_admin_columns' ) );
		add_action( sprintf( 'manage_%s_posts_custom_column', self::POST_TYPE ), array( $this, 'manage_custom_columns' ), 10, 2 );

		// Add meta boxes.
		add_action( 'add_meta_boxes', array( $this, 'meta_boxes' ), 1 );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );

		// Enqueue style and javascript
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		// Add JS templates to footer.
		add_action( 'admin_print_scripts', array( $this, 'templates' ) );

		// Add options to product.
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'product_data_tab' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_data_panel' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'process_product_meta' ) );
		add_action( 'wp_ajax_ecomus_addons_load_product_size_guide_attributes', array( $this, 'ajax_load_product_size_guide_attributes' ) );
	}

	/**
	 * Add Size Guide settings section to the Products setting tab.
     *
	 * @since 1.0.0
	 *
	 * @param array $sections
	 * @return array
	 */
	public function size_guide_section( $sections ) {
		$sections['ecomus_addons_size_guide'] = esc_html__( 'Size Guide', 'ecomus-addons' );

		return $sections;
	}

	/**
	 * Adds a new setting field to products tab.
     *
	 * @since 1.0.0
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function size_guide_settings( $settings, $section ) {
		if ( 'ecomus_addons_size_guide' != $section ) {
			return $settings;
		}

		$settings_size_guide = array(
			array(
				'name' => esc_html__( 'Size Guide', 'ecomus-addons' ),
				'type' => 'title',
				'id'   => self::OPTION_NAME . '_options',
			),
			array(
				'name'    => esc_html__( 'Enable Size Guide', 'ecomus-addons' ),
				'desc'    => esc_html__( 'Enable product size guides', 'ecomus-addons' ),
				'id'      => self::OPTION_NAME,
				'default' => 'yes',
				'type'    => 'checkbox',
				'checkboxgroup' => 'start',
			),
			array(
				'desc'    => esc_html__( 'Enable on variable products only', 'ecomus-addons' ),
				'id'      => self::OPTION_NAME . '_variable_only',
				'default' => 'no',
				'type'    => 'checkbox',
				'checkboxgroup' => 'end',
			),
			array(
				'name'    => esc_html__( 'Guide Display', 'ecomus-addons' ),
				'id'      => self::OPTION_NAME . '_display',
				'default' => 'tab',
				'class'   => 'wc-enhanced-select',
				'type'    => 'select',
				'options' => array(
					'tab'   => esc_html__( 'In product tabs', 'ecomus-addons' ),
					'panel' => esc_html__( 'By clicking on a button', 'ecomus-addons' ),
				),
			),
			array(
				'name'    => esc_html__( 'Button Position', 'ecomus-addons' ),
				'id'      => self::OPTION_NAME . '_button_position',
				'default' => 'beside_attribute',
				'class'   => 'wc-enhanced-select',
				'type'    => 'select',
				'options' => array(
					'bellow_summary'   => esc_html__( 'Bellow short description', 'ecomus-addons' ),
					'bellow_price'     => esc_html__( 'Bellow price', 'ecomus-addons' ),
					'bellow_button'     => esc_html__( 'Bellow Add To Cart button', 'ecomus-addons' ),
					'beside_attribute' => esc_html__( 'Beside the Size attribute (for variable products only)', 'ecomus-addons' ),
				),
			),
			array(
				'name'    => esc_html__( 'Attribute Slug', 'ecomus-addons' ),
				'id'      => self::OPTION_NAME . '_attribute',
				'default' => 'size',
				'type'    => 'text',
				'desc_tip' => esc_html__( 'This is the slug of a product attribute', 'ecomus-addons' ),
			),
			array(
				'type' => 'sectionend',
				'id'   => self::OPTION_NAME . '_options',
			),
		);

		return $settings_size_guide;
	}

	/**
	 * Register size guide post type
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
			'description'         => esc_html__( 'Product size guide', 'ecomus-addons' ),
			'labels'              => array(
				'name'                  => esc_html__( 'Size Guide', 'ecomus-addons' ),
				'singular_name'         => esc_html__( 'Size Guide', 'ecomus-addons' ),
				'menu_name'             => esc_html__( 'Size Guides', 'ecomus-addons' ),
				'all_items'             => esc_html__( 'Size Guides', 'ecomus-addons' ),
				'add_new'               => esc_html__( 'Add New', 'ecomus-addons' ),
				'add_new_item'          => esc_html__( 'Add New Size Guide', 'ecomus-addons' ),
				'edit_item'             => esc_html__( 'Edit Size Guide', 'ecomus-addons' ),
				'new_item'              => esc_html__( 'New Size Guide', 'ecomus-addons' ),
				'view_item'             => esc_html__( 'View Size Guide', 'ecomus-addons' ),
				'search_items'          => esc_html__( 'Search size guides', 'ecomus-addons' ),
				'not_found'             => esc_html__( 'No size guide found', 'ecomus-addons' ),
				'not_found_in_trash'    => esc_html__( 'No size guide found in Trash', 'ecomus-addons' ),
				'filter_items_list'     => esc_html__( 'Filter size guides list', 'ecomus-addons' ),
				'items_list_navigation' => esc_html__( 'Size guides list navigation', 'ecomus-addons' ),
				'items_list'            => esc_html__( 'Size guides list', 'ecomus-addons' ),
			),
			'supports'            => array( 'title', 'editor' ),
			'rewrite'             => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'show_in_menu'        => 'edit.php?post_type=product',
			'menu_position'       => 20,
			'capability_type'     => 'page',
			'query_var'           => is_admin(),
			'map_meta_cap'        => true,
			'exclude_from_search' => true,
			'hierarchical'        => false,
			'has_archive'         => false,
			'show_in_nav_menus'   => true,
			'taxonomies'          => array( 'product_cat' ),
		) );
	}

	/**
	 * Add custom column to size guides management screen
	 * Add Thumbnail column
     *
	 * @since 1.0.0
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function edit_admin_columns( $columns ) {
		$columns = array_merge( $columns, array(
			'apply_to' => esc_html__( 'Apply to Category', 'ecomus-addons' )
		) );

		return $columns;
	}

	/**
	 * Handle custom column display
     *
	 * @since 1.0.0
	 *
	 * @param  string $column
	 * @param  int    $post_id
	 */
	public function manage_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'apply_to':
				$cats = get_post_meta( $post_id, 'size_guide_category', true );
				$selected = is_array( $cats ) ? 'custom' : $cats;
				$selected = $selected ? $selected : 'none';

				switch ( $selected ) {
					case 'none':
						esc_html_e( 'No Category', 'ecomus-addons' );
						break;

					case 'all':
						esc_html_e( 'All Categories', 'ecomus-addons' );
						break;

					case 'custom':
						$links = array();

						if ( is_array( $cats ) ) {
							foreach ( $cats as $cat_id ) {
								$cat = get_term( $cat_id, 'product_cat' );
								if( ! is_wp_error( $cat ) && $cat ) {
									$links[] = sprintf( '<a href="%s">%s</a>', esc_url( get_edit_term_link( $cat_id, 'product_cat', 'product' ) ), $cat->name );
								}

							}
						} else {
							$links[] = esc_html_e( 'No Category', 'ecomus-addons' );
						}

						echo implode( ', ', $links );
						break;
				}
				break;
		}
	}

	/**
	 * Get option of size guide.
     *
	 * @since 1.0.0
	 *
	 * @param string $option
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get_option( $option = '', $default = false ) {
		if ( ! is_string( $option ) ) {
			return $default;
		}

		if ( empty( $option ) ) {
			return get_option( self::OPTION_NAME, $default );
		}

		return get_option( sprintf( '%s_%s', self::OPTION_NAME, $option ), $default );
	}

	/**
	 * Add meta boxes
	 *
	 * @param object $post
	 */
	public function meta_boxes( $post ) {
		add_meta_box( 'ecomus-size-guide-category', esc_html__( 'Apply to Categories', 'ecomus-addons' ), array( $this, 'category_meta_box' ), self::POST_TYPE, 'side' );
		add_meta_box( 'ecomus-size-guide-tables', esc_html__( 'Tables', 'ecomus-addons' ), array( $this, 'tables_meta_box' ), self::POST_TYPE, 'advanced', 'high' );
	}

	/**
	 * Category meta box.
     *
	 * @since 1.0.0
	 *
	 * @param object $post
     *
     * @return void
	 */
	public function category_meta_box( $post ) {
		$cats = get_post_meta( $post->ID, 'size_guide_category', true );
		$selected = is_array( $cats ) ? 'custom' : $cats;
		$selected = $selected ? $selected : 'none';
		?>
		<p>
			<label>
				<input type="radio" name="_size_guide_category" value="none" <?php checked( 'none', $selected ) ?>>
				<?php esc_html_e( 'No category', 'ecomus-addons' ); ?>
			</label>
		</p>

		<p>
			<label>
				<input type="radio" name="_size_guide_category" value="all" <?php checked( 'all', $selected ) ?>>
				<?php esc_html_e( 'All Categories', 'ecomus-addons' ); ?>
			</label>
		</p>

		<p>
			<label>
				<input type="radio" name="_size_guide_category" value="custom" <?php checked( 'custom', $selected ) ?>>
				<?php esc_html_e( 'Select Categories', 'ecomus-addons' ); ?>
			</label>
		</p>

		<div class="taxonomydiv" style="display: none;">
			<div class="tabs-panel">
				<ul class="categorychecklist">
					<?php
					wp_terms_checklist( $post->ID, array(
						'taxonomy'      => 'product_cat',
					) );
					?>
				</ul>
			</div>
		</div>

		<?php
	}

	/**
	 * Tables meta box.
	 * Content will be filled by js.
     *
	 * @since 1.0.0
	 *
	 * @param object $post
	 */
	public function tables_meta_box( $post ) {
		$tables = get_post_meta( $post->ID, 'size_guides', true );
		$tables = $tables ? $tables : array(
			'names' => array( '' ),
			'tabs' => array( __( 'Table 1', 'ecomus-addons' ) ),
			'tables' => array( '[["",""],["",""]]' ),
			'descriptions' => array( '' ),
			'information' => array( '' ),
		);
		wp_localize_script( 'ecomus-size-guide', 'ecomusSizeGuideTables', $tables );
		?>

		<div id="ecomus-size-guide-tabs" class="ecomus-size-guide-tabs">
			<div class="ecomus-size-guide-tabs--tabs">
				<div class="ecomus-size-guide-table-tabs--tab add-new-tab" data-title="<?php esc_attr_e( 'Table', 'ecomus-addons' ) ?>"><span class="dashicons dashicons-plus"></span></div>
			</div>
		</div>

		<?php
	}

	/**
	 * Save meta box content.
     *
	 * @since 1.0.0
	 *
	 * @param int $post_id
	 * @param object $post
     *
	 * @return void
	 */
	public function save_post( $post_id, $post ) {
		// If not the flex post.
		if ( self::POST_TYPE != $post->post_type ) {
			return;
		}

		// Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
		}

		// Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
		}

		if ( ! empty( $_POST['_size_guide_category'] ) ) {
			if ( 'custom' == $_POST['_size_guide_category'] && ! empty( $_POST['tax_input'] ) && ! empty( $_POST['tax_input']['product_cat'] ) ) {
				$cat_ids = array_map( 'intval', $_POST['tax_input']['product_cat'] );
				update_post_meta( $post_id, 'size_guide_category', $cat_ids );

				wp_set_post_terms( $post_id, $cat_ids, 'product_cat' );
			} else {
				update_post_meta( $post_id, 'size_guide_category', $_POST['_size_guide_category'] );
			}
		}

		if ( ! empty( $_POST['_size_guides'] ) ) {
			update_post_meta( $post_id, 'size_guides', $_POST['_size_guides'] );
		}
	}

	/**
	 * Load scripts and style in admin area
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_scripts( $hook ) {
		$screen = get_current_screen();

		if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) && self::POST_TYPE == $screen->post_type ) {
			wp_enqueue_style( 'ecomus-size-guide', ECOMUS_ADDONS_URL . 'modules/size-guide/assets/css/size-guide-admin.css' );

			wp_enqueue_script( 'ecomus-size-guide', ECOMUS_ADDONS_URL . 'modules/size-guide/assets/js/size-guide.js', array( 'jquery', 'wp-util' ),'1.0', true );
		}

		if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) && 'product' == $screen->post_type ) {
			wp_enqueue_style( 'ecomus-product-size-guide', ECOMUS_ADDONS_URL . 'modules/size-guide/assets/css/product-size-guide-admin.css' );

			wp_enqueue_script( 'ecomus-product-size-guide', ECOMUS_ADDONS_URL . 'modules/size-guide/assets/js/product-size-guide.js', array( 'jquery' ),'1.0', true );
		}

		if ( 'woocommerce_page_wc-settings' == $screen->base && ! empty( $_GET['section'] ) && 'ecomus_addons_size_guide' == $_GET['section'] ) {
			wp_enqueue_script( 'ecomus-size-guide', ECOMUS_ADDONS_URL . 'modules/size-guide/assets/js/size-guide-settings.js', array( 'jquery' ),'1.0', true );
		}
	}

	/**
	 * Tab templates
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function templates() {
		?>
		<script type="text/html" id="tmpl-ecomus-size-guide-tab">
			<div class="ecomus-size-guide-table-tabs--tab" data-tab="{{data.index}}">
				<span class="ecomus-size-guide-table-tabs--tab-text">{{data.tab}}</span>
				<input type="text" name="_size_guides[tabs][]" value="{{data.tab}}" class="hidden">
				<span class="dashicons dashicons-edit edit-button"></span>
				<span class="dashicons dashicons-yes confirm-button"></span>
			</div>
		</script>

		<script type="text/html" id="tmpl-ecomus-size-guide-panel">
			<div class="ecomus-size-guide-table-editor" data-tab="{{data.index}}">
				<p>
					<label>
						<?php esc_html_e( 'Table Name', 'ecomus-addons' ); ?><br/>
						<input type="text" name="_size_guides[names][]" class="widefat" value="{{data.name}}">
					</label>
				</p>

				<p>
					<label>
						<?php esc_html_e( 'Description', 'ecomus-addons' ) ?>
						<textarea name="_size_guides[descriptions][]" class="widefat" rows="6">{{data.description}}</textarea>
					</label>
				</p>

				<p><label><?php esc_html_e( 'Table', 'ecomus-addons' ) ?></label></p>

				<textarea name="_size_guides[tables][]" class="widefat ecomus-size-guide-table hidden">{{{data.table}}}</textarea>

				<p>
					<label>
						<?php esc_html_e( 'Additional Information', 'ecomus-addons' ) ?>
						<textarea name="_size_guides[information][]" class="widefat" rows="6">{{{data.information}}}</textarea>
					</label>
				</p>

				<p class="delete-table-p">
					<a href="#" class="delete-table"><?php esc_html_e( 'Delete Table', 'ecomus-addons' ) ?></a>
				</p>
			</div>
		</script>

		<?php
	}

		/**
	 * Add new product data tab for size guide
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	public function product_data_tab( $tabs ) {
		$tabs['ecomus_size_guide'] = array(
			'label'    => esc_html__( 'Size Guide', 'ecomus-addons' ),
			'target'   => 'ecomus-size-guide',
			'class'    => array( 'ecomus-size-guide', ),
			'priority' => 62,
		);

		return $tabs;
	}


	/**
	 * Outputs the size guide panel
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_data_panel() {
		global $post, $thepostid, $product_object;

		$thepostid = empty( $thepostid ) ? $post->ID : $thepostid;
		$default_display = get_option( self::OPTION_NAME . '_display', 'tab' );
		$default_positon = get_option( self::OPTION_NAME . '_button_position', 'beside_attribute' );

		$display_options = array(
			'tab'   => esc_html__( 'In product tabs', 'ecomus-addons' ),
			'panel' => esc_html__( 'By clicking on a button', 'ecomus-addons' ),
		);

		$button_options = array(
			'bellow_summary'   => esc_html__( 'Bellow short description', 'ecomus-addons' ),
			'bellow_price'     => esc_html__( 'Bellow price', 'ecomus-addons' ),
			'bellow_button'     => esc_html__( 'Bellow Add To Cart button', 'ecomus-addons' ),
			'beside_attribute' => esc_html__( 'Beside the Size attribute', 'ecomus-addons' ),
		);

		$product_size_guide = get_post_meta( $thepostid, 'ecomus_size_guide', true );
		$product_size_guide = wp_parse_args( $product_size_guide, array(
			'guide'           => '',
			'display'         => '',
			'button_position' => '',
			'attribute'       => '',
		) );

		$guides = get_posts( array(
			'post_type'      => self::POST_TYPE,
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'fields'         => 'ids',
		) );

		$guide_options = array(
			'' => esc_html__( '--Default--', 'ecomus-addons' ),
			'none' => esc_html__( '--No Size Guide--', 'ecomus-addons' ),
		);
		foreach ( $guides as $guide ) {
			$guide_options[ $guide ] = get_post_field( 'post_title', $guide );
		}

		$attributes   = $product_object->get_attributes( 'edit' );
		$attribute_options = array();
		foreach ( $attributes as $attribute ) {
			if ( ! $attribute->get_variation() ) {
				continue;
			}

			$option_value = $attribute->get_name();
			$option_name =  $option_value;

			if ( $attribute->get_id() ) {
				$taxonomy = wc_get_attribute( $attribute->get_id() );
				$option_name = $taxonomy ? $taxonomy->name : $option_name;
			}

			$attribute_options[ $option_value ] = $option_name;
		}
		?>

		<div id="ecomus-size-guide" class="panel woocommerce_options_panel hidden" data-nonce="<?php echo esc_attr( wp_create_nonce( 'ecomus_size_guide' ) ) ?>">
			<div class="options_group">
				<?php
				woocommerce_wp_select( array(
					'id'      => 'ecomus_size_guide-guide',
					'name'    => 'ecomus_size_guide[guide]',
					'value'   => $product_size_guide['guide'],
					'label'   => esc_html__( 'Size Guide', 'ecomus-addons' ),
					'options' => $guide_options,
				) );
				?>
			</div>

			<div class="options_group">
				<?php
				woocommerce_wp_select( array(
					'id'      => 'ecomus_size_guide-display',
					'name'    => 'ecomus_size_guide[display]',
					'value'   => $product_size_guide['display'],
					'label'   => esc_html__( 'Size Guide Display', 'ecomus-addons' ),
					'options' => array_merge( array( '' => esc_html__( 'Default', 'ecomus-addons' ) . ' (' . $display_options[ $default_display ] . ')' ), $display_options ),
				) );

				woocommerce_wp_select( array(
					'id'      => 'ecomus_size_guide-button_position',
					'name'    => 'ecomus_size_guide[button_position]',
					'value'   => $product_size_guide['button_position'],
					'label'   => esc_html__( 'Button Position', 'ecomus-addons' ),
					'options' => array_merge( array( '' => esc_html__( 'Default', 'ecomus-addons' ) . ' (' . $button_options[ $default_positon ] . ')' ), $button_options ),
				) );

				if ( ! empty( $attribute_options ) ) {
					woocommerce_wp_select( array(
						'id'      => 'ecomus_size_guide-attribute',
						'name'    => 'ecomus_size_guide[attribute]',
						'value'   => $product_size_guide['attribute'],
						'label'   => esc_html__( 'Attribute', 'ecomus-addons' ),
						'options' => $attribute_options,
					) );
				}
				?>
			</div>
		</div>

		<?php
	}

	/**
	 * Save product data of selected size guide
	 *
	 * @param int $post_id
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function process_product_meta( $post_id ) {
		if ( isset( $_POST['ecomus_size_guide'] ) ) {
			update_post_meta( $post_id, 'ecomus_size_guide', $_POST['ecomus_size_guide'] );
		}
	}

	/**
	 * Ajax load product variation attributes.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function ajax_load_product_size_guide_attributes() {
		check_ajax_referer( 'ecomus_size_guide', 'security' );

		if ( ! current_user_can( 'edit_products' ) || empty( $_POST['product_id'] ) ) {
			wp_die( -1 );
		}

		// Set $post global so its available, like within the admin screens.
		global $post;

		$product_id     = absint( $_POST['product_id'] );
		$post           = get_post( $product_id ); // phpcs:ignore
		$product_object = wc_get_product( $product_id );

		$product_size_guide = get_post_meta( $product_id, 'ecomus_size_guide', true );
		$product_size_guide = wp_parse_args( $product_size_guide, array(
			'guide'           => '',
			'display'         => '',
			'button_position' => '',
			'attribute'       => '',
		) );

		$attributes   = $product_object->get_attributes( 'edit' );
		$attribute_options = array();
		foreach ( $attributes as $attribute ) {
			if ( ! $attribute->get_variation() ) {
				continue;
			}

			$option_value = $attribute->get_name();
			$option_name  = $option_value;

			if ( $attribute->get_id() ) {
				$taxonomy = wc_get_attribute( $attribute->get_id() );
				$option_name = $taxonomy ? $taxonomy->name : $option_name;
			}

			$attribute_options[ $option_value ] = $option_name;
		}

		woocommerce_wp_select( array(
			'id'      => 'ecomus_size_guide-attribute',
			'name'    => 'ecomus_size_guide[attribute]',
			'value'   => $product_size_guide['attribute'],
			'label'   => esc_html__( 'Attribute', 'ecomus-addons' ),
			'options' => $attribute_options,
		) );

		wp_die();
	}
}