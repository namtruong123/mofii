<?php

namespace Ecomus\Addons\Elementor\Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use \Ecomus\Addons\Elementor\Builder\Helper;

/**
 * Main class of plugin for admin
 */
class Product_Archive {
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
	 * Product Archive  id
	 *
	 * @var $product_archive_id
	 */
	private static $product_archive_id;

	/**
	 * @var string catalog view
	 */
	public static $catalog_view;

	protected static $view_cookie_name = 'catalog_view';

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'body_class', array( $this, 'body_classes' ) );

		add_filter( 'template_include', array( $this, 'redirect_template' ), 100 );
		add_filter( 'ecomus_is_page_built_with_elementor', '__return_true' );

		// Scripts and styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'ecomus_woocommerce_product_archive_content', array( $this, 'archive_content_builder' ), 5 );

		// Change row actions in admin
		add_filter( 'display_post_states', [ $this, 'ecomus_post_state' ], 11, 2 );
		add_filter( 'get_edit_post_link', [ $this, 'ecomus_get_edit_post_link' ], 11, 3 );
		add_filter( 'page_row_actions', array( $this, 'ecomus_page_row_actions' ), 11, 2 );

		// Change shop default view
		add_filter( 'woocommerce_shortcode_products_query', [ $this, 'shortcode_products_query' ], 10, 3 );

		add_filter( 'loop_shop_columns', '__return_false' );
		add_filter( 'loop_shop_per_page', '__return_false' );

		// Set coookie
		self::set_cookie();
	}

	public function body_classes( $classes ) {
		$terms = Helper::ecomus_get_terms();
		self::$product_archive_id = self::get_product_archive_id();

		if( is_singular( 'ecomus_builder' ) && in_array( 'archive', $terms ) ) {
			$classes[] = 'ecomus-woocommerce-elementor woocommerce-shop-elementor woocommerce-shop woocommerce woocommerce-page ecomus-elementor-id-'.self::$product_archive_id;
		} else {
			$classes[] = 'ecomus-woocommerce-elementor woocommerce-shop-elementor ecomus-elementor-id-'.self::$product_archive_id;
		}

		return $classes;
	}

	public function enqueue_scripts() {
		if( ! apply_filters( 'ecomus_get_product_archive_builder', true ) ) {
			return;
		}

		if( \Ecomus\Addons\Helper::is_catalog() ) {
			$css_file = '';

			self::$product_archive_id = self::get_product_archive_id();

			if( empty( self::$product_archive_id ) ) {
				return;
			}

			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( intval( self::$product_archive_id ) );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( intval( self::$product_archive_id ) );
			}

			if( $css_file ) {
				$css_file->enqueue();
			}
		}
	}

	public function archive_content_builder() {
		if( ! apply_filters( 'ecomus_get_product_archive_builder', true ) ) {
			return;
		}

		if( \Ecomus\Addons\Helper::is_catalog() ) {
			self::$product_archive_id = self::get_product_archive_id();

			$css_bool = \Ecomus\Addons\Elementor\Builder\Helper::check_elementor_css_print_method();

			if( ! empty( self::$product_archive_id ) ) {
				$elementor_instance = \Elementor\Plugin::instance();
				echo $elementor_instance->frontend->get_builder_content_for_display( intval( self::$product_archive_id ), $css_bool );
			} else {
				?>
					<div class="ecomus-single-product-builder--empty">
						<h4><?php esc_html_e( 'Product Archive Builder', 'ecomus-addons' ); ?></h4>
						<?php
							printf(
								esc_html__( "It seems like you've turned on the Product Archive Builder, but you haven't set up any builders yet. To avoid any issues, please either %s this feature or %s. You can find a step-by-step guide in our documentation.", 'ecomus-addons' ),
								sprintf(
									'<a href="%s">%s</a>',
									esc_url( admin_url( 'themes.php?page=theme_settings' ) ),
									esc_html__( 'turn off', 'ecomus-addons' )
								),
								sprintf(
									'<a href="%s">%s</a>',
									esc_url( admin_url( 'edit.php?post_type=ecomus_builder' ) ),
									esc_html__( 'create a new builder', 'ecomus-addons' )
								)
							);
						?>
					</div>
				<?php
			}
		}
    }

	public function redirect_template( $template ){
        $template_part = '';
        $template_id = 0;

		if ( \Ecomus\Addons\Helper::is_catalog() ) {
			self::$product_archive_id = self::get_product_archive_id();
			if ( self::$product_archive_id ) {
				$template_id = self::$product_archive_id;
			}

			$template_part = 'archive';

			$template = \Ecomus\Addons\Elementor\Builder\Helper::get_redirect_template( $template, $template_part, $template_id );
		}

		return $template;
	}

	/**
	 * Get single product id
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_product_archive_id() {
		self::$product_archive_id = apply_filters( 'ecomus_product_archive_builder_page_id', self::$product_archive_id );
		if( isset( self::$product_archive_id ) ) {
			return self::$product_archive_id;
		}

		$product_archive_id = 0;
		$query = new \WP_Query( array(
			'post_type'        => 'ecomus_builder',
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'fields'           => 'ids',
			'orderby'          => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
			'no_found_rows'    => true,
			'suppress_filters' => true,
			'tax_query' => array(
				array(
					'taxonomy' => 'ecomus_builder_type',
					'field' => 'slug',
					'operator' => 'AND',
					'terms' => array( 'archive', 'enable' )
				),
			),
		));

		$product_archive_id = $query->posts ? $query->posts[0] : 0;
        self::$product_archive_id =  $product_archive_id;
		wp_reset_postdata();
		return self::$product_archive_id;
	}

	public function ecomus_post_state( $post_states, $post ) {
		if( ! is_admin() ) {
			return $post_states;
		}

		if( ! get_option( 'ecomus_cart_page_builder_enable') ) {
			return $post_states;
		}

		if( ! function_exists( 'wc_get_page_id') ) {
			return $post_states;
		}

		if ( get_the_ID() == wc_get_page_id( 'shop' ) ) {
			if( isset( $post_states['elementor'] ) ) {
				unset($post_states['elementor']);
			}

			$post_states['ecomus_builder'] = esc_html__( 'Ecomus Shop Builder', 'ecomus-addons' );
		}

		return $post_states;
	}

	public function ecomus_get_edit_post_link( $link, $post_id, $context ) {
		if( ! get_option( 'ecomus_cart_page_builder_enable') ) {
			return $link;
		}

		if( ! function_exists( 'wc_get_page_id') ) {
			return $link;
		}

		if ( $post_id == wc_get_page_id( 'shop' ) ) {
			self::$product_archive_id = self::get_product_archive_id();
			if ( ! self::$product_archive_id ) {
				return $link;
			}

            $link = esc_url( admin_url( 'post.php?post=' . self::$product_archive_id . '&action=edit' ) );
        }

        return $link;
	}

	public function ecomus_page_row_actions( $actions, $post ) {
		if( ! is_admin() ) {
			return $actions;
		}

		if( ! get_option( 'ecomus_cart_page_builder_enable') ) {
			return $actions;
		}

		if( ! function_exists( 'wc_get_page_id') ) {
			return $actions;
		}

		if( get_the_ID() == wc_get_page_id( 'shop' ) ) {
			self::$product_archive_id = self::get_product_archive_id();
			if ( ! self::$product_archive_id ) {
				return $actions;
			}

			$url = esc_url( admin_url( 'post.php?post=' . self::$product_archive_id ) );

			$actions['edit'] = sprintf(
				'<a href="%1$s">%2$s</a>',
				$url . '&action=edit',
				__( 'Edit' )
			);

			if( isset( $actions['edit_with_elementor'] ) ) {
				$actions['edit_with_elementor'] = sprintf(
					'<a href="%1$s">%2$s</a>',
					$url . '&action=elementor',
					__( 'Edit with Elementor', 'elementor' )
				);
			}
		}

		return $actions;
	}

	public function shortcode_products_query( $query_args, $attributes, $type ) {
		if( isset( $_GET['filter'] ) && $_GET['filter'] == '1' && isset( $_GET['rating_filter'] ) ) {
			if( isset( $query_args['tax_query'] ) && isset( $query_args['tax_query'][0] ) && isset( $query_args['tax_query'][0]['rating_filter']) ) {
				unset($query_args['tax_query'][0]);
			}
		}

		return $query_args;
	}

	/**
	 * Set cookie
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function set_cookie() {
		if( isset( $_COOKIE[self::$view_cookie_name] ) ) {
			$cookie_value = $_COOKIE[self::$view_cookie_name];
		}

		if( isset( $_GET['column'] ) ) {
			$cookie_value = $_GET['column'] == '1' ? 'list' : 'grid-' . $_GET['column'];
		}

		if ( empty( $cookie_value ) ) {
			return;
		}

		if( isset( $_COOKIE[self::$view_cookie_name] ) && $_COOKIE[self::$view_cookie_name] == $cookie_value ) {
			return;
		}

		setcookie(self::$view_cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
	}
}