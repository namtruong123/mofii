(function ($) {
	'use strict';

	var ecomus = ecomus || {};

	ecomus.init = function () {
		if (ecomusAjaxSearch.header_ajax_search != 'yes') {
			return;
		}

        this.instanceSearch();
		this.focusSearch();
		this.activeTabs();
    }

	ecomus.focusSearch = function() {
		$(document.body).on('ecomus_modal_opened', function(event, $target) {
			if( $target.length && $target.hasClass('search-modal') ) {
				$target.find('.search-modal__field').trigger( 'focus' );
			}
		});

		$( '.header-search .header-search__field' ).on( 'focus', function() {
			var $field = $( this );

			if ( ! $field.closest('.header-search').length ) {
				return;
			}

			if($field.closest('.header-search__form').hasClass('searched')) {
				$field.closest('.header-search__form').addClass('actived');
			} else {
				$field.closest('.header-search').find('.header-search__products-suggest').addClass('header-suggest--open');
			}

		} );

		$( document.body ).on( 'click', 'div', function( event ) {
			var $target = $( event.target );

			if ( $target.is( '.header-search' ) || $target.closest( '.header-search' ).length || $target.closest( '.header-search__form' ).length ) {
				return;
			}

			$( '.header-search .header-search__products-suggest' ).removeClass( 'header-suggest--open' );
			$('.header-search__form').removeClass('actived');
		} );
	}

	ecomus.activeTabs = function() {
		$(document.body).on('ecomus_ajax_search_request_success', function(event, $results ) {
			var $tabHeader = $results.find('.results-tab-header'),
				$tabContent = $results.find('.results-tab-content'),
				$modalContent = $results.closest('.modal__content');

			$tabHeader.find('.results-tab-button:first-child').addClass('active');
			$tabContent.find('.result-tab-item:first-child').addClass('active');
			$modalContent.addClass('active');

			if ( ! $results.find('.results-heading a').length ) {
				$('#search-modal .modal__footer').addClass('hidden');
				$('#search-modal .modal__container').removeClass('show-btn-view-all');
			} else {
				var viewAllUrl = $results.find('.results-heading a').attr('href');

				$(document.body).find('.search-modal__footer-button a').attr('href', viewAllUrl);
				$('#search-modal .modal__footer').removeClass('hidden');
				$('#search-modal .modal__container').addClass('show-btn-view-all');
			}

			$tabHeader .on('click', '.results-tab-button', function(e) {
				e.preventDefault();
				$tabHeader.find('.results-tab-button').removeClass('active');
				$(this).addClass('active');

				var target = $(this).data('target');

				$tabContent.find('.result-tab-item').removeClass('active');
				$tabContent.find('.em-col-' + target).addClass('active');
				$tabContent.find('.em-col-' + target).closest('.em-col').addClass('active');
				$modalContent.removeClass('active');
			});
		});
	}

	ecomus.instanceSearch = function () {
		var xhr = null,
			searchCache = {};

		$('.em-instant-search__form').on('keyup', '.em-instant-search__field', function (e) {
			var valid = false,
			$search = $(this);

			if (typeof e.which == 'undefined') {
				valid = true;
			} else if (typeof e.which == 'number' && e.which > 0) {
				valid = !e.ctrlKey && !e.metaKey && !e.altKey;
			}

			if (!valid) {
				return;
			}

			if (xhr) {
				xhr.abort();
			}

			var $currentForm = $search.closest('.search-modal__form'),
				$currentContent = $search.closest('.modal__container'),
				$results = $search.closest('.search-modal').find('.modal__content-results'),
				$suggestion = $search.closest('.search-modal').find('.modal__content-suggestion');

			if ( $search.closest('form').hasClass('header-search__form') ) {
				$currentForm = $search.closest('.header-search__form'),
				$currentContent = $currentForm;
				$suggestion = $currentForm.find('.header-search__products-suggest');
				$results = $currentForm.find('.header-search__products-results');
			}

			$results.html('');

			if ( $search.closest('form').hasClass('header-search__form') ) {
				$currentForm = $search.closest('.header-search__form'),
				$currentContent = $currentForm;
				$suggestion = $currentForm.find('.header-search__products-suggest');
				$results = $currentForm.find('.header-search__products-results');
			}

			$results.html('');

			if ($search.val().length < 2) {
				$currentContent.removeClass('searching searched actived found-products found-no-product invalid-length show-btn-view-all');
				$results.hide();
				$suggestion.show();
				$('#search-modal .modal__footer').addClass('hidden');
			} else {
				$suggestion.removeClass('header-suggest--open');
			}

			search($currentForm);
		}).on('focusout', '.em-instant-search__field', function () {
			var $search = $(this),
				$currentContent = $search.closest('.modal__container');

			if ( $search.closest('form').hasClass('header-search__form') ) {
				$currentContent = $search.closest('.header-search__form');
			}

			if ($search.val().length < 2) {
				$currentContent.removeClass('searching searched actived found-products found-no-product invalid-length show-btn-view-all');
				$('#search-modal .modal__footer').addClass('hidden');
			}
		}).on('click', '.close-search-modal__results', function (e) {
			e.preventDefault();
			var $close = $(this);
			var $currentForm = $close.closest('.modal__container'),
				$suggestion = $currentForm.find('.modal__content-suggestion'),
				$results = $currentForm.find('.modal__content-results'),
				$searchField = $currentForm.find('.search-modal__field');

			if ( $close.closest('form').hasClass('header-search__form') ) {
				$currentForm = $close.closest('.header-search__form');
				$suggestion = $currentForm.find('.header-search__products-suggest');
				$results = $currentForm.find('.header-search__products-results');
				$searchField = $currentForm.find('.header-search__field');
			}

			$searchField.val('');
			$currentForm.removeClass('searching searched actived found-products found-no-product invalid-length show-btn-view-all');
			$currentForm.removeClass('searching searched actived found-products found-no-product invalid-length show-btn-view-all');

			$results.html('');
			$results.hide();
			$suggestion.show();
			$suggestion.removeClass('header-suggest--open');
			$('#search-modal .modal__footer').addClass('hidden');
		});

		/**
		 * Private function for search
		 */
		function search($currentForm) {
			var $search = $currentForm.find('.em-instant-search__field'),
				keyword = $search.val(),
				$results = $currentForm.closest('.modal__container').find('.modal__content-results'),
				$suggestion = $currentForm.closest('.modal__container').find('.modal__content-suggestion'),
				$currentContent = $currentForm.closest('.modal__container');

			if ( $search.closest('form').hasClass('header-search__form') ) {
				$results = $currentForm.find('.header-search__products-results'),
				$suggestion = $currentForm.find('.header-search__products-suggest'),
				$currentContent = $currentForm;
			}

			if (keyword.trim().length < 2) {
				$currentContent.removeClass('searching found-products found-no-product').addClass('invalid-length');
				return;
			}

			$currentContent.removeClass('found-products found-no-product').addClass('searching');

			var keycat = keyword;

			if (keycat in searchCache) {
				var result = searchCache[keycat];

				$currentContent.removeClass('searching');
				$currentContent.addClass('found-products');
				$suggestion.hide();
				$results.html(result.products).show();


				$(document.body).trigger('ecomus_ajax_search_request_success', [$results]);

				$currentContent.removeClass('invalid-length');
				$currentContent.addClass('searched actived');
			} else {
				var data = {
						'term': keyword,
						'ajax_search_number': ecomusAjaxSearch.header_search_number,
					},
					ajax_url = ecomusAjaxSearch.ajax_url.toString().replace('%%endpoint%%', 'ecomus_instance_search_form');

				xhr = $.ajax({
					url: ajax_url,
					method: 'post',
					data: data,
					success: function (response) {
						var $products = response.data;
						$suggestion.hide();
						$currentContent.removeClass('searching');
						$currentContent.addClass('found-products');
						$results.html($products).show();
						$currentContent.removeClass('invalid-length');

						$(document.body).trigger('ecomus_ajax_search_request_success', [$results]);

						// Cache
						searchCache[keycat] = {
							found: true,
							products: $products
						};

						$currentContent.addClass('searched actived');

					}
				});
			}
		}
	}

	/**
	 * Document ready
	 */
	$(function () {
		ecomus.init();
	});

})(jQuery);