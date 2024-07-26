<!-- <nav id="navbar-offcanvas" class="navbar hidden-lg hidden-md" role="navigation"> -->
<div id="navbar-offcanvas" class="header-mobile-menu d-lg-none">

<a href="javascript:void(0)" class="mobile-menu-close">
    <span></span>
    <span></span>
</a>

<div class="site-main-nav">
    <nav class="site-nav">
        <ul class="navbar-mobile-wrapper">
            <li><a href="<?php echo home_url('/home-1'); ?>">Trang chủ</a></li>
            <li><a href="<?php echo home_url('/shop-2'); ?>">Sản phẩm</a>
            <li>
                <a href="<?php echo home_url('/shop-2'); ?>">Sản phẩm <span class="new blinking">Mới</span></a>
                <ul class="mega-sub-menu">
                    <li class="mega-dropdown">
                        <a class="mega-title" href="<?php echo home_url('/shop-2'); ?>">Danh mục</a>
                        <ul class="mega-item">  
                                <li><a href="<?php echo home_url('/product-category/ban-phim/'); ?>">Bàn phím</a></li>
								<li><a href="<?php echo home_url('/product-category/ban-phim-so/'); ?>">Bàn phím số</a></li>
								<li><a href="<?php echo home_url('/product-category/chuot/'); ?>">Chuột</a></li>
								<li><a href="<?php echo home_url('/product-category/lot-chuot/'); ?>">Lót chuột</a></li>
                        </ul>
                    </li>
                    <li class="mega-dropdown">
                        <a class="mega-title" href="<?php echo home_url('/shop-2'); ?>">Nhu cầu</a>
                        <ul class="mega-item">
                                <li><a href="<?php echo home_url('/product-category/mofii/'); ?>">Gaming</a></li>
								<li><a href="<?php echo home_url('/product-category/geezer/'); ?>">Văn phòng</a></li>
								<li><a href="<?php echo home_url('/product-category//'); ?>">Không dây</a></li>
								<li><a href="<?php echo home_url('/product-category//'); ?>">Có dây</a></li>
								<li><a href="<?php echo home_url('/product-category//'); ?>">Bluetooth</a></li>
                        </ul>
                    </li>
                    <li class="mega-dropdown">
                        <a class="mega-title" href="#">Danh mục khác</a>

                        <ul class="mega-item">
                            <li><a href="{{ URL::to('/store?show=all&sort_by=new') }}">Sản phẩm mới</a>
                            </li>
                            <li><a href="{{ URL::to('/store?show=all&sort_by=bestsellers') }}">Sản phẩm
                                    bán chạy</a></li>
                            <li><a href="{{ URL::to('/store?show=all&sort_by=featured') }}">Sản phẩm nổi
                                    bật</a></li>
                            <li><a href="{{ URL::to('/store?show=all&sort_by=sale') }}">Sản phẩm đang
                                    SALE</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="{{ URL::to('/blog') }}">Tin tức</a></li>
            <li><a href="{{ URL::to('/about-us') }}">Về chúng tôi</a></li>
            <li><a href="{{ URL::to('/contact') }}">Liên hệ</a></li>
        </ul>
    </nav>
</div>