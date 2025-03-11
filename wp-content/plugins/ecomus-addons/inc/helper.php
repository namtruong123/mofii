<?php
/**
 * Ecomus Addons Helper init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ecomus
 */

namespace Ecomus\Addons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Helper
 */
class Helper {

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
	 * Get the sharing URL of a social
	 *
	 * @since 1.0.0
	 *
	 * @param string $social
	 *
	 * @return string
	 */
	public static function share_link( $social, $args ) {
		$url  = '';
		$text_default = apply_filters( 'ecomus_share_link_text', ''  );
		if( empty($args[$social . '_title']) ) {
			$text =  $text_default . ' ' . ucfirst( $social );
		} else {
			$text = $args[$social . '_title'];
		}

		$icon = $social;

		switch ( $social ) {
			case 'facebook':
				$url = add_query_arg( array( 'u' => get_permalink() ), 'https://www.facebook.com/sharer.php' );
				break;

			case 'twitter':
				$url = add_query_arg( array( 'url' => get_permalink(), 'text' => get_the_title() ), 'https://twitter.com/intent/tweet' );
				break;

			case 'pinterest';
				$params         = array(
					'description' => get_the_title(),
					'media'       => get_the_post_thumbnail_url( null, 'full' ),
					'url'         => get_permalink(),
				);
				$url            = add_query_arg( $params, 'https://www.pinterest.com/pin/create/button/' );
				break;

			case 'googleplus':
				$url  = add_query_arg( array( 'url' => get_permalink() ), 'https://plus.google.com/share' );
				if( empty($args[$social . '_title']) ) {
					$text = $text_default . ' ' . esc_html__( 'Google+', 'ecomus-addons' );
				}
				$icon = 'google';
				break;

			case 'linkedin':
				$url = add_query_arg( array( 'url' => get_permalink(), 'title' => get_the_title() ), 'https://www.linkedin.com/shareArticle' );
				break;

			case 'tumblr':
				$url = add_query_arg( array( 'url' => get_permalink(), 'name' => get_the_title() ), 'https://www.tumblr.com/share/link' );
				break;

			case 'reddit':
				$url = add_query_arg( array( 'url' => get_permalink(), 'title' => get_the_title() ), 'https://reddit.com/submit' );
				break;

			case 'stumbleupon':
				$url = add_query_arg( array( 'url' => get_permalink(), 'title' => get_the_title() ), 'https://www.stumbleupon.com/submit' );
				if( empty($args[$social . '_title']) ) {
					$text = $text_default . ' ' . esc_html__( 'StumbleUpon', 'ecomus-addons' );
				}
				break;

			case 'telegram':
				$url = add_query_arg( array( 'url' => get_permalink() ), 'https://t.me/share/url' );
				break;

			case 'whatsapp':
				$params = array( 'text' => urlencode( get_permalink() ) );

				$url = 'https://wa.me/';

				if ( ! empty( $args['whatsapp_number'] ) ) {
					$url .= urlencode( $args['whatsapp_number'] );
				}

				$url = add_query_arg( $params, $url );
				break;

			case 'pocket':
				$url = add_query_arg( array( 'url' => get_permalink(), 'title' => get_the_title() ), 'https://getpocket.com/save' );
				if( empty($args[$social . '_title']) ) {
					$text = esc_html__( 'Save On Pocket', 'ecomus-addons' );
				}
				break;

			case 'digg':
				$url = add_query_arg( array( 'url' => get_permalink() ), 'https://digg.com/submit' );
				break;

			case 'vk':
				$url = add_query_arg( array( 'url' => get_permalink() ), 'https://vk.com/share.php' );
				break;

			case 'email':
				$url  = 'mailto:?subject=' . get_the_title() . '&body=' . __( 'Check out this site:', 'ecomus-addons' ) . ' ' . get_permalink();
				if( empty($args[$social . '_title']) ) {
					$text = esc_html__( 'Share Via Email', 'ecomus-addons' );
				}
				break;
		}

		if ( ! $url ) {
			return;
		}

		$icon = ( isset( $args[$icon]['icon'] ) && ! empty( $args[$icon]['icon'] ) ) ? $args[$icon]['icon'] : $icon;
		$class = ( isset( $args[$social]['class'] ) && ! empty( $args[$social]['class'] ) ) ? $args[$social]['class'] : '';
		if( empty ( $args[$social . '_icon_html'] )  ) {
			$icon = self::get_svg($icon, 'social', array( 'class' => $class ) );
		} else {
			$icon = '<span class="ecomus-svg-icon ecomus-svg-icon--twitter '. $class .'">' . $args[$social . '_icon_html'] . '</span>';
		}

		$repeat_class = ! empty ( $args['repeat_classes'] ) ? $args['repeat_classes'] : '';

		return sprintf(
			'<a href="%s" target="_blank" class="social-share-link em-socials--%s %s">%s<span class="social-share__label">%s</span></a>',
			esc_url( $url ),
			esc_attr( $social ),
			esc_attr($repeat_class),
			$icon,
			$text
		);
	}

