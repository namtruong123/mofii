(function ($) {
	'use strict';

	var ecomus = ecomus || {};

	ecomus.init = function () {
        this.stickyAddToCart();
        this.addToCartFormScroll();
        this.changeAttributesData();

        $(document.body).on('ecomus_off_canvas_closed ecomus_modal_closed ecomus_popover_closed', function (e) {
            ecomus.stickyAddToCart();
        });
    }

    ecomus.stickyAddToCart = function() {
        var $selector = $( '#ecomus-sticky-add-to-cart' );
        if ( !$selector.length ) {
            return;
        }

        var headerHeight = 0;

        if ( $(document.body).hasClass( 'admin-bar' ) ) {
            headerHeight += 32;
        }
        function stickyATCToggle() {
            if( ! $('div.product').find( 'form.cart' ).length ) {
                return;
            }
            
            var cartHeight = $('div.product').find( 'form.cart' ).offset().top + $('div.product').find( 'form.cart' ).outerHeight() - headerHeight;

            if ( window.scrollY > cartHeight ) {
                $selector.addClass( 'open' );
                $(document.body).addClass('ecomus-atc-sticky-height-open');
            } else {
                $selector.removeClass( 'open' );
                $(document.body).removeClass('ecomus-atc-sticky-height-open');
            }

        }

        $(window).on( 'scroll', function () {
            stickyATCToggle();
        } );

        $(window).on( 'resize', function () {
            var height = $selector.height();

            if( $(document.body).find( 'div.product' ).hasClass( 'outofstock' ) ) {
                height = 0;
            }

            $(document.body).css('--em-atc-sticky-height', height + 'px');
        } ).trigger('resize');
    }

    ecomus.addToCartFormScroll = function() {
        //sticky-atc-button
        $( '#ecomus-sticky-add-to-cart' ).on( 'click', '.em-add-to-cart-options', function ( event ) {
            event.preventDefault();

            $( 'html,body' ).stop().animate({
                scrollTop: $('div.product').find( 'form.cart' ).offset().top - 50
            },
            'slow');
        });
    }

    ecomus.changeAttributesData = function() {
        var $selector = $( '#ecomus-sticky-add-to-cart' );
        if ( !$selector.length ) {
            return;
        }
        var $image = $selector.find( '.ecomus-sticky-atc__image img' ),
            $addToCart = $selector.find('.single_add_to_cart_button'),
            $addToCart_text = $addToCart.text();

        $selector.find( '.ecomus-sticky-atc__variations' ).on('change', 'select', function (e) {
            var optionSelected = $("option:selected", this),
                imageSelected = optionSelected.data('image'),
                attributes = optionSelected.data('attributes'),
                stock = optionSelected.data('stock');

            if( attributes !== undefined ) {
                $addToCart.removeClass('disabled');
                for( var key in attributes) {
                    $selector.find('form.cart').find('input[name="'+ key +'"]').val( attributes[key] );
                }
            } else {
                $addToCart.addClass('disabled');
            }

            if( stock ) {
                if( stock.stock == 'out_of_stock' ) {
                    $addToCart.addClass('disabled');
                }

                $addToCart.text( stock.button_text );
            } else {
                $addToCart.text( $addToCart_text );
            }

            if( imageSelected === undefined ) {
                imageSelected = $image.data('o_src');
            }
            $image.attr( 'src', imageSelected );
        });
    }
	/**
	 * Document ready
	 */
	$(function () {
		ecomus.init();
        $( '#ecomus-sticky-add-to-cart' ).find( '.ecomus-sticky-atc__variations select' ).trigger( 'change' );
	});

})(jQuery);