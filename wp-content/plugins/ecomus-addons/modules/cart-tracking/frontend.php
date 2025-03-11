<?php

namespace Ecomus\Addons\Modules\Cart_Tracking;

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

		add_action( 'woocommerce_single_product_summary', array( $this, 'cart_tracking' ), 7 );
		add_action( 'ecomus_woocommerce_single_product_summary', array( $this, 'cart_tracking' ), 17 );
		add_action( 'ecomus_cart_tracking_elementor', array( $this, 'cart_tracking' ), 17 );

		add_action( 'template_redirect', array( $this, 'update_cart_tracking' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'ecomus-cart-tracking', ECOMUS_ADDONS_URL . 'modules/cart-tracking/assets/cart-tracking.css', array(), '1.0.0' );
	}

	/**
	 * Get people view fake
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function cart_tracking() {
		global $product;

		$categories = get_option( 'ecomus_cart_tracking_categories' );
		$products   = get_option( 'ecomus_cart_tracking_products' );
		$number     = get_post_meta( $product->get_ID(), 'ecomus_cart_tracking_expiration', true );
		$check 		= false;

		if( empty( $number ) ) {
			return;
		}

		if( empty( $products ) && empty( $categories ) ) {
			$check 		= true;
		}

		if( ! empty( $categories ) ) {

			$terms       = get_the_terms( $product->get_ID(), 'product_cat' );
			if( ! is_wp_error( $terms ) && $terms ) {
				$term_slugs = array();
				foreach( $terms as $term ) {
					$term_slugs[] = $term->slug;
					if( in_array( $term->slug, $categories ) ) {
						$check = true;
						break;
					}
				}
			}

		}

		if( ! empty( $products ) ) {
			if( in_array( $product->get_ID(), $products ) ) {
				$check = true;
			}
		}

		if( ! $check ) {
			return;
		}

		$html_number = '<span class="ecomus-cart-tracking__numbers">' . $number['number'] . '</span>';
		?>
			<div class="ecomus-cart-tracking">
				<span class="ecomus-cart-tracking__badges"><?php echo apply_filters( 'ecomus_cart_tracking_badges', esc_html__( 'Best seller', 'ecomus-addons' ) ); ?></span>
				<span class="ecomus-cart-tracking__text">
					<?php echo apply_filters( 'ecomus_cart_tracking_icon', \Ecomus\Addons\Helper::get_svg( 'thunder', 'ui', 'class=ecomus-cart-tracking__icon' ) ); ?>
					<?php
					echo apply_filters( 'ecomus_cart_tracking_text', sprintf(
						__( 'Selling fast! %s people have this in their carts.', 'ecomus-addons' ),
						$html_number
					), $html_number );
					?>
				</span>
			</div>
		<?php
	}

	/**
	 * Update cart tracking
	 *
	 * @return void
	 */
	public function update_cart_tracking() {
		if( ! is_singular( 'product' ) ) {
			return;
		}

		$number = get_post_meta( get_the_ID(), 'ecomus_cart_tracking_expiration', true );
		$time   = ( intval( apply_filters( 'ecomus_cart_tracking_expiration', 15 ) ) * 60 );
		$from   = get_option( 'ecomus_cart_tracking_random_numbers_form', 1 );
		$to     = get_option( 'ecomus_cart_tracking_random_numbers_to', 100 );

		$args = array(
			'number' => rand( $from, $to ),
			'time'   => time()
		);

		if( ! $number || ! isset( $number['time'] ) ) {
			update_post_meta( get_the_ID(), 'ecomus_cart_tracking_expiration', $args );
		} else {
			if( ( $number['time'] + $time ) <= time() ) {
				update_post_meta( get_the_ID(), 'ecomus_cart_tracking_expiration', $args );
			}
		}
	}
}