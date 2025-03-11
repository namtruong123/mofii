class EcomusProductImagesWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				productGallery: '.woocommerce-product-gallery',
				parentGallery: '.product-gallery-summary'
			}
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings('selectors');
		return {
		  $productGallery: this.$element.find(selectors.productGallery),
		  $parentGallery: this.$element.find(selectors.parentGallery)
		};
	}

	productGallery( vertical, $selector = this.elements.$productGallery ) {
		if (typeof Swiper === 'undefined') {
			return;
		}

		const settings = this.getElementSettings();
		var $window = jQuery( window ),
			$body = jQuery( document.body );
		var slider = null;
		var thumbs = null;

		function initSwiper( $el, options ) {
			if( $el.length < 1 ) {
				return;
			}

			return new Swiper( $el.get(0), options );
		}

		function enableSwiper( el ) {
			el.enable();
		}

		function disableSwiper( el ) {
			el.disable();
		}

		function galleryOptions( $el ) {
			var options = {
				loop: false,
				autoplay: false,
				speed: 800,
				spaceBetween: 30,
				watchOverflow: true,
				autoHeight: true,
				navigation: {
					nextEl: $el.find('.swiper-button-next').get(0),
					prevEl: $el.find('.swiper-button-prev').get(0),
				},
				on: {
					init: function () {
						setTimeout(function () {
							$el.css('opacity', 1);
						}, 100 );

						$body.trigger( 'ecomus_product_gallery_init' );
					},
					slideChange: function () {
						if( this.slides[this.realIndex].getAttribute( 'data-zoom_status' ) == 'false' ) {
							this.$el.parent().addClass( 'swiper-item-current-extra' );
						} else {
							if( this.$el.parent().hasClass( 'swiper-item-current-extra' ) ) {
								this.$el.parent().removeClass( 'swiper-item-current-extra' );
							}
						}
					},
					slideChangeTransitionEnd: function () {
						$body.trigger( 'ecomus_product_gallery_slideChangeTransitionEnd' );
					}
				}
			};

			if( thumbs ) {
				options.thumbs = {
					swiper: thumbs,
				};
			}

			return options;
		}

		function initGallery() {
			var $gallery = $selector.find('.woocommerce-product-gallery__wrapper'),
				$selectorParent = $selector.closest( '.ecomus-product-gallery' ),
				arrows_type = $selectorParent.data( 'arrows_type' ),
				$icon_prev = '<svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 11L0 5.5L5.5 0L6.47625 0.97625L1.9525 5.5L6.47625 10.0238L5.5 11Z" fill="currentColor"/></svg>',
				$icon_next = '<svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 11L7 5.5L1.5 0L0.52375 0.97625L5.0475 5.5L0.52375 10.0238L1.5 11Z" fill="currentColor"/></svg>';

			if( $selectorParent.data( 'prev_icon' ) ) {
				$icon_prev = $selectorParent.data( 'prev_icon' );
			}

			if( $selectorParent.data( 'next_icon' ) ) {
				$icon_next = $selectorParent.data( 'next_icon' );
			}

			$gallery.addClass('woocommerce-product-gallery__slider swiper');
			$gallery.wrapInner('<div class="swiper-wrapper"></div>');
			$gallery.find('.swiper-wrapper').after('<span class="ecomus-svg-icon swiper-button-' + arrows_type + ' ecomus-swiper-button swiper-button swiper-button-prev elementor-swiper-button-prev">' + $icon_prev + '</span>');
			$gallery.find('.swiper-wrapper').after('<span class="ecomus-svg-icon swiper-button-' + arrows_type + ' ecomus-swiper-button swiper-button swiper-button-next elementor-swiper-button-next">' + $icon_next + '</span>');
			$gallery.find('.woocommerce-product-gallery__image').addClass('swiper-slide');

			return initSwiper( $gallery, galleryOptions( $gallery ) );
		}

		function thumbnailsOptions( $el ) {
			var options = {
				spaceBetween: 10,
				watchOverflow: true,
				watchSlidesProgress: true,
				autoHeight: true,
				on: {
					beforeInit: function () {
						var $index = 1;
						$el.find('.swiper-slide').each( function () {
							jQuery(this).parent().find('.swiper-slide:nth-child(' + $index + ')').css('--animation-delay', ( ( $index * 3 ) / 10 ) + 's' );
							$index++;
						});
					},
					init: function () {
						setTimeout(function () {
							$el.css('opacity', 1);
						}, 100 );

						$body.trigger( 'ecomus_product_thumbnails_init' );
					},
				},
			};

			if (vertical) {
				options.breakpoints = {
									0: {
										direction: 'horizontal',
										slidesPerView: 5,
									},
									1200: {
										direction: 'vertical',
										slidesPerView: "auto",
									}
								};
			} else {
				options.direction = 'horizontal';
				options.slidesPerView = 5;
			}

			return options;
		}

		function initThumbnails() {
			var $thumbnails = $selector.find( '.ecomus-product-gallery-thumbnails' );

			$thumbnails.addClass('swiper');
			$thumbnails.wrapInner('<div class="woocommerce-product-thumbnail__nav swiper-wrapper"></div>');
			$thumbnails.find('.woocommerce-product-gallery__image').addClass('swiper-slide');

			return initSwiper( $thumbnails, thumbnailsOptions( $thumbnails ) );
		}

		function responsiveGallery() {
			if ( $window.width() < 1200 ) {
				enableSwiper( thumbs );
				enableSwiper( slider );
			} else {
				disableSwiper( thumbs );
				disableSwiper( slider );
			}
		}

		function product_gallery_is_slider() {
			if( settings.thumbnails_layout &&  jQuery.inArray( settings.thumbnails_layout, [ 'grid-1', 'grid-2', 'stacked' ] ) !== -1 ) {
				return false;
			}

			return true;
		}

		function init() {
			$selector.imagesLoaded(function () {
				var $thumbnails = $selector.find( '.ecomus-product-gallery-thumbnails' );
					$thumbnails.appendTo( $selector );

				thumbs = initThumbnails();
				slider = initGallery();

				if ( ! product_gallery_is_slider() ) {
					$selector.addClass( 'woocommerce-product-gallery--reponsive' );

					responsiveGallery();
					$window.on( 'resize', function () {
						responsiveGallery();
					});
				}
			});
		}

		init();
	}

	productImageZoom () {
		if (typeof Drift === 'undefined') {
			return;
		}

		const settings = this.getElementSettings();
		var $selector = jQuery('.ecomus-product-gallery');

		if( ! $selector ) {
			return;
		}

		if( settings.product_image_zoom == 'none' ) {
			return
		}

		var $summary   = $selector.closest( '.e-con-full' ).siblings(),
		    $gallery   = $selector.find('.woocommerce-product-gallery__wrapper');

		if( settings.product_image_zoom == 'bounding' ) {
			var $zoom = jQuery( '<div class="ecomus-product-zoom-wrapper" />' );
			$summary.prepend( $zoom );
		}

		var options = {
			containInline: true,
		};

		if( settings.product_image_zoom == 'bounding' ) {
			options.paneContainer = $zoom.get(0);
			options.hoverBoundingBox = true;
			options.zoomFactor = 2;
		}

		if( settings.product_image_zoom == 'inner' ) {
			options.zoomFactor = 3;
		}

		if( settings.product_image_zoom == 'magnifier' ) {
			options.zoomFactor = 2;
			options.inlinePane = true;
		}

		$gallery.find( '.woocommerce-product-gallery__image' ).each( function() {
			var $this = jQuery(this),
				$image = $this.find( 'img' ),
				imageUrl = $this.find( 'a' ).attr('href');

			if( $this.hasClass('ecomus-product-video') || $this.data( 'zoom_status' ) == false ) {
				return;
			}

			if( settings.product_image_zoom == 'inner' ) {
				options.paneContainer = $this.get(0);
			}

			$image.attr( 'data-zoom', imageUrl );

			new Drift( $image.get(0), options );
		});

		jQuery('.single-product div.product .product-gallery-summary .variations_form').on( 'show_variation hide_variation', function () {
			var $selector = jQuery(this).closest( '.product-gallery-summary' ),
				$gallery = $selector.find( '.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image' ).eq(0),
				imageUrl = $gallery.find( 'a' ).attr( 'href' ),
				$image = $gallery.find( 'img' );

			$image.attr( 'data-zoom', imageUrl );
		});

		jQuery( window ).on( 'resize', function () {
			if( jQuery( window ).width() < 1200 ) {
				if( ! jQuery( '.single-product div.product .woocommerce-product-gallery' ).hasClass( 'woocommerce-product-gallery--has-zoom' ) ) {
					return;
				}

				var touch = false;

				jQuery( '.woocommerce-product-gallery--has-zoom .woocommerce-product-gallery__image' ).on('touchstart', function() {
					touch = true;
				});

				jQuery( '.woocommerce-product-gallery--has-zoom .woocommerce-product-gallery__image' ).on('touchmove', function() {
					touch = false;
				});

				jQuery( '.woocommerce-product-gallery--has-zoom .woocommerce-product-gallery__image' ).on('touchend', function() {
					if ( touch ) {
						jQuery(this).addClass( 'zoom-enable' );
					} else {
						jQuery(this).removeClass( 'zoom-enable' );
					}
				});
			}
		});
	}

	productLightBox() {
		const settings = this.getElementSettings();
		var $selector = jQuery('.woocommerce-product-gallery');

		jQuery('.woocommerce-product-gallery__image').on( 'click', 'a', function (e) {
			return false;
		});

		if( ! $selector ) {
			return;
		}

		if( ! settings.product_image_lightbox ) {
			return
		}
		lightBoxButton();
		jQuery(document.body).on( 'ecomus_product_gallery_lightbox', function(){
			lightBoxButton();
		} );

		jQuery(document).on( 'click', '.ecomus-button--product-lightbox', function (e) {
			e.preventDefault();

			var pswpElement = jQuery( '.pswp' )[0],
				items       = getGalleryItems( jQuery(this).siblings( '.woocommerce-product-gallery__wrapper' ).find( '.woocommerce-product-gallery__image' ) ),
				clicked = jQuery(this).siblings( '.woocommerce-product-gallery__wrapper' ).find( '.swiper-slide-active' );

			var options = jQuery.extend( {
				index: jQuery( clicked ).index(),
				addCaptionHTMLFn: function( item, captionEl ) {
					if ( ! item.title ) {
						captionEl.children[0].textContent = '';
						return false;
					}
					captionEl.children[0].textContent = item.title;
					return true;
				}
			}, wc_single_product_params.photoswipe_options );

			// Initializes and opens PhotoSwipe.
			var photoswipe = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
			photoswipe.init();
		});

		function lightBoxButton() {
			jQuery('.woocommerce-product-gallery__image').on( 'click', 'a', function (e) {
				return false;
			});

			var $icon = '<svg width="24" height="24" aria-hidden="true" role="img" focusable="false" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.672 17.0111L17.672 12.0526L16.4091 12.0526L16.4091 15.4846L11.5285 10.604L10.6352 11.4972L15.5158 16.3778L12.082 16.3796L12.082 17.6425L17.0405 17.6425C17.3878 17.6407 17.6701 17.3584 17.672 17.0111ZM2.48608 16.3778L5.91808 16.3778L5.91808 17.6407L0.961377 17.6425C0.78679 17.6425 0.628951 17.5701 0.515665 17.4568C0.40053 17.3417 0.329985 17.1856 0.329948 17.0111L0.329912 12.0525H1.59277V15.4845L6.47335 10.6039L7.36662 11.4972L2.48604 16.3778L2.48608 16.3778ZM15.514 1.56337H12.082L12.0819 0.300476L17.0405 0.300512C17.1234 0.300625 17.2054 0.317088 17.2819 0.348957C17.3584 0.380826 17.4278 0.427474 17.4862 0.486229C17.6032 0.603249 17.6719 0.764822 17.6719 0.931941L17.6701 5.88864L16.4072 5.88864L16.4072 2.45664L11.5267 7.33722L10.6334 6.44395L15.514 1.56337ZM6.47523 7.33722L7.3685 6.44395L2.48608 1.56152L5.91993 1.56337L5.91808 0.298663L0.961377 0.300512C0.878435 0.300435 0.796292 0.316715 0.719649 0.34842C0.643005 0.380126 0.573367 0.426633 0.514718 0.485282C0.456069 0.543931 0.409562 0.613569 0.377857 0.690212C0.346151 0.766856 0.329871 0.848999 0.329948 0.931941L0.328062 5.88868L1.59277 5.89053L1.59281 2.45479L6.47523 7.33722Z"></path></svg>';

			if( $selector.closest( '.ecomus-product-gallery' ).data( 'lightbox_icon' ) ) {
				$icon = $selector.closest( '.ecomus-product-gallery' ).data( 'lightbox_icon' );
			}

			$selector.append('<a href="#" class="ecomus-button--product-lightbox em-flex em-flex-align-center em-flex-center"><span class="ecomus-svg-icon ecomus-svg-icon--fullscreen">' + $icon + '</span></a>')
		}

		function getGalleryItems( $slides ) {
			var items = [];

			if ( $slides.length > 0 ) {
				$slides.each( function( i, el ) {
					var img = jQuery( el ).find( 'img' );

					if ( img.length ) {
						var large_image_src = img.attr( 'data-large_image' ),
							large_image_w   = img.attr( 'data-large_image_width' ),
							large_image_h   = img.attr( 'data-large_image_height' ),
							alt             = img.attr( 'alt' ),
							item            = {
								alt  : alt,
								src  : large_image_src,
								w    : large_image_w,
								h    : large_image_h,
								title: img.attr( 'data-caption' ) ? img.attr( 'data-caption' ) : img.attr( 'title' )
							};
						items.push( item );
					}
				} );
			}

			return items;
		};
	};

	onInit() {
		super.onInit();
		var self = this;
		if( this.elements.$productGallery.hasClass( 'woocommerce-product-gallery--vertical' ) ) {
			self.productGallery(true);
			this.elements.$productGallery.on('product_thumbnails_slider_vertical wc-product-gallery-after-init', function(){
				self.productGallery(true);
			});
		} else {
			self.productGallery(false);
			this.elements.$productGallery.on('product_thumbnails_slider_horizontal', function(){
				self.productGallery(false);
			});
		}

		self.productImageZoom();
		jQuery(document.body).on( 'ecomus_product_gallery_zoom', function(){
			self.productImageZoom();
		} );

		self.productLightBox();
	}
}

