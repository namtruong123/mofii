<?php
/**
 * Posts hooks.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Advanced_Search\Ajax_Search;

use Ecomus\Addons\Modules\Advanced_Search\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Posts
 */
class Posts {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * posts
	 *
	 * @var $instance
	 */
	protected static $posts = null;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
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

	}

	public function get_products() {
		$post_result = $this->get_search();
		if( empty($post_result) ) {
			return;
		}

		if( ! isset( $post_result['product'] ) || empty( $post_result['product'] ) ) {
			return;
		}
		$keyword   = trim( $_POST['term'] );
		$result = array();
		$result['classes'] = 'em-col em-md-3 em-col-products result-tab-item';
		$result['name'] = esc_html__('Products', 'ecomus-addons');
		$result['view_all'] = sprintf(
			'<a href="%s" class="em-button em-button-subtle"><span class="ecomus-button-text">%s</span>%s</a>',
			esc_url( home_url( '/' ) . '?s=' . $keyword . '&post_type=product' ),
			esc_html__('View All', 'ecomus-addons'),
			\Ecomus\Addons\Helper::get_svg('arrow-top', 'ui'),
		);

		$result['response'] = implode('', $post_result['product']);

		return Helper::get_result_list($result);
	}

	public function get_posts() {
		$post_result = $this->get_search();
		if( empty($post_result) ) {
			return;
		}

		if( ! isset( $post_result['post'] ) || empty( $post_result['post'] ) ) {
			return;
		}

		$result = array();
		$result['classes'] = 'em-col em-md-3 em-col-posts result-tab-item';
		$result['name'] = esc_html__('Articles', 'ecomus-addons');
		$result['view_all'] = '';
		$result['response'] = implode('', $post_result['post']);

		return Helper::get_result_list($result);
	}

	public function get_pages() {
		$post_result = $this->get_search();
		if( empty($post_result) ) {
			return;
		}

		if( ! isset( $post_result['page'] ) || empty( $post_result['page'] ) ) {
			return;
		}

		$result = array();
		$result['classes'] = 'em-col-page em-col-pages result-tab-item';
		$result['name'] = esc_html__('Pages', 'ecomus-addons');
		$result['view_all'] = '';
		$result['response'] = implode('', $post_result['page']);

		return Helper::get_result_list($result);
	}

	private function get_query_var() {
		global $wpdb;

		$result_number = isset( $_POST['ajax_search_number'] ) ? intval( $_POST['ajax_search_number'] ) : 0;
		$keyword   = trim( $_POST['term'] );

		$query_var = '';
		$fields = 'posts.ID, posts.post_type';
		$search_string = '%' . $wpdb->esc_like( $keyword ) . '%';
		if( get_option('ecomus_ajax_search_products', 'yes') == 'yes' ) {
			$sku_join = $sku_where = '';
			if( get_option('ecomus_ajax_search_products_by_sku', 'yes') == 'yes' ) {
				$sku_join = " LEFT JOIN {$wpdb->wc_product_meta_lookup} wc_product_meta_lookup ON posts.ID = wc_product_meta_lookup.product_id ";
				$sku_where =  ' OR ' . $wpdb->prepare("(wc_product_meta_lookup.sku LIKE %s) ", $search_string);
			}

			$query_var = "(SELECT {$fields} FROM {$wpdb->posts} as posts"
				. $sku_join .
				"WHERE 1 = 1
				AND(posts.post_title LIKE %s)
				AND(
					posts.post_type = 'product'
					AND	( posts.post_status = 'publish' OR posts.post_status = 'private')
				)"
				. $sku_where .
				"ORDER BY posts.post_date DESC
				LIMIT %d
				)";

			$query_var = $wpdb->prepare($query_var,
				$search_string,
				$result_number
			);
		}

		if( get_option('ecomus_ajax_search_posts', 'yes') == 'yes' ) {
			$query_var .= $wpdb->prepare("
				UNION ALL (SELECT {$fields} FROM {$wpdb->posts} as posts
				WHERE 1 = 1
					AND(posts.post_title LIKE %s)
					AND(
						posts.post_type = 'post'
						AND	( posts.post_status = 'publish' OR posts.post_status = 'private')
					)
				ORDER BY posts.post_date DESC
				LIMIT %d
				)",
				$search_string,
				$result_number
			);
		}

		if( get_option('ecomus_ajax_search_pages', 'yes') == 'yes' ) {
			$query_var .= $wpdb->prepare("
				UNION ALL (SELECT {$fields} FROM {$wpdb->posts} as posts
				WHERE 1 = 1
					AND(posts.post_title LIKE %s)
					AND(
						posts.post_type = 'page'
						AND	( posts.post_status = 'publish' OR posts.post_status = 'private')
					)
				ORDER BY posts.post_date DESC
				LIMIT %d
				)",
				$search_string,
				$result_number
			);
		}

		return $query_var;
	}

	private function get_search() {
		if( isset(self::$posts) ) {
			return self::$posts;
		}
		global $wpdb;

		$query_var = $this->get_query_var();
		$query = $wpdb->get_results($query_var);
		self::$posts = array();
		foreach ( $query as $post ) {
			$result = array();
			$post_type = $post->post_type;
			$post_id = $post->ID;
			if( in_array($post_type, array( 'product' ) ) ) {
				$product   = wc_get_product( $post_id );
				$result['permalink'] = $product->get_permalink();
				$result['image'] = $product->get_image( 'woocommerce_thumbnail' );
				$result['name'] = $product->get_title();
				$result['desc'] = '<span class="price em-flex">' . $product->get_price_html() . '</span>';
				self::$posts['product'][]= Helper::get_result_item($result);
			} elseif( $post_type == 'post' ) {
				$post = get_post( $post_id );
				$result['permalink'] = get_permalink($post_id);
				$result['image'] = wp_get_attachment_image( get_post_thumbnail_id( $post_id ), 'large');
				$result['name'] = $post->post_title;
				$result['desc'] = '<span class="post-date">' . get_the_date( '', $post_id ) . '</span>';
				self::$posts['post'][]= Helper::get_result_item($result);
			} elseif( $post_type == 'page' ) {
				$post = get_post( $post_id );
				$result['permalink'] = get_permalink($post_id);
				$result['image'] = '';
				$result['name'] = $post->post_title;
				$result['desc'] = '';
				self::$posts['page'][]= Helper::get_result_item($result);
			}
		}

		return self::$posts;
	}

}