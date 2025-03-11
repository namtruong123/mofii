<?php

namespace Ecomus\Addons\Modules\Advanced_Linked_Products;

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
	 * Has variation images
	 *
	 * @var $has_variation_images
	 */
	protected static $has_variation_images = null;


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

		add_action( 'woocommerce_single_product_summary', array( $this, 'advanced_linked_products' ), 17 );
		add_action( 'ecomus_advanced_linked_products_elementor', array( $this, 'advanced_linked_products' ), 17 );
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
			wp_enqueue_style( 'ecomus-advanced-linked-products', ECOMUS_ADDONS_URL . 'modules/advanced-linked-products/assets/advanced-linked-products.css', array(), '1.0.0' );
		}
	}

	public function advanced_linked_products() {
		global $product;

		$product_ids = maybe_unserialize( get_post_meta( $product->get_id(), 'ecomus_advanced_linked_product_ids', true ) );
		$product_ids = apply_filters( 'ecomus_advanced_linked_product_ids', $product_ids, $product );

		if ( empty( $product_ids ) ) {
            return;
        }

		if( ! in_array( $product->get_id(), $product_ids ) ) {
			array_unshift( $product_ids, $product->get_id() );
		}
	?>
		<div id="ecomus-advanced-linked-products" class="advanced-linked-products em-flex em-flex-wrap">
			<div class="advanced-linked-products__heading"><?php esc_html_e( 'Choose: ', 'ecomus-addons' ); ?><span class="em-color-dark em-font-semibold"><?php echo wp_kses_post( $product->get_title() ) ?></span></div>
			<?php foreach ( $product_ids as $product_id ) : ?>
				<?php $linked_product = wc_get_product( $product_id );?>
                <a class="advanced-linked-products__item <?php echo $product->get_id() == $product_id ? 'current' : ''; ?>" href="<?php echo esc_url( $linked_product->get_permalink() ); ?>" title="<?php echo wp_kses_post( $linked_product->get_title() ); ?>">
                    <span class="advanced-linked-products__image">
                        <?php echo $linked_product->get_image();?>
                    </span>
                    <span class="advanced-linked-products__title em-color-dark em-font-semibold">
                        <?php echo $linked_product->get_title();?>
                    </span>
				</a>
			<?php endforeach; ?>
		</div>
	<?php
	}
}