	/**
	 * Get Theme SVG.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_svg( $svg_name, $group = 'ui', $attr = array()  ) {
		if ( class_exists( '\Ecomus\Icon' ) && method_exists( '\Ecomus\Icon', 'get_svg' ) ) {
			return \Ecomus\Icon::get_svg( $svg_name, $group, $attr );
		}

		return '';
	}

	/**
	 * Get Theme SVG.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function inline_svg( $args = array()  ) {
		if ( class_exists( '\Ecomus\Icon' ) && method_exists( '\Ecomus\Icon', 'get_svg' ) ) {
			return \Ecomus\Icon::inline_svg($args);
		}

		return '';
	}

	/**
	 * Get Theme SVG.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function sanitize_svg( $svg ) {
		if ( class_exists( '\Ecomus\Icon' ) && method_exists( '\Ecomus\Icon', 'sanitize_svg' ) ) {
			return \Ecomus\Icon::sanitize_svg( $svg );
		}

		return '';
	}

	/**
	 * Get Theme Options.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_option( $name ) {
		if ( class_exists( '\Ecomus\Helper' ) && method_exists( '\Ecomus\Helper', 'get_option' ) ) {
			return \Ecomus\Helper::get_option( $name );
		}

		return '';
	}

	/**
	 * Get Instagram images
	 *
	 * @param int $limit
	 *
	 * @return array|WP_Error
	 */
	public static function ecomus_get_instagram_images( $limit = 12 ) {
		$access_token = \Ecomus\Helper::get_option( 'api_instagram_token' );

		if ( empty( $access_token ) ) {
			return new \WP_Error( 'instagram_no_access_token', esc_html__( 'No access token', 'ecomus-addons' ) );
		}

		$user = self::ecomus_get_instagram_user();

		if ( ! $user || is_wp_error( $user ) ) {
			return $user;
		}

		if ( isset( $user['error'] ) ) {
			return new \WP_Error( 'instagram_no_images', esc_html__( 'Instagram did not return any images. Please check your access token', 'ecomus-addons' ) );

		} else {
			$transient_key = 'ecomus_instagram_photos_' . sanitize_title_with_dashes( $user['username'] . '__' . $limit );
			$images = get_transient( $transient_key );
			$images = apply_filters( 'ecomus_get_instagram_photos', $images );
			if ( false === $images || empty( $images ) ) {
				$images = array();
				$next = false;

				while ( count( $images ) < $limit ) {
					if ( ! $next ) {
						$fetched = self::ecomus_fetch_instagram_media( $access_token );
					} else {
						$fetched = self::ecomus_fetch_instagram_media( $next );
					}

					if ( is_wp_error( $fetched ) ) {
						break;
					}

					$images = array_merge( $images, $fetched['images'] );
					$next = $fetched['paging'] ? $fetched['paging']['cursors']['after'] : false;

					if ( ! $next ) {
						break;
					}
				}

				if ( ! empty( $images ) ) {
					set_transient( $transient_key, $images, 2 * 3600 ); // Cache for 2 hours.
				}
			}

			if ( ! empty( $images ) ) {
				return $images;
			} else {
				return new \WP_Error( 'instagram_no_images', esc_html__( 'Instagram did not return any images.', 'ecomus-addons' ) );
			}
		}
	}

