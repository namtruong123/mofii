<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;
?>

<!-- header -->
<div class="apus-checkout-header">
    <div class="apus-checkout-step">
        <ul class="clearfix">
            <li>
                <div class="inner">
                <?php printf(__( '<span class="step">%s</span>', 'yozi' ), '01' ); ?>
                <span class="inner-step">
                    <?php echo esc_html__('Giỏ hàng','yozi'); ?>
                </span>
                </div>
            </li>
            <li>
                <div class="inner">
                <?php printf(__( '<span class="step">%s</span>', 'yozi' ), '02' ); ?>
                <span class="inner-step">
                    <?php echo esc_html__('Thanh toán','yozi'); ?>
                </span>
                </div>
            </li>
            <li class="active">
                <div class="inner">
                <?php printf(__( '<span class="step">%s</span>', 'yozi' ), '03' ); ?>
                <span class="inner-step">
                    <?php echo esc_html__('Đơn hàng đã hoàn thành','yozi'); ?>
                </span>
                </div>
            </li>
        </ul>
    </div>
</div>

<?php if ( $order ) : ?>

    <?php if ( $order->has_status( 'failed' ) ) : ?>
        <p class="woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'yozi' ); ?></p>
    <?php else : ?>
        <p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Cảm ơn. Đơn đặt hàng của bạn đã được tiếp nhận.', 'yozi' ), $order ); ?></p>

        <ul class="woocommerce-thankyou-order-details order_details">
            <li class="order">
                <?php esc_html_e( 'Mã đơn hàng:', 'yozi' ); ?>
                <strong><?php echo trim($order->get_order_number()); ?></strong>
            </li>
            <li class="date">
                <?php esc_html_e( 'Ngày đặt:', 'yozi' ); ?>
                <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
            </li>
            <li class="total">
                <?php esc_html_e( 'Tổng cộng:', 'yozi' ); ?>
                <strong><?php echo trim($order->get_formatted_order_total()); ?></strong>
            </li>
            <li class="method">
                <?php esc_html_e( 'Phương thức thanh toán:', 'yozi' ); ?>
                <strong><?php echo trim($order->get_payment_method_title()); ?></strong>
            </li>
        </ul>

    <?php endif; ?>

    <div class="woo-pay-perfect text-theme">
        <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
    </div>

    <!-- Nút nhận hàng tại cửa hàng -->
    <button id="store-pickup-btn" class="button"><?php esc_html_e( 'Nhận hàng tại cửa hàng', 'yozi' ); ?></button>
    
    <!-- Địa chỉ cửa hàng -->
<div id="store-addresses" style="display: none;">
    <div class="row">
        <div class="col">
            <h4><?php esc_html_e( 'Showroom Chính', 'yozi' ); ?></h4>
            <p>450 Nguyễn Tri Phương, Phường 4, Quận 10, Tp.HCM</p>
        </div>
        <div class="col">
            <h4><?php esc_html_e( 'Vạn Hạnh Mall', 'yozi' ); ?></h4>
            <p>11 Sư Vạn Hạnh, Phường 12, Quận 10, Tp.HCM</p>
        </div>
    </div>
</div>

<?php else : ?>

    <p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Cảm ơn. Đơn đặt hàng của bạn đã được tiếp nhận.', 'yozi' ), null ); ?></p>

<?php endif; ?>

<script type="text/javascript">
    document.getElementById('store-pickup-btn').addEventListener('click', function() {
        var storeAddresses = document.getElementById('store-addresses');
        if (storeAddresses.style.display === 'none') {
            storeAddresses.style.display = 'block';
        } else {
            storeAddresses.style.display = 'none';
        }
    });
</script>
