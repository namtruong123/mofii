(function ($) {
    'use strict';

	function productsCarousel( $selector ) {
		$selector.addClass('swiper');
		$selector.find('ul.products').addClass('swiper-wrapper');
		$selector.find('ul.products').after('<span class="ecomus-svg-icon em-button-light ecomus-swiper-button swiper-button swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 11L0 5.5L5.5 0L6.47625 0.97625L1.9525 5.5L6.47625 10.0238L5.5 11Z" fill="currentColor"/></svg></span>');
		$selector.find('ul.products').after('<span class="ecomus-svg-icon em-button-light ecomus-swiper-button swiper-button swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 11L7 5.5L1.5 0L0.52375 0.97625L5.0475 5.5L0.52375 10.0238L1.5 11Z" fill="currentColor"/></svg></span>');
		$selector.find('li.product').addClass('swiper-slide');

		var $productThumbnail = $selector.find('.product-thumbnail');

		var	options = {
				loop: false,
				autoplay: false,
				speed: 800,
				watchOverflow: true,
				navigation: {
					nextEl: $selector.find('.swiper-button-next:not(.ecomus-product-card-swiper-button)').get(0),
					prevEl: $selector.find('.swiper-button-prev:not(.ecomus-product-card-swiper-button)').get(0),
				},
				on: {
					resize: function () {
						var self = this;

						if( $productThumbnail.length > 0 ) {
							$productThumbnail.imagesLoaded(function () {
								var	heightThumbnails = $productThumbnail.outerHeight(),
									top = ( heightThumbnails / 2 ) + 'px';

								$(self.navigation.$nextEl).css({'--em-arrow-top': top});
								$(self.navigation.$prevEl).css({'--em-arrow-top': top});
							});
						}
					}
				},
				breakpoints: {
					0: {
						slidesPerView: 2,
						spaceBetween: 10,
					},
					767: {
						slidesPerView: $selector.data('columns'),
						spaceBetween: 20,
					},

				}
			};

		new Swiper($selector.get(0), options);
	}

	function headerCategoryMenu() {
		var $menu = $('.header-category-menu');

		if ( ! $menu.find('.header-category__content .mega-menu-container').hasClass('full-width') ) {
			 return;
		}

		$(window).on('resize', function () {
			var contentWidth = $menu.find('.header-category__content').outerWidth(),
			headerWidth = $menu.closest('.site-header__container').width(),
			containerWidth = headerWidth - contentWidth;

			$menu.find('.mega-menu-container').css('width', containerWidth + 'px')
		}).trigger('resize');
	}

	/**
     * Document ready
     */
    $(function () {
		$( '.menu-item--widget-products-carousel' ).each( function() {
			if( ! $('.menu-item--widget-products-carousel').length ) {
				return;
			}

			productsCarousel($(this).find('.mega-menu-products-carousel'));

		} );

		headerCategoryMenu();
    });
})(jQuery);