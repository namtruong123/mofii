<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Upload_File_Field extends Custom_Payment_Field {

	public function get_html() {

		$mime_types = $this->get_allowed_mime_types();
		$accept     = implode( ',', $mime_types );

		return '
		<input id="' . $this->get_id() . '" accept="' . esc_attr( $accept ) . '" class="input-text custom_payment_file_upload ' . $this->get_css_class() . ' ' . $this->get_size() . '" data-key="' . $this->get_id() . '" type="file" name="file_' . $this->get_id() . '" value="' . esc_attr( $this->get_default_value() ) . '">
		<input type="hidden" name="' . $this->get_id() . '" />
		';
	}

	private function get_allowed_mime_types() {
		$wp_mimes = wp_get_mime_types();

		if ( count( $this->get_allowed_extensions() ) === 0 ) {
			return array_values( $wp_mimes );
		}

		$normalized_mimes = [];
		foreach ( $wp_mimes as $key => $mime ) {
			$keys = explode( '|', $key );
			if ( count( $keys ) > 1 ) {
				foreach ( $keys as $mime_key ) {
					$normalized_mimes[ $mime_key ] = $mime;
				}
			} else {
				$normalized_mimes[ $key ] = $mime;
			}
		}
		$mimes = [];
		foreach ( $this->get_allowed_extensions() as $allowedExtension ) {
			if ( isset( $normalized_mimes[ strtolower( $allowedExtension ) ] ) ) {
				$mimes[] = $normalized_mimes[ strtolower( $allowedExtension ) ];
			}
		}

		return $mimes;
	}
}
