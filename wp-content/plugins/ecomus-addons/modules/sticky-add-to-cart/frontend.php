<?php

namespace Ecomus\Addons\Modules\Sticky_Add_To_Cart;
use Ecomus\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Frontend {

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
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		// Sticky add to cart
		add_action( 'wp_footer', array( $this, 'sticky_single_add_to_cart' ) );
	}

	public function scripts() {
		wp_enqueue_style( 'ecomus-sticky-add-to-cart', ECOMUS_ADDONS_URL . 'modules/sticky-add-to-cart/assets/css/sticky-add-to-cart.css', array(), '1.0.1' );

		wp_enqueue_script('ecomus-sticky-add-to-cart', ECOMUS_ADDONS_URL . 'modules/sticky-add-to-cart/assets/js/sticky-add-to-cart.js');
	}

	/**
	 * Check has sticky add to cart
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public function has_sticky_atc() {
		global $product;

		if ( $product->is_purchasable() && $product->is_in_stock() ) {
			return true;
		} elseif ( $product->is_type( 'external' ) || $product->is_type( 'grouped' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Add sticky add to cart HTML
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function sticky_single_add_to_cart( $sticky_class ) {
		global $product;

		if ( ! $this->has_sticky_atc() ) {
			return;
		}

		$product_type    = $product->get_type();
		$sticky_class    = 'ecomus-sticky-add-to-cart product-' . $product_type;

		$post_thumbnail_id =  $product->get_image_id();

		if ( $post_thumbnail_id ) {
			$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
			$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
			$thumbnail_src     = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
			$alt_text          = trim( wp_strip_all_tags( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) );
		} else {
			$thumbnail_src = wc_placeholder_img_src( 'gallery_thumbnail' );
			$alt_text      = esc_html__( 'Awaiting product image', 'ecomus-addons' );
		}
		$multi_attributes = true;
		$number = apply_filters('ecomus_sticky_atc_number_variations_select', 3);
		if ( $product->is_type( 'variable' ) ) {
			$attributes = $product->get_variation_attributes();
			$multi_attributes = count($attributes) > $number ? true : false;
			$sticky_class    .= $multi_attributes ? '' : ' variations-custom';
		}

		if ( $product->is_sold_individually() ) {
			$sticky_class .= ' sold-individually';
		}

		$sticky_class = apply_filters('ecomus_sticky_add_to_cart_classes', $sticky_class);

		?>
        <section id="ecomus-sticky-add-to-cart" class="<?php echo esc_attr( $sticky_class ) ?>">
				<div class="em-container">
					<div class="ecomus-sticky-atc__content">
						<div class="ecomus-sticky-atc__image">
							<img src="<?php echo esc_url( $thumbnail_src[0] ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>" data-o_src="<?php echo esc_url( $thumbnail_src[0] );?>">
						</div>
						<div class="ecomus-sticky-atc__product-info">
							<div class="ecomus-sticky-atc__title"><?php the_title(); ?></div>
							<div class="ecomus-sticky-atc__price"><?php echo $product->get_price_html(); ?></div>
						</div>
						<div class="ecomus-sticky-atc__actions">
							<?php
								add_filter( 'ecomus_show_product_featured_buttons', '__return_false' );
								add_filter( 'ecomus_show_quantity_label', '__return_false' );
								if ( $product->is_type( 'grouped' ) ) {
									$this->add_to_cart_button('em-add-to-cart-options');
								} elseif ( $product->is_type( 'variable' ) ) {
									if ( $multi_attributes ) {
										$this->get_default_product_variable_form();
										$this->add_to_cart_button('em-add-to-cart-options');
									} else {
										$this->get_custom_product_variable_form();
									}
								} else {
									woocommerce_template_single_add_to_cart();
								}

								remove_filter( 'ecomus_show_product_featured_buttons', '__return_false' );
								remove_filter( 'ecomus_show_quantity_label', '__return_false' );
							?>

							<?php do_action( 'ecomus_after_sticky_add_to_cart_button' ); ?>
						</div>
					</div>
                </div>
        </section><!-- .ecomus-sticky-add-to-cart -->
		<?php
	}

	public function add_to_cart_button($class = '') {
		global $product;
		echo '<button type="submit" class="single_add_to_cart_button button ' . esc_attr( $class ) . '">' . esc_html( $product->single_add_to_cart_text() ) . '</button>';
	}

	/**
	 *
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function ecomus_sticky_add_to_cart__percentage( $html, $percentage ) {
		$html = '-' . $percentage . '%' . '';
		return $html;
	}

	public function get_custom_product_variable_form() {
		global $product;

		?>
		<form class="cart" action="<?php echo esc_url($product->get_permalink()) ?>" method="post" enctype="multipart/form-data">
			<div class="ecomus-sticky-atc__variations">
				<?php
					\Ecomus\Addons\Modules\Sticky_Add_To_Cart\Variation_Select::instance()->render();
				?>
			</div>
			<div class="ecomus-sticky-atc__buttons">
				<?php
				woocommerce_quantity_input(
					array(
						'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
						'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
						'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
					)
				);
				$this->add_to_cart_button();

				?>
				<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ) ?>">
				<input type="hidden" name="product_id" value="<?php echo esc_attr( $product->get_id() ) ?>">
			</div>
		</form>
		<?php

	}

	/**
	 *
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_default_product_variable_form() {
		global $product;
		$available_variations = $product->get_available_variations();

		if ( ! $available_variations ) {
			return;
		}

		if ( class_exists( 'WCBoost\VariationSwatches\Swatches' ) ) {
			remove_filter( 'woocommerce_dropdown_variation_attribute_options_html', [ \WCBoost\VariationSwatches\Swatches::instance(), 'swatches_html' ], 100, 2 );
		}

		woocommerce_template_single_add_to_cart();

	}

}