class EcomusProductShortDescriptionWidgetHandler extends elementorModules.frontend.handlers.Base {
	onInit() {
        super.onInit();

		var $selector =  jQuery(document).find( '.short-description__content' );

		$selector.each( function () {
			if( jQuery(this)[0].scrollHeight > jQuery(this)[0].clientHeight ) {
				jQuery(this).siblings( '.short-description__more' ).removeClass( 'hidden' );
			}
		});

		jQuery( document.body ).on( 'click', '.short-description__more', function(e) {
			e.preventDefault();

			var $settings = jQuery(this).data( 'settings' ),
				$more     = $settings.more,
				$less     = $settings.less;

			if( jQuery(this).hasClass( 'less' ) ) {
				jQuery(this).removeClass( 'less' );
				jQuery(this).text( $more );
				jQuery(this).siblings( '.short-description__content' ).removeAttr( 'style' );
			} else {
				jQuery(this).addClass( 'less' );
				jQuery(this).text( $less );
				jQuery(this).siblings( '.short-description__content' ).css( '-webkit-line-clamp', 'inherit' );
			}
		});
    }
}

class EcomusProductDataTabsWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				productTabs: '.woocommerce-tabs--dropdown',
			}
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings('selectors');
		return {
		  $productTabs: this.$element.find(selectors.productTabs),
		};
	}

	onInit() {
		super.onInit();
		const settings = this.getElementSettings();

		this.$element.on( 'click', 'button.ecomus-form-review', function() {
			jQuery( this ).closest( '.elementor-element.e-parent' ).css( '--z-index', '999' );
		});

		this.$element.on( 'click', '.modal__backdrop, .ecomus-review-form-wrapper__close', function() {
			jQuery( this ).closest( '.elementor-element.e-parent' ).css( '--z-index', '' );
		});

		if( settings.product_tabs_layout !== 'accordion' ) {
			return;
		}

		this.elements.$productTabs.on( 'click', '.woocommerce-tabs-title', function() {
			var self = jQuery(this);
			if( self.hasClass('active') ) {
				if( self.closest('.woocommerce-tabs--dropdown').hasClass('wc-tabs-first--opened') ) {
					self.closest('.woocommerce-tabs--dropdown').removeClass('wc-tabs-first--opened');
				}

				self.removeClass('active');
				self.siblings('.woocommerce-tabs-content').slideUp(200);
			} else {
				self.addClass('active');
				self.siblings('.woocommerce-tabs-content').slideDown(200);
			}
		});

		jQuery( 'a.woocommerce-review-link' ).on( 'click', function() {
			jQuery('#tab-reviews .woocommerce-tabs-title:not(.active)').trigger('click');
		});

		jQuery(document).ready(function() {
			if ( window.location.href.indexOf( '#reviews' ) > -1 ) {
				jQuery('#tab-reviews .woocommerce-tabs-title:not(.active)').trigger('click');
			}
		});
	}
}

class EcomusProductRelatedWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-products-carousel--elementor section.products';
		settings.selectors.swiperArrow = this.$element.find('.ecomus-products-carousel--elementor > .swiper-button').get(0);
		settings.selectors.swiperWrapper = 'ul.products';
		settings.selectors.slideContent = 'li.product';

		return settings;
	}

	getSwiperSettings() {
		const settings = super.getSwiperSettings(),
			  elementSettings = this.getElementSettings(),
			  elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints;

		var changed = false;
		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if( elementorBreakpoints[breakpoint].value !== elementorBreakpoints[breakpoint].default_value ) {
				return;
			}

			elementorBreakpoints[breakpoint].value = parseInt( elementorBreakpoints[breakpoint].value ) + 1;

			changed = true;
		});

		if ( changed ) {
			const 	slidesToShow = +elementSettings.slides_to_show || 3,
					isSingleSlide = 1 === slidesToShow,
					elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints,
					defaultSlidesToShowMap = {
						mobile: 1,
						tablet: isSingleSlide ? 1 : 2,
					};
			let argsBreakpoints = {};
			let lastBreakpointSlidesToShowValue = slidesToShow;

			Object.keys( elementorBreakpoints ).reverse().forEach( ( breakpointName ) => {
				// Tablet has a specific default `slides_to_show`.
				const defaultSlidesToShow = defaultSlidesToShowMap[ breakpointName ] ? defaultSlidesToShowMap[ breakpointName ] : lastBreakpointSlidesToShowValue;

				argsBreakpoints[ elementorBreakpoints[ breakpointName ].value ] = {
					slidesPerView: +elementSettings[ 'slides_to_show_' + breakpointName ] || defaultSlidesToShow,
					slidesPerGroup: +elementSettings[ 'slides_to_scroll_' + breakpointName ] || 1,
				};

				if ( elementSettings.image_spacing_custom ) {
					argsBreakpoints[ elementorBreakpoints[ breakpointName ].value ].spaceBetween = this.getSpaceBetween( breakpointName );
				}

				lastBreakpointSlidesToShowValue = +elementSettings[ 'slides_to_show_' + breakpointName ] || defaultSlidesToShow;
			} );

			settings.breakpoints = argsBreakpoints;
		}

		settings.navigation.nextEl = this.$element.find('.ecomus-products-carousel--elementor > .elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.$element.find('.ecomus-products-carousel--elementor > .elementor-swiper-button-prev').get(0);

		settings.on.beforeInit = function () {
			var self = this,
				$productThumbnail =	this.$el.closest( '.ecomus-products-carousel--elementor' ).find('.product-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + parseFloat( self.$el.closest( '.ecomus-products-carousel--elementor' ).find('ul.products').css( 'padding-top' ) ) ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}
		}

		settings.on.resize = function () {
			var self = this,
				$productThumbnail =	this.$el.closest( '.ecomus-products-carousel--elementor' ).find('.product-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + parseFloat( self.$el.closest( '.ecomus-products-carousel--elementor' ).find('ul.products').css( 'padding-top' ) ) ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}
		}

		return settings;
	}

	async onInit() {
        super.onInit();

		this.elements.$swiperContainer.addClass('swiper');
		this.elements.$swiperContainer.find('ul.products').addClass('swiper-wrapper');
		this.elements.$swiperContainer.find('.product').addClass('swiper-slide');

		if ( ! this.elements.$swiperContainer.length ) {
			return;
		}

		await super.initSwiper();

		const elementSettings = this.getElementSettings();
		if ( 'yes' === elementSettings.pause_on_hover ) {
			this.togglePauseOnHover( true );
		}
    }
}

class EcomusProductUpsellWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-products-carousel--elementor section.products';
		settings.selectors.swiperArrow = this.$element.find('.ecomus-products-carousel--elementor > .swiper-button').get(0);
		settings.selectors.swiperWrapper = 'ul.products';
		settings.selectors.slideContent = 'li.product';

		return settings;
	}

	getSwiperSettings() {
		const settings = super.getSwiperSettings(),
			  elementSettings = this.getElementSettings(),
			  elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints;

		var changed = false;
		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if( elementorBreakpoints[breakpoint].value !== elementorBreakpoints[breakpoint].default_value ) {
				return;
			}

			elementorBreakpoints[breakpoint].value = parseInt( elementorBreakpoints[breakpoint].value ) + 1;

			changed = true;
		});

		if ( changed ) {
			const 	slidesToShow = +elementSettings.slides_to_show || 3,
					isSingleSlide = 1 === slidesToShow,
					elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints,
					defaultSlidesToShowMap = {
						mobile: 1,
						tablet: isSingleSlide ? 1 : 2,
					};
			let argsBreakpoints = {};
			let lastBreakpointSlidesToShowValue = slidesToShow;

			Object.keys( elementorBreakpoints ).reverse().forEach( ( breakpointName ) => {
				// Tablet has a specific default `slides_to_show`.
				const defaultSlidesToShow = defaultSlidesToShowMap[ breakpointName ] ? defaultSlidesToShowMap[ breakpointName ] : lastBreakpointSlidesToShowValue;

				argsBreakpoints[ elementorBreakpoints[ breakpointName ].value ] = {
					slidesPerView: +elementSettings[ 'slides_to_show_' + breakpointName ] || defaultSlidesToShow,
					slidesPerGroup: +elementSettings[ 'slides_to_scroll_' + breakpointName ] || 1,
				};

				if ( elementSettings.image_spacing_custom ) {
					argsBreakpoints[ elementorBreakpoints[ breakpointName ].value ].spaceBetween = this.getSpaceBetween( breakpointName );
				}

				lastBreakpointSlidesToShowValue = +elementSettings[ 'slides_to_show_' + breakpointName ] || defaultSlidesToShow;
			} );

			settings.breakpoints = argsBreakpoints;
		}

		settings.navigation.nextEl = this.$element.find('.ecomus-products-carousel--elementor > .elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.$element.find('.ecomus-products-carousel--elementor > .elementor-swiper-button-prev').get(0);

		settings.on.beforeInit = function () {
			var self = this,
				$productThumbnail =	this.$el.closest( '.ecomus-products-carousel--elementor' ).find('.product-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + parseFloat( self.$el.closest( '.ecomus-products-carousel--elementor' ).find('ul.products').css( 'padding-top' ) ) ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}
		}

		settings.on.resize = function () {
			var self = this,
				$productThumbnail =	this.$el.closest( '.ecomus-products-carousel--elementor' ).find('.product-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + parseFloat( self.$el.closest( '.ecomus-products-carousel--elementor' ).find('ul.products').css( 'padding-top' ) ) ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}
		}

		return settings;
	}

	async onInit() {
        super.onInit();

		this.elements.$swiperContainer.addClass('swiper');
		this.elements.$swiperContainer.find('ul.products').addClass('swiper-wrapper');
		this.elements.$swiperContainer.find('.product').addClass('swiper-slide');

		if ( ! this.elements.$swiperContainer.length ) {
			return;
		}

		await super.initSwiper();

		const elementSettings = this.getElementSettings();
		if ( 'yes' === elementSettings.pause_on_hover ) {
			this.togglePauseOnHover( true );
		}
    }
}

class EcomusProductsFilterWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				filter: '.ecomus-products-filter',
			}
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings('selectors');
		return {
			$filter: this.$element.find(selectors.filter),
		};
	}

	searchTerms() {
		var $this = jQuery( this ),
		term = $this.val().toLowerCase(),
		$list = $this.next( '.products-filter__options' ).find( '.products-filter__option' );

		if ( term ) {
			$list.hide().filter( function() {
				return jQuery( '.name', this ).text().toLowerCase().indexOf( term ) !== -1;
			} ).show();
		} else {
			$list.show();
		}
    }

	updatePrice(event) {
		event.preventDefault();
		var $item = jQuery( this ).closest( '.products-filter__option' ),
			$filter = $item.closest( '.filter' ),
			$value = $item.data('value'),
			$box = $filter.find('.product-filter-box');

		if ( ! $filter.hasClass( 'price' ) ) {
			return;
		}

		$box.find('input[name="min_price"]').val($value.min);
		$box.find('input[name="max_price"]').val($value.max);
	}

	toggleItem (event) {
		event.preventDefault();

		var $item = jQuery( this ).closest( '.products-filter__option' ),
			$filter = $item.closest( '.filter' ),
			$input = $item.closest( '.products-filter__options' ).next( 'input[type=hidden]' ),
			current = $input.val(),
			value = $item.data( 'value' ),
			form = $item.closest( 'form' ).get( 0 ),
			index = -1;

		if ( $filter.hasClass( 'multiple' ) ) {
			current = current ? current.split( ',' ) : [];
			index = current.indexOf( value );
			index = (-1 !== index) ? index : current.indexOf( value.toString() );

			if ( index !== -1 ) {
				current = _.without( current, value );
			} else {
				current.push( value );
			}

			$input.val( current.join( ',' ) );
			$item.toggleClass( 'selected' );

			$input.prop( 'disabled', current.length <= 0 );

			if ( $filter.hasClass( 'attribute' ) ) {
				var $queryTypeInput = $input.next( 'input[name^=query_type_]' );

				if ( $queryTypeInput.length ) {
					$queryTypeInput.prop( 'disabled', current.length <= 1 );
				}
			}
		} else {
			// @note: Ranges are always single selection.
			if ( $item.hasClass( 'selected' ) ) {
				$input.val( '' ).prop( 'disabled', true );
				$item.removeClass( 'selected' );
				if ( $filter.hasClass( 'ranges' ) ) {
					$input.next( 'input[type=hidden]' ).val( '' ).prop( 'disabled', true );

					var $box = $filter.find('.product-filter-box');

					$box.find('input[name="min_price"]').val( '' ).prop( 'disabled', true );
					$box.find('input[name="max_price"]').val( '' ).prop( 'disabled', true );
				}
			} else {
				$filter.find( '.products-filter__option.selected' );
				$item.addClass( 'selected' );
				$input.val( value ).prop( 'disabled', false );

				if ( $filter.hasClass( 'ranges' ) ) {
					$input.val( value.min ).prop( 'disabled', ! value.min );
					$input.next( 'input[type=hidden]' ).val( value.max ).prop( 'disabled', ! value.max );
				}
			}
		}

		if ( $filter.hasClass( 'products-filter--collapsible' ) && $item.children( 'ul' ).length ) {
			event.data.widget.checkToggleCollapse( $item );
		}

		jQuery( document.body ).trigger( 'ecomus_products_filter_change', [form] );
	}

	checkToggleCollapse( $item ) {
		var $children = $item.children( 'ul' );

		if ( ! $children.length ) {
			return;
		}

		if ( $item.hasClass( 'selected' ) && ! $item.hasClass( 'active' ) ) {
			$children.stop( true, true ).slideDown( function() {
				$item.addClass( 'active' );
			} );
		}

		if ( ! $item.hasClass( 'selected' ) && $item.hasClass( 'active' ) ) {
			// Don't close if subitems are selected.
			if ( $item.find( '.products-filter__option.selected' ).length ) {
				return;
			}

			$children.stop( true, true ).slideUp( function() {
				$item.removeClass( 'active' );
			} );
		}
	}

	toggleCollapse( event ) {
		var $option = jQuery( this ).closest( '.products-filter__option' ),
			$children = $option.children( 'ul' );

		if ( ! $children.length ) {
			return;
		}

		event.preventDefault();

		$children.stop( true, true ).slideToggle( function() {
			$option.toggleClass( 'active' );
		} );
	}

	triggerItemChange() {
		var form = jQuery( this ).closest( 'form' ).get( 0 );
		jQuery( document.body ).trigger( 'ecomus_products_filter_change', [form] );
	}

	resetFilters() {
		var $form = jQuery( this ).closest( 'form' );

		$form.get( 0 ).reset();
		$form.find( '.selected' ).removeClass( 'selected' );
		$form.find( 'select' ).val( '' ).prop('disabled', true);
		$form.find( ':input' ).not( '[type="button"], [type="submit"], [type="reset"]' )
			.val( '' )
			.filter('[type="hidden"],[name="min_price"], [name="max_price"]').prop('disabled', true);

		$form.trigger( 'submit' );
		jQuery( document.body ).trigger( 'ecomus_products_filter_reseted', [$form] );
	}

	removeFiltered( event ) {
		event.preventDefault();

		var $el = jQuery( this ),
			$widget = $el.closest( ' .products-filter-widget--elementor' ),
			$form = $widget.find( 'form' ),
			name = $el.data( 'name' ),
			key = name.replace( /^filter_/g, '' ),
			value = $el.data( 'value' ),
			$filter = $widget.find( '.filter.' + key );

		$el.remove();

		if ( $filter.length ) {
			var $input = $filter.find( ':input[name=' + name + ']' ),
				current = $input.val();

			if( name == 'price' ) {
				$filter.find(':input[name=min_price]').val('');
				$filter.find(':input[name=max_price]').val('');
				$filter.find('.products-filter__option').removeClass('selected');
			} else {
				if ( $input.is( 'select' ) ) {
					$input.prop( 'selectedIndex', 0 );
					$input.trigger( 'change' );
				} else {
					current = current.replace( ',' + value, '' );
					current = current.replace( value, '' );
					$input.val( current );

					if ( '' == current ) {
						$input.prop( 'disabled', true );
					}

					$filter.find( '[data-value="' + value + '"]' ).removeClass( 'selected' );
				}
			}

			$form.trigger( 'submit' );
		}
	}

	ajaxSearch( event ) {
		event.data.widget.sendAjaxRequest( this );
		return false;
	}

	collapseFilterWidget( event ) {
		if ( ! jQuery(this).closest( 'form' ).hasClass('has-collapse')) {
            return;
        }

		event.preventDefault();

		jQuery(this).next().slideToggle();
		jQuery(this).closest('.products-filter__filter').toggleClass('ecomus-active');
	}

	instantSearch( event, form ) {
		var settings = jQuery( form ).data( 'settings' );

		if ( ! settings.instant ) {
			return;
		}

		event.data.widget.sendAjaxRequest( form );
	}

	updateURL( event, response, url, form ) {
		var settings = jQuery( form ).data( 'settings' );

		if ( ! settings.change_url ) {
			return;
		}

		if ( '?' === url.slice( -1 ) ) {
			url = url.slice( 0, -1 );
		}

		url = url.replace( /%2C/g, ',' );

		history.pushState( null, '', url );
	}

	updateForm( event, response, url, form ) {
		var $widget = jQuery( form ).closest( '.elementor-widget-ecomus-products-filter' ),
			widgetId = $widget.data( 'id' ),
			$newWidget = jQuery( '.elementor-widget-ecomus-products-filter[data-id="' + widgetId + '"', response );

		if ( ! $newWidget.length ) {
			return;
		}

		jQuery( '.filters', form ).html( jQuery( '.filters', $newWidget ).html() );
		jQuery( '.products-filter__activated', $widget ).html( jQuery( '.products-filter__activated', $newWidget ).html() );

		jQuery( document.body ).trigger( 'ecomus_products_filter_widget_updated', [form] );
	}

	sendAjaxRequest( form ) {
		var self = this,
			$form = jQuery( form ),
			$container = jQuery('.ecomus-archive-products ul.products'),
			$notice = jQuery('.site-content .woocommerce-notices-wrapper'),
			$noticeNF = jQuery('.ecomus-archive-products .woocommerce-info'),
			$count = jQuery('.ecomus-result-count'),
			$page_header = jQuery('.page-header-elementor'),
			$breadcrumb = jQuery('.ecomus-woocommerce-breadcrumb'),
			$top_catetories = jQuery('.catalog-top-categories'),
			$inputs = $form.find(':input:not(:checkbox):not(:button)'),
			params = {},
			action = $form.attr('action'),
			separator = action.indexOf('?') !== -1 ? '&' : '?',
			url = action;

		params = $inputs.filter( function() {
			return this.value != '' && this.name != '';
		} ).serializeObject();


		if (params.min_price && params.min_price == $inputs.filter('[name=min_price]').data('min')) {
			delete params.min_price;
		}

		if (params.max_price && params.max_price == $inputs.filter('[name=max_price]').data('max')) {
			delete params.max_price;
		}

		// the filer always contains "filter" param
		// so it is empty if the size less than 2
		if ( _.size( params ) > 1 ) {
			url += separator + jQuery.param(params, true);
		}

		if ($container.hasClass('layout-carousel')) {
			window.location.href = url;
			return false;
		}

		if (!$container.length) {
			$container = jQuery('.ecomus-archive-products ul.products');
			jQuery('#site-content .woocommerce-info').replaceWith($container);
		}

		if ( self.ajax ) {
			self.ajax.abort();
		}

		$form.addClass('filtering');
		$container.fadeIn().addClass('loading').append('<li class="loading-screen"><span class="em-loading-spin"></span></li>');

		if( $form.closest('.ecomus-products-filter--sidebar').hasClass('close-sidebar') ) {
			$form.closest('.ecomus-products-filter__form').fadeOut().removeClass('offscreen-panel--open');
			jQuery(document.body).removeClass('offcanvas-opened');
		}

		jQuery(document.body).trigger('ecomus_products_filter_before_send_request', $container);

		self.ajax = jQuery.get(url, function (response) {
			var $html = jQuery(response),
				$products = $html.find('.ecomus-archive-products ul.products'),
				$pagination = $container.next('.woocommerce-pagination'),
				$nav = $html.find('.woocommerce-navigation, .woocomerce-pagination');

			if ( ! $products.children().length ) {
				var $info = $html.find('.ecomus-archive-products .woocommerce-info');
				$pagination.fadeOut();
				$container.fadeOut();
				$count.fadeOut();
				$notice.html($info);
				$notice.fadeIn();

			} else {
				var $nav = $products.next('.woocommerce-pagination'),
					$order = jQuery('form.woocommerce-ordering');

				if ($nav.length) {
					if ($pagination.length) {
						$pagination.replaceWith($nav).fadeIn();
					} else {
						$container.after($nav);
					}
				} else {
					$pagination.fadeOut();
				}
				$count.fadeIn();
				$notice.fadeOut();
				$noticeNF.fadeOut();
				$container.fadeIn();
				$products.children().each(function (index, product) {
					jQuery(product).css('animation-delay', index * 100 + 'ms');
				});

				// Modify the ordering form.
				$inputs.each(function () {
					var $input = jQuery(this),
						name = $input.attr('name'),
						value = $input.val();

					if (name === 'orderby') {
						return;
					}

					if ('min_price' === name && value == $input.data('min')) {
						$order.find('input[name="min_price"]').remove();
						return;
					}

					if ('max_price' === name && value == $input.data('max')) {
						$order.find('input[name="max_price"]').remove();
						return;
					}

					$order.find('input[name="' + name + '"]').remove();

					if (value !== '' && value != 0) {
						jQuery('<input type="hidden" name="' + name + '">').val(value).appendTo($order);
					}
				});

				// Replace result count.
				$count.replaceWith($html.find('.ecomus-result-count'));

				$page_header.replaceWith($html.find('.page-header-elementor'));

				$breadcrumb.replaceWith($html.find('.ecomus-woocommerce-breadcrumb'));

				$top_catetories.replaceWith($html.find('.catalog-top-categories'));

				$container.replaceWith($products);
				$products.find('li.product').addClass('animated ecomusFadeInUp');

				jQuery(document.body).trigger('ecomus_products_loaded', [$products.children(), false]); // appended = false
			}

			$form.removeClass('filtering');
			jQuery(document.body).trigger('ecomus_products_filter_request_success', [response, url, form]);
		});
	}

	viewMoreCats(event) {
		var $filter = event ? event.data.widget.elements.$filter : this.elements.$filter,
			$widget = $filter.find('.product_cat'),
			$widgetChild = $filter.find('.products-filter--show-children-only'),
			$items = $widget.find('.products-filter--list > .filter-list-item, .products-filter--checkboxes > .filter-checkboxes-item'),
			catNumbers = parseInt($widget.find('input.widget-cat-numbers').val(), 10);

		if (!$widget.hasClass('products-filter--view-more')) {
			return;
		}

		if ( $widgetChild.find('.products-filter__option').hasClass('selected') ) {
			$items = $widgetChild.find('ul.products-filter--list li.selected .children > .filter-list-item, ul.products-filter--checkboxes li.selected .children > .filter-checkboxes-item');
		}

		var count = $widget.find( $items ).size();

		if (count > catNumbers) {
			$widget.find('.show-more').show();

			if ( $widgetChild.find('ul.products-filter__options > .products-filter__option').hasClass( 'selected' ) ) {
				$widgetChild.find( '.ecomus-widget-product-cats-btn' ).addClass( 'btn-children' );
			}
		}

		$widget.find('ul.products-filter--list > .filter-list-item:lt(' + catNumbers + ')').show();
		$widget.find('ul.products-filter--checkboxes > .filter-checkboxes-item:lt(' + catNumbers + ')').show();

		$widgetChild.find('ul.products-filter--list li.selected .children > .filter-list-item:lt(' + catNumbers + ')').show();
		$widgetChild.find('ul.products-filter--checkboxes li.selected .children > .filter-checkboxes-item:lt(' + catNumbers + ')').show();

		$widget.on('click', '.show-more', function () {
			$widget.find( $items ).show();
			jQuery(this).hide();
			$widget.find('.show-less').show();
			$widget.find( '.ecomus-widget-product-cats-btn' ).addClass( 'btn-show-item' );
		});

		$widget.on('click', '.show-less', function () {
			$widget.find( 'ul.products-filter--list > .filter-list-item' ).not(':lt(' + catNumbers + ')').hide();
			$widget.find( 'ul.products-filter--checkboxes > .filter-checkboxes-item' ).not(':lt(' + catNumbers + ')').hide();
			$widgetChild.find( 'ul.products-filter--list li.selected .children > .filter-list-item' ).not(':lt(' + catNumbers + ')').hide();
			$widgetChild.find( 'ul.products-filter--checkboxes li.selected .children > .filter-checkboxes-item' ).not(':lt(' + catNumbers + ')').hide();
			jQuery(this).hide();
			$widget.find('.show-more').show();
			$widget.find( '.ecomus-widget-product-cats-btn' ).removeClass( 'btn-show-item' );
		});
	}

	initDropdowns( event, form ) {
		if ( ! jQuery.fn.select2 ) {
			return;
		}

		var $container = form ? jQuery( form ) : this.elements.$filter,
			direction = jQuery( document.body ).hasClass( 'rtl' ) ? 'rtl' : 'ltr';

		jQuery( 'select', $container ).each( function() {
			var $select = jQuery( this ),
				$searchBoxText = $select.prev( '.products-filter__search-box' ),
				searchText = $searchBoxText.length ? $searchBoxText.text() : false;

			$select.select2( {
				dir: direction,
				width: '100%',
				minimumResultsForSearch: searchText ? 3 : -1,
				dropdownCssClass: 'products-filter-dropdown',
				dropdownParent: $select.parent()
			} );
		} );
	}

	initSliders( event, form ) {
		jQuery( document.body ).trigger( 'init_price_filter' );

		event.data.widget.removeSliderInputs( form );
	}

	updateActivatedItems( event, form ) {
		var $container = form ? jQuery( form ) : this.elements.$filter;

		if ( jQuery.trim( $container.find( '.products-filter__activated-items' ).html() ) ) {
			$container.find('.products-filter__activated').removeClass( 'hidden' );
		} else {
			$container.find('.products-filter__activated').addClass( 'hidden' );
		}
	}

	removeSliderInputs( form ) {
		var $container = form ? jQuery( form ) : this.elements.$filter;

		jQuery( '.widget_price_filter', $container ).find( 'input[type=hidden]' ).not( '[name=min_price], [name=max_price]' ).remove();
	}


	collapseFilterWidgetMobile() {
		if ( ! this.elements.$filter.find( 'form' ).hasClass('has-collapse')) {
            return;
        }

		if ( ! this.elements.$filter.find( 'form' ).hasClass('products-filter__filter-section--collapse') ) {
			return;
		}

		var $this = this.elements.$filter.find('.products-filter__filter');

		jQuery(window).on('resize', function () {
			if (jQuery(window).width() < 768) {
				$this.addClass('ecomus-active');
			} else {
				$this.removeClass('ecomus-active');
				$this.find('.products-filter__filter-control').removeAttr('style');
			}

		}).trigger('resize');

	}

	scrollFilters() {
		if( ! jQuery(".ecomus-archive-products").length ) {
			return;
		}

		var $height = 0;

		jQuery(window).on( 'resize', function () {
			if ( jQuery(window).width() < 1024 ) {
				jQuery( '.ecomus-products-filter__form' ).removeClass( 'offscreen-panel--open' ).fadeOut();
				$height += 100;
			} else {
				var $sticky 	= jQuery( document.body ).hasClass('ecomus-header-sticky') ? jQuery( '#site-header .header-sticky' ).outerHeight() : 0,
					$wpadminbar = jQuery('#wpadminbar').is(":visible") ? jQuery('#wpadminbar').height() : 0;

					$height 	= $sticky + $wpadminbar + 150;
			}
		}).trigger( 'resize' );

		jQuery( document.body ).removeAttr('style');
		jQuery( document.body ).removeClass( 'offcanvas-opened' );

		jQuery('html,body').stop().animate({
				scrollTop: jQuery(".ecomus-archive-products").offset().top - $height
			},
		'slow');

	}

	mobileFilters() {
		if( this.elements.$filter.hasClass('ecomus-products-filter--sidebar') ) {
			return;
		}
		var $selector = this.elements.$filter.find('.ecomus-products-filter__form');
		jQuery(window).on('resize', function () {
            if (jQuery(window).width() > 1024) {
                if ($selector.hasClass('offscreen-panel')) {
                    $selector.removeClass('offscreen-panel offscreen-panel--side-left').removeAttr('style');
                }
            } else {
                $selector.addClass('offscreen-panel offscreen-panel--side-left');
            }

        }).trigger('resize');
	}

	onInit() {
		super.onInit();
		this.initDropdowns();
		this.removeSliderInputs();
		this.viewMoreCats('');
		this.collapseFilterWidgetMobile();
		this.mobileFilters();

		this.elements.$filter
		.on( 'input', '.products-filter__search-box', this.searchTerms )
		.on( 'click', '.products-filter__option-name', this.updatePrice)
		.on( 'click', '.products-filter__option-name, .products-filter__options .swatch', { widget: this }, this.toggleItem)
		.on( 'click', '.products-filter--collapsible .products-filter__option-toggler', this.toggleCollapse )
		.on( 'change', 'input, select', this.triggerItemChange )
		.on( 'click', '.reset-button', this.resetFilters )
		.on( 'click', '.remove-filtered', this.removeFiltered )
		.on( 'submit', 'form.ajax-filter', { widget: this }, this.ajaxSearch )
		.on( 'click', '.products-filter__filter-name', this.collapseFilterWidget );

		jQuery( document.body )
		.on( 'ecomus_products_filter_change', { widget: this }, this.instantSearch )
		.on( 'ecomus_products_filter_request_success', this.updateURL )
		.on( 'ecomus_products_filter_request_success', this.updateForm )
		.on( 'ecomus_products_filter_request_success', { widget: this }, this.viewMoreCats )
		.on( 'ecomus_products_filter_widget_updated', this.initDropdowns )
		.on( 'ecomus_products_filter_widget_updated', { widget: this }, this.initSliders )
		.on( 'ecomus_products_filter_widget_updated', this.updateActivatedItems )
		.on( 'ecomus_products_filter_before_send_request', this.scrollFilters);
	}
}

