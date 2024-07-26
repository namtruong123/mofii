<head>
    <!-- Other head elements -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Yozi
 * @since Yozi 1.0
 */

$footer = apply_filters( 'yozi_get_footer_layout', 'default' );
$show_footer_desktop_mobile = yozi_get_config('show_footer_desktop_mobile', false);
$show_footer_mobile = yozi_get_config('show_footer_mobile', true);
?>

	</div><!-- .site-content -->

	<footer id="apus-footer" class="apus-footer <?php echo esc_attr(!$show_footer_desktop_mobile ? 'hidden-xs hidden-sm' : ''); ?>" role="contentinfo">
	<div class="footer-inner">
    <?php if ( !empty($footer) ): ?>
        <?php yozi_display_footer_builder($footer); ?>
    <?php else: ?>
        <div class="footer-default">
            <div class="container-fluid">
                <div class="footer-content clearfix">
                    <div class="footer-info pull-left">
                        <p><?php _e('Thông tin liên hệ', 'yozi'); ?></p>
                        <span><?php _e('Địa chỉ: 450 Nguyễn Tri Phương, Phường 4 Quận 10', 'yozi'); ?></span>
                        <br/>
                        <span><?php _e('0989 188 768', 'yozi'); ?></span>
                        <br/>
                        <a href="mailto:info@gmail.com"><?php _e('Email: huypatelectronics@gmail.com', 'yozi'); ?></a>
                        <br/>
                        <a href="https://facebook.com" target="_blank"><i id="icon1" class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com" target="_blank"><i id="icon2" class="fab fa-instagram"></i></a>
                        <br/>
                    </div>
                    <div class="footer-contact pull-left">
                        <p><?php _e('Liên hệ', 'yozi'); ?></p>
                        <span><?php _e('Ms. Trang - Kinh doanh', 'yozi'); ?></span><br/>
						<span class="call1"><i class="fas fa-phone-alt icon1"></i> <?php _e(' 0963 620 629', 'yozi'); ?></span><br/>
						<span><?php _e('Ms. Thúy - Kinh doanh', 'yozi'); ?></span><br/>
						<span class="call2"><i class="fas fa-phone-alt icon2"></i> <?php _e('0975 999 628', 'yozi'); ?></span><br/>
						<span><?php _e('Ms. Chi - Bảo hành', 'yozi'); ?></span><br/>
						<span class="call3"><i class="fas fa-phone-alt icon3"></i><?php _e('(028) 6683 0388', 'yozi'); ?></span><br/>
						<span><?php _e('Mr. Công - Kỹ thuật', 'yozi'); ?></span><br/>
						<span class="call4"><i class="fas fa-phone-alt icon4"></i><?php _e('0934 358 278', 'yozi'); ?></span><br/>
                    </div>
                    <div class="footer-new-branch pull-left">
                        <p><?php _e('Chi nhánh Vh Mall', 'yozi'); ?></p>
                        <span><?php _e('Đường Sư Vạn Hạnh, Quận 10', 'yozi'); ?></span>
<br/>
                        <span><?php _e('Điện thoại: 0906206668', 'yozi'); ?></span>
                        <br/>
                        <a href="mailto:branch@example.com"><?php _e('Email:tien1hp@gmail.com', 'yozi'); ?></a>
                        <br/>
                    </div>
                    <div class="footer-social-map pull-right">
                        <div class="footer-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.766768462743!2d106.6731458142879!3d10.762918992331824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec9808d2c67%3A0xd9a6b1b6dcfb1ae6!2s450+Nguy%E1%BB%85n+Tri+Ph%C6%B0%C6%A1ng%2C+Ph%C6%B0%E1%BB%9Dng+4%2C+Qu%E1%BA%ADn+10%2C+Th%C3%A0nh+ph%E1%BB%91+H%E1%BB%93+Ch%C3%AD+Minh%2C+Vietnam!5e0!3m2!1sen!2sus!4v1620212064958!5m2!1sen!2sus" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
			<div class="footer-copyright text-center">
                    <?php
                        $allowed_html_array = array(
                            'a' => array('href' => array()),
                            'br' => array(),
                            'span' => array(),
                        );
                        echo wp_kses(__('&copy; 2024 - Develop by Kirse x Kami. All Rights Reserved.', 'yozi'), $allowed_html_array);
                    ?>
                </div>
        </div>
    <?php endif; ?>
</div>
</footer><!-- .site-footer -->
	<?php
	if ( yozi_get_config('back_to_top') ) { ?>
		<a href="#" id="back-to-top" class="add-fix-top">
			<i class="fa fa-angle-up" aria-hidden="true"></i>
		</a>
	<?php
	}
	?>
	
	<?php if ( is_active_sidebar( 'popup-newsletter' ) ): ?>
		<?php dynamic_sidebar( 'popup-newsletter' ); ?>
	<?php endif; ?>

	<?php
		if ( $show_footer_mobile ) {
			get_template_part( 'footer-mobile' );
		}
	?>

</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>