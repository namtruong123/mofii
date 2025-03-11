class EcomusCarouselWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-carousel--elementor';

		return settings;
	}

	getSwiperSettings() {
		const settings = super.getSwiperSettings(),
			  elementSettings = this.getElementSettings(),
			  slidesToShow = +elementSettings.slides_to_show || 3,
			  isSingleSlide = 1 === slidesToShow,
			  elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints,
			  defaultSlidesToShowMap = {
					mobile: 1,
					tablet: isSingleSlide ? 1 : 2,
				};

		let argsBreakpoints = {};
		let lastBreakpointSlidesToShowValue = slidesToShow;

		var changed = false;
		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if( elementorBreakpoints[breakpoint].value !== elementorBreakpoints[breakpoint].default_value ) {
				return;
			}

			elementorBreakpoints[breakpoint].value = parseInt( elementorBreakpoints[breakpoint].value ) + 1;
			changed = true;
		});

		if ( changed ) {
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

		if( elementSettings.center_mode == 'yes' ) {
			settings.spaceBetween = 30;
			settings.loopAdditionalSlides = elementSettings.infinite == 'yes' ? 1 : 0;
		}

		settings.on.resize = function () {
			var self           = this,
				$productThumbnail = this.$el.closest( '.ecomus-carousel--elementor' ).find('.product-thumbnail'),
				$postThumbnail    = this.$el.closest( '.ecomus-carousel--elementor' ).find('.post-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + 15 ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}

			if( $postThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $postThumbnail.outerHeight(),
						top = ( heightThumbnails / 2 ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}
		}

		return settings;
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( 'activeItemIndex' === propertyName ) {
			this.swiper.slideToLoop( this.getEditSettings( 'activeItemIndex' ) - 1 );
		}
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

class EcomusProductCarouselWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-products-carousel--elementor .product-swiper--elementor';
		if( this.$element.find( '.ecomus-products-carousel--relative' ).length > 0 ) {
			settings.selectors.swiperArrow = this.$element.find('.ecomus-products-carousel .ecomus-products-carousel--relative > .swiper-button').get(0);
		} else {
			settings.selectors.swiperArrow = this.$element.find('.ecomus-products-carousel > .swiper-button').get(0);
		}

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

		if( elementSettings.slidesperview_auto == 'yes' ) {
			settings.slidesPerView = 'auto';
			settings.freeMode = true;
		}

		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if ( elementSettings[ 'slidesperview_auto_' + breakpoint ] == 'yes' ) {
				settings.breakpoints[ elementorBreakpoints[breakpoint].value ].slidesPerView = 'auto';
				settings.breakpoints[ elementorBreakpoints[breakpoint].value ].freeMode = true;
			}
		});

		if( this.$element.find( '.ecomus-products-carousel--relative' ).length > 0 ) {
			settings.navigation.nextEl = this.$element.find('.ecomus-products-carousel--relative > .elementor-swiper-button-next').get(0);
            settings.navigation.prevEl = this.$element.find('.ecomus-products-carousel--relative > .elementor-swiper-button-prev').get(0);
		} else {
			settings.navigation.nextEl = this.$element.find('.ecomus-products-carousel > .elementor-swiper-button-next').get(0);
			settings.navigation.prevEl = this.$element.find('.ecomus-products-carousel > .elementor-swiper-button-prev').get(0);
		}

		settings.on.afterInit = function () {
			var $navigation = this.$el.closest( '.ecomus-carousel--elementor' ).find('.ecomus-products-carousel__heading .swiper-button' );

			if( $navigation.length > 0 ) {
				if( this.isEnd == true && this.isBeginning == true ) {
					this.$el.closest( '.ecomus-carousel--elementor' ).find('.ecomus-products-carousel__heading .elementor-swiper-button-prev' ).addClass( 'swiper-button-disabled swiper-button-lock' );
				} else {
					this.$el.closest( '.ecomus-carousel--elementor' ).find('.ecomus-products-carousel__heading .elementor-swiper-button-prev' ).addClass( 'swiper-button-disabled' );
				}

				if( this.isEnd == true && this.isBeginning == true ) {
					this.$el.closest( '.ecomus-carousel--elementor' ).find('.ecomus-products-carousel__heading .elementor-swiper-button-next' ).addClass( 'swiper-button-disabled swiper-button-lock' );
				}
			}
		};

		settings.on.resize = function () {
			var self = this,
				$productThumbnail =	this.$el.closest( '.ecomus-products-carousel--elementor' ).find('.product-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + parseFloat(self.$el.closest( '.ecomus-products-carousel--elementor' ).find( '.ecomus-products-carousel--relative > .swiper').css( 'padding-top')) ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}

			if( elementSettings.slidesperview_auto == 'yes' || elementSettings.slidesperview_auto_tablet == 'yes' || elementSettings.slidesperview_auto_mobile == 'yes' ) {
				var windowWidth = jQuery(window).width(),
				widthElement = jQuery( self.$el.closest( '.ecomus-slidesperview-auto--yes' ) ).width(),
				spacing = ( windowWidth - widthElement ) / 2;

				jQuery( self.$el.closest( '.ecomus-carousel--slidesperview-auto' ) ).css( '--slidesperview-auto-spacing', '-' + spacing + 'px' );
			}
		}

		settings.on.transitionStart = function () {
			var $buttonNext = this.$el.closest( '.ecomus-carousel--elementor' ).find('.ecomus-products-carousel__heading .elementor-swiper-button-next' ),
				$buttonPrev = this.$el.closest( '.ecomus-carousel--elementor' ).find('.ecomus-products-carousel__heading .elementor-swiper-button-prev' );

			if( $buttonPrev.length > 0 ) {
				if( this.isBeginning == true ) {
					$buttonPrev.addClass( 'swiper-button-disabled' );
				} else {
					if( $buttonPrev.hasClass( 'swiper-button-disabled' ) ) {
						$buttonPrev.removeClass( 'swiper-button-disabled' );
					}
				}
			}

			if( $buttonNext.length > 0 ) {
				if( this.isEnd == true ) {
					$buttonNext.addClass( 'swiper-button-disabled' );
				} else {
					if( $buttonNext.hasClass( 'swiper-button-disabled' ) ) {
						$buttonNext.removeClass( 'swiper-button-disabled' );
					}
				}
			}
		};

		return settings;
	}

	bindEvents() {
		if( this.$element.find('.ecomus-products-carousel__heading .swiper-button' ).length > 0 ) {
			this.$element.find('.ecomus-products-carousel__heading .swiper-button' ).on('click', function(e) {
				e.preventDefault();

				var $this = jQuery(this);

				const swiper = $this.closest('.ecomus-products-carousel--elementor').find('.swiper').get(0).swiper;

				if( swiper ) {
					if( $this.hasClass( 'elementor-swiper-button-next' ) ) {
						swiper.slideNext();
					}

					if( $this.hasClass( 'elementor-swiper-button-prev' ) ) {
						swiper.slidePrev();
					}
				}
			});
		}
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

	initSwiper() {
		this.elements.$swiperContainer.find('.products').addClass('swiper-wrapper');
		this.elements.$swiperContainer.find('.product').addClass('swiper-slide');

		super.initSwiper();
	}

	onInit() {
        var self = this;
        super.onInit();
    }
}

class EcomusBrandsWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				button: '.ecomus-brands-filters .ecomus-brands-filters__button',
				item: '.ecomus-brands-filters__items',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$button: this.findElement( selectors.button ),
			$item: this.findElement( selectors.item ),
		};
	}

	changeActiveFilter( data ) {
		const $button     = this.elements.$button.filter( '[data-filter="' + data + '"]' ),
		      $item       = this.elements.$item.filter( '[data-filter="' + data + '"]' ),
		      $itemActive = this.elements.$item.siblings( '.active' ),
		      isActive    = $button.hasClass( 'active' );

		if ( isActive ) {
			return;
		}

		$button.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );

		if( data == 'all' ) {
			$itemActive.siblings().addClass( 'active' );
		} else {
			$item.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
		}
	}

	bindEvents() {
		this.elements.$button.on( {
			click: ( event ) => {
				event.preventDefault();

				this.changeActiveFilter( event.currentTarget.getAttribute( 'data-filter' ) );
			}
		} );
	}

	onInit( ...args ) {
        super.onInit( ...args );
    }
}

class EcomusStoreLocationsWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				content: '.ecomus-store-locations__content',
				embed: '.ecomus-store-locations__embed',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$content: this.findElement( selectors.content ),
			$embed: this.findElement( selectors.embed ),
		};
	}

	changeActiveTab( data ) {
		const $content     = this.elements.$content.filter( '[data-tab="' + data + '"]' ),
		      $embed       = this.elements.$embed.filter( '[data-tab="' + data + '"]' ),
		      isActive    = $content.hasClass( 'active' );

		if ( isActive ) {
			return;
		}

		$content.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
		$embed.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
	}

	bindEvents() {
		this.elements.$content.on( {
			click: ( event ) => {
				event.preventDefault();

				this.changeActiveTab( event.currentTarget.getAttribute( 'data-tab' ) );
			}
		} );
	}

	onInit( ...args ) {
        super.onInit( ...args );
    }
}

class EcomusTestimonialCarouselWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-testimonial-carousel--elementor'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	onInit( ...args ) {
		super.onInit( ...args );

		const settings = this.getElementSettings();
		var $selector = this.elements.$container;
		var options = {
            loop: settings.infinite == 'yes' ? true : false,
            autoplay: settings.autoplay == 'yes' ? true : false,
            speed: settings.speed ? settings.speed : 800,
            watchOverflow: true,
			watchSlidesVisibility: true,
			slidesPerView: 1,
			slidesPerGroup: 1,
            pagination: {
                el: $selector.find('.swiper-pagination').get(0),
                clickable: true
            },
			navigation: {
                nextEl: $selector.find('.elementor-swiper-button-next').get(0),
                prevEl: $selector.find('.elementor-swiper-button-prev').get(0),
            },
            on: {
                init: function () {
                    this.$el.css('opacity', 1);
                }
            },
        };

		if ( settings.autoplay == 'yes' ) {
			options.autoplay = {
                delay: settings.autoplay_speed,
                pauseOnMouseEnter: settings.pause_on_hover == 'yes' ? true : false,
				disableOnInteraction: false
            }
		}

		var thumbOptions = {};

		if ( settings.space_between.size ) {
			options.spaceBetween = settings.space_between.size;
			thumbOptions.spaceBetween = settings.space_between.size;
		}

		var $gallerySwiper = new Swiper( this.elements.$container.find('.ecomus-testimonial__gallery').get(0), options );
		var $thumbnailSwiper = new Swiper( this.elements.$container.find('.ecomus-testimonial__thumbnail').get(0), thumbOptions );

		$gallerySwiper.controller.control = $thumbnailSwiper;
    	$thumbnailSwiper.controller.control = $gallerySwiper;
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( 'activeItemIndex' === propertyName ) {
			this.swiper.slideToLoop( this.getEditSettings( 'activeItemIndex' ) - 1 );
		}
	}
}

