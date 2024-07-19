<header id="apus-header" class="apus-header header-v5 hidden-sm hidden-xs" role="banner">
            <div id="apus-topbar" class="apus-topbar apus-topbar-v5 clearfix">
                <div class="container">
                    <?php if ( is_active_sidebar( 'sidebar-topbar-left' ) ) { ?>
                        <div class="pull-left">
                            <div class="topbar-left">
                                <?php dynamic_sidebar( 'sidebar-topbar-left' ); ?>
                            </div>
                        </div>
                    <?php } ?> 
                    <div class="pull-right">
                        <div class="topbar-right">
                            <?php if( !is_user_logged_in() ){ ?>
                                <div class="login-topbar pull-right">
                                    <a class="login" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_html_e('Sign in','yozi'); ?>"><?php esc_html_e('Login /', 'yozi'); ?></a>
                                    <a class="register" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_html_e('Register','yozi'); ?>"><?php esc_html_e('Register', 'yozi'); ?></a>
                                </div>
                            <?php } else { ?>
                                <?php if ( has_nav_menu( 'top-menu' ) ): ?>
                                    <div class="wrapper-topmenu pull-right">
                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0">
                                                <?php esc_html_e( 'My Account', 'yozi' ); ?><span class="caret"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <?php
                                                    $args = array(
                                                        'theme_location' => 'top-menu',
                                                        'container_class' => 'collapse navbar-collapse',
                                                        'menu_class' => 'nav navbar-nav topmenu-menu',
                                                        'fallback_cb' => '',
                                                        'menu_id' => 'topmenu-menu',
                                                        'walker' => new Yozi_Nav_Menu()
                                                    );
                                                    wp_nav_menu($args);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php } ?>
                            <?php if ( is_active_sidebar( 'sidebar-topbar-right' ) ) { ?>
                            <div class="topbar-right-inner">
                                <?php dynamic_sidebar( 'sidebar-topbar-right' ); ?>
                            </div>
                            <?php } ?> 
                        </div>
                    </div>
                     
                </div>  
            </div>
        <div class="clearfix">
            <div class="<?php echo (yozi_get_config('keep_header') ? 'main-sticky-header-wrapper' : ''); ?>">
                <div class="<?php echo (yozi_get_config('keep_header') ? 'main-sticky-header' : ''); ?>">
                    <div class="container">
                    <div class="header-middle p-relative">
                        <div class="row">
                            <div class="table-visiable-dk">
                                <div class="col-md-2">
                                    <div class="logo-in-theme">
                                        <?php get_template_part( 'template-parts/logo/logo-yellow' ); ?>
                                    </div>
                                </div>
                                <?php if ( has_nav_menu( 'primary' ) ) : ?>
                                <div class="col-md-4 p-static">
                                    <div class="main-menu">
                                        <nav data-duration="400" class="hidden-xs hidden-sm apus-megamenu slide animate navbar p-static" role="navigation">
                                        <?php   $args = array(
                                                'theme_location' => 'primary',
                                                'container_class' => 'collapse navbar-collapse no-padding',
                                                'menu_class' => 'nav navbar-nav megamenu',
                                                'fallback_cb' => '',
                                                'menu_id' => 'primary-menu',
                                                'walker' => new Yozi_Nav_Menu()
                                            );
                                            wp_nav_menu($args);
                                        ?>
                                        </nav>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="wpb_column vc_column_container vc_col-sm-4"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="vc_wp_search"><div class="widget widget_search"><div class="asl_w_container asl_w_container_1">
	<div id="ajaxsearchlite1" data-id="1" data-instance="1" class="asl_w asl_m asl_m_1 asl_m_1_1">
		<div class="probox">

	
	<div class="prosettings" data-opened="0">
				<div class="innericon">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22" height="22" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
					<polygon transform="rotate(90 256 256)" points="142.332,104.886 197.48,50 402.5,256 197.48,462 142.332,407.113 292.727,256 "></polygon>
				</svg>
		</div>
	</div>

	
	
	<div class="proinput">
        <form role="search" action="#" autocomplete="off" aria-label="Search form">
			<input aria-label="Search input" type="search" class="orig" tabindex="0" name="phrase" placeholder="Search here.." value="" autocomplete="off">
			<input aria-label="Search autocomplete" type="text" class="autocomplete" tabindex="-1" name="phrase" value="" autocomplete="off" disabled="">
			<input type="submit" value="Start search" style="width:0; height: 0; visibility: hidden;">
		</form>
	</div>

	
	
	<button class="promagnifier" tabindex="0" aria-label="Search magnifier">
				<span class="innericon" style="display:block;">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22" height="22" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
					<path d="M460.355,421.59L353.844,315.078c20.041-27.553,31.885-61.437,31.885-98.037
						C385.729,124.934,310.793,50,218.686,50C126.58,50,51.645,124.934,51.645,217.041c0,92.106,74.936,167.041,167.041,167.041
						c34.912,0,67.352-10.773,94.184-29.158L419.945,462L460.355,421.59z M100.631,217.041c0-65.096,52.959-118.056,118.055-118.056
						c65.098,0,118.057,52.959,118.057,118.056c0,65.096-52.959,118.056-118.057,118.056C153.59,335.097,100.631,282.137,100.631,217.041
						z"></path>
				</svg>
		</span>
	</button>

	
	
	<div class="proloading">

		<div class="asl_loader"><div class="asl_loader-inner asl_simple-circle"></div></div>

			</div>

			<div class="proclose" style="display: none;">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="12" height="12" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
				<polygon points="438.393,374.595 319.757,255.977 438.378,137.348 374.595,73.607 255.995,192.225 137.375,73.622 73.607,137.352 192.246,255.983 73.622,374.625 137.352,438.393 256.002,319.734 374.652,438.378 "></polygon>
			</svg>
		</div>
	
	
