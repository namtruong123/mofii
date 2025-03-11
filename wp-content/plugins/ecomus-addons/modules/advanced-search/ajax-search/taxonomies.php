<?php
/**
 * Taxonomies hooks.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Advanced_Search\Ajax_Search;

use Ecomus\Addons\Modules\Advanced_Search\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Taxonomies
 */
class Taxonomies {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;


	/**
	 * taxonomies
	 *
	 * @var $instance
	 */
	protected static $taxonomies = null;

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

	public function get_cats() {
		if( get_option('ecomus_ajax_search_categories', 'yes') != 'yes' ) {
			return;
		}

		$response = $this->get_search();

		if( empty($response) ) {
			return;
		}

		if( ! isset( $response['category'] ) || empty( $response['category'] ) ) {
			return;
		}

		$result = array();
		$result['classes'] = 'em-col em-md-3 em-col-categories result-tab-item';
		$result['name'] = esc_html__('Categories', 'ecomus-addons');
		$result['view_all'] = '';
		$result['response'] = implode('', $response['category']);

		return Helper::get_result_list($result );
	}

	public function get_tags() {
		if( get_option('ecomus_ajax_search_tags', 'yes') != 'yes' ) {
			return;
		}

		$response = $this->get_search();

		if( empty($response) ) {
			return;
		}

		if( ! isset( $response['tag'] ) || empty( $response['tag'] ) ) {
			return;
		}

		$result = array();
		$result['classes'] = 'em-col-page em-col-tags result-tab-item';
		$result['name'] = esc_html__('Tags', 'ecomus-addons');
		$result['view_all'] = '';
		$result['response'] = implode('', $response['tag']);

		return Helper::get_result_list($result );
	}

	private function get_search() {
		if( isset(self::$taxonomies) ) {
			return self::$taxonomies;
		}
		$args = array(
			'number'   => isset( $_POST['ajax_search_number'] ) ? intval( $_POST['ajax_search_number'] ) : 0,
			'search'     => trim( $_POST['term'] ),
		);

		$taxonomy = array();
		if( get_option('ecomus_ajax_search_categories', 'yes') == 'yes' ) {
			$taxonomy[] = 'product_cat';
		}

		if( get_option('ecomus_ajax_search_tags', 'yes') == 'yes' ) {
			$taxonomy[] = 'product_tag';
		}

		if( empty( $taxonomy ) ) {
			return;
		}

		$args['taxonomy'] = $taxonomy;

		$terms = get_terms( $args );

		if( empty( $terms ) ) {
			return;
		}

		self::$taxonomies   = array();
		foreach ( $terms as $term ) {
			$result = array();
			$result['permalink'] = get_term_link($term->term_id, $term->taxonomy);
			$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
			$result['image'] = $thumb_id ? wp_get_attachment_image( $thumb_id, 'large') : '';
			$result['name'] = $term->name;
			if( $term->taxonomy == 'product_cat' ) {
				$item_text = $term->count > 1 ? esc_html__('items', 'ecomus-addons') : esc_html__('item', 'ecomus-addons');
				$result['desc'] = '<span class="product-count">' . $term->count . ' ' . $item_text . '</span>';
				self::$taxonomies['category'][] = Helper::get_result_item($result);
			} elseif ($term->taxonomy == 'product_tag') {
				$result['desc'] = '';
				self::$taxonomies['tag'][] = Helper::get_result_item($result);
			}
		}

		return self::$taxonomies;
	}

}