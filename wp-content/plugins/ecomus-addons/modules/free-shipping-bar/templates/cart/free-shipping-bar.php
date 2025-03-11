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

<div class="ecomus-free-shipping-bar ecomus-free-shipping-bar--preload<?php echo esc_attr( $classes );?>" style="--em-progress:<?php echo esc_attr( $percent ); ?>">
	<div class="ecomus-free-shipping-bar__progress">
		<div class="ecomus-free-shipping-bar__progress-bar">
			<div class="ecomus-free-shipping-bar__icon"><?php echo \Ecomus\Addons\Helper::get_svg( 'delivery' ) ?></div>
		</div>
	</div>
	<div class="ecomus-free-shipping-bar__percent-value"><?php echo $percent; ?></div>
	<div class="ecomus-free-shipping-bar__message">
		<?php echo $message; ?>
	</div>
</div>