</div>	</div>
	<div class="asl_data_container" style="display:none !important;">
		<div class="asl_init_data wpdreams_asl_data_ct" style="display:none !important;" id="asl_init_id_1" data-asl-id="1" data-asl-instance="1" data-asldata="ew0KCSJob21ldXJsIjogImh0dHA6Ly9sb2NhbGhvc3QvbW9maWkvIiwNCgkicmVzdWx0c3R5cGUiOiAidmVydGljYWwiLA0KCSJyZXN1bHRzcG9zaXRpb24iOiAiaG92ZXIiLA0KCSJpdGVtc2NvdW50IjogNCwNCgkiY2hhcmNvdW50IjogIDAsDQoJImhpZ2hsaWdodCI6IDAsDQoJImhpZ2hsaWdodHdob2xld29yZHMiOiAxLA0KCSJzaW5nbGVIaWdobGlnaHQiOiAwLA0KCSJzY3JvbGxUb1Jlc3VsdHMiOiB7DQoJCSJlbmFibGVkIjogMCwNCgkJIm9mZnNldCI6IDANCgl9LA0KCSJyZXN1bHRhcmVhY2xpY2thYmxlIjogMSwNCgkiYXV0b2NvbXBsZXRlIjogew0KCQkiZW5hYmxlZCIgOiAxLA0KCQkibGFuZyIgOiAiZW4iLA0KCQkidHJpZ2dlcl9jaGFyY291bnQiIDogMA0KCX0sDQoJIm1vYmlsZSI6IHsNCgkJIm1lbnVfc2VsZWN0b3IiOiAiI21lbnUtdG9nZ2xlIg0KCX0sDQoJInRyaWdnZXIiOiB7DQoJCSJjbGljayI6ICJyZXN1bHRzX3BhZ2UiLA0KCQkiY2xpY2tfbG9jYXRpb24iOiAic2FtZSIsDQoJCSJ1cGRhdGVfaHJlZiI6IDAsDQoJCSJyZXR1cm4iOiAicmVzdWx0c19wYWdlIiwNCgkJInJldHVybl9sb2NhdGlvbiI6ICJzYW1lIiwNCgkJImZhY2V0IjogMSwNCgkJInR5cGUiOiAxLA0KCQkicmVkaXJlY3RfdXJsIjogIj9zPXtwaHJhc2V9IiwNCgkJImRlbGF5IjogMzAwDQoJfSwNCiAgICAiYW5pbWF0aW9ucyI6IHsNCiAgICAgICAgInBjIjogew0KICAgICAgICAgICAgInNldHRpbmdzIjogew0KICAgICAgICAgICAgICAgICJhbmltIiA6ICJmYWRlZHJvcCIsDQogICAgICAgICAgICAgICAgImR1ciIgIDogMzAwDQogICAgICAgICAgICB9LA0KICAgICAgICAgICAgInJlc3VsdHMiIDogew0KCQkJCSJhbmltIiA6ICJmYWRlZHJvcCIsDQoJCQkJImR1ciIgIDogMzAwDQogICAgICAgICAgICB9LA0KICAgICAgICAgICAgIml0ZW1zIiA6ICJ2b2lkYW5pbSINCiAgICAgICAgfSwNCiAgICAgICAgIm1vYiI6IHsNCiAgICAgICAgICAgICJzZXR0aW5ncyI6IHsNCiAgICAgICAgICAgICAgICAiYW5pbSIgOiAiZmFkZWRyb3AiLA0KICAgICAgICAgICAgICAgICJkdXIiICA6IDMwMA0KICAgICAgICAgICAgfSwNCiAgICAgICAgICAgICJyZXN1bHRzIiA6IHsNCgkJCQkiYW5pbSIgOiAiZmFkZWRyb3AiLA0KCQkJCSJkdXIiICA6IDMwMA0KICAgICAgICAgICAgfSwNCiAgICAgICAgICAgICJpdGVtcyIgOiAidm9pZGFuaW0iDQogICAgICAgIH0NCiAgICB9LA0KCSJhdXRvcCI6IHsNCgkJInN0YXRlIjogImRpc2FibGVkIiwNCgkJInBocmFzZSI6ICIiLA0KCQkiY291bnQiOiAxCX0sDQogICAgInJlc1BhZ2UiOiB7DQogICAgICAgICJ1c2VBamF4IjogMCwNCiAgICAgICAgInNlbGVjdG9yIjogIiNtYWluIiwNCiAgICAgICAgInRyaWdnZXJfdHlwZSI6IDEsDQogICAgICAgICJ0cmlnZ2VyX2ZhY2V0IjogMSwNCiAgICAgICAgInRyaWdnZXJfbWFnbmlmaWVyIjogMCwNCiAgICAgICAgInRyaWdnZXJfcmV0dXJuIjogMCAgICB9LA0KCSJyZXN1bHRzU25hcFRvIjogImxlZnQiLA0KICAgICJyZXN1bHRzIjogew0KICAgICAgICAid2lkdGgiOiAiYXV0byIsDQogICAgICAgICJ3aWR0aF90YWJsZXQiOiAiYXV0byIsDQogICAgICAgICJ3aWR0aF9waG9uZSI6ICJhdXRvIg0KICAgIH0sDQoJInNldHRpbmdzaW1hZ2Vwb3MiOiAicmlnaHQiLA0KCSJjbG9zZU9uRG9jQ2xpY2siOiAxLA0KCSJvdmVycmlkZXdwZGVmYXVsdCI6IDEsDQoJIm92ZXJyaWRlX21ldGhvZCI6ICJnZXQiDQp9DQo="></div>	<div id="asl_hidden_data">
		<svg style="position:absolute" height="0" width="0">
			<filter id="aslblur">
				<feGaussianBlur in="SourceGraphic" stdDeviation="4"></feGaussianBlur>
			</filter>
		</svg>
		<svg style="position:absolute" height="0" width="0">
			<filter id="no_aslblur"></filter>
		</svg>
	</div>
	</div>

	<div id="ajaxsearchliteres1" class="vertical wpdreams_asl_results asl_w asl_r asl_r_1 asl_r_1_1">

	
	<div class="results">

		
		<div class="resdrg">
		</div>

		
	</div>

	
	
