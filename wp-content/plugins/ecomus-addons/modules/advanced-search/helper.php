<?php
/**
 * Helper hooks.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Advanced_Search;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Helper
 */
class Helper {
	public static function get_result_item($result) {
		$thumbnail = '';
		if( $result['image'] ) {
			$thumbnail = sprintf(
				'<div class="result-card-thumbnail">' .
				'<a class="result-card__link em-ratio" href="%s">' .
				'%s' .
				'</a>' .
				'</div>',
				esc_url( $result['permalink'] ),
				$result['image']
			);
		}
		return sprintf(
			'<li class="result-card-item em-flex">' .
			'%s' .
			'<div class="result-summary em-flex">' .
			'<a class="result-title" href="%s">' .
			'%s' .
			'</a>' .
			'<span class="result-desc">%s</span>' .
			'</div>' .
			'</li>',
			$thumbnail,
			esc_url( $result['permalink'] ),
			$result['name'],
			$result['desc']
		);

	}

	public static function get_result_list($result) {
		return sprintf(
			'<div class="%s">'.
			'<div class="results-heading em-flex">'.
			'<h6 class="em-font-medium">%s</h6>'.
			'%s'.
			'</div>'.
			'<ul class="results-list">'.
			'%s'.
			'</ul>'.
			'</div>',
			esc_attr($result['classes']),
			$result['name'],
			$result['view_all'],
			$result['response']
		);

	}

	public static function get( $class ) {
		if( $class == 'posts' ) {
			return \Ecomus\Addons\Modules\Advanced_Search\Ajax_Search\Posts::instance();
		} elseif( $class == 'taxonomies' ) {
			return \Ecomus\Addons\Modules\Advanced_Search\Ajax_Search\Taxonomies::instance();
		}
	}
}