	/**
	 * Fetch photos from Instagram API
	 *
	 * @param  string $access_token
	 * @return array
	 */
	public static function ecomus_fetch_instagram_media( $access_token ) {
		$url = add_query_arg( array(
			'fields'       => 'id,caption,media_type,media_url,permalink,thumbnail_url',
			'access_token' => $access_token,
		), 'https://graph.instagram.com/me/media' );

		$remote = wp_remote_retrieve_body( wp_remote_get( $url ) );
		$data   = json_decode( $remote, true );
		$images = array();
		if ( isset( $data['error'] ) ) {
			return new \WP_Error( 'instagram_error', $data['error']['message'] );
		} else if(isset($data['data']) ) {
			foreach ( $data['data'] as $media ) {
				$images[] = array(
					'type'    => $media['media_type'],
					'caption' => isset( $media['caption'] ) ? $media['caption'] : $media['id'],
					'link'    => $media['permalink'],
					'images'  => array(
						'thumbnail' => ! empty( $media['thumbnail_url'] ) ? $media['thumbnail_url'] : $media['media_url'],
						'original'  => $media['media_url'],
					),
				);
			}
		}

		return array(
			'images' => $images,
			'paging' => isset( $data['paging'] ) ? $data['paging'] : false,
		);
	}

	/**
	 * Get user data
	 *
	 * @return bool|WP_Error|array
	 */
	public static function ecomus_get_instagram_user() {
		$access_token = \Ecomus\Helper::get_option( 'api_instagram_token' );

		if ( empty( $access_token ) ) {
			return new \WP_Error( 'no_access_token', esc_html__( 'No access token', 'ecomus-addons' ) );
		}

		$transient_key = 'ecomus_instagram_user_' . $access_token;

		$user = get_transient( $transient_key );

		$user = apply_filters( 'ecomus_get_instagram_user', $user );

		if ( false === $user ) {
			$url  = add_query_arg( array( 'fields' => 'id,username', 'access_token' => $access_token ), 'https://graph.instagram.com/me' );
			$data = wp_remote_get( $url );
			$data = wp_remote_retrieve_body( $data );

			if ( ! $data ) {
				return new \WP_Error( 'no_user_data', esc_html__( 'No user data received', 'ecomus-addons' ) );
			}

			$user = json_decode( $data, true );

			if ( ! empty( $data ) ) {
				set_transient( $transient_key, $user, 2592000 ); // Cache for one month.
			}
		}

		return $user;
	}

