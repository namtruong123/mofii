<?php
namespace Ecomus\Addons\Modules\Product_Variations_Listing;

use Ecomus\Addons\Modules\Base\Variation_Select as BaseVariation_Select;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Variation_Listing extends BaseVariation_Select {

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
	 * Constructor
	 *
	 * @param WC_Product_Variable $product
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Render variation dropdown
	 *
	 * @return void
	 */
	public function render( $product = null ) {
		if( ! empty( $product ) ) {
			$this->product = $product;
		}

		if ( ! $this->product ) {
			return;
		}

		$options = $this->get_options();

		if ( empty( $options ) ) {
			return;
		}

		$args = [
			'quantity'      => 0,
			'price'         => 0,
			'variation_ids' => []
		];

		$cart_item          = self::cart_items();
		$variation_ids      = array_column( $options, 'variation_id' );
		$args['total_item'] = count( $options );
		$pagination         = get_option( 'ecomus_product_variations_listing_pagination' );
		$per_page           = get_option( 'ecomus_product_variations_listing_per_page' );
		$page_number        = 1;
		$count              = 1;

		?>
		<?php foreach ( $options as $option ) : ?>
			<?php
				$variation_id      = $option['variation_id'];
				$variation_product = new \WC_Product_Variation( $variation_id );
				$variation         = $variation_id . '|' . $this->json_encode_attribute( $option['attributes'] );
				$quantity          = 0;
				$variation_price   = 0;
				$class             = '';

				if( ! empty( $cart_item[ $variation ]['quantity'] ) && ! array_diff( $cart_item[ $variation ]['attributes'], $option['attributes'] ) ) {
					$quantity          = $cart_item[ $variation ]['quantity'];
					$variation_price   = ( floatval( $cart_item[ $variation ]['line_total'] ) / intval( $quantity ) );
					$args['quantity'] += intval( $cart_item[ $variation ]['quantity'] );
					$args['price']    += floatval( $cart_item[ $variation ]['line_total'] );
					$class             = 'active';
				}
			?>
			<div class="product-variations-listing__item em-flex <?php echo esc_attr( $class ); ?>" data-page="<?php echo esc_attr( $page_number ); ?>" data-variation="<?php echo esc_attr( $variation ); ?>">
				<div class="product-variations-listing__image">
					<img src="<?php echo esc_attr( $option['thumbnail_src'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>">
				</div>
				<div class="product-variations-listing__summary em-flex em-flex-align-center">
					<div class="product-variations-listing__title"><?php echo esc_html( $option['label'] ); ?></div>
					<div class="product-variations-listing__quantity em-flex em-flex-align-center">
						<?php
						if( ! $variation_product->is_in_stock() ) {
							echo '<div class="product-variations-listing__stock em-button">' . esc_html__( 'Sold out', 'ecomus' ) . '</div>';
						} else {
							echo woocommerce_quantity_input( array(
																'input_name'   => "variation_cart_{$variation_id}_qty",
																'input_value'  => $quantity,
															), $variation_product, false );
						}
						?>
						<input type="hidden" name="product_id" value="<?php echo intval( $this->product->get_id() ); ?>" />
						<input type="hidden" name="variation_id" value="<?php echo intval( $variation_id ); ?>" />
						<input type="hidden" name="variation_price" value="<?php echo esc_attr( $option['price'] ); ?>" />
						<input type="hidden" name="variation_regular_price" value="<?php echo esc_attr( $variation_product->get_regular_price() ); ?>" />
						<input type="hidden" name="variation_attribute" value="<?php echo esc_attr( $this->json_encode_attribute( $option['attributes'] ) ); ?>" />
						<input type="hidden" name="variation_cart_item_key" value="<?php echo ! empty( $cart_item[$variation]['cart_item_key'] ) ? $cart_item[$variation]['cart_item_key'] : ''; ?>" />
						<button class="product-variations-listing__remove em-button em-button-subtle <?php echo esc_attr( $quantity == 0 ? 'hidden' : '' ); ?>"><span><?php echo esc_html__( 'Remove', 'ecomus-addons' ); ?></span></button>
					</div>
					<div class="product-variations-listing__price text-right">
						<span class="hidden-lg hidden-md hidden-sm"><?php echo esc_html__( 'Price', 'ecomus-addons' ); ?></span>
						<span class="price em-font-semibold">
							<?php
							if( $variation_price !== 0 && floatval( $variation_product->get_price() ) !== $variation_price ) {
								if( $variation_price < $variation_product->get_price() ) {
									echo wc_format_sale_price( $variation_product->get_price(), $variation_price );
								} else {
									echo wc_price( $variation_price );
								}
						 	} else {
								if( $variation_product->get_price() < $variation_product->get_regular_price() ) {
									echo wc_format_sale_price( $variation_product->get_regular_price(), $variation_product->get_price() );
								} else {
                                    echo wc_price( $variation_product->get_price() );
                                }
							}
							?>
						</span>
					</div>
					<div class="product-variations-listing__total text-right"><span class="hidden-lg hidden-md hidden-sm"><?php echo esc_html__( 'Variant total', 'ecomus-addons' ); ?></span><span class="price em-font-semibold em-loading-spin"><?php echo wc_price( $quantity * $variation_price ); ?></span></div>
				</div>
			</div>
			<?php
				if( $pagination == 'yes' ) {
					if( $count == $per_page ) {
						$count = 0;
						$page_number++;

						if( $product == null ) {
							break;
						}
					}
				}
			?>
		<?php
			$count++;
		endforeach;

		$args['variation_ids'] = json_encode( $variation_ids );

		return $args;
	}

	/**
	 * Cart items
	 *
	 * @return array $args
	 */
	public function cart_items() {
		$args = [];

		if( empty( WC()->cart ) ) {
			return $args;
		}
		
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
			$args[ $cart_item['variation_id'] . '|' . json_encode( $cart_item['variation'] ) ] = [
												'cart_item_key' => $cart_item_key,
												'quantity'      => $cart_item['quantity'],
												'attributes'    => $cart_item['variation'],
												'line_total'    => $cart_item['line_total'],
											];
		endforeach;

		return $args;
	}
}
