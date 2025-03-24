<?php
/**
 * Free Shipping bar
 *
 */

defined( 'ABSPATH' ) || exit;

$message = ! empty( $args['message'] ) ? $args['message'] : '';
$percent = ! empty( $args['percent'] ) ? $args['percent'] : '';
$classes = ! empty( $args['classes'] ) ? $args['classes'] : '';

?>

<div class="ecomus-free-shipping-bar ecomus-free-shipping-bar--preload" style="width: 88.8%; margin: 20px 0px 20px 20px;background-color: #ffffff; border-radius: 14px;border: 2px solid #fa9eda;">
	<div class="ecomus-free-shipping-bar__progress">
		<div class="ecomus-free-shipping-bar__progress-bar">
		</div>
	</div>
	<div class="ecomus-free-shipping-bar__message">
		<?php echo $message; ?>
	</div>
</div>
