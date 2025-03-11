<?php
/**
 * The Template for displaying all single products
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'ecomus_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
global $post;

?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		/**
		 * Hook for product builder.
		 * ecomus_before_woocommerce_product_content
		 */
		do_action( 'ecomus_before_woocommerce_product_content', $post );

		/**
		 * Hook for product builder.
		 * ecomus_woocommerce_product_content
		 */
		do_action( 'ecomus_woocommerce_product_content', $post );

		/**
		 * Hook for product builder.
		 * ecomus_after_woocommerce_product_content
		 */
		do_action( 'ecomus_after_woocommerce_product_content', $post );
	?>
</div><!-- #product-<?php //the_ID(); ?> -->

<?php do_action( 'ecomus_after_single_product' ); ?>