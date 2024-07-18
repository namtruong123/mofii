<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $woocommerce_loop;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$classes = array();
$woo_display = yozi_woocommerce_get_display_mode();
if ( $woo_display == 'list' ) { 	
	$classes[] = 'list-products col-xs-12';
	$product_list_version = yozi_get_config('product_list_version', 'list');
?>
	<div <?php wc_product_class( $classes, $product ); ?>>
	 	<?php wc_get_template_part( 'item-product/inner', $product_list_version ); ?>
	</div>
<?php
} else {
	$product_grid_version = yozi_get_config('product_grid_version', 'v1');
	if( empty($product_grid_version) || ($product_grid_version == 'v1')){
		$product_grid_version = 'inner';
	}else{
		$product_grid_version = 'inner-'.$product_grid_version;
	}
	// Store loop count we're currently on
	if ( empty( $woocommerce_loop['loop'] ) ) {
		$woocommerce_loop['loop'] = 0;
	}
	// Store column count for displaying the grid
	if ( empty( $woocommerce_loop['columns'] ) ) {
		$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	}

	// Ensure visibility
	if ( ! $product || ! $product->is_visible() ) {
		return;
	}

	$columns = 12/$woocommerce_loop['columns'];
	if($woocommerce_loop['columns'] == 5){
		$columns = 'cl-5 col-md-3';
	}
	if($woocommerce_loop['columns'] >=4 ){
		$classes[] = 'col-md-'.$columns.' col-sm-4 col-xs-6 ';
	}else{
		$classes[] = 'col-md-'.$columns.' col-sm-6 col-xs-6 ';
	}
	?>
	<div <?php wc_product_class( $classes, $product ); ?>>
		<?php wc_get_template_part( 'item-product/'.$product_grid_version ); ?>
	</div>
<?php } ?>