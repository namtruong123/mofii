(function ($) {
    'use strict';

	function freeShippingContent () {
		$( document.body ).on('wc_fragments_loaded wc_fragments_refreshed', function () {
			var $attributes = $('#ecomus-free-shipping-bar-attributes'),
				message		= $attributes.data('message'),
				percent		= $attributes.data('percent'),
				classes		= $attributes.data('classes');

			if ( $(document.body).hasClass('woocommerce-cart') ) {
				return;
			}

			if ( ! $attributes.length ) {
				$('.cart-panel .ecomus-free-shipping-bar').hide();
			} else {
				$('.cart-panel .ecomus-free-shipping-bar').show();
			}

			$('.ecomus-free-shipping-bar').css('--em-progress', percent);
			$('.ecomus-free-shipping-bar__message').html(message);
			$('.ecomus-free-shipping-bar').removeClass('em-is-success em-is-unreached em-progress-full').addClass(classes);
		});

		$(document.body).on('ecomus_off_canvas_closed added_to_cart', function (e) {
            $('.ecomus-free-shipping-bar').removeClass('ecomus-free-shipping-bar--preload');
        });


	}

	function updateFreeShippingCheckoutPage () {
		if (!$(document.body).hasClass('woocommerce-checkout')) {
			return;
		}

		var storageKey = 'selected_shipping_method';
		var selectedShippingMethod = localStorage.getItem(storageKey);

		$(document.body).on('added_to_cart', function (e) {
			$(document.body).trigger('update_checkout');
        });

		$(document.body).on('updated_checkout', function () {
			updateShippingMethod(storageKey, selectedShippingMethod);
		});

		$(document.body).on('change', 'input.shipping_method', function () {
			selectedShippingMethod = $(this).val();
			localStorage.setItem(storageKey, selectedShippingMethod);
		});

		$(document.body).on('added_to_cart', function () {
			selectedShippingMethod = null;
		});
	}

	function updateShippingMethod(storageKey, selectedShippingMethod) {
		var freeShipping = $('input.shipping_method[value*="free_shipping"]');

		if (freeShipping.length) {
			if (!selectedShippingMethod || !$('input.shipping_method[value="' + selectedShippingMethod + '"]').length) {
				freeShipping.prop("checked", true).trigger("change");
				selectedShippingMethod = freeShipping.val();
				localStorage.setItem(storageKey, selectedShippingMethod);
			}
		}

		if (selectedShippingMethod) {
			var savedMethod = $('input.shipping_method[value="' + selectedShippingMethod + '"]');
			if (savedMethod.length) {
				savedMethod.prop("checked", true);
			}
		}
	}

    /**
     * Document ready
     */
    $(function () {
		freeShippingContent();
		updateFreeShippingCheckoutPage();
    });

})(jQuery);