	/**
	 * Refresh Instagram Access Token
	 */
	public static function ecomus_refresh_instagram_access_token() {
		$access_token = \Ecomus\Helper::get_option( 'api_instagram_token' );

		if ( empty( $access_token ) ) {
			return new \WP_Error( 'no_access_token', esc_html__( 'No access token', 'ecomus-addons' ) );
		}

		$data = wp_remote_get( 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' . $access_token );
		$data = wp_remote_retrieve_body( $data );
		$data = json_decode( $data, true );

		if ( isset( $data['error'] ) ) {
			return new \WP_Error( 'access_token_refresh', $data['error']['message'] );
		}

		$new_access_token = $data['access_token'];

		set_theme_mod( 'api_instagram_token', $new_access_token );

		return $new_access_token;
	}

	/**
	 * Get the output of an Instagram photo
	 */
	public static function ecomus_instagram_image( $media, $ratio = 'em-ratio', $show_video = false ) {
		if ( ! is_array( $media ) ) {
			return;
		}

		$srcset = array(
			$media['images']['thumbnail'] . ' 320w',
			$media['images']['original'] . ' 640w',
			$media['images']['original'] . ' 2x',
		);


		$caption = is_array( $media['caption'] ) && isset( $media['caption']['text'] ) ? $media['caption']['text'] : $media['caption'];

		$image = '';
		if( $media['type'] == 'VIDEO' ) {
			if( $show_video ) {
				$image  = sprintf(
					'<video width="640" height="360" autoplay muted loop poster="%s"><source src="%s" type="video/mp4"></video>',
					esc_url($media['images']['thumbnail']),
					esc_url( $media['images']['original'] )
				);
			} else {
				$srcset = array($media['images']['thumbnail']);
			}
		}

		if( empty( $image ) ) {
			$image  = sprintf(
				'<img src="%s" alt="%s" srcset="%s" sizes="(max-width: 1400px) 320px">',
				esc_url( $media['images']['thumbnail'] ),
				esc_attr( $caption ),
				esc_attr( implode( ', ', $srcset ) )
			);
		}

		return sprintf(
			'<a class="ecomus-instagram__link %s em-eff-img-zoom" href="%s" target="_blank" rel="nofollow">%s</a>',
			esc_attr( $ratio ),
			esc_url( $media['link'] ),
			$image
		);
	}

	/**
	 * Get terms array for select control
	 *
	 * @param string $taxonomy
	 * @return array
	 */
	public static function get_terms_hierarchy( $taxonomy = 'category', $separator = '-', $hide_empty = true, $child_of = false ) {
		$terms = get_terms( array(
			'taxonomy'   	=> $taxonomy,
			'hide_empty' 	=> $hide_empty,
			'child_of' 		=> $child_of,
			'update_term_meta_cache' => false,
		) );

		if ( ! $terms || is_wp_error( $terms ) ) {
			return array();
		}

		$taxonomy = get_taxonomy( $taxonomy );
		if ( $taxonomy->hierarchical ) {
			$terms = self::sort_terms_hierarchy( $terms );
			$terms = self::flatten_hierarchy_terms( $terms, $separator );
		}

		return $terms;
	}

	/**
	 * Recursively sort an array of taxonomy terms hierarchically.
	 *
	 * @param array $terms
	 * @param integer $parent_id
	 * @return array
	 */
	public static function sort_terms_hierarchy( $terms, $parent_id = 0 ) {
		$hierarchy = array();

		foreach ( $terms as $term ) {
			if ( $term->parent == $parent_id ) {
				$term->children = self::sort_terms_hierarchy( $terms, $term->term_id );
				$hierarchy[] = $term;
			}
		}

		return $hierarchy;
	}

	/**
	 * Flatten hierarchy terms
	 *
	 * @param array $terms
	 * @param integer $depth
	 * @return array
	 */
	public static function flatten_hierarchy_terms( $terms, $separator = '&mdash;', $depth = 0 ) {
		$flatted = array();


		foreach ( $terms as $term ) {
			$children = array();

			if ( ! empty( $term->children ) ) {
				$children = $term->children;
				$term->has_children = true;
				unset( $term->children );
			}

			$term->depth = $depth;
			$term->name = $depth && $separator ? str_repeat( $separator, $depth ) . ' ' . $term->name : $term->name;
			$flatted[] = $term;

			if ( ! empty( $children ) ) {
				$flatted = array_merge( $flatted, self::flatten_hierarchy_terms( $children, $separator, ++$depth ) );
				$depth--;
			}
		}

		return $flatted;
	}

	/**
	 * Functions that used to get coutndown texts
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_countdown_shorten_texts() {
		return apply_filters( 'ecomus_get_countdown_texts', array(
			'weeks'    	=> esc_html__( 'Weeks', 'ecomus-addons' ),
			'week'    	=> esc_html__( 'Week', 'ecomus-addons' ),
			'days'    	=> esc_html__( 'Days', 'ecomus-addons' ),
			'day'    	=> esc_html__( 'Day', 'ecomus-addons' ),
			'hours'   	=> esc_html__( 'Hours', 'ecomus-addons' ),
			'hour'   	=> esc_html__( 'Hour', 'ecomus-addons' ),
			'minutes' 	=> esc_html__( 'Mins', 'ecomus-addons' ),
			'minute' 	=> esc_html__( 'Min', 'ecomus-addons' ),
			'seconds' 	=> esc_html__( 'Secs', 'ecomus-addons' ),
			'second' 	=> esc_html__( 'Sec', 'ecomus-addons' )
		) );
	}

	/**
	 * Check is product deals
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public static function is_product_deal( $product ) {
		$product = is_numeric( $product ) ? wc_get_product( $product ) : $product;

		// It must be a sale product first
		if ( ! $product->is_on_sale() ) {
			return false;
		}

		// Only support product type "simple" and "external"
		if ( ! $product->is_type( 'simple' ) && ! $product->is_type( 'external' ) ) {
			return false;
		}

		$deal_quantity = get_post_meta( $product->get_id(), '_deal_quantity', true );

		if ( $deal_quantity > 0 ) {
			return true;
		}

		return false;
	}

	/**
	 * Get is post ID
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_post_ID() {
		if ( class_exists( '\Ecomus\Helper' ) && method_exists( '\Ecomus\Helper', 'get_post_ID' ) ) {
			return \Ecomus\Helper::get_post_ID();
		}

		return '';
	}

		/**
	 * Get is catalog
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function is_catalog() {
		if ( class_exists( '\Ecomus\Helper' ) && method_exists( '\Ecomus\Helper', 'is_catalog' ) ) {
			return \Ecomus\Helper::is_catalog();
		}

		return '';
	}

		/**
	 * Get is blog
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function is_blog() {
		if ( class_exists( '\Ecomus\Helper' ) && method_exists( '\Ecomus\Helper', 'is_blog' ) ) {
			return \Ecomus\Helper::is_blog();
		}

		return '';
	}


	/**
	 * Get nav menus
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_navigation_bar_get_menus() {
		if ( ! is_admin() ) {
			return [];
		}

		$menus = wp_get_nav_menus();
		if ( ! $menus ) {
			return [];
		}

		$output = array(
			0 => esc_html__( 'Select Menu', 'ecomus-addons' ),
		);
		foreach ( $menus as $menu ) {
			$output[ $menu->slug ] = $menu->name;
		}

		return $output;
	}

	public static function product_card_layout_default() {
		return \Ecomus\Helper::get_option( 'product_card_layout' );
	}

	public static function product_card_layout_select() {
		return \Ecomus\WooCommerce\Helper::product_card_layout_select();
	}

	public static function get_responsive_image_elementor( $settings, $size = 'full' ) {
		$output = [];
		$image = [  'image' => '', 'image_size' => $size ];

		if( ! empty( $settings['image'] ) && ! empty( $settings['image']['url'] ) ) {
			$image['image'] = $settings['image'];
			$class = '';
			if( ! empty( $settings['image_mobile'] ) && ! empty( $settings['image_mobile']['url'] ) ) {
				$class = 'hidden-mobile';
			}

			if( ! empty( $settings['image_tablet'] ) && ! empty( $settings['image_tablet']['url'] ) ) {
				$class = 'hidden-tablet hidden-mobile';
			}

			$output[] = sprintf( '<span class="em-responsive-image em-responsive-image__desktop %s">%s</span>',
									esc_attr( $class ),
									wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image ) )
								);
		}

		if( ! empty( $settings['image_tablet'] ) && ! empty( $settings['image_tablet']['url'] ) ) {
			$image['image'] = $settings['image_tablet'];

			$output[] = sprintf( '<span class="em-responsive-image em-responsive-image__tablet hidden-desktop %s">%s</span>',
									! empty( $settings['image_mobile'] ) && ! empty( $settings['image_mobile']['url'] ) ? 'hidden-mobile' : '',
									wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image ) )
								);
		}

		if( ! empty( $settings['image_mobile'] ) && ! empty( $settings['image_mobile']['url'] ) ) {
			$image['image'] = $settings['image_mobile'];

			$output[] = sprintf( '<span class="em-responsive-image em-responsive-image__mobile hidden-desktop hidden-tablet">%s</span>',
									wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $image ) )
								);
		}

		return implode( '', $output );
	}
}
