<?php
/**
 * Sales botter popup
 *
 */

defined( 'ABSPATH' ) || exit;

$product = $args['product'];

if( empty( $product ) ) {
	return;
}

?>

<div class="live-sales-notification animated">
	<div class="live-sales-notification__content">
		<a class="live-sales-notification__thumbnail" href="<?php echo esc_url( $product['product_link'] ); ?>">
			<?php echo $product['product_thumb']; ?>
		</a>
		<div class="live-sales-notification__summary">
			<div class="live-sales-notification__name">
				<span><?php echo $product['first_name']; ?> <?php esc_html_e( 'purchased', 'ecomus-addons' ); ?></span>
				<a class="sales-booter-popup__product" href="<?php echo esc_url( $product['product_link'] ); ?>"><?php echo $product['product_name']; ?></a>
			</div>
			<div class="live-sales-notification__bottom">
				<span class="live-sales-notification__time-passed"><?php echo $product['time_passed']; ?> <?php echo $product['time_passed_type']; ?> <?php esc_html_e( 'ago', 'ecomus-addons' ); ?></span>
			</div>
		</div>
	</div>
	<span class="live-sales-notification__close live-sales-notification__icon">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
	</span>
</div>