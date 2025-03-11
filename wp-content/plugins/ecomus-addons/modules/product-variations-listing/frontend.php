<?php

namespace Ecomus\Addons\Modules\Product_Variations_Listing;

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

		add_action( 'woocommerce_after_single_product_summary', array( $this, 'product_variations_listing' ), 7 );
		add_action( 'ecomus_single_product_variations_listing_elementor', array( $this, 'product_variations_listing' ), 7 );

		// Update Cart
		add_action( 'wc_ajax_ecomus_update_variations_listing', array( $this, 'update_variations_listing' ) );
		add_action( 'wc_ajax_ecomus_pagination_load', array( $this, 'pagination_load' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( is_singular( 'product' ) || is_singular( 'ecomus_builder' ) ) {
			wp_enqueue_style( 'ecomus-product-variations-listing', ECOMUS_ADDONS_URL . 'modules/product-variations-listing/assets/product-variations-listing.css', array(), '1.0.0' );
			wp_enqueue_script('ecomus-product-variations-listing', ECOMUS_ADDONS_URL . 'modules/product-variations-listing/assets/product-variations-listing.js',  array('jquery'), '1.0.0' );

			$data = array(
				'currency_pos'    => get_option( 'woocommerce_currency_pos' ),
				'currency_symbol' => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '',
				'thousand_sep'    => function_exists( 'wc_get_price_thousand_separator' ) ? wc_get_price_thousand_separator() : '',
				'decimal_sep'     => function_exists( 'wc_get_price_decimal_separator' ) ? wc_get_price_decimal_separator() : '',
				'price_decimals'  => function_exists( 'wc_get_price_decimals' ) ? wc_get_price_decimals() : '',
				'ajax_url'        => class_exists( 'WC_AJAX' ) ? \WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
				'pagination'      => get_option( 'ecomus_product_variations_listing_pagination' ),
			);

			wp_localize_script(
				'ecomus-product-variations-listing', 'ecomusPVL', $data
			);
		}
	}

	/**
	 * Get people view fake
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_variations_listing() {
		global $product;

		if( $product->get_type() !== 'variable' ) {
			return;
		}

		if( empty( $product->get_available_variations() ) ) {
			return;
		}

		$selector   = get_option( 'ecomus_product_variations_listing_products' );
		$categories = get_option( 'ecomus_product_variations_listing_category' );
		$products   = get_option( 'ecomus_product_variations_listing_product_ids' );
		$check 		= false;

		if( $selector == 'all' && empty( $categories ) ) {
			$check = true;
		}

		if( ! empty( $categories ) ) {
			$terms = get_the_terms( $product->get_ID(), 'product_cat' );
			if( ! is_wp_error( $terms ) && $terms ) {
				foreach( $terms as $term ) {
					if( in_array( $term->slug, $categories ) ) {
						$check = true;
						break;
					} else {
						$check = false;
					}
				}
			}
		}

		if( $selector == 'custom' && empty( $products ) && empty( $categories ) ) {
			$check = true;
		}

		if( $selector == 'custom' && ! empty( $products ) ) {
			if( in_array( $product->get_ID(), $products ) ) {
				$check = true;
			} else {
				$check = false;
			}
		}

		if( ! apply_filters( 'ecomus_product_variations_listing_check', $check ) ) {
			return;
		}
	?>
		<div id="ecomus-product-variations-listing" class="ecomus-product-variations-listing" data-product_id="<?php echo intval( $product->get_id() ); ?>">
			<div class="product-variations-listing__header em-flex em-flex-align-center">
				<span class="em-color-dark em-font-semibold">
					<?php esc_html_e( 'Variants', 'ecomus-addons' ); ?>
				</span>
				<span class="em-color-dark em-font-semibold">
					<?php esc_html_e( 'Quantity', 'ecomus-addons' ); ?>
				</span>
				<span class="em-color-dark em-font-semibold text-right">
					<?php esc_html_e( 'Price', 'ecomus-addons' ); ?>
				</span>
				<span class="em-color-dark em-font-semibold text-right">
					<?php esc_html_e( 'Variant total', 'ecomus-addons' ); ?>
				</span>
			</div>
			<div class="product-variations-listing__body em-flex em-flex-align-center em-flex-wrap">
				<?php $args = \Ecomus\Addons\Modules\Product_Variations_Listing\Variation_Listing::instance()->render(); ?>
			</div>
			<div class="product-variations-listing__footer em-flex">
				<div class="product-variations-listing__button">
					<a class="button em-font-semibold" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php echo esc_attr__( 'View Cart', 'ecomus-addons' ); ?>"><?php echo esc_html__( 'View Cart', 'ecomus-addons' ); ?></a>
				</div>
				<?php
					$pagination = get_option( 'ecomus_product_variations_listing_pagination' );
					$per_page   = get_option( 'ecomus_product_variations_listing_per_page' );
					$total_page = ceil( $args['total_item'] / $per_page );
				?>
				<?php if ( $pagination == 'yes' ) : ?>
					<?php if( $total_page > 1 ) : ?>
						<?php self::get_pagination( $total_page, intval( $product->get_id() ) ); ?>
					<?php else : ?>
						<div class="product-variations-listing__total-quantity em-flex em-color-dark text-center">
							<span class="total-quantity"><?php echo wp_kses_post( $args['quantity'] ); ?></span>
							<span><?php esc_html_e( 'Total items', 'ecomus-addons' );?></span>
						</div>
						<div class="product-variations-listing__subtotal em-flex em-color-dark text-right">
							<span class="total-price em-font-semibold"><?php echo wc_price( $args['price'] ); ?></span>
							<span><?php esc_html_e( 'Product subtotal', 'ecomus-addons' );?></span>
						</div>
					<?php endif; ?>
				<?php else : ?>
				<div class="product-variations-listing__total-quantity em-flex em-color-dark text-center">
					<span class="total-quantity"><?php echo wp_kses_post( $args['quantity'] ); ?></span>
					<span><?php esc_html_e( 'Total items', 'ecomus-addons' );?></span>
				</div>
				<div class="product-variations-listing__subtotal em-flex em-color-dark text-right">
					<span class="total-price em-font-semibold"><?php echo wc_price( $args['price'] ); ?></span>
					<span><?php esc_html_e( 'Product subtotal', 'ecomus-addons' );?></span>
				</div>
				<?php endif; ?>
			</div>
			<input name="variation_ids" type="hidden" value="<?php echo esc_attr( $args['variation_ids'] ); ?>" />
		</div>
	<?php
	}

	/**
	 * Update variation listing
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function update_variations_listing() {
		if ( empty( $_POST['action'] ) ) {
			return;
		}

		if( $_POST['action'] !== 'ecomus_update_variations_listing' ) {
			return;
		}

		wc_nocache_headers();

		$args = [
			'success' => false,
		];

		$variation_id  = $_POST['variation_id'];
		$variation     = (array) json_decode( stripslashes( $_POST['variation_attribute'] ) );
		$quantity      = isset( $_POST[ 'variation_quantity' ] ) ? intval( $_POST[ 'variation_quantity' ] ) : 0;
		$in_cart       = false;
		$cart_item_key = null;

		if ( ! WC()->cart->is_empty() ) {
			foreach ( WC()->cart->get_cart() as $key => $cart_item ) {
				if( $cart_item['variation_id'] == $variation_id && ! array_diff( $cart_item['variation'], $variation ) ) {
					$in_cart       = true;
					$cart_item_key = $key;
					break;
				}
			}
		}

		if( $in_cart ) {
			if( $quantity > 0 ) {
				$args['success'] = WC()->cart->set_quantity( $cart_item_key, intval( $quantity ) );
			} else {
				$args['success'] = WC()->cart->remove_cart_item( $cart_item_key );
			}
		} else {
			$adding_to_cart = wc_get_product( $variation_id );

			if ( $adding_to_cart ) {
				$product_id = $adding_to_cart->get_parent_id();
				$args['success'] = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );
			}
		}

		wp_send_json( $args );
		die();
	}

	/**
     * Pagination load
     *
	 **/
	public function pagination_load() {
		if( empty( $_POST['name'] ) ) {
			return;
		}

		if( $_POST['name'] !== 'ecomus_product_variations_listing_pagination_load' ) {
			return;
		}

		ob_start();
		$product = wc_get_product( $_POST['product_id'] );
		\Ecomus\Addons\Modules\Product_Variations_Listing\Variation_Listing::instance()->render( $product );
		$response = ob_get_clean();
		wp_send_json_success( $response );
		die();
	}

	/**
	 * Pagination.
	 */
	public function get_pagination( $total_page, $product_id ) {
		?>
		<nav class="woocommerce-pagination product-variations-listing__pagination" data-product_id="<?php echo esc_attr( $product_id ); ?>">
			<ul class="page-numbers">
				<?php if( $total_page > 3 ): ?>
					<li class="prev page-numbers hidden"><?php echo \Ecomus\Addons\Helper::get_svg( 'left-mini' ); ?></li>
				<?php endif;?>

				<?php for( $i = 1; $i <= $total_page; $i++ ) { ?>
					<li class="page-numbers <?php echo $i == 1 ? 'current' : ''; ?> <?php echo $i > 3 ? 'hidden' : ''; ?>" aria-current="page" data-page="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></li>
				<?php } ?>

				<?php if( $total_page > 3 ): ?>
					<li class="next page-numbers"><?php echo \Ecomus\Addons\Helper::get_svg( 'right-mini' ); ?></li>
				<?php endif;?>
			</ul>
		</nav>
		<?php
	}
}