</div>

	<div id="__original__ajaxsearchlitesettings1" data-id="1" class="searchsettings wpdreams_asl_settings asl_w asl_s asl_s_1" style="position: absolute;">
		<form name="options" aria-label="Search settings form" autocomplete="off">

	
	
	<input type="hidden" name="filters_changed" style="display:none;" value="0">
	<input type="hidden" name="filters_initial" style="display:none;" value="1">

	<div class="asl_option_inner hiddend">
		<input type="hidden" name="qtranslate_lang" id="qtranslate_lang1" value="0">
	</div>

	
	
	<fieldset class="asl_sett_scroll">
		<legend style="display: none;">Generic selectors</legend>
		<div class="asl_option" tabindex="0">
			<div class="asl_option_inner">
				<input type="checkbox" value="exact" aria-label="Exact matches only" name="asl_gen[]">
				<div class="asl_option_checkbox"></div>
			</div>
			<div class="asl_option_label">
				Exact matches only			</div>
		</div>
		<div class="asl_option" tabindex="0">
			<div class="asl_option_inner">
				<input type="checkbox" value="title" aria-label="Search in title" name="asl_gen[]" checked="checked">
				<div class="asl_option_checkbox"></div>
			</div>
			<div class="asl_option_label">
				Search in title			</div>
		</div>
		<div class="asl_option" tabindex="0">
			<div class="asl_option_inner">
				<input type="checkbox" value="content" aria-label="Search in content" name="asl_gen[]" checked="checked">
				<div class="asl_option_checkbox"></div>
			</div>
			<div class="asl_option_label">
				Search in content			</div>
		</div>
		<div class="asl_option_inner hiddend">
			<input type="checkbox" value="excerpt" aria-label="Search in excerpt" name="asl_gen[]" checked="checked">
			<div class="asl_option_checkbox"></div>
		</div>
	</fieldset>
	<fieldset class="asl_sett_scroll">
		<legend style="display: none;">Post Type Selectors</legend>
					<div class="asl_option" tabindex="0">
				<div class="asl_option_inner">
					<input type="checkbox" value="product" aria-label="product" name="customset[]" checked="checked">
					<div class="asl_option_checkbox"></div>
				</div>
				<div class="asl_option_label">
					product				</div>
			</div>
						<div class="asl_option" tabindex="0">
				<div class="asl_option_inner">
					<input type="checkbox" value="product_variation" aria-label="product_variation" name="customset[]">
					<div class="asl_option_checkbox"></div>
				</div>
				<div class="asl_option_label">
					product_variation				</div>
			</div>
				</fieldset>
	
		<fieldset>
							<legend>Filter by Categories</legend>
						<div class="categoryfilter asl_sett_scroll">
									<div class="asl_option hiddend" tabindex="0">
						<div class="asl_option_inner">
							<input type="checkbox" value="1" aria-label="Uncategorized" name="categoryset[]" checked="checked">
							<div class="asl_option_checkbox"></div>
						</div>
						<div class="asl_option_label">
							Uncategorized						</div>
					</div>
					
			</div>
		</fieldset>
		</form>
	</div>