class EcomusAccordionWidgetHandler extends elementorModules.frontend.handlers.Base {

	getDefaultSettings() {
		return {
			selectors: {
				tab: '.ecomus-accordion__title',
				panel: '.ecomus-accordion__content'
			},
			classes: {
				active: 'ecomus-tab--active',
				firstActive: 'ecomus-tab--first-active'
			},
			showFn: 'slideDown',
			hideFn: 'slideUp',
			autoExpand: false,
			toggleSelf: true,
			hidePrevious: true
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$tabs: this.findElement( selectors.tab ),
			$panels: this.findElement( selectors.panel )
		};
	}

	activateDefaultTab() {
		const settings = this.getSettings();

		if ( ! settings.autoExpand || 'editor' === settings.autoExpand && ! this.isEdit ) {
			return;
		}

		const defaultActiveTab = this.getEditSettings( 'activeItemIndex' ) || 1,
			originalToggleMethods = {
				showFn: settings.showFn,
				hideFn: settings.hideFn
			};

		this.setSettings( {
			showFn: 'show',
			hideFn: 'hide'
		} );

		this.changeActiveTab( defaultActiveTab );

		this.setSettings( originalToggleMethods );
	}

	changeActiveTab( tabIndex ) {
		const settings = this.getSettings(),
			$tab = this.elements.$tabs.filter( '[data-tab="' + tabIndex + '"]' ),
			$panel = this.elements.$panels.filter( '[data-tab="' + tabIndex + '"]' ),
			isActive = $tab.hasClass( settings.classes.active );

		if ( ! settings.toggleSelf && isActive ) {
			return;
		}

		if ( ( settings.toggleSelf || ! isActive ) && settings.hidePrevious ) {
			this.elements.$tabs.removeClass( settings.classes.active );
			this.elements.$tabs.parent().removeClass( settings.classes.active );
			this.elements.$panels.removeClass( settings.classes.active )[settings.hideFn]();
		}

		if ( ! settings.hidePrevious && isActive ) {
			$tab.removeClass( settings.classes.active );
			$tab.parent().removeClass( settings.classes.active );
			$panel.removeClass( settings.classes.active )[settings.hideFn]();
		}

		if ( ! isActive ) {
			$tab.addClass( settings.classes.active );
			$tab.parent().addClass( settings.classes.active );
			$panel.addClass( settings.classes.active )[settings.showFn]();
		}
	}

	bindEvents() {
		this.elements.$tabs.on( {
			keydown: ( event ) => {
				if ( 'Enter' !== event.key ) {
					return;
				}

				event.preventDefault();

				this.changeActiveTab( event.currentTarget.getAttribute( 'data-tab' ) );
			},
			click: ( event ) => {
				event.preventDefault();

				this.changeActiveTab( event.currentTarget.getAttribute( 'data-tab' ) );
			},
		} );
	}

	onInit() {
		super.onInit();

		this.activateDefaultTab();

		const settings = this.getSettings();
		this.elements.$tabs.each((index, tab) => {
			const $tab = jQuery(tab)
			if ($tab.hasClass(settings.classes.firstActive)) {
				$tab.addClass(settings.classes.active);
				$tab.parent().addClass( settings.classes.active );
				$tab.siblings().addClass( settings.classes.active )[settings.showFn]();
			}
		});
	}
}

class EcomusNavigationBarHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-navigation-bar'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	stickyNavigationBar() {
		var navbar = this.elements.$container,
			wrapper = navbar.closest('.e-con-inner'),
			sticky = navbar.offset().top,
			top = 0;

		if ( jQuery(document.body).find('.site-header__desktop').hasClass('ecomus-header-sticky') ) {
			var headerHeight = jQuery(document.body).find('.site-header__desktop .header-contents').outerHeight();

			sticky = sticky - headerHeight;
			top = top + headerHeight;
		}

		if ( jQuery(document.body).find('#wpadminbar').length ) {
			var adminHeight = jQuery(document.body).find('#wpadminbar').outerHeight();

			sticky = sticky - adminHeight;
			top = top + adminHeight;
		}

		jQuery(window).on( 'scroll', function () {
			if ( jQuery(document.body).find('.site-header__desktop').hasClass('headroom--pinned') || jQuery(document.body).find('.site-header__desktop').hasClass('minimized') ) {
				navbar.css('--em-navigation-bar-top', top + 'px');
			} else {
				navbar.css('--em-navigation-bar-top', '32px');
			}

			if ( jQuery(window).scrollTop() <= wrapper.outerHeight() ) {
				if ( jQuery(window).scrollTop() >= sticky ) {
					navbar.addClass( "sticky-navigation-bar" );
				} else {
					navbar.removeClass( "sticky-navigation-bar" );
					navbar.removeAttr('style');
				};

			} else {
				navbar.removeClass( "sticky-navigation-bar" );
				navbar.removeAttr('style');
				return;
			}

        });

		jQuery( '.ecomus-navigation-bar__title' ).on( 'click', 'a', function(e) {

			var value = jQuery( this ).attr( 'href' );

			if( jQuery(value).length ) {
				e.preventDefault();

				jQuery(value).addClass('em-navigation-bar-active').siblings().removeClass('em-navigation-bar-active');

				jQuery( '.ecomus-navigation-bar__title' ).removeClass( 'active' );
				jQuery( this ).closest('.ecomus-navigation-bar__title').addClass( 'active' );

				jQuery('html, body').animate({
					scrollTop: jQuery(value).offset().top - top
				}, 1000);

				return false;
			}

		});
	}

	onInit() {
		super.onInit();
		this.stickyNavigationBar();
	}
}

class EcomusMarqueeWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-elementor--marquee',
				inner: '.ecomus-marquee--inner',
				items: '.ecomus-marquee--original',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container ),
			$inner: this.$element.find( selectors.inner ),
			$items: this.$element.find( selectors.items ),
		};
	}

	dulicateItems() {
		const settings = this.getElementSettings(),
			  $inner = this.elements.$inner,
			  $items = this.elements.$items;

		$inner.imagesLoaded(function () {
			let item, amount = ( parseInt( Math.ceil( jQuery( window ).width() / $items.outerWidth( true ) ) ) || 0 ) + 1,
				speed = 1 / parseFloat( settings.speed ) * ( $items.outerWidth( true ) / 350 );

			$inner.css( '--em-marquee-speed', speed + 's' );

			for ( let i = 1; i <= amount; i++ ) {
				item = $items.clone();
				item.addClass( 'ecomus-marquee--duplicate em-absolute' );
				item.removeClass( 'ecomus-marquee--original' );
				item.css( '--em-marquee-index', String(i) );

				item.appendTo( $inner );
			}
		});
	}

	onInit( ...args ) {
		super.onInit( ...args );

		this.dulicateItems();
	}
}

class EcomusProductGridHandler extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                container: '.ecomus-product-grid'
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');

        return {
            $container: this.$element.find(selectors.container)
        };

    }

    loadProductsGrid() {
		var self = this;

        // Load Products
        this.elements.$container.on('click', 'a.ajax-load-products', function (e) {
            e.preventDefault();

            var $el = jQuery(this);

            if ($el.hasClass('loading')) {
                return;
            }

            $el.addClass('loading');

            self.loadProducts($el);
        });
    };

    loadProductsInfinite() {
		var self = this;
		if ( ! this.elements.$container.find( '.woocommerce-pagination' ).hasClass( 'woocommerce-pagination--infinite' ) ) {
			return;
		}

		var $el = this.elements.$container.find('.woocommerce-pagination-button'),
			waiting = false;

			jQuery(window).on('scroll', function () {
				if (waiting || !$el.length || !$el.is(':visible')) {
					return;
				}

				var buttonOffset = $el.offset().top,
					windowHeight = jQuery(window).height(),
					scrollPosition = jQuery(window).scrollTop();

				if (scrollPosition + windowHeight >= buttonOffset) {
					waiting = true;

					if (!$el.hasClass('loading')) {
						$el.addClass('loading');
						self.loadProducts($el);
					}

					setTimeout(function () {
						waiting = false;

						if (!$el.is(':visible')) {
							jQuery(window).off('scroll');
						}
					}, 300);
				}
			});

    };

	loadProducts($el) {
		var ajax_url = '';
		if (typeof ecomusData !== 'undefined') {
			ajax_url = ecomusData.ajax_url;
		} else if (typeof wc_add_to_cart_params !== 'undefined') {
			ajax_url = wc_add_to_cart_params.wc_ajax_url;
		}

        const settings = this.getElementSettings();

		if( ! ajax_url ) {
			return;
		}

		jQuery.post(
			ajax_url.toString().replace(  '%%endpoint%%', 'ecomus_elementor_load_products' ),
			{
				page: $el.attr('data-page'),
				settings: settings
			},
			function (response) {
				if ( ! response ) {
					return;
				}

				$el.removeClass('loading');

				var $data = jQuery(response.data),
					$products = $data.find('li.product'),
					$container = $el.closest('.ecomus-product-grid'),
					$grid = $container.find('ul.products'),
					$page_number = $data.find('.page-number').data('page');

				// If has products
				if ($products.length) {
					$products.addClass( 'em-fadeinup em-animated' );

					let delay = 0.5;
					$products.each( function( i, product ) {
						jQuery(product).css( '--em-fadeinup-delay', delay + 's' );
						delay = delay + 0.1;
					});

					$grid.append($products);

					if ($page_number == '0') {
						$el.remove();
					} else {
						$el.attr('data-page', $page_number);
					}
				}

				if( response.success ) {
					if( $products.hasClass( 'em-animated' ) ) {
						setTimeout( function() {
							$products.removeClass( 'em-animated' );
						}, 10 );
					}
				}

				jQuery(document.body).trigger('ecomus_products_loaded', [$products, true]);
			}
		);
	}

    onInit() {
        var self = this;
        super.onInit();

        self.loadProductsGrid();
        self.loadProductsInfinite();
    }
}

class EcomusImagesHotspotCarouselWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-carousel--elementor .swiper';
		settings.selectors.product = '.ecomus-images-hotspot__product';
		settings.selectors.button = '.ecomus-images-hotspot__button';
		settings.selectors.popover_content = '.popover__content.images-hotspot-content';

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

		if( elementSettings.slidesperview_auto == 'yes' ) {
			settings.slidesPerView = 'auto';
			settings.freeMode = true;
		}

		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if ( elementSettings[ 'slidesperview_auto_' + breakpoint ] == 'yes' ) {
				settings.breakpoints[ elementorBreakpoints[breakpoint].value ].slidesPerView = 'auto';
				settings.breakpoints[ elementorBreakpoints[breakpoint].value ].freeMode = true;
			}
		});

		settings.on.resize = function () {
			var self = this;
			if( elementSettings.slidesperview_auto == 'yes' || elementSettings.slidesperview_auto_tablet == 'yes' || elementSettings.slidesperview_auto_mobile == 'yes' ) {
				var windowWidth = jQuery(window).width(),
				widthElement = jQuery( self.$el.closest( '.ecomus-slidesperview-auto--yes' ) ).width(),
				spacing = ( windowWidth - widthElement ) / 2;

				jQuery( self.$el.closest( '.ecomus-carousel--slidesperview-auto' ) ).css( '--slidesperview-auto-spacing', '-' + spacing + 'px' );
			}
		}

		return settings;
	}

	imagesHotspotHandle() {
		const selectors = this.getSettings('selectors');

		var product = this.$element.find( selectors.product ),
			button = this.$element.find( selectors.button ),
			popover_content = this.$element.find( selectors.popover_content );

		button.on( 'click', function (e) {
			e.preventDefault();

			jQuery(this).closest( '.ecomus-images-hotspot__item' ).siblings().find( '.ecomus-images-hotspot__product' ).removeClass( 'active');
			jQuery(this).closest( '.ecomus-images-hotspot__product' ).toggleClass( 'active' ).siblings().removeClass( 'active');

			if( jQuery(this).closest( '.ecomus-images-hotspot__product' ).hasClass('active' ) ) {
				jQuery(this).closest( '.ecomus-carousel--elementor' ).addClass( 'hotspot-active' );
			} else {
				jQuery(this).closest( '.ecomus-carousel--elementor' ).removeClass( 'hotspot-active' );
			}

			var clone = jQuery(this).siblings( '.ecomus-images-hotspot__product-inner' ).clone().html();

			popover_content.html( clone );
        });

        jQuery( document.body ).on('click', function (evt) {
			if (jQuery( evt.target ).closest( product ).length > 0) {
                return;
            }

			product.closest( '.ecomus-carousel--elementor' ).removeClass( 'hotspot-active' );
            product.removeClass('active');
        });
	}

	onInit() {
		super.onInit();

		this.imagesHotspotHandle();

		jQuery( window ).on( 'resize', function () {
			if( jQuery( window ).width() > 767 ) {
				jQuery( '#images-hotspot-popover .popover__button-close' ).trigger('click');
			}
		});
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( ( propertyName === 'panel' || 'activeItemIndex' === propertyName ) && this.getEditSettings('panel').activeSection ) {
			if( this.getEditSettings('panel').activeSection.match(/\d+/) ) {
				this.swiper.slideToLoop( this.getEditSettings('panel').activeSection.match(/\d+/)[0] - 1 );
			}
		}
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

class EcomusTestimonialCarousel2WidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-carousel--elementor';
		settings.selectors.swiperArrow = this.$element.find('.swiper-button').get(0);

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

		settings.navigation.nextEl = this.$element.find('.elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.$element.find('.elementor-swiper-button-prev').get(0);

		if( elementSettings.slidesperview_auto == 'yes' ) {
			settings.slidesPerView = 'auto';
			settings.freeMode = true;
		}

		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if ( elementSettings[ 'slidesperview_auto_' + breakpoint ] == 'yes' ) {
				settings.breakpoints[ elementorBreakpoints[breakpoint].value ].slidesPerView = 'auto';
				settings.breakpoints[ elementorBreakpoints[breakpoint].value ].freeMode = true;
			}
		});

		settings.on.resize = function () {
			var self = this;

			if( elementSettings.slidesperview_auto == 'yes' || elementSettings.slidesperview_auto_tablet == 'yes' || elementSettings.slidesperview_auto_mobile == 'yes' ) {
				var windowWidth = jQuery(window).width(),
				widthElement = jQuery( self.$el.closest( '.e-con-inner' ) ).width(),
				spacing = ( windowWidth - widthElement ) / 2;

				jQuery( self.$el.closest( '.ecomus-carousel--slidesperview-auto' ) ).css( '--slidesperview-auto-spacing', '-' + spacing + 'px' );
			}
		}

		return settings;
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( 'activeItemIndex' === propertyName ) {
			this.swiper.slideToLoop( this.getEditSettings( 'activeItemIndex' ) - 1 );
		}
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

class EcomusImageCarouselWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings        = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-image-carousel .ecomus-image-carousel__swiper';

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

		if( elementSettings.slidesperview_auto == 'yes' ) {
			settings.slidesPerView = 'auto';
		}

		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if ( elementSettings[ 'slidesperview_auto_' + breakpoint ] == 'yes' ) {
				settings.breakpoints[ elementorBreakpoints[breakpoint].value ].slidesPerView = 'auto';
			}
		});

		settings.on.resize = function () {
			var self = this;
			if( elementSettings.slidesperview_auto == 'yes' || elementSettings.slidesperview_auto_tablet == 'yes' || elementSettings.slidesperview_auto_mobile == 'yes' ) {
				var windowWidth = jQuery(window).width(),
				widthElement = jQuery( self.$el.closest( '.ecomus-slidesperview-auto--yes' ) ).width(),
				spacing = ( windowWidth - widthElement ) / 2;

				jQuery( self.$el.closest( '.ecomus-carousel--slidesperview-auto' ) ).css( '--slidesperview-auto-spacing', '-' + spacing + 'px' );
			}
		}

		return settings;
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( 'activeItemIndex' === propertyName ) {
			this.swiper.slideToLoop( this.getEditSettings( 'activeItemIndex' ) - 1 );
		}
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

class EcomusCountDownWidgetHandler extends elementorModules.frontend.handlers.Base {

	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-countdown'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getCountDownInit() {
		this.elements.$container.ecomus_countdown();
	}

	onInit() {
		super.onInit();
		this.getCountDownInit();
	}
}

class EcomusButtonCarouselWidgetHandler extends elementorModules.frontend.handlers.Base {

	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-button-carousel'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getButtonSwiperInit() {
		const settings = this.getElementSettings();

		var options = {
			slidesPerView: settings.slides_per_view,
			pagination: {
                el: this.elements.$container.find('.swiper-pagination').get(0),
                clickable: true
            },
		}

		if ( settings.space_between.size ) {
			options.spaceBetween = settings.space_between.size;
		}

		new Swiper(this.elements.$container.get(0), options);
	}

	onInit() {
		super.onInit();

		this.getButtonSwiperInit();
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( 'activeItemIndex' === propertyName ) {
			this.swiper.slideToLoop( this.getEditSettings( 'activeItemIndex' ) - 1 );
		}
	}
}

class EcomusTabsElementorWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				tab: '.ecomus-tab--elementor',
				item: '.ecomus-tab-item--elementor',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$tab: this.findElement( selectors.tab ),
			$item: this.findElement( selectors.item ),
		};
	}

	changeActiveTab( data ) {
		const $tab  = this.elements.$tab.filter( '[data-tab="' + data + '"]' ),
		      $item = this.elements.$item.filter( '[data-tab="' + data + '"]' );

		if ( $tab.attr( 'data-active' ) == true ) {
			return;
		}

		$tab.attr( 'data-active', 'true' ).siblings( '[data-active="true"]' ).attr( 'data-active', 'false' );
		$item.siblings( '[data-active="true"]' ).attr( 'data-active', 'waiting' );

		setTimeout( function() {
			$item.attr( 'data-active', 'true' );
			$item.parent().find( '[data-active="waiting"]' ).attr( 'data-active', 'false' );
		}, 400);
	}

	bindEvents() {
		this.elements.$tab.on( {
			click: ( event ) => {
				event.preventDefault();

				this.changeActiveTab( event.currentTarget.getAttribute( 'data-tab' ) );
			}
		} );
	}

	onInit( ...args ) {
        super.onInit( ...args );
    }
}

class EcomusProductTabsGridWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				tab: '.ecomus-product-tabs-grid__heading span',
				panel: '.ecomus-product-tabs-grid__item',
				products: 'ul.products',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$tabs: this.findElement( selectors.tab ),
			$panels: this.findElement( selectors.panel ),
			$products: this.findElement( selectors.products ),
		};
	}

	activateDefaultTab() {
		const defaultActiveTab = this.getEditSettings( 'activeItemIndex' ) || 1;

		if ( this.isEdit ) {
			jQuery( document.body ).trigger( 'ecomus_products_loaded', [this.elements.$products.find( 'li.product' ), false] );
		}

		this.changeActiveTab( defaultActiveTab );
	}

	changeActiveTab( tabIndex ) {
		if ( this.isActiveTab( tabIndex ) ) {
			return;
		}

		const $tab = this.getTab( tabIndex ),
			  $panel = this.getPanel( tabIndex );

		$tab.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );

		if ( $panel.length ) {
			$panel.siblings( '.active' ).removeClass( 'active' ).addClass( 'waiting' );

			setTimeout( function() {
				$panel.removeClass( 'no-active' ).addClass( 'active' );
				$panel.parent().find( '.waiting' ).removeClass( 'waiting' ).addClass( 'no-active' );
			}, 300);
		} else {
			this.loadNewPanel( tabIndex );
		}
	}

	isActiveTab( tabIndex ) {
		return this.getTab( tabIndex ).hasClass( 'active' );
	}

	hasTabPanel( tabIndex ) {
		return this.getPanel( tabIndex ).length;
	}

	getTab( tabIndex ) {
		return this.elements.$tabs.filter( '[data-target="' + tabIndex + '"]' );
	}

	getPanel( tabIndex ) {
		return this.elements.$panels.filter( '[data-panel="' + tabIndex + '"]' );
	}

	loadNewPanel( tabIndex ) {
		if ( this.hasTabPanel( tabIndex ) ) {
			return;
		}

		const isEdit           = this.isEdit,
		      $tab             = this.elements.$tabs.filter( '[data-target="' + tabIndex + '"]' ),
		      $panelsContainer = this.elements.$panels.first().parent(),
		      atts             = $tab.data( 'atts' );

		if ( ! atts ) {
			return;
		}

		var self = this;

		var ajax_url = '';
		if (typeof ecomusData !== 'undefined') {
			ajax_url = ecomusData.ajax_url;
		} else if (typeof wc_add_to_cart_params !== 'undefined') {
			ajax_url = wc_add_to_cart_params.wc_ajax_url;
		}

		if( ! ajax_url ) {
			return;
		}

		ajax_url = ajax_url.toString().replace(  '%%endpoint%%', 'ecomus_get_products_tab' );

		$panelsContainer.addClass( 'loading' );

		jQuery.post( ajax_url, {
			action: 'ecomus_get_products_tab',
			atts  : atts,
		}, ( response ) => {
			if ( ! response.success ) {
				$panelsContainer.removeClass( 'loading' );
				return;
			}

			const $newPanel = this.elements.$panels.first().clone();

			$newPanel.html( response.data );
			$newPanel.attr( 'data-panel', tabIndex );
			$newPanel.removeClass( 'no-active' ).addClass( 'active' );
			$newPanel.appendTo( $panelsContainer );
			$newPanel.siblings( '.active' ).removeClass( 'active' ).addClass( 'no-active' );

			this.elements.$panels = this.elements.$panels.add( $newPanel );

			self.loadProductsInfinite();

			if ( ! isEdit ) {
				jQuery( document.body ).trigger( 'ecomus_products_loaded', [$newPanel.find( 'li.product' ), false] );
			}

			if( response.success ) {
				$panelsContainer.removeClass( 'loading' );
			}
		} );
	}

	loadMoreProducts() {
		var self = this;

		// Load Products
		this.$element.on( 'click', '.woocommerce-pagination a', function (e) {
			e.preventDefault();

			var $el = jQuery(this),
				$els = jQuery(this).closest( '.woocommerce-pagination-button' );

			if ( $els.hasClass('loading')) {
				return;
			}

			$els.addClass( 'loading' );

			self.loadProducts($el);
		});
	};

	loadProductsInfinite() {
		var self = this;
		if ( ! this.elements.$panels.find( '.woocommerce-pagination' ).hasClass( 'woocommerce-pagination--infinite' ) ) {
			return;
		}

		var $el = this.elements.$panels.find('.woocommerce-pagination-button'),
			waiting = false;

			jQuery(window).on('scroll', function () {
				if (waiting || !$el.length || !$el.is(':visible')) {
					return;
				}

				var buttonOffset = $el.offset().top,
					windowHeight = jQuery(window).height(),
					scrollPosition = jQuery(window).scrollTop();

				if (scrollPosition + windowHeight >= buttonOffset) {
					waiting = true;

					if (!$el.hasClass('loading')) {
						$el.addClass('loading');
						self.loadProducts($el);
					}

					setTimeout(function () {
						waiting = false;

						if (!$el.is(':visible')) {
							jQuery(window).off('scroll');
						}
					}, 300);
				}
			});

    };

	loadProducts($el) {
		var ajax_url = ecomusData.ajax_url.toString().replace('%%endpoint%%', 'ecomus_elementor_load_products' ),
			$panel = $el.closest( '.ecomus-product-tabs-grid__item' ).attr( 'data-panel' ),
			$settings = $el.closest( '.ecomus-product-tabs-grid' ).find( "span[data-target='" + $panel + "']" ).data( 'atts' );;

		if( ! ajax_url ) {
			return;
		}

		jQuery.post(
			ajax_url,
			{
				page: $el.attr( 'data-page' ),
				settings: $settings
			},
			function ( response ) {
				if ( ! response ) {
					return;
				}

				$el.closest( '.woocommerce-pagination-button' ).removeClass( 'loading' );

				var $data = jQuery( response.data ),
					$products = $data.find( 'li.product' ),
					$container = $el.closest( '.ecomus-product-tabs-grid__item' ),
					$grid = $container.find( 'ul.products' ),
					$page_number = $data.find( '.page-number' ).data( 'page' );

				if ( $products.length ) {
					$products.addClass( 'em-fadeinup em-animated' );

					let delay = 0.5;
					$products.each( function( i, product ) {
						jQuery(product).css( '--em-fadeinup-delay', delay + 's' );
						delay = delay + 0.1;
					});

					$grid.append($products);

					if ($page_number == '0') {
						$el.closest( '.woocommerce-pagination' ).remove();
					} else {
						$el.attr( 'data-page', $page_number );
					}
				}

				if( response.success ) {
					if( $products.hasClass( 'em-animated' ) ) {
						setTimeout( function() {
							$products.removeClass( 'em-animated' );
						}, 10 );
					}
				}

				jQuery(document.body).trigger( 'ecomus_products_loaded', [ $products, true ] );
			}
		);
	};



	bindEvents() {
		this.elements.$tabs.on( {
			click: ( event ) => {
				event.preventDefault();

				this.changeActiveTab( event.currentTarget.getAttribute( 'data-target' ) );
			}
		} );
	}

	onInit( ...args ) {
		super.onInit( ...args );

		this.activateDefaultTab();

		this.loadMoreProducts();
		this.loadProductsInfinite();
	}
}

class EcomusSlidesPerViewAutoCarouselWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-carousel--elementor .swiper';

		if( this.$element.find( '.ecomus-products-carousel--relative' ).length > 0 ) {
			settings.selectors.swiperArrow = this.$element.find('.ecomus-products-carousel--relative > .swiper-button').get(0);
		} else {
			settings.selectors.swiperArrow = this.$element.find('.swiper-navigation .swiper-button').get(0);
		}

		settings.selectors.paginationWrapper = this.$element.find('.swiper-pagination:not(.pagination-heading)').get(0);

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

		if( elementSettings.slidesperview_auto == 'yes' ) {
			settings.slidesPerView = 'auto';
			settings.freeMode = true;
		}

		Object.keys(elementorBreakpoints).forEach(breakpoint => {
			if ( elementSettings[ 'slidesperview_auto_' + breakpoint ] == 'yes' ) {
				settings.breakpoints[ elementorBreakpoints[breakpoint].value ].slidesPerView = 'auto';
				settings.breakpoints[ elementorBreakpoints[breakpoint].value ].freeMode = true;
			}
		});

		settings.pagination.el = this.$element.find('.swiper-pagination:not(.pagination-heading)').get(0);

		if( this.$element.find( '.ecomus-products-carousel--relative' ).length > 0 ) {
			settings.navigation.nextEl = this.$element.find('.ecomus-products-carousel--relative > .elementor-swiper-button-next').get(0);
            settings.navigation.prevEl = this.$element.find('.ecomus-products-carousel--relative > .elementor-swiper-button-prev').get(0);
		} else {
			settings.navigation.nextEl = this.$element.find('.swiper-navigation .elementor-swiper-button-next').get(0);
			settings.navigation.prevEl = this.$element.find('.swiper-navigation .elementor-swiper-button-prev').get(0);
		}

		settings.on.afterInit = function () {
			var $navigation = this.$el.closest( '.ecomus-carousel--elementor' ).find('.heading--carousel .swiper-button' ),
				$pagination = this.$el.closest( '.ecomus-carousel--elementor' ).find('.heading--carousel .swiper-pagination' );

			if( $navigation.length > 0 ) {
				if( this.isEnd == true && this.isBeginning == true ) {
					this.$el.closest( '.ecomus-carousel--elementor' ).find('.heading--carousel .elementor-swiper-button-prev' ).addClass( 'swiper-button-disabled swiper-button-lock' );
				} else {
					this.$el.closest( '.ecomus-carousel--elementor' ).find('.heading--carousel .elementor-swiper-button-prev' ).addClass( 'swiper-button-disabled' );
				}

				if( this.isEnd == true && this.isBeginning == true ) {
					this.$el.closest( '.ecomus-carousel--elementor' ).find('.heading--carousel .elementor-swiper-button-next' ).addClass( 'swiper-button-disabled swiper-button-lock' );
				}
			}

			if( $pagination.length > 0 ) {
				$pagination.addClass( this.pagination.$el.attr( 'class' ) ).html( this.pagination.$el.html() );
			}
		};

		settings.on.transitionStart = function () {
			var $buttonNext = this.$el.closest( '.ecomus-carousel--elementor' ).find('.heading--carousel .elementor-swiper-button-next' ),
				$buttonPrev = this.$el.closest( '.ecomus-carousel--elementor' ).find('.heading--carousel .elementor-swiper-button-prev' ),
				$pagination = this.$el.closest( '.ecomus-carousel--elementor' ).find('.heading--carousel .swiper-pagination' );

			if( $buttonPrev.length > 0 ) {
				if( this.isBeginning == true ) {
					$buttonPrev.addClass( 'swiper-button-disabled' );
				} else {
					if( $buttonPrev.hasClass( 'swiper-button-disabled' ) ) {
						$buttonPrev.removeClass( 'swiper-button-disabled' );
					}
				}
			}

			if( $buttonNext.length > 0 ) {
				if( this.isEnd == true ) {
					$buttonNext.addClass( 'swiper-button-disabled' );
				} else {
					if( $buttonNext.hasClass( 'swiper-button-disabled' ) ) {
						$buttonNext.removeClass( 'swiper-button-disabled' );
					}
				}
			}

			if( $pagination.length > 0 ) {
				$pagination.find( 'span' ).removeClass( 'swiper-pagination-bullet-active' );

				if( this.pagination && this.pagination.$el.find( '.swiper-pagination-bullet-active' ).length > 0 ) {
					var activeIndex = jQuery(this.pagination.$el.find( '.swiper-pagination-bullet-active' )[0]).data('bullet-index');
					$pagination.find( 'span[data-bullet-index="' + activeIndex + '"]' ).addClass( 'swiper-pagination-bullet-active' );
				}
			}
		};

		settings.on.resize = function () {
			var self = this;
			if( elementSettings.slidesperview_auto == 'yes' || elementSettings.slidesperview_auto_tablet == 'yes' || elementSettings.slidesperview_auto_mobile == 'yes' ) {
				var windowWidth = jQuery(window).width(),
					widthElement = jQuery( self.$el.closest( '.ecomus-slidesperview-auto--yes' ) ).width(),
					spacing = ( windowWidth - widthElement ) / 2;

				jQuery( self.$el.closest( '.ecomus-carousel--slidesperview-auto' ) ).css( '--slidesperview-auto-spacing', '-' + spacing + 'px' );
			}
		}

		return settings;
	}

	bindEvents() {
		if( this.$element.find('.heading--carousel .swiper-button' ).length > 0 ) {
			this.$element.find('.heading--carousel .swiper-button' ).on('click', function(e) {
				e.preventDefault();

				var $this = jQuery(this);

				const swiper = $this.closest('.ecomus-carousel--elementor').find('.swiper').get(0).swiper;

				if( swiper ) {
					if( $this.hasClass( 'elementor-swiper-button-next' ) ) {
						swiper.slideNext();
					}

					if( $this.hasClass( 'elementor-swiper-button-prev' ) ) {
						swiper.slidePrev();
					}
				}
			});
		}

		if( this.$element.find('.heading--carousel .swiper-pagination' ).length > 0 ) {
			this.$element.find('.heading--carousel .swiper-pagination' ).on( 'click', 'span', function (e) {
				e.preventDefault();

				var $this = jQuery(this),
					indexActive = $this.data( 'bullet-index' );

				const swiper = $this.closest('.ecomus-carousel--elementor').find('.swiper').get(0).swiper;

				swiper.slideTo( indexActive );
			});
		}

		jQuery(window).on( 'resize', function () {
			setTimeout( function () {
				if( jQuery('.heading--carousel .swiper-pagination' ).length > 0 && jQuery('.heading--carousel .swiper-pagination' ).closest('.ecomus-carousel--elementor').find('.swiper').get(0).swiper ) {
					if( this.$element.find( '.ecomus-products-carousel--relative' ).length > 0 ) {
						jQuery('.heading--carousel .swiper-pagination' ).html( jQuery('.heading--carousel .swiper-pagination' ).closest('.ecomus-carousel--elementor').find('.ecomus-products-carousel--relative .swiper-pagination').html() );
					} else {
						jQuery('.heading--carousel .swiper-pagination' ).html( jQuery('.heading--carousel .swiper-pagination' ).closest('.ecomus-carousel--elementor').find('.swiper-pagination').html() );
					}
				}
			}, 200 );
		});
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( 'activeItemIndex' === propertyName ) {
			this.swiper.slideToLoop( this.getEditSettings( 'activeItemIndex' ) - 1 );
		}
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

class EcomusLookBookProductsWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-lookbook-products',
				image: '.ecomus-lookbook-products__image',
				content: '.ecomus-lookbook-products__content',
				button: '.ecomus-lookbook-products__button',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container ),
			$image: this.$element.find( selectors.image ),
			$content: this.$element.find( selectors.content ),
			$button: this.$element.find( selectors.button ),
		};
	}

	getPinClick( $status = true ) {
		if ( ! $status ) {
			return;
		}

		var $gallery_wrapper = this.elements.$content.find('.ecomus-lookbook-products__inner'),
			$container = this.elements.$container;

		this.elements.$image.on( 'click', '.ecomus-lookbook-products__button-item', function() {
			jQuery( '.ecomus-lookbook-products__button-item' ).removeClass( 'clicked' );
			jQuery( this ).addClass( 'clicked' );

			if( ! $gallery_wrapper.hasClass('swiper') ) {
				return;
			}

			var dataID = jQuery( this ).data('id'),
				$slideToProduct = $gallery_wrapper.find('[data-id="' + dataID + '"]');

				if ( $container.hasClass('ecomus-lookbook__product-type--carousel') ) {
					$slideToProduct = $gallery_wrapper.find('.post-' + dataID );
				}

				if ( $slideToProduct.length ) {
					var index = $gallery_wrapper.find('.product').index( $slideToProduct );
					$gallery_wrapper.get(0).swiper.slideTo(index);
				}
		});
	}

	getPinHover( $status = true ) {
		if ( ! $status ) {
			return;
		}

		if ( ! this.elements.$container.hasClass('ecomus-lookbook__product-type--list') ) {
			return;
		}

		var $gallery_wrapper = this.elements.$content.find('.ecomus-lookbook-products__inner');

		this.elements.$image.on( 'mouseover', '.ecomus-lookbook-products__button-item', function() {
			var dataID = jQuery( this ).data('id'),
				$slideToProduct = $gallery_wrapper.find('[data-id="' + dataID + '"]');

				$gallery_wrapper.find('ul.products').addClass('has--hover');

				if ( $slideToProduct.length ) {
					$slideToProduct.addClass('is--hover');
				}
		}).on('mouseout', '.ecomus-lookbook-products__button-item', function () {
			$gallery_wrapper.find('ul.products').removeClass('has--hover');
			$gallery_wrapper.find('li.product').removeClass('is--hover');
        });
	}

	getSwiperInit() {
		const settings = this.getElementSettings();

		var $container = this.elements.$container,
			$selector = this.elements.$content,
			$image = this.elements.$image;

		if ( $container.hasClass('ecomus-lookbook__product-type--carousel') ) {
			$selector.find('.products').addClass('swiper-wrapper');
			$selector.find('.product').addClass('swiper-slide');
		}

		var options = {
			pagination: {
                el: $selector.find('.swiper-pagination').get(0),
                clickable: true
            },
			navigation: {
                nextEl: $selector.find('.swiper-button-next').get(0),
                prevEl: $selector.find('.swiper-button-prev').get(0),
            },
			on: {
				slideChange: function () {
					var $pointItem = $image.find('.ecomus-lookbook-products__button-item[data-index="' + this.activeIndex + '"]');

					$image.find('.ecomus-lookbook-products__button-item').removeClass('clicked');
					$pointItem.addClass('clicked');
				},
			}
		}

		return new Swiper($selector.find('.ecomus-lookbook-products__inner').get(0), options);
	}

	variationChange() {
		var $this = this,
			$container = this.elements.$container,
			$button = this.elements.$button;

		$container.on( 'change', 'select[name="variation_id"]', function (e) {
			e.preventDefault();

			var $product             = jQuery(this).closest( '.ecomus-lookbook-products__product' ),
			    image_origin         = $product.find( '.ecomus-lookbook-products__product-thumbnail a' ).data( 'image' ),
			    $image               = $product.find( '.ecomus-lookbook-products__product-thumbnail img' ),
			    $price               = $product.find( '.ecomus-lookbook-products__product-price .price:not(.price-new)' ),
			    variation_id         = jQuery(this).val(),
			    variation_attributes = jQuery("option:selected", this).data( 'attributes' ),
			    variation_price      = jQuery("option:selected", this).data( 'price' ),
			    variation_price_html = jQuery("option:selected", this).data( 'price_html' ),
			    variation_image      = jQuery("option:selected", this).data( 'image' );

			if( variation_attributes ) {
				$product.attr( 'data-active', true );
				$product.attr( 'data-price', variation_price );
				$image.attr( 'src', variation_image );
				$price.addClass( 'hidden' );
				if( $price.siblings( '.price-new' ).length > 0 ) {
					$price.siblings( '.price-new' ).html( variation_price_html );
				} else {
					$price.after( '<span class="price price-new">' + variation_price_html + '</span>' );
				}

				$product.attr( 'data-variation', JSON.stringify( {'type': 'variable', variation_id: variation_id, variation_attributes: variation_attributes} ) );

				jQuery(this).closest('.product-inner').find('.woocommerce-loop-product__link img').attr('src', variation_image);
				jQuery(this).closest('.product-inner').find('.woocommerce-loop-product__link img').attr('srcset', variation_image);
			} else {
				$product.attr( 'data-active', false );
                $product.attr( 'data-price', 0 );
				$image.attr( 'src', image_origin );
				$image.attr( 'srcset', image_origin );
				$price.siblings( '.price-new' ).remove();
				$price.removeClass( 'hidden' );
                $product.attr( 'data-variation', '' );
			}

			var $products = jQuery(this).closest( '.ecomus-lookbook-products__products' ),
				$product = $products.find( '.ecomus-lookbook-products__product' ),
				data = {},
				price = 0;

			$product.each( function( i, product ) {
				var product = jQuery( product );

				if( product.attr( 'data-active' ) == 'true' ) {
					if( product.attr( 'data-type' ) == 'variable' ) {
						if( product.attr( 'data-variation' ) ) {
							data[i] = JSON.parse( product.attr( 'data-variation' ) );
						}
					} else {
						data[i] = {'type': product.data( 'type' ), 'product_id': product.data( 'id' )};
					}

					price += parseFloat( product.attr( 'data-price' ) );
				}
			});

			if ( ! price ) {
				$button.addClass('disabled');
			} else {
				$button.removeClass('disabled');
			}

			$button.attr( 'data-products', JSON.stringify( data ) );
			$button.find( '.price' ).html( $this.formatPrice( price ) );
		});

		jQuery( window ).on( 'load', function (e) {
			e.preventDefault();
			$container.find( 'form.cart select' ).trigger('change');
		});
	}

	add_to_cart() {
		var $this = this,
			$button = this.elements.$button;

		$button.on( 'click', function( event ) {
			event.preventDefault();

			if ( $button.data('requestRunning') ) {
				return;
			}

			$button.data( 'requestRunning', true );
			$button.addClass( 'em-loading-spin loading' );

			var ajax_url = '';
			if (typeof ecomusData !== 'undefined') {
				ajax_url = ecomusData.ajax_url;
			} else if (typeof wc_add_to_cart_params !== 'undefined') {
				ajax_url = wc_add_to_cart_params.wc_ajax_url;
			}

			if( ! ajax_url ) {
				return;
			}

			jQuery.ajax({
				url: ajax_url.toString().replace(  '%%endpoint%%', 'ecomus_ajax_add_to_cart' ),
				method: 'POST',
				data: {
					action: 'ecomus_ajax_add_to_cart',
					data_products: $button.attr( 'data-products' ),
				},
				success: function (data) {
					if (typeof wc_add_to_cart_params !== 'undefined') {
						if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
							window.location = wc_add_to_cart_params.cart_url;
							return;
						}
					}

					if ( data ) {
						jQuery(document.body).trigger('wc_fragment_refresh');
					}

					$button.data( 'requestRunning', false );
				},
				complete: function () {
					jQuery(document.body).on( 'wc_fragments_refreshed', function () {
						$button.removeClass( 'em-loading-spin loading' );
						$this.openMiniCartPanel();
					});
				}
			});
		});
	}

	formatPrice( $number ) {
		var $container     = this.elements.$container,
		    data           = $container.data( 'price' ),
		    currency       = data.currency_symbol,
		    thousand       = data.thousand_sep,
		    decimal        = data.decimal_sep,
		    price_decimals = data.price_decimals,
		    currency_pos   = data.currency_pos,
		    n              = $number;

		if ( parseInt(price_decimals) > -1 ) {
			$number = $number.toFixed(price_decimals) + '';
			var x = $number.split('.');
			var x1 = x[0],
				x2 = x.length > 1 ? decimal + x[1] : '';

			if( thousand ) {
				var rgx = /(\d+)(\d{3})/;
				while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + thousand + '$2');
				}
			}

			n = x1 + x2
		}

		switch (currency_pos) {
			case 'left' :
				return '<span>' + currency + n + '</span>';
				break;
			case 'right' :
				return '<span>' + n + currency + '</span>';
				break;
			case 'left_space' :
				return '<span>' + currency + ' ' + n + '</span>';
				break;
			case 'right_space' :
				return '<span>' + n + ' ' + currency + '</span>';
				break;
		}
	}

	openMiniCartPanel() {
		if (typeof ecomusData.added_to_cart_notice === 'undefined') {
			return;
		}

		if (ecomusData.added_to_cart_notice.added_to_cart_notice_layout !== 'mini') {
			return;
		}

		var $cartPanel = jQuery( '#cart-panel' ),
			widthScrollBar = window.innerWidth - jQuery('#page').width();

		if( jQuery('#page').width() < 767 ) {
			widthScrollBar = 0;
		}
		jQuery(document.body).css({'padding-right': widthScrollBar, 'overflow': 'hidden'});

		$cartPanel.fadeIn();
		$cartPanel.addClass( 'offscreen-panel--open' );
		jQuery( document.body ).addClass( 'offcanvas-opened cart-panel-opened' );
	};

	onInit() {
		super.onInit();
		this.variationChange();
		this.add_to_cart();

		var $this = this,
			$container = this.elements.$container,
			swiper = this.getSwiperInit();

		if ( $container.hasClass('ecomus-lookbook__product-type--list') && jQuery( window ).width() > 1200 ) {
			swiper.disable();
			$this.getPinHover();
			$this.getPinClick( false );
		} else {
			$this.getPinClick();
			$this.getPinHover( false );
		}

		jQuery( window ).on( 'resize', function () {
			if ( $container.hasClass('ecomus-lookbook__product-type--list') ) {
				if ( jQuery( window ).width() < 1200 ) {
					swiper.enable();
					$this.getPinClick();
					$this.getPinHover( false );
				} else {
					swiper.disable();
					$this.getPinClick( false );
					$this.getPinHover();
				}
			}
		});
	}
}

class EcomusFlashSaleWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-carousel--elementor .swiper';
		settings.selectors.swiperArrow = this.$element.find('.swiper-button').get(0);
		settings.selectors.swiperWrapper = '.products';
		settings.selectors.slideContent = '.product';

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

		settings.navigation.nextEl = this.$element.find('.elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.$element.find('.elementor-swiper-button-prev').get(0);

		settings.on.resize = function () {
			var self = this,
				$productThumbnail =	this.$el.closest( '.ecomus-carousel--elementor' ).find('.product-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + 10 ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}
		}

		return settings;
	}

	initSwiper() {
		this.elements.$swiperContainer.find('.products').addClass('swiper-wrapper');
		this.elements.$swiperContainer.find('.product').addClass('swiper-slide');

		super.initSwiper();
	}

	onInit() {
        var self = this;
        super.onInit();
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

class EcomusImageHotspotWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-image-hotspot',
				product: '.ecomus-image-hotspot__product',
				button: '.ecomus-image-hotspot__button',
				popover_content: '.popover__content.image-hotspot-content',
			},
		};
	}

	imagesHotspotHandle() {
		const selectors = this.getSettings('selectors');

		var product = this.$element.find( selectors.product ),
			button = this.$element.find( selectors.button ),
			popover_content = this.$element.find( selectors.popover_content );

		button.on( 'click', function (e) {
			e.preventDefault();

			jQuery(this).closest( '.ecomus-image-hotspot__product' ).toggleClass( 'active' ).siblings().removeClass( 'active');

			var clone = jQuery(this).siblings( '.ecomus-image-hotspot__product-inner' ).clone().html();

			popover_content.html( clone );
        });

        jQuery( document.body ).on('click', function (evt) {
			if (jQuery( evt.target ).closest( product ).length > 0) {
                return;
            }

            product.removeClass('active');
        });
	}

	onInit() {
		super.onInit();

		this.imagesHotspotHandle();
	}
}

class EcomusIconBoxCarouselWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-carousel--elementor .swiper';
		settings.selectors.swiperArrow = this.$element.find('.swiper-button').get(0);

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

		settings.navigation.nextEl = this.$element.find('.elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.$element.find('.elementor-swiper-button-prev').get(0);
		settings.pagination.el = this.$element.find('.swiper-pagination').get(0);

		return settings;
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( 'activeItemIndex' === propertyName ) {
			this.swiper.slideToLoop( this.getEditSettings( 'activeItemIndex' ) - 1 );
		}
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

class EcomusFeaturedProductWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-featured-product',
				gallery: '.woocommerce-product-gallery',
				galleryWrapper: '.woocommerce-product-gallery__wrapper',
				thumbnails: '.ecomus-product-gallery-thumbnails',
				summary: '.entry-summary',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container ),
			$gallery: this.$element.find( selectors.gallery ),
			$galleryWrapper: this.$element.find( selectors.galleryWrapper ),
			$thumbnails: this.$element.find( selectors.thumbnails ),
			$summary: this.$element.find( selectors.summary ),
		};
	}

	initSwiper( $el, options ) {
		if( $el.length < 1 ) {
			return;
		}

		return new Swiper( $el.get(0), options );
	}

	enableSwiper( el ) {
		el.enable();
	}

	disableSwiper( el ) {
		el.disable();
	}

	galleryOptions( $el ) {
		var options = {
			loop: false,
			autoplay: false,
			speed: 800,
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
				},
			}
		};

		if( this.elements.$thumbnails.length > 0 ) {
			options.thumbs = {
				swiper: this.elements.$thumbnails.get(0).swiper,
			};
		}

		return options;
	}

	initGallery() {
		var $gallery = this.elements.$galleryWrapper;

		$gallery.addClass('woocommerce-product-gallery__slider swiper');
		$gallery.wrapInner('<div class="swiper-wrapper"></div>');
		$gallery.find('.swiper-wrapper').after('<span class="ecomus-svg-icon em-button-light ecomus-swiper-button swiper-button swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 11L0 5.5L5.5 0L6.47625 0.97625L1.9525 5.5L6.47625 10.0238L5.5 11Z" fill="currentColor"/></svg></span>');
		$gallery.find('.swiper-wrapper').after('<span class="ecomus-svg-icon em-button-light ecomus-swiper-button swiper-button swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 11L7 5.5L1.5 0L0.52375 0.97625L5.0475 5.5L0.52375 10.0238L1.5 11Z" fill="currentColor"/></svg></span>');
		$gallery.find('.woocommerce-product-gallery__image').addClass('swiper-slide');

		return this.initSwiper( $gallery, this.galleryOptions( $gallery ) );
	}

	thumbnailsOptions( $el ) {
		var options = {
			slidesPerView: 5,
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
				},
			},
		};

		if (this.elements.$container.hasClass('ecomus-featured-product__gallery--left')) {
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
		}

		return options;
	}

	initThumbnails() {
		var $thumbnails = this.elements.$thumbnails;

		$thumbnails.addClass('swiper');
		$thumbnails.wrapInner('<div class="woocommerce-product-thumbnail__nav swiper-wrapper"></div>');
		$thumbnails.find('.woocommerce-product-gallery__image').addClass('swiper-slide');

		return this.initSwiper( $thumbnails, this.thumbnailsOptions( $thumbnails ) );
	}

	productImageZoom() {
		if (typeof Drift === 'undefined') {
			return;
		}

		var $container = this.elements.$container,
			$gallery = this.elements.$galleryWrapper,
			$summary = this.elements.$summary,
			$zoom = jQuery( '<div class="ecomus-product-zoom-wrapper" />' );

		$summary.prepend( $zoom );

		var options = {
			containInline: true,
			paneContainer: $zoom.get(0),
			hoverBoundingBox: true,
			zoomFactor: 2,
		};

		$gallery.find( '.woocommerce-product-gallery__image' ).each( function() {
			var $this = jQuery(this),
				$image = $this.find( 'img' ),
				imageUrl = $this.find( 'a' ).attr('href');

			if( $this.hasClass('ecomus-product-video') || $this.data( 'zoom_status' ) == false ) {
				return;
			}

			$image.attr( 'data-zoom', imageUrl );

			new Drift( $image.get(0), options );
		});

		$summary.find('.variations_form').on( 'show_variation hide_variation', function () {
			var $selector = jQuery(this).closest( '.product-gallery-summary' ),
				$gallery = $selector.find( '.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image' ).eq(0),
				imageUrl = $gallery.find( 'a' ).attr( 'href' ),
				$image = $gallery.find( 'img' );

			$image.attr( 'data-zoom', imageUrl );
		});
	}

	descriptionMore() {
		var $summary = this.elements.$summary,
			$selector =  $summary.find( '.short-description__content' ),
			$line = ecomusData.product_description_lines,
			$height = parseInt( $selector.css( 'line-height' ) ) * $line;

		$selector.each( function () {
			var $currentHeight = jQuery(this).outerHeight();

			if( $currentHeight > $height ) {
				jQuery(this).siblings( '.short-description__more' ).removeClass( 'hidden' );
			}
		});

		jQuery(document.body).on( 'click', '.short-description__more', function(e) {
			e.preventDefault();

			var $this = jQuery(this),
				$settings = $this.data( 'settings' ),
				$more     = $settings.more,
				$less     = $settings.less;

			if( $this.hasClass( 'less' ) ) {
				$this.removeClass( 'less' );
				$this.text( $more );
				$this.siblings( '.short-description__content' ).removeAttr( 'style' );
			} else {
				$this.addClass( 'less' );
				$this.text( $less );
				$this.siblings( '.short-description__content' ).css( '-webkit-line-clamp', 'inherit' );
			}
		});
	}

	productVariation() {
        var $summary = this.elements.$summary,
			$countdown_variable_original = $summary.find( '.em-countdown-single-product' ).html();

		$summary.find('.variations_form').on( 'show_variation', function () {
            var $countdown_variable      = jQuery(this).closest( '.product-gallery-summary' ).find( '.em-countdown-single-product' ),
                variation_id             = jQuery(this).find( '.variation_id' ).val(),
                $countdown_variable_html = jQuery(this).find( '.variation-id-' + variation_id ).html();

			$countdown_variable.fadeOut().addClass( 'hidden' );

            if( $countdown_variable_html && variation_id !== '0' ) {
                $countdown_variable.html( $countdown_variable_html );
                $countdown_variable.fadeIn().removeClass( 'hidden' );
            }

			$countdown_variable.find('.ecomus-countdown').ecomus_countdown();
        });

        $summary.find('.variations_form').on( 'hide_variation', function () {
            var $countdown_variable = jQuery(this).closest( '.product-gallery-summary' ).find( '.em-countdown-single-product' );

            if( $countdown_variable_original ) {
				$countdown_variable.fadeOut().addClass( 'hidden' );
                $countdown_variable.html( $countdown_variable_original );
            }

			$countdown_variable.find('.ecomus-countdown').ecomus_countdown();
        });
    }

	onInit() {
		var self = this;
		super.onInit();

		self.descriptionMore();
		self.productVariation();
		this.elements.$gallery.imagesLoaded(function () {
			self.elements.$gallery.css( 'opacity', '1' );
			self.elements.$thumbnails.appendTo( self.elements.$gallery );

			self.initThumbnails();
			self.initGallery();
			self.productImageZoom();
		});
	}
}

