<?php
/**
 * Single Product hooks.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Advanced_Search;

use Ecomus\Addons\Modules\Advanced_Search\Posts as Search_Posts;
use Ecomus\Addons\Modules\Advanced_Search\Taxonomies as Search_Taxonomies;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Single Product
 */
class AJAX_Search {
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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action('ecomus_search_modal_after_form', array( $this, 'search_modal_results' ));
		add_action('ecomus_header_search_after_form', array( $this, 'header_search_results' ));
		add_action( 'wc_ajax_ecomus_instance_search_form', array( $this, 'instance_search_form' ) );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'ecomus-ajax-search', ECOMUS_ADDONS_URL . 'modules/advanced-search/assets/js/ajax-search-frontend.js',  array( 'jquery'), '1.0.0' );

		$ecomus_data = array(
			'ajax_url'             	=> class_exists( 'WC_AJAX' ) ? \WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
			'nonce'                	=> wp_create_nonce( '_ecomus_nonce' ),
			'header_ajax_search' 	=> get_option( 'ecomus_ajax_search', 'yes'),
			'header_search_number' 	=> get_option( 'ecomus_ajax_search_number', 4),
		);

		wp_localize_script(
			'ecomus-ajax-search', 'ecomusAjaxSearch', $ecomus_data
		);
	}

	public function search_modal_results() {
		?>
		<div class="modal__content-results"></div>
		<div class="modal__content-loading em-row">
			<div class="em-product-card em-flex em-col em-md-3">
				<div class="em-product-card_img"></div>
				<div class="em-product-card__info">
					<div class="em-product-card_txt1"></div>
					<div class="em-product-card_txt2"></div>
				</div>
			</div>
			<div class="em-product-card em-flex em-col em-md-3">
				<div class="em-product-card_img"></div>
				<div class="em-product-card__info">
					<div class="em-product-card_txt1"></div>
					<div class="em-product-card_txt2"></div>
				</div>
			</div>
			<div class="em-product-card em-flex em-col em-md-3">
				<div class="em-product-card_img"></div>
				<div class="em-product-card__info">
					<div class="em-product-card_txt1"></div>
					<div class="em-product-card_txt2"></div>
				</div>
			</div>
			<div class="em-product-card em-flex em-col em-md-3">
				<div class="em-product-card_img"></div>
				<div class="em-product-card__info">
					<div class="em-product-card_txt1"></div>
					<div class="em-product-card_txt2"></div>
				</div>
			</div>
		</div>
		<?php
	}

	public function header_search_results() {
		?>
		<div class="header-search-results">
			<div class="header-search__products-results modal__content-results"></div>
			<div class="modal__content-loading em-flex em-flex-column">
				<div class="em-product-card em-flex">
					<div class="em-product-card_img"></div>
					<div class="em-product-card__info">
						<div class="em-product-card_txt1"></div>
						<div class="em-product-card_txt2"></div>
					</div>
				</div>
				<div class="em-product-card em-flex">
					<div class="em-product-card_img"></div>
					<div class="em-product-card__info">
						<div class="em-product-card_txt1"></div>
						<div class="em-product-card_txt2"></div>
					</div>
				</div>
				<div class="em-product-card em-flex">
					<div class="em-product-card_img"></div>
					<div class="em-product-card__info">
						<div class="em-product-card_txt1"></div>
						<div class="em-product-card_txt2"></div>
					</div>
				</div>
				<div class="em-product-card em-flex">
					<div class="em-product-card_img"></div>
					<div class="em-product-card__info">
						<div class="em-product-card_txt1"></div>
						<div class="em-product-card_txt2"></div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Search form
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function instance_search_form() {
		$tab_html = '';
		if($product_html = Helper::get('posts')->get_products()) {
			$tab_html .= '<button class="em-relative em-button-text results-tab-button" data-target="products">' . esc_html__('Products', 'ecomus-addons') .'</button>';
		}

		if($cat_html = Helper::get('taxonomies')->get_cats()) {
			$tab_html .= '<button class="em-relative em-button-text results-tab-button" data-target="categories">' . esc_html__('Categories', 'ecomus-addons') .'</button>';
		}

		if($post_html = Helper::get('posts')->get_posts()) {
			$tab_html .= '<button class="em-relative em-button-text results-tab-button" data-target="posts">' . esc_html__('Articles', 'ecomus-addons') .'</button>';
		}

		if($tags_html = Helper::get('taxonomies')->get_tags()) {
			$tab_html .= '<button class="em-relative em-button-text results-tab-button" data-target="tags">' . esc_html__('Tags', 'ecomus-addons') .'</button>';
		}

		if($pages_html = Helper::get('posts')->get_pages()) {
			$tab_html .= '<button class="em-relative em-button-text results-tab-button" data-target="pages">' . esc_html__('Pages', 'ecomus-addons') .'</button>';
		}

		$response = $product_html . $cat_html . $post_html;

		if( ! empty($tags_html) || !empty($pages_html) ) {
			$response .= '<div class="em-col em-md-3 result-tab-item">' . $tags_html . $pages_html .'</div>';
		}

		if ( empty( $response ) ) {
			$empty_icon = \Ecomus\Addons\Helper::get_svg( 'search-not-found' );
			$response .= sprintf( '<div class="list-item list-item-empty">%s%s</div>', $empty_icon, esc_html__( 'No products were found matching your selection.', 'ecomus-addons' ) );
		} else {
			$tab_html = '<div class="results-tab-header">' . $tab_html . '</div>';
			$response = $tab_html . '<div class="results-tab-content em-row">' . $response . '</div>';
		}

		wp_send_json_success( $response );
		die();
	}


}