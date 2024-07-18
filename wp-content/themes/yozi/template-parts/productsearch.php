<!-- <div class="apus-search-nocategory">
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<input type="hidden" name="post_type" value="product" class="post_type" />
		<div class="input-group"> 
			<input type="text" placeholder="<?php echo esc_attr(esc_html__( 'Search by Model', 'yozi' )); ?>" name="s" class="form-control"/>
			<span class="input-group-btn"> 
				<button type="submit" class="btn"><span class="ti-search"></span></button>
			</span> 
		</div>
	</form>
</div> -->

<?php if ( yozi_get_config('show_searchform') ):
	$class = yozi_get_config('enable_autocompleate_search', true) ? ' apus-autocompleate-input' : '';
?>
	<div class="apus-search-form">
		<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			<!-- <?php 
				$args = array(
				    'show_count' => 0,
				    'hierarchical' => true,
				    'show_uncategorized' => 0,
				    'selected' => false
				);
				echo '<div class="select-category">';
					wc_product_dropdown_categories( $args );
				echo '</div>';
			?> -->
			<div class="main-search">
				<?php if ( yozi_get_config('enable_autocompleate_search', true) ) echo '<div class="twitter-typeahead">'; ?>
			  		<input type="text" placeholder="<?php echo esc_attr(esc_html__( 'Bạn muốn tìm sản phẩm gì?', 'yozi' )); ?>" name="s" class="apus-search form-control <?php echo esc_attr($class); ?>"/>
				<?php if ( yozi_get_config('enable_autocompleate_search', true) ) echo '</div>'; ?>
			</div>
			<input type="hidden" name="post_type" value="product" class="post_type" />
			
			<button type="submit" class="btn btn-theme radius-0"><?php esc_html_e('SEARCH', 'yozi'); ?></button>
		</form>
	</div>
<?php endif; ?>