class EcomusProductSidebarWidgetHandler extends elementorModules.frontend.handlers.Base {
	bindEvents() {
		var self = this;
		jQuery( window ).on( 'resize', function () {
			if( self.$element.find( '.single-product-sidebar-panel' ).hasClass( 'offscreen-panel--open' ) ) {
				if( jQuery( window ).width() > 1199 ) {
					if( self.$element.find( '.single-product-sidebar-panel' ).hasClass( 'desktop-sidebar' ) ) {
						self.$element.find( '.single-product-sidebar-panel .sidebar__button-close' )[0].click();
					}
				}

				if( jQuery( window ).width() < 1200 && jQuery( window ).width() > 767 ) {
					if( self.$element.find( '.single-product-sidebar-panel' ).hasClass( 'tablet-sidebar' ) ) {
						self.$element.find( '.single-product-sidebar-panel .sidebar__button-close' )[0].click();
					}
				}

				if( jQuery( window ).width() < 768 ) {
					if( self.$element.find( '.single-product-sidebar-panel' ).hasClass( 'mobile-sidebar' ) ) {
						self.$element.find( '.single-product-sidebar-panel .sidebar__button-close' )[0].click();
					}
				}
			}
		});
	}

	onInit() {
		super.onInit();
		const settings = this.getElementSettings();

		if( settings.toggle_heading !== 'yes' ) {
			return;
		}

		var $heading = this.$element.find( '.ecomus-heading' );

		$heading.append( '<span class="em-collapse-icon"></span>' );

		$heading.on( 'click', function() {
			jQuery(this).toggleClass( 'active' );

			if( jQuery(this).hasClass( 'active' ) ) {
				jQuery( this ).closest( '.elementor-widget-ecomus-heading' ).siblings().slideUp();
			} else {
				jQuery( this ).closest( '.elementor-widget-ecomus-heading' ).siblings().slideDown();
			}
		});
	}
}

class EcomusArchiveTopCategoriesWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.catalog-top-categories--elementor';
		settings.selectors.swiperArrow = this.$element.find('.swiper .swiper-button').get(0);
		settings.selectors.paginationWrapper = this.$element.find('.swiper-pagination').get(0);

		return settings;
	}

	getSwiperSettings() {
		const 	settings = super.getSwiperSettings(),
				elementSettings = this.getElementSettings(),
				elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints;

		var changed = false;
		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if( elementorBreakpoints[breakpoint].value !== elementorBreakpoints[breakpoint].default_value ) {
				return;
			}

			elementorBreakpoints[breakpoint].value = parseInt( elementorBreakpoints[breakpoint].value ) + 1;

			changed = true;
		});

		if ( changed ) {
			const 	slidesToShow = +elementSettings.slides_to_show || 3,
					isSingleSlide = 1 === slidesToShow,
					elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints,
					defaultSlidesToShowMap = {
						mobile: 1,
						tablet: isSingleSlide ? 1 : 2,
					};
			let argsBreakpoints = {};
			let lastBreakpointSlidesToShowValue = slidesToShow;

			Object.keys( elementorBreakpoints ).reverse().forEach( ( breakpointName ) => {
				// Tablet has a specific default `slides_to_show`.
				const defaultSlidesToShow = defaultSlidesToShowMap[ breakpointName ] ? defaultSlidesToShowMap[ breakpointName ] : lastBreakpointSlidesToShowValue;

				argsBreakpoints[ elementorBreakpoints[ breakpointName ].value ] = {
					slidesPerView: +elementSettings[ 'slides_to_show_' + breakpointName ] || defaultSlidesToShow,
					slidesPerGroup: +elementSettings[ 'slides_to_scroll_' + breakpointName ] || 1,
				};

				if ( elementSettings.image_spacing_custom ) {
					argsBreakpoints[ elementorBreakpoints[ breakpointName ].value ].spaceBetween = this.getSpaceBetween( breakpointName );
				}

				lastBreakpointSlidesToShowValue = +elementSettings[ 'slides_to_show_' + breakpointName ] || defaultSlidesToShow;
			} );

			settings.breakpoints = argsBreakpoints;
		}

		settings.navigation.nextEl = this.$element.find('.swiper .elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.$element.find('.swiper .elementor-swiper-button-prev').get(0);

		return settings;
	}

	a11ySetSlideAriaHidden( status = '' ) {
		const currentIndex = 'initialisation' === status ? 0 : this.swiper?.activeIndex;

		if ( 'number' !== typeof currentIndex ) {
			return;
		}

		const $slides = this.elements.$swiperContainer.find( this.getSettings( 'selectors' ).slideContent );

		$slides.each( ( index, slide ) => {
			slide.removeAttribute( 'inert' );
		} );
	}
}

