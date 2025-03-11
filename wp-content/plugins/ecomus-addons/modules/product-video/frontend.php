<?php
/**
 * Single Product hooks.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Modules\Product_Video;

use Ecomus\Helper;
use Ecomus\Icon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Single Product
 */
class Frontend {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

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
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		add_filter( 'ecomus_product_get_gallery_image', array( $this, 'get_gallery_thumbnail' ), 10, 2 );
		add_filter( 'ecomus_product_get_gallery_thumbnail', array( $this, 'get_gallery_thumbnail' ), 10, 2 );

		add_filter( 'woocommerce_single_product_image_thumbnail_html', array( $this, 'product_video_gallery' ), 10, 2 );
	}

	public function scripts() {
		wp_enqueue_script('ecomus-product-video', ECOMUS_ADDONS_URL . 'modules/product-video/assets/js/product-video.js', array( 'jquery' ), '20240506', true );
	}

	/**
	 * Get product video
	 *
	 * @static
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_gallery_thumbnail( $html, $index ) {
		global $product;

		$video_position       = intval(get_post_meta( $product->get_id(), 'video_position', true ));

		if ( $video_position == 0 ) {
			return $html;
		}

		if ( $video_position != $index ) {
			return $html;
		}

		$video_url    = get_post_meta( $product->get_id(), 'video_url', true );

		if ( empty( $video_url ) ) {
			return $html;
		}

		$video_image_id  = get_post_meta( $product->get_id(), 'video_thumbnail_id', true );

		if ( empty( $video_image_id ) ) {
			$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
			$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
			$video_thumb = wc_placeholder_img( $thumbnail_size );
			$video_thumb_src = wc_placeholder_img_src( $thumbnail_size );

			$video_thumb = '<div data-thumb="' . esc_url( $video_thumb_src ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $video_thumb_src ) . '">' . $video_thumb . '</a></div>';
		} else {
			$video_thumb = wc_get_gallery_image_html($video_image_id);
		}

		return $video_thumb . $html;
	}

	/**
	 * Get product video
	 *
	 * @static
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_product_video() {
		global $product;
		$video_html  = self::get_product_video_html();
		if ( $video_html ) {
			$video_image  = get_post_meta( $product->get_id(), 'video_thumbnail_id', true );

			if ( empty( $video_image ) ) {
				$video_thumb = wc_placeholder_img_src( 'shop_thumbnail' );
			} else {
				$video_thumb = wp_get_attachment_image_src( $video_image, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
				$video_thumb = ! empty( $video_thumb ) ? $video_thumb[0] : wc_placeholder_img_src( 'shop_thumbnail' );
			}
			$video_html = '<div data-thumb="' . esc_url( $video_thumb ) . '" class="woocommerce-product-gallery__image ecomus-product-video">' . $video_html . '</div>';
		}

		return $video_html;
	}

	/**
	 * Get product video
	 *
	 * @static
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_product_video_html() {
		global $product;
		$video_url    	= get_post_meta( $product->get_id(), 'video_url', true );
		$video_autoplay = get_post_meta( $product->get_id(), 'video_autoplay', true );
		$video_image_id = get_post_meta( $product->get_id(), 'video_thumbnail_id', true );

		$video_width  	= 1200;
		$video_height 	= 500;
		$video_autoplay = $video_autoplay ? 'autoplay' : '';
		$video_html   	= $video_class = '';

		if ( strpos( $video_url, 'youtube' ) !== false ) {
			$video_class = 'video-youtube';
		} elseif ( strpos( $video_url, 'vimeo' ) !== false ) {
			$video_class = 'video-vimeo';
		}

		if( $video_autoplay ) {
			$video_class .= ' video-autoplay';
		}

		// If URL: show oEmbed HTML
		if ( filter_var( $video_url, FILTER_VALIDATE_URL ) ) {

			$atts = array(
				'width'    => $video_width,
				'height'   => $video_height,
			);

			if ( strpos( $video_url, 'youtube' ) !== false ) {
				$video_url = add_query_arg('autoplay', '0', $video_url);
			}

			if ( $oembed = @wp_oembed_get( $video_url, $atts ) ) {
				$video_html = $oembed;
			} else {
				$atts = array(
					'src'    => $video_url,
					'width'  => $video_width,
					'height' => $video_height
				);

				$video_html = '<video '. urldecode( http_build_query( $atts, '', ' ' ) ) .' loop="true" muted="muted" controls playsinline '.$video_autoplay.'></video>';
			}
		}


		if ( empty( $video_image_id ) ) {
			$thumbnail_size    = 'woocommerce_single';
			$video_thumb = wc_placeholder_img( $thumbnail_size );
			$video_thumb_src = wc_placeholder_img_src( $thumbnail_size );

			$video_thumb = '<a href="' . esc_url( $video_thumb_src ) . '">' . $video_thumb . '</a>';
		} else {
			$video_thumb = wp_get_attachment_image( $video_image_id, 'woocommerce_single' );
		}

		if ( $video_html ) {
			$btn_play = '<span class="ecomus-i-video" role="button"></span>';
			$video_thumb = '<div class="ecomus-video-thumbnail">'. $btn_play . $video_thumb .'</div>';

			$video_html = '<div class="ecomus-video-wrapper ' . esc_attr( $video_class ) . '">' . $video_html . '</div>';
			$video_html = $video_thumb . $video_html;
		}

		return $video_html;
	}

	/**
	 * Get product video
	 *
	 * @static
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function product_video_gallery( $html, $attachment_id ) {
		global $product;
		$video_position     = get_post_meta( $product->get_id(), 'video_position', true );

		if ( $video_position == 0 ) {
			return $html;
		}

		if ( $video_position == '1' ) {
			if ( $product->get_image_id() == $attachment_id ) {
				$html = self::get_product_video() . $html;
			}
		} else {
			$attachment_ids 	= $product->get_gallery_image_ids();

			$key = array_search ($attachment_id, $attachment_ids);

			if ( $key === false && $video_position == '2' ) {
				$html = $html . self::get_product_video();
			} elseif( $key && $video_position == $key + 2 ) {
				$html = self::get_product_video() . $html;
			}
		}

		return $html;
	}

}
