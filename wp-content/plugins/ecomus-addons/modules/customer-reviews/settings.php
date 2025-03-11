<?php
namespace Ecomus\Addons\Modules\Customer_Reviews;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings  {

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
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'woocommerce_get_sections_products', array( $this, 'customer_reviews_section' ), 190, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'customer_reviews_settings' ), 190, 2 );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function customer_reviews_section( $sections ) {
		$sections['ecomus_customer_reviews'] = esc_html__( 'Customer Reviews', 'ecomus-addons' );

		return $sections;
	}

	/**
	 * Adds settings to product display settings
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings
	 * @param string $section
	 *
	 * @return array
	 */
	public function customer_reviews_settings( $settings, $section ) {
		if ( 'ecomus_customer_reviews' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'ecomus_customer_reviews_options',
				'title' => esc_html__( 'Customer Reviews', 'ecomus-addons' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'ecomus_customer_reviews_upload',
				'title'   => esc_html__( 'Allow Media Uploads', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'id'      => 'ecomus_customer_reviews_upload_video',
				'title'   => esc_html__( 'Allow Video Upload', 'ecomus-addons' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'name'    => esc_html__( 'Limit The Number of Files', 'ecomus-addons' ),
				'id'      => 'ecomus_customer_reviews_upload_limit',
				'type'    => 'number',
				'custom_attributes' => array(
					'min'  => 1,
					'step' => 1,
				),
				'default' => 5,
			);

			$settings[] = array(
				'name'    => esc_html__( 'Maximum Size of Media File (in MB)', 'ecomus-addons' ),
				'desc_tip' => esc_html__( 'Specify the maximum size (in MB) of an image or a video that can be uploaded with a review. This setting applies only to reviews submitted on single product pages.', 'ecomus-addons' ),
				'id'      => 'ecomus_customer_reviews_upload_size',
				'type'    => 'number',
				'default' => 5,
			);

			$settings[] = array(
				'id'   => 'ecomus_customer_reviews_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}
}