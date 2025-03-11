<?php
/**
 * Mini Cart hooks.
 *
 * @package Ecomus
 */

namespace Ecomus\WooCommerce;

use Ecomus\Helper;
use Ecomus\Icon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Mini Cart
 */
class Mini_Cart {
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
		add_action('woocommerce_mini_cart_contents', array( $this, 'mini_cart_recommended_products' ));

		// Ajax update mini cart.
		add_action( 'wc_ajax_update_cart_item', array( $this, 'update_cart_item' ) );

		add_action('ecomus_mini_cart_products_recommended_loop_after', array( $this, 'mini_cart_featured_icon' ));
	}

		/**
	 * Update a cart item.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function update_cart_item() {
		if ( empty( $_POST['cart_item_key'] ) || ! isset( $_POST['qty'] ) ) {
			wp_send_json_error();
			exit;
		}

		$cart_item_key 		= wc_clean( isset( $_POST['cart_item_key'] ) ? wp_unslash( $_POST['cart_item_key'] ) : '' );
		$cart_item_length 	= isset( $_POST['cart_item_length'] ) ? $_POST['cart_item_length'] : '';
		$qty           		= floatval( $_POST['qty'] );

		check_admin_referer( 'ecomus-update-cart-qty--' . $cart_item_key, 'security' );

		do_action( 'ecomus_update_cart_item', $cart_item_key, $qty );

		ob_start();
		WC()->cart->set_quantity( $cart_item_key, $qty );

		if ( $cart_item_key && false !== WC()->cart->set_quantity( $cart_item_key, $qty ) ) {
			if ( $cart_item_length == 1 && ! $qty ) {
				WC()->cart->empty_cart();
			}

			\WC_AJAX::get_refreshed_fragments();
		} else {
			wp_send_json_error();
		}
	}

	function mini_cart_recommended_products() {
        if ( ! class_exists( 'WC_Shortcode_Products' ) ) {
            return;
        }

        $limit = Helper::get_option( 'mini_cart_products_limit' );
        $type  = Helper::get_option( 'mini_cart_products' );

        if('none' == $type){
            return;
        } elseif('crosssells_products' == $type) {
			$cross_sells = array_filter( array_map( 'wc_get_product', WC()->cart->get_cross_sells() ), 'wc_products_array_filter_visible' );
			$orderby = 'rand';
			$order = 'desc';
			$orderby     = apply_filters( 'woocommerce_cross_sells_orderby', $orderby );
			$order       = apply_filters( 'woocommerce_cross_sells_order', $order );
			$cross_sells = wc_products_array_orderby( $cross_sells, $orderby, $order );
			$limit       = intval( apply_filters( 'woocommerce_cross_sells_total', $limit ) );
			$cross_sells = $limit > 0 ? array_slice( $cross_sells, 0, $limit ) : $cross_sells;
			if( empty( $cross_sells ) ) {
				return;
			}
			$this->products_recommended_content($cross_sells);
		} else {
			$atts = array(
				'per_page'     => intval( $limit ),
				'category'     => '',
				'cat_operator' => 'IN',
			);

			switch ( $type ) {
				case 'sale_products':
				case 'top_rated_products':
					$atts = array_merge( array(
						'orderby' => 'title',
						'order'   => 'ASC',
					), $atts );
					break;

				case 'recent_products':
					$atts = array_merge( array(
						'orderby' => 'date',
						'order'   => 'DESC',
					), $atts );
					break;

				case 'featured_products':
					$atts = array_merge( array(
						'orderby' => 'date',
						'order'   => 'DESC',
					), $atts );
					break;
			}

			$args  = new \WC_Shortcode_Products( $atts, $type );
			$args  = $args->get_query_args();

			foreach( WC()->cart->get_cart() as $cart_item ){
				$product_id[] = $cart_item['product_id'];
			}

			if ( $product_id ) {
				$args = array_merge( array(
					'post__not_in' => $product_id,
				), $args );
			}

			$query = new \WP_Query( $args );

			if( !count($query->posts) ) {
				return;
			}

			$this->products_recommended_content($query->posts);
			wp_reset_postdata();
		}
	}

	/**
    * Get products recommended content
    *
    * @since 1.0.0
    *
    * @param $query_posts
    *
    * @return void
    */
    public function products_recommended_content($query_posts) {
        ?>
        <li>
			<div class="ecomus-mini-products-recommended">
				<div class="products-recommended-header">
					<h2 class="recommendation-heading em-font-semibold"> <?php echo esc_html__( 'Customers also bought', 'ecomus' ); ?> </h2>
					<span class="swiper-pagination"></span>
				</div>
				<div class="swiper">
					<ul class="woocommerce-loop-products swiper-wrapper">
						<?php
						foreach ( $query_posts as $product ) {
							$_product = is_numeric( $product ) ? wc_get_product( $product ) : $product;

							if( empty( $_product ) || ! is_object( $_product ) ) {
								continue;
							}
							?>

							<li class="woocommerce-loop-product">
								<a class="woocommerce-loop-product__thumbnail" href="<?php echo esc_url( $_product->get_permalink() ); ?>">
									<?php echo ! empty( $_product ) ?  $_product->get_image( 'woocommerce_thumbnail' ) : ''; ?>
								</a>
								<div class="woocommerce-loop-product__summary">
									<a href="<?php echo esc_url( $_product->get_permalink() ); ?>">
										<span class="woocommerce-loop-product__title"><?php echo esc_html( $_product->get_name() ); ?></span>
									</a>
									<span class="price"><?php echo ! empty( $_product ) ? $_product->get_price_html() : ''; ?></span>
								</div>
								<?php do_action('ecomus_mini_cart_products_recommended_loop_after', $_product) ?>
							</li>

							<?php
						}
					?>
					</ul>
				</div>
			</div>
		</li>
	<?php
	}

	/**
	 *  Featured icon
	 */
	 public function mini_cart_featured_icon($product = false) {
		if ( Helper::get_option( 'mini_cart_featured_icon' ) == 'quick-view' ) {
			$this->mini_cart_quick_view_icon($product);
		} else {
			$this->mini_cart_add_to_cart_button($product);
		}
	}

	/**
	 *  Featured icon
	 */
	public function mini_cart_quick_view_icon($product) {
		$classes = 'em-button product-loop-button em-flex-align-center em-flex-center em-button-icon em-tooltip';

		if( \Ecomus\WooCommerce\Helper::get_product_card_layout() == '2' ) {
			$classes .= ' mobile-show-button';
		}

		$classes = apply_filters( 'ecomus_quick_view_button_icon_classes', $classes );

		\Ecomus\WooCommerce\Loop\Quick_View::quick_view_button_html( $classes, true, $product );
	}

	/**
	 *  Add to cart button
	 */
	 public function mini_cart_add_to_cart_button($product) {
		$classes = 'button em-button product-loop-button em-flex-align-center em-flex-center em-button-icon em-tooltip ecomus-featured-icons';
		$classes .= ' product_type_' . $product->get_type();
		$classes .= $product->is_purchasable() && $product->is_in_stock() ? ' add_to_cart_button' : '';
		$classes .= $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? ' ajax_add_to_cart' : '';

		$classes = apply_filters( 'ecomus_quick_view_button_icon_classes', $classes );

		$data_toggle = $product->get_type() == 'variable' ? 'data-toggle="modal"' : '';
		$data_target = $product->get_type() == 'variable' ? 'data-target="quick-add-modal"' : '';

		echo sprintf(
			'<a href="%s" data-quantity="1" class="%s" data-product_id="%s" data-tooltip="%s" aria-label="%s" %s %s rel="nofollow">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $classes ),
			esc_attr($product->get_id()),
			$this->mini_cart_add_to_cart_button_text($product),
			$this->mini_cart_add_to_cart_button_text($product) . esc_attr__( ' for ', 'ecomus' ) . $product->get_title(),
			$data_toggle,
			$data_target,
			\Ecomus\Helper::get_cart_icons()
		);
	 }

	/**
	 *  Add to cart button text
	 */
	 public function mini_cart_add_to_cart_button_text($product) {
		if( $product && $product->get_type() == 'variable' ) {
			$product_card = \Ecomus\WooCommerce\Helper::get_product_card_layout();
			$button_text = $product_card == '4' ? esc_html__( 'Quick Add', 'ecomus' ) : esc_html__( 'Quick Shop', 'ecomus' );

			\Ecomus\Theme::set_prop( 'modals', 'quickadd' );
		} else {
			$button_text = $product->add_to_cart_text();
		}

		return $button_text;
	 }
}