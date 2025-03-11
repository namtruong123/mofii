(function ($) {
	'use strict';

	var ecomus = ecomus || {};

	ecomus.init = function () {
        this.foundVariation();
    }

    ecomus.foundVariation = function() {
        var $selector = $( '#product-variation-compare-modal' );

        if ( !$selector.length ) {
            return;
        }

        $selector.find( 'form.cart' ).on('change', 'select', function (e) {
            var $addToCart = $(this).closest( 'form.cart' ).find('.single_add_to_cart_button'),
                $addToCart_text = $addToCart.data('button_text'),
                optionSelected = $("option:selected", this),
                attributes = optionSelected.data('attributes'),
                stock = optionSelected.data('stock'),
                self = $(this);

            if( attributes !== undefined ) {
                self.closest('form.cart').find('.single_add_to_cart_button').removeClass('disabled');
                for( var key in attributes) {
                    self.closest('form.cart').find('input[name="'+ key +'"]').val( attributes[key] );
                }
            } else {
                self.closest('form.cart').find('.single_add_to_cart_button').addClass('disabled');
            }

            if( stock ) {
                if( stock.stock == 'out_of_stock' ) {
                    $addToCart.addClass('disabled');
                }

                $addToCart.text( stock.button_text );
            } else {
                $addToCart.text( $addToCart_text );
            }

        });
    }
	/**
	 * Document ready
	 */
	$(function () {
		ecomus.init();
	});

})(jQuery);