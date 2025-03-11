(function($, _) {
	var EcomusProductsFilterWidget = function() {
		var self = this;

		self.ajax = null;

		// Init.
		self.init();

		// Methods.
		self.init = self.init.bind( self );
		self.initDropdowns = self.initDropdowns.bind( self );
		self.removeSliderInputs = self.removeSliderInputs.bind( self );
		self.sendAjaxRequest = self.sendAjaxRequest.bind( self );
		self.checkToggleCollapse = self.checkToggleCollapse.bind( self );

		// Events.
		$( '.products-filter-widget' )
			.on( 'input', '.products-filter__search-box', { widget: self }, self.searchTerms )
			.on( 'click', '.products-filter__option-name', { widget: self }, self.updatePrice )
			.on( 'click', '.products-filter__option-name, .products-filter__options .swatch', { widget: self }, self.toggleItem )
			.on( 'click', '.products-filter--collapsible .products-filter__option-toggler', { widget: self }, self.toggleCollapse )
			.on( 'change', 'input, select', { widget: self }, self.triggerItemChange )
			.on( 'click', '.reset-button', { widget: self }, self.resetFilters )
			.on( 'click', '.remove-filtered', { widget: self }, self.removeFiltered )
			.on( 'submit', 'form.ajax-filter', { widget: self }, self.ajaxSearch )
			.on( 'click', '.products-filter__filter-name', { widget: self }, self.collapseFilterWidget );

		$( document.body )
			.on( 'price_slider_create', self.addListenerToSlider )
			.on( 'ecomus_products_filter_change', { widget: self }, self.instantSearch )
			.on( 'ecomus_products_filter_request_success', self.updateURL )
			.on( 'ecomus_products_filter_request_success', { widget: self }, self.updateForm )
			.on( 'ecomus_products_filter_request_success', { widget: self }, self.viewMoreCats )
			.on( 'ecomus_products_filter_widget_updated', { widget: self }, self.initDropdowns )
			.on( 'ecomus_products_filter_widget_updated', { widget: self }, self.initSliders )
			.on( 'ecomus_products_filter_widget_updated', { widget: self }, self.updateActivatedItems );
	};

	EcomusProductsFilterWidget.prototype.init = function() {
		var self = this;

		self.initDropdowns();
		self.removeSliderInputs();
		self.viewMoreCats();
		self.collapseFilterWidgetMobile();
	}

	EcomusProductsFilterWidget.prototype.initDropdowns = function( event, form ) {
		if ( ! $.fn.select2 ) {
			return;
		}

		var $container = form ? $( form ) : $( '.products-filter-widget' ),
			direction = $( document.body ).hasClass( 'rtl' ) ? 'rtl' : 'ltr';

		$( 'select', $container ).each( function() {
			var $select = $( this ),
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

	EcomusProductsFilterWidget.prototype.initSliders = function( event, form ) {
		$( document.body ).trigger( 'init_price_filter' );

		event.data.widget.removeSliderInputs( form );
	}

	EcomusProductsFilterWidget.prototype.removeSliderInputs = function( form ) {
		var $container = form ? $( form ) : $( '.products-filter-widget' );

		$( '.widget_price_filter', $container ).find( 'input[type=hidden]' ).not( '[name=min_price], [name=max_price]' ).remove();
	}

	EcomusProductsFilterWidget.prototype.searchTerms = function( event ) {
		var $this = $( this ),
			term = $this.val().toLowerCase(),
			$list = $this.next( '.products-filter__options' ).find( '.products-filter__option' );

		if ( term ) {
			$list.hide().filter( function() {
				return $( '.name', this ).text().toLowerCase().indexOf( term ) !== -1;
			} ).show();
		} else {
			$list.show();
		}
	}

	EcomusProductsFilterWidget.prototype.toggleCollapse = function( event ) {
		var $option = $( this ).closest( '.products-filter__option' ),
			$children = $option.children( 'ul' );

		if ( ! $children.length ) {
			return;
		}

		event.preventDefault();
		$children.stop( true, true ).slideToggle();
		$option.toggleClass( 'active' );
	}

	EcomusProductsFilterWidget.prototype.checkToggleCollapse = function( $item ) {
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

	EcomusProductsFilterWidget.prototype.toggleItem = function( event ) {
		event.preventDefault();

		var $item = $( this ).closest( '.products-filter__option' ),
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
				$item.removeClass( 'selected' );
				$input.val( '' ).prop( 'disabled', true );

				if ( $filter.hasClass( 'ranges' ) ) {
					$input.next( 'input[type=hidden]' ).val( '' ).prop( 'disabled', true );

					var $box = $filter.find('.product-filter-box');

					$box.find('input[name="min_price"]').val( '' ).prop( 'disabled', true );
					$box.find('input[name="max_price"]').val( '' ).prop( 'disabled', true );
				}
			} else {
				$filter.find( '.products-filter__option.selected' ).removeClass( 'selected' );
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

		$( document.body ).trigger( 'ecomus_products_filter_change', [form] );
	}

	EcomusProductsFilterWidget.prototype.triggerItemChange = function() {
		var form = $( this ).closest( 'form' ).get( 0 );
		$( document.body ).trigger( 'ecomus_products_filter_change', [form] );
	}

	EcomusProductsFilterWidget.prototype.addListenerToSlider = function() {
		var $slider = $( '.products-filter-widget .price_slider.ui-slider' );

		$slider.each( function() {
			var $el = $( this ),
				form = $el.closest( 'form' ).get( 0 ),
				onChange = $el.slider( 'option', 'change' );

			$el.slider( 'option', 'change', function( event, ui ) {
				onChange( event, ui );

				$( document.body ).trigger( 'ecomus_products_filter_change', [form] );
			} );
		} );
	}

	EcomusProductsFilterWidget.prototype.resetFilters = function() {
		var $form = $( this ).closest( 'form' ),
			search = null,
			post_type = null;

		if( $form.find( 'input[name="s"]' ).length > 0 ) {
			search = $form.find( 'input[name="s"]' ).val();
		}

		if( $form.find( 'input[name="post_type"]' ).length > 0 ) {
			post_type = $form.find( 'input[name="post_type"]' ).val();
		}

		$form.get( 0 ).reset();
		$form.find( '.selected' ).removeClass( 'selected' );
		$form.find( 'select' ).val( '' ).prop('disabled', true);
		$form.find( ':input' ).not( '[type="button"], [type="submit"], [type="reset"]' )
			.val( '' )
			.filter('[type="hidden"],[name="min_price"], [name="max_price"]').prop('disabled', true);

		if( search ) {
			$form.find( 'input[name="s"]' ).val( search );
			$form.find( 'input[name="s"]' ).prop('disabled', false);
		}

		if( post_type ) {
			$form.find( 'input[name="post_type"]' ).val( post_type );
			$form.find( 'input[name="post_type"]' ).prop('disabled', false);
		}

		$form.trigger( 'submit' );

		$('#site-content ul.products').fadeIn();

		$( document.body ).trigger( 'ecomus_products_filter_reseted', [$form] );
	}

	EcomusProductsFilterWidget.prototype.removeFiltered = function( event ) {
		event.preventDefault();

		var self = event.data.widget,
			$el = $( this ),
			$widget = $el.closest( ' .products-filter-widget' ),
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

			$('#site-content ul.products').fadeIn();
		}
	}

	EcomusProductsFilterWidget.prototype.ajaxSearch = function( event ) {
		event.data.widget.sendAjaxRequest( this );

		return false;
	}

	EcomusProductsFilterWidget.prototype.instantSearch = function( event, form ) {
		var settings = $( form ).data( 'settings' );

		if ( ! settings.instant ) {
			return;
		}

		event.data.widget.sendAjaxRequest( form );
	}

	EcomusProductsFilterWidget.prototype.updateURL = function( event, response, url, form ) {
		var settings = $( form ).data( 'settings' );

		if ( ! settings.change_url ) {
			return;
		}

		if ( '?' === url.slice( -1 ) ) {
			url = url.slice( 0, -1 );
		}

		url = url.replace( /%2C/g, ',' );

		history.pushState( null, '', url );
	}

	EcomusProductsFilterWidget.prototype.updateForm = function( event, response, url, form ) {
		var $widget = $( form ).closest( '.widget.products-filter-widget' ),
			widgetId = $widget.attr( 'id' ),
			$newWidget = $( '#' + widgetId, response );

		if ( ! $newWidget.length ) {
			return;
		}

		$( '.filters', form ).html( $( '.filters', $newWidget ).html() );
		$( '.products-filter__activated', $widget ).html( $( '.products-filter__activated', $newWidget ).html() );

		$( document.body ).trigger( 'ecomus_products_filter_widget_updated', [form] );
	}

	EcomusProductsFilterWidget.prototype.sendAjaxRequest = function( form ) {
		var self = this,
			$form = $( form ),
			$container = $('#site-content .content-area ul.products'),
			$notice = $('#site-content .woocommerce-notices-wrapper'),
			$toolbar = $('#site-content .catalog-toolbar'),
			$active_filters = $('#site-content .catalog-toolbar__active-filters'),
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
			url += separator + $.param(params, true);
		}

		if ($container.hasClass('layout-carousel')) {
			window.location.href = url;
			return false;
		}

		if (!$container.length) {
			$container = $('#site-content .content-area ul.products');
			$('#main .woocommerce-info').replaceWith($container);
		}

		if ( self.ajax ) {
			self.ajax.abort();
		}

		$form.addClass('filtering');
		$container.addClass('loading').append('<li class="loading-screen"><span class="em-loading-spin"></span></li>');

		$(document.body).trigger('ecomus_products_filter_before_send_request', $container);

		self.ajax = $.get(url, function (response) {
			var $html = $(response),
				$products = $html.find('#site-content .content-area ul.products'),
				$pagination = $container.next('.woocommerce-pagination'),
				$nav = $html.find('.woocommerce-navigation, .woocomerce-pagination');

			if (!$products.length) {
				var $info = $html.find('#main .woocommerce-info, #main .wc-block-components-notice-banner');
				$pagination.fadeOut();
				$container.fadeOut();
				$toolbar.fadeOut();
				$notice.html($info);
				$notice.fadeIn();

			} else {
				var $nav = $products.next('.woocommerce-pagination'),
					$order = $('form.woocommerce-ordering');

				if ($nav.length) {
					if ($pagination.length) {
						$pagination.replaceWith($nav).fadeIn();
					} else {
						$container.after($nav);
					}
				} else {
					$pagination.fadeOut();
				}
				$notice.fadeOut();
				$container.fadeIn();
				$toolbar.fadeIn();
				$products.children().each(function (index, product) {
					$(product).css('animation-delay', index * 100 + 'ms');
				});

				// Modify the ordering form.
				$inputs.each(function () {
					var $input = $(this),
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
						$('<input type="hidden" name="' + name + '">').val(value).appendTo($order);
					}
				});

				// Modify the column selector.
				$('.products-toolbar .columns-switcher').replaceWith($html.find('.products-toolbar .columns-switcher'));

				// Replace result count.
				$('.products-toolbar .woocommerce-result-count').replaceWith($html.find('.products-toolbar .woocommerce-result-count'));

				// Replace tabs.
				$('.products-toolbar .products-tabs').replaceWith($html.find('.products-toolbar .products-tabs'));

				$container.replaceWith($products);
				$products.find('li.product').addClass('animated ecomusFadeInUp');

				$(document.body).trigger('ecomus_products_loaded', [$products.children(), false]); // appended = false
			}

			$form.removeClass('filtering');
			$(document.body).trigger('ecomus_products_filter_request_success', [response, url, form]);
		});
	}

	EcomusProductsFilterWidget.prototype.collapseFilterWidget = function( event ) {
		if ( ! $(this).closest( 'form' ).hasClass('has-collapse')) {
            return;
        }

		event.preventDefault();

		$(this).next().slideToggle();
		$(this).closest('.products-filter__filter').toggleClass('ecomus-active');
	}

	EcomusProductsFilterWidget.prototype.collapseFilterWidgetMobile = function( event ) {
		if ( ! $( '.products-filter-widget' ).find( 'form' ).hasClass('has-collapse')) {
            return;
        }

		if ( ! $( '.products-filter-widget' ).find( 'form' ).hasClass('products-filter__filter-section--collapse') ) {
			return;
		}

		var $this = $( '.products-filter-widget' ).find('.products-filter__filter');
		$(window).on('resize', function () {
			if ($(window).width() < 768) {
				$this.addClass('ecomus-active');
			} else {
				$this.removeClass('ecomus-active');
				$this.find('.products-filter__filter-control').removeAttr('style');
			}

		}).trigger('resize');

	}

	EcomusProductsFilterWidget.prototype.viewMoreCats = function() {
		var $widget = $('.products-filter-widget .product_cat'),
			$widgetChild = $('.products-filter-widget .products-filter--show-children-only'),
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
			$(this).hide();
			$widget.find('.show-less').show();
			$widget.find( '.ecomus-widget-product-cats-btn' ).addClass( 'btn-show-item' );
		});

		$widget.on('click', '.show-less', function () {
			$widget.find( 'ul.products-filter--list > .filter-list-item' ).not(':lt(' + catNumbers + ')').hide();
			$widget.find( 'ul.products-filter--checkboxes > .filter-checkboxes-item' ).not(':lt(' + catNumbers + ')').hide();
			$widgetChild.find( 'ul.products-filter--list li.selected .children > .filter-list-item' ).not(':lt(' + catNumbers + ')').hide();
			$widgetChild.find( 'ul.products-filter--checkboxes li.selected .children > .filter-checkboxes-item' ).not(':lt(' + catNumbers + ')').hide();
			$(this).hide();
			$widget.find('.show-more').show();
			$widget.find( '.ecomus-widget-product-cats-btn' ).removeClass( 'btn-show-item' );
		});
	}

	EcomusProductsFilterWidget.prototype.updateActivatedItems = function( event, form ) {
		var $container = form ? $( form ) : $( '.products-filter-widget' );

		if ( $container.find( '.products-filter__activated-items' ).html() && $container.find( '.products-filter__activated-items' ).html().trim() ) {
			$container.find('.products-filter__activated').removeClass( 'hidden' );
		} else {
			$container.find('.products-filter__activated').addClass( 'hidden' );
		}
	}

	EcomusProductsFilterWidget.prototype.updatePrice = function( event ) {
		event.preventDefault();

		var $item = $( this ).closest( '.products-filter__option' ),
			$filter = $item.closest( '.filter' ),
			$value = $item.data('value'),
			$box = $filter.find('.product-filter-box');

		if ( ! $filter.hasClass( 'price' ) ) {
			return;
		}

		$box.find('input[name="min_price"]').val($value.min);
		$box.find('input[name="max_price"]').val($value.max);
	}

	$( function() {
		new EcomusProductsFilterWidget();
	} )
})( jQuery, _ );
