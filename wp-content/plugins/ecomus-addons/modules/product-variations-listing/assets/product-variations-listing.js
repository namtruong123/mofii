(function ($) {
    'use strict';

    var xhr = null;

    function cart_actions() {
        $('#ecomus-product-variations-listing').on( 'change', '.product-variations-listing__quantity input.qty', function( e ) {
            variations_listing( $(this) );
        });

        $('#ecomus-product-variations-listing').on( 'click', '.product-variations-listing__remove', function( e ) {
            e.preventDefault();
            variations_listing( $(this) );
        });
    }

    function variations_listing( $selector ) {
        var $this             = $selector.closest( '.product-variations-listing__quantity' ),
            $container        = $this.closest('.ecomus-product-variations-listing'),
            $quantitySiblings = $this.closest( '.product-variations-listing__item' ).siblings().find( '.product-variations-listing__quantity' ),
            $summary          = $this.closest( '.product-variations-listing__summary' ),
            $quantity         = $this.find( 'input.qty' ),
            $price            = $summary.find( '.product-variations-listing__total .price' );

        var product_id          = $this.find( 'input[name="product_id"]' ).val(),
            variation_id        = $this.find( 'input[name="variation_id"]' ).val(),
            variation_attribute = $this.find( 'input[name="variation_attribute"]' ).val(),
            variation_ids       = $container.find( 'input[name="variation_ids"]' ).val(),
            remove              = $selector.hasClass( 'product-variations-listing__remove' ) ? true : false,
            quantity            = remove ? 0 : parseInt( $quantity.val() ),
            ajax_url            = ecomusPVL.ajax_url;

        var formData = {
                    action             : 'ecomus_update_variations_listing',
                    product_id         : product_id,
                    variation_ids      : variation_ids,
                    variation_id       : variation_id,
                    variation_attribute: variation_attribute,
                    variation_quantity : quantity
                };

        if (xhr) {
            $price.data( 'requestRunning', false );
            xhr.abort();
        }

        if ( $price.data( 'requestRunning' ) ) {
            return;
        }

        $price.data( 'requestRunning', true );
        $price.addClass( 'loading' );
        $quantitySiblings.addClass( 'waiting' );

        xhr = $.ajax({
            url: ajax_url.toString().replace( '%%endpoint%%', 'ecomus_update_variations_listing' ),
            method: 'POST',
            data: formData,
            success: function (data) {
                if (typeof wc_add_to_cart_params !== 'undefined') {
                    if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
                        window.location = wc_add_to_cart_params.cart_url;
                        return;
                    }
                }

                if ( data.success ) {
                    $(document.body).trigger('wc_fragment_refresh');
                }

                $price.data( 'requestRunning', false );
            }
        });
    }

    function update_variations_listing_with_mini_cart() {
        $(document.body).on( 'wc_fragments_loaded wc_fragments_refreshed', function () {
            var $mini_cart = $( '.widget_shopping_cart_content' );

            if( $mini_cart.length < 1 ) {
                return;
            }

            var $container     = $( '#ecomus-product-variations-listing' ),
                $quantityTotal = $container.find( '.product-variations-listing__total-quantity .total-quantity' ),
                $subtotal      = $container.find( '.product-variations-listing__subtotal .total-price' );

            var product_parent_id = $container.data( 'product_id' ),
                quantityTotal     = 0,
                subtotal          = 0;

            $container.find( '.product-variations-listing__item' ).removeClass( 'active' );

            $mini_cart.find( '.woocommerce-mini-cart-item' ).each( function( i, item ) {
                var $item    = $(item),
                    $details = $item.find('input[name="details_product"]');

                var product_id = $details.data( 'id' ),
                    price      = $details.data( 'price' ),
                    variation  = $details.val(),
                    quantity   = $item.find( 'input.qty' ).val();

                var $variation_item         = $container.find( ".product-variations-listing__item[data-variation='" + variation + "']" ),
                    variation_price         = $variation_item.find( 'input[name="variation_price"]' ).val(),
                    variation_regular_price = $variation_item.find( 'input[name="variation_regular_price"]' ).val();

                if( product_parent_id == product_id && quantity > 0 ) {
                    if( variation_price !== price ) {
                        if( parseFloat( price ) <  parseFloat( variation_price ) ) {
                            $variation_item.find( '.product-variations-listing__price .price' ).html( '<del>'+ formatPrice( parseFloat( variation_price ) ) +'</del><ins>'+ formatPrice( parseFloat( price ) ) +'</ins>' );
                        } else {
                            $variation_item.find( '.product-variations-listing__price .price' ).html( '<span class="woocommerce-Price-amount amount">'+ formatPrice( parseFloat( price ) ) +'</span>' );
                        }
                    } else {
                        if( parseFloat( variation_price ) <  parseFloat( variation_regular_price ) ) {
                            $variation_item.find( '.product-variations-listing__price .price' ).html( '<del>'+ formatPrice( parseFloat( variation_regular_price ) ) +'</del><ins>'+ formatPrice( parseFloat( variation_price ) ) +'</ins>' );
                        } else {
                            $variation_item.find( '.product-variations-listing__price .price' ).html( '<span class="woocommerce-Price-amount amount">'+ formatPrice( parseFloat( variation_price ) ) +'</span>' );
                        }
                    }

                    $variation_item.find( 'input.qty' ).val( quantity );
                    $variation_item.find( '.product-variations-listing__total .price' ).html( formatPrice( parseFloat( quantity * price ) ) );
                    $variation_item.find( '.product-variations-listing__remove' ).removeClass( 'hidden' );
                    $variation_item.addClass( 'active' );

                    quantityTotal += parseFloat( quantity );
                    subtotal += parseFloat( quantity * price );
                }
            });

            $container.find( '.product-variations-listing__item:not(.active)' ).each( function( i, item ) {
                var $item         = $(item),
                    variation_price         = $item.find( 'input[name="variation_price"]' ).val(),
                    variation_regular_price = $item.find( 'input[name="variation_regular_price"]' ).val();

                if( parseFloat( variation_price ) <  parseFloat( variation_regular_price ) ) {
                    $item.find( '.product-variations-listing__price .price' ).html( '<del>'+ formatPrice( parseFloat( variation_regular_price ) ) +'</del><ins>'+ formatPrice( parseFloat( variation_price ) ) +'</ins>' );
                } else {
                    $item.find( '.product-variations-listing__price .price' ).html( '<span class="woocommerce-Price-amount amount">'+ formatPrice( parseFloat( variation_price ) ) +'</span>' );
                }

                $item.find( 'input.qty' ).val(0);
            });

            $container.find( '.product-variations-listing__item:not(.active) .product-variations-listing__total .price' ).html( formatPrice( 0 ) );
            $container.find( '.product-variations-listing__item:not(.active) .product-variations-listing__remove' ).addClass( 'hidden' );

            $quantityTotal.text( quantityTotal );
            $subtotal.html( formatPrice( subtotal ) );

            $('.product-variations-listing__quantity.waiting').removeClass( 'waiting' );
            $('.product-variations-listing__total .price.loading').removeClass( 'loading' );
        });
    }

    function input_quantity() {
        $('#ecomus-product-variations-listing').on( 'keyup', '.product-variations-listing__quantity input.qty', function( e ) {
            if( $(this).val() ) {
                $(this).attr( 'value', $(this).val() );
            } else {
                $(this).attr( 'value', 0 );
            }
        });
    }

    function formatPrice( $number ) {
		var currency       = ecomusPVL.currency_symbol,
			thousand       = ecomusPVL.thousand_sep,
			decimal        = ecomusPVL.decimal_sep,
			price_decimals = ecomusPVL.price_decimals,
			currency_pos   = ecomusPVL.currency_pos,
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

    function pagination_ajax() {
        $('#ecomus-product-variations-listing').on( 'click', '.product-variations-listing__pagination li', function( e ) {
            e.preventDefault();

            var $this       = $(this),
                $body       = $this.closest( '.product-variations-listing__footer' ).siblings( '.product-variations-listing__body' ),
                $items      = $body.find( '.product-variations-listing__item' ),
                $pagination = $this.closest( '.product-variations-listing__pagination' ),
                product_id  = $pagination.data( 'product_id' ),
                page        = $this.data('page'),
                ajax_url    = ecomusPVL.ajax_url;

            $body.addClass( 'em-loading-spin loading' );

            if( $body.find( '.product-variations-listing__item[data-page="' + page + '"]' ).length > 1 ) {
                $body.removeClass( 'em-loading-spin loading' );
                $items.addClass( 'hidden' );
                $body.find( '.product-variations-listing__item[data-page="' + page + '"]' ).removeClass( 'hidden' );
                return;
            }

            $.ajax({
                url: ajax_url.toString().replace( '%%endpoint%%', 'ecomus_pagination_load' ),
                method: 'POST',
                data: {
                    name       : 'ecomus_product_variations_listing_pagination_load',
                    product_id : product_id,
                    page_number: page,
                },
                success: function( response ) {
                    if ( response ) {
                        if( $body.find( '.product-variations-listing__item[data-page="' + page + '"]' ).length < 1 ) {
                            var $items_html = $($.parseHTML(response.data)).filter( '.product-variations-listing__item[data-page="' + page + '"]' );

                            $body.append( $items_html );
                        }
                    }
                },
                complete: function() {
                    $body.removeClass( 'em-loading-spin loading' );
                    $items.addClass( 'hidden' );
                }
            });
        });
    }

    function pagination_button() {
        $('#ecomus-product-variations-listing').on( 'click', '.product-variations-listing__pagination li', function( e ) {
            e.preventDefault();
            var $this = $(this);

            if( ! $this.hasClass( 'prev' ) && ! $this.hasClass( 'next' ) ) {
                $this.siblings().removeClass( 'current' );
                $this.addClass( 'current' );

                if( $this.next().hasClass( 'hidden' ) ) {
                    var number = parseInt( $this.next().data( 'page' ) ),
                        $prev  = $this.parent().find( 'li[data-page="'+ ( number - 3 ) +'"]' );

                    $this.next().removeClass( 'hidden' );
                    $prev.addClass( 'hidden' );

                    if( $prev.prev().hasClass( 'prev' ) ) {
                        $prev.prev().removeClass( 'hidden' );
                    }
                }

                if( $this.prev().hasClass( 'hidden' ) ) {
                    var number = parseInt( $this.prev().data( 'page' ) ),
                        $next  = $this.parent().find( 'li[data-page="'+ ( number + 3 ) +'"]' );

                    $this.prev().removeClass( 'hidden' );
                    $next.addClass( 'hidden' );
                    $this.parent().find( '.prev' ).addClass( 'hidden' );

                    if( $next.next().hasClass( 'next' ) ) {
                        $next.next().removeClass( 'hidden' );
                    }
                }

                if( $this.prev().hasClass( 'prev' ) ) {
                    $this.prev().addClass( 'hidden' );
                }

                if( $this.next().hasClass( 'next' ) ) {
                    $this.next().addClass( 'hidden' );
                }

                if( $this.next().next().hasClass( 'next' ) ) {
                    $this.next().next().removeClass( 'hidden' );
                }

                if( $this.prev().prev().prev().hasClass( 'prev' ) ) {
                    $this.prev().prev().prev().removeClass( 'hidden' );
                }
            }

            if( $this.hasClass( 'prev' ) ) {
                if( ! $this.parent().find( '.current' ).prev().hasClass( 'prev' ) ) {
                    $this.parent().find( '.current' ).removeClass( 'current' ).prev().addClass( 'current' );
                }
            }

            if( $this.hasClass( 'next' ) ) {
                if( ! $this.parent().find( '.current' ).next().hasClass( 'next' ) ) {
                    $this.parent().find( '.current' ).removeClass( 'current' ).next().addClass( 'current' );
                }
            }
        });
    }

    function scrollbars() {
        var $content = $('#ecomus-product-variations-listing'),
            $header = $('#site-header').height(),
            $heightHold = $content.offset().top + $header,
            $heightHoldEnd  = $content.offset().top + $content.height();

        $(window).scroll(function() {
            var $scrollBottom = $(window).scrollTop() + $(window).height();

            if ($scrollBottom > $heightHold && $scrollBottom < $heightHoldEnd ) {
                $(document.body).addClass('ecomus-product-variations-listing-scroll');
            } else {
                $(document.body).removeClass('ecomus-product-variations-listing-scroll');
            }
        });
    }

    /**
     * Document ready
     */
    $(function () {
        if ( ! $('body').hasClass('single-product') ) {
            return;
        }

        if ( $('#ecomus-product-variations-listing').length < 1 ) {
            return;
        }

        if( ! ecomusPVL ) {
            return;
        }

        cart_actions();
        update_variations_listing_with_mini_cart();
        input_quantity();
        scrollbars();

        if( ecomusPVL.pagination  == 'yes' ) {
            pagination_ajax();
            pagination_button();
        }
    });

})(jQuery);