class EcomusTestimonialCarousel3WidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-carousel--elementor';
		settings.selectors.swiperArrow = this.$element.find('.swiper-button').get(0);

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

		settings.navigation.nextEl = this.$element.find('.elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.$element.find('.elementor-swiper-button-prev').get(0);

		return settings;
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( 'activeItemIndex' === propertyName ) {
			this.swiper.slideToLoop( this.getEditSettings( 'activeItemIndex' ) - 1 );
		}
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

class EcomusProductTabsCarouselWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-product-tabs-carousel__item .swiper';
		settings.selectors.swiperWrapper = '.products';
		settings.selectors.slideContent = '.product';
		settings.selectors.swiperArrow = this.$element.find('.ecomus-product-tabs-carousel__item .swiper-button').get(0);
		settings.selectors.tab = '.ecomus-product-tabs-carousel__heading span';
		settings.selectors.panel = '.ecomus-product-tabs-carousel__item';
		settings.selectors.products = 'ul.products';

		return settings;
	}

	getDefaultElements() {
		const 	selectors = this.getSettings( 'selectors' ),
				elements = super.getDefaultElements();

		elements.$tabs = this.$element.find( selectors.tab );
		elements.$panels = this.$element.find( selectors.panel );
		elements.$products = this.$element.find( selectors.products );

		return elements;
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

		settings.navigation.nextEl = this.elements.$panels.find('.elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.elements.$panels.find('.elementor-swiper-button-prev').get(0);
		settings.pagination.el = this.elements.$panels.find('.swiper-pagination').get(0);

		settings.on.resize = function () {
			var self = this,
				$productThumbnail =	this.$el.closest( '.ecomus-product-tabs-carousel' ).find('.product-thumbnail');

			if( $productThumbnail.length > 0 ) {
				jQuery(this.$el).imagesLoaded(function () {
					var	heightThumbnails = $productThumbnail.outerHeight(),
						top = ( ( heightThumbnails / 2 ) + 15 ) + 'px';

					jQuery(self.navigation.$nextEl).css({ '--em-arrow-top': top });
					jQuery(self.navigation.$prevEl).css({ '--em-arrow-top': top });
				});
			}
		}

		return settings;
	}

	activateDefaultTab() {
		const defaultActiveTab = this.getEditSettings( 'activeItemIndex' ) || 1;

		if ( this.isEdit ) {
			jQuery( document.body ).trigger( 'ecomus_products_loaded', [this.elements.$products.find( 'li.product' ), false] );
		}

		this.changeActiveTab( defaultActiveTab );
	}

	changeActiveTab( tabIndex ) {
		if ( this.isActiveTab( tabIndex ) ) {
			return;
		}

		const $tab = this.getTab( tabIndex ),
			  $panel = this.getPanel( tabIndex );

		$tab.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );

		if ( $panel.length ) {
			$panel.siblings( '.active' ).removeClass( 'active' ).addClass( 'waiting' );

			setTimeout( function() {
				$panel.removeClass( 'no-active' ).addClass( 'active' );
				$panel.parent().find( '.waiting' ).removeClass( 'waiting' ).addClass( 'no-active' );
			}, 300);

			$panel.find( '.swiper-slide' ).removeAttr( 'inert' );
		} else {
			this.loadNewPanel( tabIndex );
		}
	}

	isActiveTab( tabIndex ) {
		return this.getTab( tabIndex ).hasClass( 'active' );
	}

	hasTabPanel( tabIndex ) {
		return this.getPanel( tabIndex ).length;
	}

	getTab( tabIndex ) {
		return this.elements.$tabs.filter( '[data-target="' + tabIndex + '"]' );
	}

	getPanel( tabIndex ) {
		return this.elements.$panels.filter( '[data-panel="' + tabIndex + '"]' );
	}

	loadNewPanel( tabIndex ) {
		if ( this.hasTabPanel( tabIndex ) ) {
			return;
		}

		const isEdit           = this.isEdit,
		      $tab             = this.elements.$tabs.filter( '[data-target="' + tabIndex + '"]' ),
		      $panelsContainer = this.elements.$panels.first().parent(),
		      atts             = $tab.data( 'atts' );

		if ( ! atts ) {
			return;
		}

		var ajax_url = '';
		if (typeof ecomusData !== 'undefined') {
			ajax_url = ecomusData.ajax_url;
		} else if (typeof wc_add_to_cart_params !== 'undefined') {
			ajax_url = wc_add_to_cart_params.wc_ajax_url;
		}

		if( ! ajax_url ) {
			return;
		}

		ajax_url = ajax_url.toString().replace(  '%%endpoint%%', 'ecomus_get_products_tab' );

		$panelsContainer.addClass( 'loading' );

		jQuery.post( ajax_url, {
			action: 'ecomus_get_products_tab',
			atts  : atts,
		}, ( response ) => {
			if ( ! response.success ) {
				$panelsContainer.removeClass( 'loading' );
				return;
			}

			const $newPanel = this.elements.$panels.first().clone();

			$newPanel.html( response.data );
			$newPanel.attr( 'data-panel', tabIndex );
			$newPanel.removeClass( 'no-active' ).addClass( 'active' );
			$newPanel.appendTo( $panelsContainer );
			$newPanel.siblings( '.active' ).removeClass( 'active' ).addClass( 'no-active' );

			this.elements.$panels = this.elements.$panels.add( $newPanel );

			if ( ! isEdit ) {
				jQuery( document.body ).trigger( 'ecomus_products_loaded', [$newPanel.find( 'li.product' ), false] );
			}

			if ( ! response.data ) {
				$panelsContainer.removeClass( 'loading' );
				return;
			}

			$newPanel.children().wrapAll( '<div class="swiper"></div>' );
			$newPanel.append( this.$element.find( '.navigation-original .swiper-button' ).clone() );
			$newPanel.append( this.$element.find( '.navigation-original .swiper-pagination' ).clone() );
			$newPanel.find( '.products' ).addClass( 'swiper-wrapper' );
			$newPanel.find( '.product' ).addClass( 'swiper-slide' );

			const 	Swiper = elementorFrontend.utils.swiper,
					settings = super.getSwiperSettings();

			settings.navigation.nextEl = $newPanel.find('.elementor-swiper-button-next').get(0);
			settings.navigation.prevEl = $newPanel.find('.elementor-swiper-button-prev').get(0);
			settings.pagination.el = $newPanel.find('.swiper-pagination').get(0);

			settings.on.resize = function () {
				var $productThumbnail =	$newPanel.find('.product-thumbnail');

				if( $productThumbnail.length > 0 ) {
					$newPanel.imagesLoaded(function () {
						var	heightThumbnails = $productThumbnail.outerHeight(),
							top = ( ( heightThumbnails / 2 ) + 15 ) + 'px';

						$newPanel.find('.elementor-swiper-button-next').css({ '--em-arrow-top': top });
						$newPanel.find('.elementor-swiper-button-prev').css({ '--em-arrow-top': top });
					});
				}
			}

			new Swiper( $newPanel.find( '.swiper' ), settings );

			if( response.success ) {
				$panelsContainer.removeClass( 'loading' );
			}
		} );
	}

	bindEvents() {
		super.bindEvents();

		this.elements.$tabs.on( {
			click: ( event ) => {
				event.preventDefault();

				this.changeActiveTab( event.currentTarget.getAttribute( 'data-target' ) );
			}
		} );
	}

	initSwiper() {
		this.elements.$panels.append( this.$element.find( '.navigation-original .swiper-button' ).clone() );
		this.elements.$panels.append( this.$element.find( '.navigation-original .swiper-pagination' ).clone() );
		this.elements.$panels.find( '.products' ).addClass( 'swiper-wrapper' );
		this.elements.$panels.find( '.product' ).addClass( 'swiper-slide' );

		super.initSwiper();
	}

	onInit() {
		super.onInit();
		this.activateDefaultTab();
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

class EcomusCodeDiscountWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				input: '.ecomus-code-discount__input',
				button: '.ecomus-code-discount__copy',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$input: this.findElement( selectors.input ),
			$button: this.findElement( selectors.button ),
		};
	}

	bindEvents() {
		super.bindEvents();

		this.elements.$button.on( {
			click: ( event ) => {
				event.preventDefault();

				jQuery(event.currentTarget).addClass( 'added' ).siblings( '.ecomus-code-discount__input' ).trigger('select');
				document.execCommand('copy');
			}
		});
	}

	onInit() {
		super.onInit();

		if( this.$element.closest( '.modal__content' ).length > 0 ) {
			this.$element.closest( '.modal__content' ).addClass( 'modal--has-code-discount' );
		}
	}
}

