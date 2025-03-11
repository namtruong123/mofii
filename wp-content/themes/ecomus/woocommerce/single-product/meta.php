<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

use Automattic\WooCommerce\Enums\ProductType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( \Ecomus\Helper::get_option( 'product_sku' ) && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( ProductType::VARIABLE ) ) ) : ?>

		<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'ecomus' ); ?>
			<span class="sku">
				<?php if ( $sku = $product->get_sku() ) {
					echo !empty( $sku ) ? $sku : '';
				} else {
					esc_html_e( 'N/A', 'ecomus' );
				}   ?>
			</span>
		</span>

	<?php endif; ?>

	<?php echo \Ecomus\Helper::get_option( 'product_categtories' ) ? wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'ecomus' ) . ' ', '</span>' ) : ''; ?>

	<?php echo \Ecomus\Helper::get_option( 'product_tags' ) ? wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'ecomus' ) . ' ', '</span>' ) : ''; ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
