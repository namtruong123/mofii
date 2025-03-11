<?php

namespace Ecomus\Addons\Modules\Recent_Sales_Count;

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

		add_action( 'woocommerce_single_product_summary', array( $this, 'recent_sales_count' ), 13 );
		add_action( 'ecomus_recent_sales_count_elementor', array( $this, 'recent_sales_count' ), 13 );

		add_action( 'template_redirect', array( $this, 'update_recent_sales_count' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'ecomus-recent-sales-count', ECOMUS_ADDONS_URL . 'modules/recent-sales-count/assets/recent-sales-count.css', array(), '1.0.0' );
	}

	/**
	 * Get people view fake
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function recent_sales_count() {
		global $product;

		$categories = get_option( 'ecomus_recent_sales_count_categories' );
		$products   = get_option( 'ecomus_recent_sales_count_products' );
		$number     = get_post_meta( $product->get_ID(), 'ecomus_recent_sales_count_expiration', true );
		$hours      = apply_filters( 'ecomus_recent_sales_hours', get_option( 'ecomus_recent_sales_count_hours', 7 ) );
		$check 		= false;

		if( empty( $products ) && empty( $categories ) ) {
			$check = true;
		}

		if( ! empty( $categories ) ) {

			$terms = get_the_terms( $product->get_ID(), 'product_cat' );
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

		$html_number = '<span class="ecomus-recent-sales-count__numbers">' . $number['number'] . '</span>';
		?>
			<div class="ecomus-recent-sales-count">
				<?php echo apply_filters( 'ecomus_recent_sales_count_icon', \Ecomus\Addons\Helper::get_svg( 'fire', 'ui', 'class=ecomus-recent-sales-count__icon' ) ); ?>
				<span class="ecomus-recent-sales-count__text">
					<?php
					echo apply_filters( 'ecomus_recent_sales_count_text', sprintf(
						__( '%s sold in last %s hours', 'ecomus-addons' ),
						$html_number,
						$hours
					), $html_number, $hours );
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
	public function update_recent_sales_count() {
		if( ! is_singular( 'product' ) ) {
			return;
		}

		$number = get_post_meta( get_the_ID(), 'ecomus_recent_sales_count_expiration', true );
		$time   = ( intval( apply_filters( 'ecomus_recent_sales_hours', get_option( 'ecomus_recent_sales_count_hours', 7 ) ) ) * 60 * 60 );
		$from   = get_option( 'ecomus_recent_sales_count_random_numbers_form', 1 );
		$to     = get_option( 'ecomus_recent_sales_count_random_numbers_to', 100 );

		$args = array(
			'number' => rand( $from, $to ),
			'time'   => time()
		);

		if( ! $number ) {
			update_post_meta( get_the_ID(), 'ecomus_recent_sales_count_expiration', $args );
		} else {
			if( ( $number['time'] + $time ) <= time() ) {
				update_post_meta( get_the_ID(), 'ecomus_recent_sales_count_expiration', $args );
			}
		}
	}
}