class EcomusWCCartWidgetHandler extends elementorModules.frontend.handlers.Base {
	updateAuto() {
		const settings = this.getElementSettings();

		if( ! settings.cart_button_update_auto ) {
			return;
		}

		jQuery( '.elementor-widget-ecomus-wc-cart' ).on( 'change', '.quantity .qty', function() {
			if( jQuery(this).closest( '.woocommerce-cart-form' ).find( '[name="update_cart"]' ).is( ':disabled' ) ) {
				jQuery(this).closest( '.woocommerce-cart-form' ).find( '[name="update_cart"]' ).prop( 'disabled', false );
			}

			if( jQuery(this).val() == 0 ) {
				jQuery(this).closest( '.woocommerce-cart-form__cart-item' ).find( 'a.remove' ).trigger( 'click' );
			} else {
				jQuery(this).closest( '.woocommerce-cart-form' ).find( '[name="update_cart"]' ).trigger( 'click' );
			}
		});
	}

	input_quantity() {
        jQuery( '.elementor-widget-ecomus-wc-cart' ).on( 'keyup', '.quantity .qty', function( e ) {
            if( jQuery(this).val() ) {
                jQuery(this).attr( 'value', jQuery(this).val() );
            } else {
                jQuery(this).attr( 'value', 0 );
            }
        });
    }

