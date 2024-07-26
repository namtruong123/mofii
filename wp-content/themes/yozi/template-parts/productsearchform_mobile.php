<?php if ( yozi_get_config('show_searchform') ):
	$class = yozi_get_config('enable_autocompleate_search', true) ? ' apus-autocompleate-input' : '';
?>
	<div class="apus-search-form">
	<div class="clearfix search-mobile">
            <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
            </div>
	</div>
<?php endif; ?>