</div></div></div></div></div></div>
                                <div class="col-md-2">
                                <div class="header-right pull-right">
                                        <?php if ( defined('YOZI_WOOCOMMERCE_ACTIVED') && yozi_get_config('show_cartbtn') && !yozi_get_config( 'enable_shop_catalog' ) ): ?>
                                            <div class="pull-right">
                                                <?php get_template_part( 'woocommerce/cart/mini-cart-button-header-left' ); ?>
                                            </div>
                                        <?php endif; ?>
                                        <!-- Wishlist -->
                                        <?php if ( class_exists( 'YITH_WCWL' ) ){
                                            $wishlist_url = YITH_WCWL()->get_wishlist_url();
                                        ?>
                                            <div class="pull-right">
                                                <a class="wishlist-icon" href="<?php echo esc_url($wishlist_url);?>" title="<?php esc_html_e( 'View Your Wishlist', 'yozi' ); ?>"><i class="ti-heart"></i>
                                                    <?php if ( function_exists('yith_wcwl_count_products') ) { ?>
                                                        <span class="count"><?php echo yith_wcwl_count_products(); ?></span>
                                                    <?php } ?>
                                                </a>
                                            </div>
                                        <?php } elseif( yozi_is_woosw_activated() ) {
                                            $woosw_page_id = WPCleverWoosw::get_page_id();
                                        ?>
                                            <div class="pull-right">
                                                <a class="wishlist-icon" href="<?php echo esc_url(get_permalink($woosw_page_id));?>">
                                                    <i class="ti-heart"></i>
                                                    <span class="count woosw-custom-menu-item">0</span>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>   
                        </div> 
                    </div>
                    </div>
                </div>
            </div>
        </div>
</header>