	onInit() {
		this.updateAuto();
		this.input_quantity();
	}
}

class EcomusWCCartCrossSellWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-products-carousel--elementor > .cross-sells';
		settings.selectors.swiperArrow = this.$element.find('.ecomus-products-carousel--elementor > .swiper-button').get(0);
		settings.selectors.swiperWrapper = '.products';
		settings.selectors.slideContent = '.product';

		return settings;
	}

	getSwiperSettings() {
		const settings = super.getSwiperSettings(),
			  elementSettings = this.getElementSettings(),
			  elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints;

		var changed = false;
		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if( elementorBreakpoints[breakpoint].value !== elementorBreakpoints[breakpoint].default_value ) {
				return;
			}

			elementorBreakpoints[breakpoint].value = parseInt( elementorBreakpoints[breakpoint].value ) + 1;

			changed = true;
		});

		if ( changed ) {
			const 	slidesToShow = +elementSettings.slides_to_show || 3,
					isSingleSlide = 1 === slidesToShow,
					elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints,
					defaultSlidesToShowMap = {
						mobile: 1,
						tablet: isSingleSlide ? 1 : 2,
					};
			let argsBreakpoints = {};
			let lastBreakpointSlidesToShowValue = slidesToShow;

			Object.keys( elementorBreakpoints ).reverse().forEach( ( breakpointName ) => {
				// Tablet has a specific default `slides_to_show`.
				const defaultSlidesToShow = defaultSlidesToShowMap[ breakpointName ] ? defaultSlidesToShowMap[ breakpointName ] : lastBreakpointSlidesToShowValue;

				argsBreakpoints[ elementorBreakpoints[ breakpointName ].value ] = {
					slidesPerView: +elementSettings[ 'slides_to_show_' + breakpointName ] || defaultSlidesToShow,
					slidesPerGroup: +elementSettings[ 'slides_to_scroll_' + breakpointName ] || 1,
				};

				if ( elementSettings.image_spacing_custom ) {
					argsBreakpoints[ elementorBreakpoints[ breakpointName ].value ].spaceBetween = this.getSpaceBetween( breakpointName );
				}

				lastBreakpointSlidesToShowValue = +elementSettings[ 'slides_to_show_' + breakpointName ] || defaultSlidesToShow;
			} );

			settings.breakpoints = argsBreakpoints;
		}

		settings.navigation.nextEl = this.$element.find('.ecomus-products-carousel--elementor > .elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.$element.find('.ecomus-products-carousel--elementor > .elementor-swiper-button-prev').get(0);

		settings.on.beforeInit = function () {
			var self = this,
				$productThumbnail =	this.$el.closest( '.ecomus-products-carousel--elementor' ).find('.product-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + parseFloat( self.$el.closest( '.swiper' ).css( 'padding-top') ) ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}
		}

		settings.on.resize = function () {
			var self = this,
				$productThumbnail =	this.$el.closest( '.ecomus-products-carousel--elementor' ).find('.product-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + parseFloat( self.$el.closest( '.swiper' ).css( 'padding-top') ) ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}
		}

		return settings;
	}

	async onInit() {
        super.onInit();

		this.elements.$swiperContainer.addClass( 'swiper' );
		this.elements.$swiperContainer.find('.products').addClass('swiper-wrapper');
		this.elements.$swiperContainer.find('.product').addClass('swiper-slide');

		if ( ! this.elements.$swiperContainer.length ) {
			return;
		}

		await super.initSwiper();

		const elementSettings = this.getElementSettings();
		if ( 'yes' === elementSettings.pause_on_hover ) {
			this.togglePauseOnHover( true );
		}
    }
}

jQuery( window ).on( 'elementor/frontend/init', () => {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-images.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductImagesWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-short-description.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductShortDescriptionWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-data-tabs.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductDataTabsWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-related.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductRelatedWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-upsell.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductUpsellWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-products-filter.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductsFilterWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-sidebar.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductSidebarWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-archive-top-categories.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusArchiveTopCategoriesWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-wc-cart.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusWCCartWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-wc-cart-cross-sell.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusWCCartCrossSellWidgetHandler, { $element } );
	} );
} );

jQuery(document).ready(function($) {
	$( document.body ).on( 'price_slider_create', function() {
		var $slider = $(this).find( '.products-filter-widget--elementor .price_slider.ui-slider' );
		$slider.each( function() {
			var $el = $( this ),
				form = $el.closest( 'form' ).get( 0 ),
				onChange = $el.slider( 'option', 'change' );

			$el.slider( 'option', 'change', function( event, ui ) {
				onChange( event, ui );

				$( document.body ).trigger( 'ecomus_products_filter_change', [form] );
			} );
		} );
	});
});