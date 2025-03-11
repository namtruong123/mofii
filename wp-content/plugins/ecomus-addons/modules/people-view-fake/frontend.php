<?php

namespace Ecomus\Addons\Modules\People_View_Fake;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Frontend {

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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'ecomus_woocommerce_single_product_summary', array( $this, 'people_view_fake' ), 24 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'people_view_fake' ), 15 );
		add_action( 'ecomus_people_view_fake_elementor', array( $this, 'people_view_fake' ), 15 );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'ecomus-people-view', ECOMUS_ADDONS_URL . 'modules/people-view-fake/assets/people-view-fake.css', array(), '1.0.0' );
		wp_enqueue_script('ecomus-people-view', ECOMUS_ADDONS_URL . 'modules/people-view-fake/assets/people-view-fake.js',  array('jquery'), '1.0.0' );
		$datas = array(
			'interval' => get_option( 'ecomus_people_view_fake_interval', 6000 ),
			'from'     => get_option( 'ecomus_people_view_fake_random_numbers_from', 1 ),
			'to'       => get_option( 'ecomus_people_view_fake_random_numbers_to', 100 ),
		);

		wp_localize_script(
			'ecomus-people-view', 'ecomusPVF', $datas
		);
	}

	/**
	 * Get people view fake
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function people_view_fake() {
		$from 	= get_option( 'ecomus_people_view_fake_random_numbers_form', 1 );
		$to   	= get_option( 'ecomus_people_view_fake_random_numbers_to', 100 );
		?>
			<div class="ecomus-people-view">
				<span class="ecomus-people-view__numbers"><?php echo rand( $from, $to ); ?></span>
				<span class="ecomus-people-view__text"><?php echo apply_filters( 'ecomus_people_view_fake_text', esc_html__( 'People are viewing this right now', 'ecomus-addons' ) );?></span>
			</div>
		<?php
	}
}