class EcomusToggleMobileWidgetHandler extends elementorModules.frontend.handlers.Base {
	bindEvents() {
		const settings = this.getElementSettings();

		var $title = this.$element.find('.ecomus-toggle-mobile__title');

		jQuery( window ).on('resize', function () {
			if ( jQuery( window ).width() < 767 && settings.toggle_menu == "yes") {
				$title.addClass( 'ecomus-toggle-mobile__title--toggle' );
				$title.next( '.ecomus-toggle-mobile__content' ).addClass( 'clicked' );
				$title.closest( '.ecomus-toggle-mobile__wrapper' ).addClass( 'dropdown' );

				if ( settings.toggle_status == "yes" ) {
					$title.addClass( 'active' );
					$title.siblings( '.ecomus-toggle-mobile__content' ).css( 'display', 'block' );
				} else {
					$title.removeClass( 'active' );
				}

			} else {
				$title.removeClass( 'ecomus-toggle-mobile__title--toggle' );
				$title.removeClass( 'active' );
				$title.siblings( '.ecomus-toggle-mobile__content' ).removeAttr('style');
				$title.next('.ecomus-toggle-mobile__content').removeClass('clicked');
				$title.next('.ecomus-toggle-mobile__content').removeAttr('style');
				$title.closest('.ecomus-toggle-mobile__wrapper').removeClass('dropdown');
			}
		}).trigger('resize');

		this.$element.on( 'click', '.ecomus-toggle-mobile__title--toggle', function ( e ) {
			e.preventDefault();

			if ( !$title.closest( '.ecomus-toggle-mobile__wrapper' ).hasClass( 'dropdown' ) ) {
				return;
			}

			jQuery(this).next('.clicked').stop().slideToggle();
			jQuery(this).toggleClass('active');
			return false;
		} );
	}
}

class EcomusVideoPopupWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-video-popup'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getPopupOption() {
		const 	options = {
					type: 'iframe',
	            	mainClass: 'mfp-fade',
		            removalDelay: 300,
		            preloader: false,
		            fixedContentPos: false,
		            iframe: {
						markup: '<div class="mfp-iframe-scaler">' +
								'<div class="mfp-close"></div>' +
								'<iframe class="mfp-iframe" frameborder="0" allow="autoplay"></iframe>' +
								'</div>',
		                patterns: {
		                    youtube: {
		                        index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

		                        id: 'v=', // String that splits URL in a two parts, second part should be %id%
		                        src: 'https://www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
		                    },
		                    vimeo: {
		                        index: 'vimeo.com/',
		                        id: '/',
		                        src: '//player.vimeo.com/video/%id%?autoplay=1'
		                    }
		                },

		                srcAction: 'iframe_src', // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".
		            }
				};

		return options;
	}

	getPopupInit() {
		this.elements.$container.find('.ecomus-video-popup__play').magnificPopup( this.getPopupOption() )
	}

	input_quantity() {
        jQuery( '.elementor-widget-ecomus-wc-cart-data-items' ).on( 'keyup', '.quantity .qty', function( e ) {
            if( jQuery(this).val() ) {
                jQuery(this).attr( 'value', jQuery(this).val() );
            } else {
                jQuery(this).attr( 'value', 0 );
            }
        });
    }

	onInit() {
		super.onInit();
		this.getPopupInit();
	}
}

class EcomusImageBeforeAfterWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.ecomus-image-before-after'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	changeImagesHandle() {
		const container = this.elements.$container;

        container.imagesLoaded( function () {
            container.find( '.box-thumbnail' ).imageslide();
        } );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.changeImagesHandle();
	}
}

class EcomusTestimonialCarousel4WidgetHandler extends elementorModules.frontend.handlers.CarouselBase {

	getDefaultSettings() {
		const settings = super.getDefaultSettings();

		settings.selectors.carousel = '.ecomus-carousel--elementor';
		settings.selectors.swiperArrow = this.$element.find('.swiper-button').get(0);

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

		settings.navigation.nextEl = this.$element.find('.elementor-swiper-button-next').get(0);
		settings.navigation.prevEl = this.$element.find('.elementor-swiper-button-prev').get(0);

		return settings;
	}

	onEditSettingsChange( propertyName ) {
		if( this.swiper === undefined ) {
			return;
		}

		if ( 'activeItemIndex' === propertyName ) {
			this.swiper.slideToLoop( this.getEditSettings( 'activeItemIndex' ) - 1 );
		}
	}

	bindEvents() {
		this.$element.find( '.ecomus-testimonial-carousel-4__positioning' ).on( 'click', '.ecomus-testimonial-carousel-4__positioning-item', function(){
			var $this = jQuery( this );

			if( $this.hasClass( 'active' ) ) {
				return;
			}

			$this.siblings().removeClass( 'active' );
			$this.addClass( 'active' );
			$this.closest( '.ecomus-testimonial-carousel-4__positioning' ).siblings( '.swiper' ).get(0).swiper.slideTo( $this.data( 'index' ) );
		});
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

class EcomusProductRecentlyViewedWidgetHandler extends elementorModules.frontend.handlers.CarouselBase {
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
		const 	self = this,
				elementSettings = this.getElementSettings();

		if( elementSettings.ajax_enable == 'yes' ) {
			self.elements.$swiperContainer.on( 'ecomus_recently_viewed_loaded', async function() {

				self.elements.$swiperContainer.addClass('swiper');
				self.elements.$swiperContainer.find('ul.products').addClass('swiper-wrapper');
				self.elements.$swiperContainer.find('.product').addClass('swiper-slide');

				if ( ! self.elements.$swiperContainer.length ) {
					return;
				}

				await self.initSwiper();

				if ( 'yes' === elementSettings.pause_on_hover ) {
					self.togglePauseOnHover( true );
				}
			});
		} else {
			self.elements.$swiperContainer.addClass('swiper');
			self.elements.$swiperContainer.find('ul.products').addClass('swiper-wrapper');
			self.elements.$swiperContainer.find('.product').addClass('swiper-slide');

			if ( ! self.elements.$swiperContainer.length ) {
				return;
			}

			await super.initSwiper();

			if ( 'yes' === elementSettings.pause_on_hover ) {
				self.togglePauseOnHover( true );
			}
		}
    }

	a11ySetSlideAriaHidden() {
		const 	self = this,
				elementSettings = this.getElementSettings();

		let status = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
		const currentIndex = 'initialisation' === status ? 0 : this.swiper?.activeIndex;

		if ('number' !== typeof currentIndex) {
			return;
		}

		if( elementSettings.ajax_enable == 'yes' ) {
			self.elements.$swiperContainer.on( 'ecomus_recently_viewed_loaded', function() {
				const 	swiperWrapperTransformXValue = self.getSwiperWrapperTranformXValue(),
						swiperWrapperWidth = self.elements.$swiperWrapper[0].clientWidth,
						$slides = self.elements.$swiperContainer.find(self.getSettings('selectors').slideContent);

				$slides.each((index, slide) => {
					const isSlideInsideWrapper = 0 <= slide.offsetLeft + swiperWrapperTransformXValue && swiperWrapperWidth > slide.offsetLeft + swiperWrapperTransformXValue;
					if (!isSlideInsideWrapper) {
						slide.setAttribute('aria-hidden', true);
						slide.setAttribute('inert', '');
					} else {
						slide.removeAttribute('aria-hidden');
						slide.removeAttribute('inert');
					}
				});
			});
		} else {
			const 	swiperWrapperTransformXValue = this.getSwiperWrapperTranformXValue(),
					swiperWrapperWidth = this.elements.$swiperWrapper[0].clientWidth,
					$slides = this.elements.$swiperContainer.find(this.getSettings('selectors').slideContent);

			$slides.each((index, slide) => {
				const isSlideInsideWrapper = 0 <= slide.offsetLeft + swiperWrapperTransformXValue && swiperWrapperWidth > slide.offsetLeft + swiperWrapperTransformXValue;
				if (!isSlideInsideWrapper) {
					slide.setAttribute('aria-hidden', true);
					slide.setAttribute('inert', '');
				} else {
					slide.removeAttribute('aria-hidden');
					slide.removeAttribute('inert');
				}
			});
		}
	}
}

jQuery( window ).on( 'elementor/frontend/init', () => {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-products-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-brands.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusBrandsWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-store-locations.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusStoreLocationsWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-testimonial-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusTestimonialCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-instagram.default', ( $element ) => {

		$element.imagesLoaded(function () {
			$element.find( '.ecomus-instagram__link' ).addClass( 'em-ratio' );
		});

		elementorFrontend.elementsHandler.addHandler( EcomusCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-icon-box-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusIconBoxCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-slides.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-accordion.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusAccordionWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-navigation-bar.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusNavigationBarHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-marquee.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusMarqueeWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-image-box-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusSlidesPerViewAutoCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-grid.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductGridHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-images-hotspot-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusImagesHotspotCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-testimonial-carousel-2.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusTestimonialCarousel2WidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-image-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusImageCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-countdown.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusCountDownWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-button-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusButtonCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-stores-tab.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusTabsElementorWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-image-content-slider.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-tabs-grid.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductTabsGridWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-categories-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusSlidesPerViewAutoCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-lookbook-products.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusLookBookProductsWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-category-tabs.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusTabsElementorWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-posts-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-flash-sale.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusFlashSaleWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-image-hotspot.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusImageHotspotWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-featured-product.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusFeaturedProductWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-testimonial-carousel-3.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusTestimonialCarousel3WidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-tabs-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductTabsCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-hero-images.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusMarqueeWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-code-discount.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusCodeDiscountWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-navigation-menu.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusToggleMobileWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-subscribe-group.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusToggleMobileWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-video-popup.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusVideoPopupWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-image-before-after.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusImageBeforeAfterWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-testimonial-carousel-4.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusTestimonialCarousel4WidgetHandler, { $element } );

	} );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-shoppable-video.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusCarouselWidgetHandler, { $element } );
	} );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-price-tables-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/ecomus-product-recently-viewed.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( EcomusProductRecentlyViewedWidgetHandler, { $element } );
	} );
} );