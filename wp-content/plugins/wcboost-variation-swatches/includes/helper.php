<?php
namespace WCBoost\VariationSwatches;

defined( 'ABSPATH' ) || exit;

class Helper {

	/**
	 * Returns an array of all the swatches types.
	 *
	 * @since 1.0.18
	 *
	 * @return array
	 */
	public static function get_swatches_types() {
		return [
			'color'  => esc_html__( 'Color', 'wcboost-variation-swatches' ),
			'image'  => esc_html__( 'Image', 'wcboost-variation-swatches' ),
			'label'  => esc_html__( 'Label', 'wcboost-variation-swatches' ),
			'button' => esc_html__( 'Button', 'wcboost-variation-swatches' ),
		];
	}

	/**
	 * Check if a type is a valid swatches type.
	 *
	 * @since 1.0.18
	 *
	 * @param string $type The type to check.
	 *
	 * @return bool True if the type is valid.
	 */
	public static function is_swatches_type( $type ) {
		return array_key_exists( $type, self::get_swatches_types() );
	}

	/**
	 * Get attribute swatches meta data from product data.
	 *
	 * @param int $product_id
	 * @return array
	 */
	public static function get_swatches_meta( $product_id = null ) {
		$product_id = $product_id ? $product_id : get_the_ID();

		return \WCBoost\VariationSwatches\Admin\Product_Data::instance()->get_meta( $product_id );
	}

	/**
	 * Get plugin settings.
	 *
	 * @param string $name
	 * @return mixed
	 */
	public static function get_settings( $name ) {
		return \WCBoost\VariationSwatches\Admin\Settings::instance()->get_option( $name );
	}

	/**
	 * Check if a setting is set as default.
	 *
	 * @param string $value
	 * @return boolean
	 */
	public static function is_default( $value ) {
		return empty( $value ) || 'default' == $value;
	}

	/**
	 * Get attribute's properties
	 *
	 * @param string $attribute_name Attribute name or full slug.
	 *
	 * @return object
	 */
	public static function get_attribute_taxonomy( $attribute_name ) {
		$attribute_slug     = wc_attribute_taxonomy_slug( $attribute_name );
		$taxonomies         = wc_get_attribute_taxonomies();
		$attribute_taxonomy = wp_list_filter( $taxonomies, [ 'attribute_name' => $attribute_slug ] );
		$attribute_taxonomy = ! empty( $attribute_taxonomy ) ? array_shift( $attribute_taxonomy ) : null;

		return $attribute_taxonomy;
	}

	/**
	 * Check if an attribute type is custom type that support swatches.
	 *
	 * @param object $taxonomy The attribute object
	 * @param string $context The context of the check, 'view' or 'edit'.
	 *
	 * @return bool
	 */
	public static function attribute_is_swatches( $taxonomy, $context = 'view' ) {
		if ( ! is_object( $taxonomy ) || empty( $taxonomy->attribute_type ) ) {
			return false;
		}

		$is_swatches = self::is_swatches_type( $taxonomy->attribute_type );

		// If this is a check of admin edit area.
		if ( 'view' !== $context ) {
			return $is_swatches && 'button' !== $taxonomy->attribute_type;
		}

		return $is_swatches;
	}

	/**
	 * Get the correct image by size.
	 * Crop a new image if the correct image is not exists.
	 *
	 * @param int   $attachment_id
	 * @param array $size
	 * @param bool  $force_crop Force cropping to a custom image size
	 *
	 * @return array|bool
	 */
	public static function get_image( $attachment_id, $size, $force_crop = false ) {
		if ( is_string( $size ) || ! $force_crop ) {
			return wp_get_attachment_image_src( $attachment_id, $size );
		}

		$width     = $size[0];
		$height    = $size[1];
		$image_src = wp_get_attachment_image_src( $attachment_id, 'full' );
		$file_path = get_attached_file( $attachment_id );

		if ( $file_path ) {
			$file_info = pathinfo( $file_path );
			$extension = '.' . $file_info['extension'];

			if ( $image_src[1] >= $width || $image_src[2] >= $height ) {
				$no_ext_path      = $file_info['dirname'] . '/' . $file_info['filename'];
				$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

				// the file is larger, check if the resized version already exists
				if ( file_exists( $cropped_img_path ) ) {
					$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );

					return [
						0 => $cropped_img_url,
						1 => $width,
						2 => $height,
					];
				}

				// No resized file, let's crop it
				$image_editor = wp_get_image_editor( $file_path );

				if ( is_wp_error( $image_editor ) || is_wp_error( $image_editor->resize( $width, $height, true ) ) ) {
					return false;
				}

				$new_img_path = $image_editor->generate_filename();

				if ( is_wp_error( $image_editor->save( $new_img_path ) ) ) {
					false;
				}

				if ( ! is_string( $new_img_path ) ) {
					return false;
				}

				$new_img_size = getimagesize( $new_img_path );
				$new_img      = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

				return [
					0 => $new_img,
					1 => $new_img_size[0],
					2 => $new_img_size[1],
				];
			}
		}

		return false;
	}
}
