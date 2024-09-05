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
        <?php if (!empty($footer)): ?>
            <?php yozi_display_footer_builder($footer); ?>
        <?php else: ?>
            <div class="footer-default">
                <div class="container-fluid">
                    <div class="footer-content clearfix">
						<div class="footer-info">
							<p class="titlefooter">Thông tin liên hệ</p>
							<hr class="linefooter">
							<div class="showroom">
								<span class="callshowroom"><i class="fas fa-building icon5"></i>Showroom Chính</span><br/>
								<p class="contentfooter">450 Nguyễn Tri Phương, Phường 4, Quận 10, Tp.HCM</p>
							</div><br/>
							<div class="showroom">
								<span class="callshowroom1"><i class="fas fa-building icon5"></i>Vạn Hạnh Mall</span><br>
								<p class="contentfooter">11 Sư Vạn Hạnh, Phường 12, Quận 10, Tp.HCM</p>
							</div>
							<hr class="linefooter1">
						</div>
							<div class="footer-contact pull-left">
								<p class="titlefooter">Liên hệ</p>
								<hr class="linefooter">
								<p class="namekd"><span>Ms. Trang - Kinh doanh</span><br/></p>
								<span class="call1"><i class="fas fa-phone-alt icon1"></i> 0963 620 629</span><br/>
								<p class="namekd"><span>Ms. Thúy - Kinh doanh</span><br/></p>
								<span class="call2"><i class="fas fa-phone-alt icon2"></i> 0975 999 628</span><br/>
								<p class="namekd"><span>Ms. Chi - Bảo hành</span><br/></p>
								<span class="call3"><i class="fas fa-phone-alt icon3"></i>(028) 6683 0388</span><br/>
								<p class="namekd"><span>Mr. Công - Kỹ thuật</span><br/></p>
								<span class="call4"><i class="fas fa-phone-alt icon4"></i>0934 358 278</span><br/>
							</div>
							<div class="footer-new-branch pull-left">
								<p class="titlefooter">Các chính sách</p>
								<hr class="linefooter2">
								<span><a href="<?php echo home_url('/gioi-thieu/');?>"><p class="contentfooter1" style="font-size: 18px;font-weight:400;">Chính sách bảo hành</p></a></span><br/>
								<span><a href="<?php echo home_url('/gioi-thieu/');?>"><p class="contentfooter1" style="font-size: 18px;font-weight:400;">Chính sách giao hàng</p></a></span><br/>
								<span><a href="<?php echo home_url('/gioi-thieu/');?>"><p class="contentfooter1" style="font-size: 18px;font-weight:400;">Giới thiệu</p></a></span>
							</div>
							<div class="footer-social-map pull-right">
								<div class="footer-map">
									<div style="position: relative; width: 130%;padding-right: 120px;">
									  <iframe 
										src="https://www.google.com/maps/d/embed?mid=1Bym1VaYTcaTRhxELHN189dubnHAp43c&ehbc=2E312F&noprof=1" 
										width="auto" 
										height="250" 
										style="border:0;" 
										allowfullscreen="" 
										loading="lazy" 
										referrerpolicy="no-referrer-when-downgrade">
									  </iframe>
									  <div style="position: absolute; top: 0; left: 0; width: 100%; height: 50px; background-color:#333"></div>
									</div>
                                
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
            </div>
        <?php endif; ?>
    </div>
</footer>
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