(function ($) {
    'use strict';

	function selectProduct () {
		$( '#ecomus-product-pbt .product-select--list .product-select__check' ).on( 'click', '.select', function (e) {
			var $selector = $(this).closest( '.product-select--list' ),
				productID = $selector.attr( 'data-id' );

			if( $selector.hasClass( 'product-primary' ) ) {
				return false;
			}

			$(this).closest( '.product-select--list' ).toggleClass( 'uncheck' );
			$(this).toggleClass( 'active' );

			$(this).closest( '.ecomus-product-pbt__products' ).find( '#pbt-product-' + productID + ' .product-select a' ).trigger( 'click' );
		});

		$( '#ecomus-product-pbt .product-select' ).on( 'click', 'a', function (e) {
			e.preventDefault();

			var $this                = $(this).closest( '#ecomus-product-pbt' ),
			    $productsList        = $(this).closest( 'ul.products' ).siblings( '.ecomus-product-pbt__lists' ).find( '.product-select--list[data-id="' + $(this).attr('data-id') + '"]'),
			    $subTotalData        = $this.find('#ecomus-data_subtotal'),
			    $totalPriceData      = $this.find('#ecomus-data_price'),
			    $totalSavePriceData  = $this.find('#ecomus-data_save_price'),
			    $subTotalHtml        = $this.find('.ecomus-pbt-subtotal'),
			    $subTotal            = $this.find('.ecomus-pbt-subtotal .woocommerce-Price-amount'),
			    $savePrice           = $this.find('.ecomus-pbt-save-price :not(.woocommerce-price-suffix) .woocommerce-Price-amount'),
			    $percent             = $this.find('.ecomus-pbt-save-price .percent'),
			    $priceHtml           = $this.find('.ecomus-pbt-total-price'),
			    $priceAt             = $this.find('.ecomus-pbt-total-price .woocommerce-Price-amount'),
			    $ecomus_pbt_ids      = $this.find('input[name="ecomus_pbt_ids"]'),
			    $button              = $this.find('.ecomus-pbt-add-to-cart'),
			    $productsVariation   = $this.find('li.product[data-type="variable"]'),
			    $ecomus_variation_id = $this.find('input[name="ecomus_variation_id"]'),
				$suffixTotal         = $this.find('.price-box__total .woocommerce-price-suffix .woocommerce-Price-amount'),

				subTotal             = parseFloat($this.find('#ecomus-data_subtotal').attr('data-price')),
				totalPrice           = parseFloat($this.find('#ecomus-data_price').attr('data-price')),
				savePrice            = parseFloat($this.find('#ecomus-data_save_price').attr('data-price')),
				discountAll          = parseFloat($this.find('#ecomus-data_discount-all').data('discount')),
				quantityDiscountAll  = parseFloat($this.find('#ecomus-data_quantity-discount-all').data('quantity')),
				currentPrice         = $(this).closest( '.product-select' ).find( '.s-price' ).attr( 'data-price' ),
				product_ids          = '',
				productVariation_ids = '',
				numberProduct        = [];

			if( $(this).closest( '.product-select' ).hasClass( 'product-current' ) ) {
				return false;
			}

			$(this).closest( '.product-select' ).toggleClass( 'uncheck' );

			$productsList.toggleClass( 'uncheck' );
			if( $productsList.hasClass( 'uncheck' ) ) {
				$productsList.find( '[type="checkbox"]' ).prop('checked', false);
			} else {
				$productsList.find( '[type="checkbox"]' ).prop('checked', true);
			}

			var $i = 0;
			$this.find( '.product-select' ).each(function () {
				if ( ! $(this).hasClass( 'uncheck' ) && ! $(this).closest( 'li.product' ).hasClass( 'out-of-stock' ) ) {
					if( $(this).hasClass( 'product-current' ) ) {
						product_ids = $(this).find('.product-id').attr('data-id');
					} else {
						product_ids += ',' + $(this).find('.product-id').attr('data-id');
					}

					if( parseFloat( $(this).find('.product-id').attr('data-id') ) !== 0 && parseFloat( $(this).find('.s-price').attr('data-price') ) !== 0 ) {
						numberProduct[$i] = $(this).find('.product-id').attr('data-id');
					}

					$i++;
				}
			});

			numberProduct = jQuery.grep( numberProduct, function(n){ return (n); });

			$productsVariation.find( '.product-select' ).each(function () {
				if ( ! $(this).hasClass( 'uncheck' ) && ! $(this).closest( 'li.product' ).hasClass( 'out-of-stock' ) ) {
					productVariation_ids += $(this).find('.product-id').attr('data-id') + ',';
				}

				if( ! productVariation_ids ) {
					productVariation_ids = 0;
				}
			});

			$ecomus_variation_id.attr( 'value', productVariation_ids );
			$ecomus_pbt_ids.attr( 'value', product_ids );
			$button.attr( 'value', product_ids );

			if( ! $(this).closest( 'li.product' ).hasClass( 'out-of-stock' ) ) {
				if ( $(this).closest( '.product-select' ).hasClass( 'uncheck' ) ) {
					$(this).closest( 'li.product' ).addClass( 'un-active' );

					subTotal -= parseFloat(currentPrice);
					savePrice -= roundLikePHP( parseFloat( currentPrice - ( ( currentPrice / 100 ) * discountAll ) ), ecomusPbt.price_decimals );
				} else {
					$(this).closest( 'li.product' ).removeClass( 'un-active' );

					subTotal += parseFloat(currentPrice);
					savePrice += roundLikePHP( parseFloat( currentPrice - ( ( currentPrice / 100 ) * discountAll ) ), ecomusPbt.price_decimals );
				}
			}

			if( discountAll || discountAll !== 0 ) {
				if( quantityDiscountAll <= numberProduct.length ) {
					$subTotalData.attr( 'data-price', subTotal );
					$subTotal.html(formatNumber(subTotal));
					$savePrice.html(formatNumber(savePrice));
					$percent.text(discountAll);
					$priceAt.html(formatNumber(savePrice));
					$totalPriceData.attr( 'data-price', subTotal - savePrice );
					$totalSavePriceData.attr( 'data-price', savePrice );

					$(this).closest( '.ecomus-product-pbt__products' ).find( '.price-new' ).removeClass( 'hidden' );
					$(this).closest( '.ecomus-product-pbt__products' ).find( '.price-ori' ).addClass( 'hidden' );

					$(this).closest( '.ecomus-product-pbt__products' ).find( '.product-price-new' ).siblings( 'div.price' ).addClass( 'hidden' );

					$(this).closest( '.ecomus-product-pbt__products' ).find( '.product-variation-price' ).addClass( 'active' );
					$(this).closest( '.ecomus-product-pbt__products' ).find( '.product-variation-price .price' ).addClass( 'hidden' );
					$(this).closest( '.ecomus-product-pbt__products' ).find( '.product-variation-price .price-variation-new' ).removeClass( 'hidden' );

					$priceHtml.addClass( 'ins' );
					$subTotalHtml.removeClass( 'hidden' );
				} else {
					$subTotalData.attr( 'data-price', subTotal );
					$subTotal.html(formatNumber(subTotal));
					$savePrice.html(formatNumber(0));
					$percent.text(0);
					$priceAt.html(formatNumber(subTotal));
					$totalPriceData.attr( 'data-price', subTotal );
					$totalSavePriceData.attr( 'data-price', savePrice );

					$(this).closest( '.ecomus-product-pbt__products' ).find( '.price-new' ).addClass( 'hidden' );
					$(this).closest( '.ecomus-product-pbt__products' ).find( '.price-ori' ).removeClass( 'hidden' );

					$(this).closest( '.ecomus-product-pbt__products' ).find( '.product-variation-price' ).removeClass( 'active' );
					$(this).closest( '.ecomus-product-pbt__products' ).find( '.product-variation-price .price' ).removeClass( 'hidden' );
					$(this).closest( '.ecomus-product-pbt__products' ).find( '.product-variation-price .price-variation-new' ).addClass( 'hidden' );

					$priceHtml.removeClass( 'ins' );
					$subTotalHtml.addClass( 'hidden' );
				}
			} else {
				$priceAt.html(formatNumber(totalPrice));
				$totalPriceData.attr( 'data-price', totalPrice );
				$totalSavePriceData.attr( 'data-price', savePrice );

				if( subTotal > $totalPriceData.attr( 'data-price' ) ) {
					$priceHtml.addClass( 'ins' );
					$subTotalHtml.removeClass( 'hidden' );
				} else {
					$priceHtml.removeClass( 'ins' );
					$subTotalHtml.addClass( 'hidden' );
				}
			}

			// Suffix
			var	suffixTotal = 0,
				sf          = [],
				i           = 0;

			$(this).closest( 'ul.products' ).find( 'li.product' ).each(function () {
				var $suffix = parseFloat( $(this).find( '.price:not(.hidden) .woocommerce-price-suffix .woocommerce-Price-amount' ).text().split( ecomusPbt.currency_symbol ).join('') );

				if( $(this).attr( 'data-type' ) == 'variable' ) {
					if( $(this).find( '.product-variation-price' ).hasClass( 'active' ) ) {
						$suffix = parseFloat( $(this).find( '.product-variation-price .price.price-variation-new .woocommerce-price-suffix .woocommerce-Price-amount' ).text().split( ecomusPbt.currency_symbol ).join('') );
					} else {
						$suffix = parseFloat( $(this).find( '.product-variation-price .price:not(.price-variation-new) .woocommerce-price-suffix .woocommerce-Price-amount' ).text().split( ecomusPbt.currency_symbol ).join('') );
					}

					if( ! $(this).find( '.variation-attribute' ).first().val() || $(this).hasClass( 'out-of-stock' ) ) {
						$suffix = 0;
					}
				}

				if ( ! $(this).hasClass( 'un-active' ) && ! isNaN( $suffix ) ) {
					sf[i] = $suffix;

					i++;
				}
			});

			suffixTotal = sf.reduce((a, b) => a + b, 0);

			$suffixTotal.html( formatNumber( suffixTotal ) );

			// Check
			check_ready( $this );
			check_button();

			if( $(this).closest( 'li.product' ).data( 'type' ) == 'variable' ) {
				$( '.variations_form select' ).trigger('change');
			}
		});
	}

	function productVariationChange() {
		$('#ecomus-product-pbt').find( '.variations_form' ).on('change', 'select', function (e) {
			if( $(this).closest( '.ecomus-product-pbt__products' ).length < 1 ) {
				return;
			}

			var $wrapper        = $(this).closest( '.ecomus-product-pbt__wrapper' ),
				$form              = $(this).closest('form'),
				optionSelected     = $("option:selected", this),
				productID          = $form.data( 'product_id' ),
				attributes         = optionSelected.data('attributes'),
				stock              = optionSelected.data('stock'),
				$titleProduct      = $(this).closest('.ecomus-product-pbt__products').find( '#pbt-product-' + productID + ' .woocommerce-loop-product__title a' ),
				$titleProduct_list = $(this).closest('.ecomus-product-pbt__products').find( '.product-select--list[data-id="' + productID + '"] .product-select__name' );

			if( stock ) {
                if( stock.stock !== 'in_stock' ) {
					if( $titleProduct.find( 'span.stock' ).length > 0 ) {
						$titleProduct.find( 'span.stock' ).text( ' - ' + stock.button_text );
					} else {
                    	$titleProduct.append( '<span class="stock"> - ' + stock.button_text + '</span>' );
						$titleProduct.closest( 'li.product' ).addClass( 'out-of-stock' );
					}

					if( $titleProduct_list.find( 'span.stock' ).length > 0 ) {
						$titleProduct_list.find( 'span.stock' ).text( ' - ' + stock.button_text );
					} else {
                    	$titleProduct_list.append( '<span class="stock"> - ' + stock.button_text + '</span>' );
						$titleProduct_list.closest( '.product-select--list' ).addClass( 'out-of-stock' );
					}
                } else {
					$titleProduct.find( 'span.stock' ).remove();
					$titleProduct.closest( 'li.product' ).removeClass( 'out-of-stock' );
					$titleProduct_list.find( 'span.stock' ).remove();
					$titleProduct_list.closest( '.product-select--list' ).removeClass( 'out-of-stock' );
				}
            } else {
				if( $titleProduct.find( 'span.stock' ).length > 0 ) {
					$titleProduct.closest( 'li.product' ).removeClass( 'out-of-stock' );
				}

                $titleProduct.find( 'span.stock' ).remove();

				if( $titleProduct_list.find( 'span.stock' ).length > 0 ) {
					$titleProduct_list.closest( '.product-select--list' ).removeClass( 'out-of-stock' );
				}
                $titleProduct_list.find( 'span.stock' ).remove();
            }

			if( attributes !== undefined ) {
                for( var key in attributes) {
                    $form.find('input[name="'+ key +'"]').val( attributes[key] );
                }

				found_variation( $wrapper, optionSelected, productID );
            } else {
				$form.find('input').val( '' );

				reset_data( $wrapper, optionSelected, productID );
			}

			// Suffix
			var $suffixTotal = $wrapper.find('.price-box__total .woocommerce-price-suffix .woocommerce-Price-amount'),
			    suffixTotal  = 0,
			    sf           = [],
			    i            = 0;

			$wrapper.find( 'li.product' ).each(function () {
				var $suffix = parseFloat( $(this).find( '.price:not(.hidden) .woocommerce-price-suffix .woocommerce-Price-amount' ).text().split( ecomusPbt.currency_symbol ).join('') );

				if( $(this).attr( 'data-type' ) == 'variable' ) {
					if( $(this).find( '.product-variation-price' ).hasClass( 'active' ) ) {
						$suffix = parseFloat( $(this).find( '.product-variation-price .price.price-variation-new .woocommerce-price-suffix .woocommerce-Price-amount' ).text().split( ecomusPbt.currency_symbol ).join('') );
					} else {
						$suffix = parseFloat( $(this).find( '.product-variation-price .price:not(.price-variation-new) .woocommerce-price-suffix .woocommerce-Price-amount' ).text().split( ecomusPbt.currency_symbol ).join('') );
					}

					if( ! $(this).find( '.variation-attribute' ).first().val() || $(this).hasClass( 'out-of-stock' ) ) {
						$suffix = 0;
					}
				}

				if ( ! $(this).hasClass( 'un-active' ) && ! isNaN( $suffix ) ) {
					sf[i] = $suffix;

					i++;
				}
			});

			suffixTotal = sf.reduce((a, b) => a + b, 0);

			$suffixTotal.html( formatNumber( suffixTotal ) );

			check_button();
        });

		$( '.variations_form select' ).trigger('change');
    }

	function found_variation( $wrapper, $selector, productID ) {
		if( $selector.closest( 'ul.products' ).length > 0 ) {
			var $product  = $selector.closest('li.product'),
			    $_product = $selector.closest('ul.products').siblings( '.ecomus-product-pbt__lists' ).find( '.product-select--list[data-id="' + productID + '"]' ),
			    $_price   = $selector.closest('ul.products').siblings( '.ecomus-product-pbt__lists' ).find( '.product-select--list[data-id="' + productID + '"] div.price');
		} else {
			var $product  = $selector.closest( '.ecomus-product-pbt__lists' ).siblings( 'ul.products' ).find( '#pbt-product-' + productID ),
			    $_product = $selector.closest( '.product-select--list' ),
			    $_price   = $selector.closest( '.product-select--list' ).find( 'div.price' );
		}

		var $price        = $product.find( 'div.price' ),
		    $productPrice = $product.find( '.s-price' ),
		    $productAttrs = $product.find( '.s-attrs' ),
		    $productID    = $product.find( '.product-id' ),
		    $button       = $wrapper.find( '.ecomus-pbt-add-to-cart' ),

			variation_id = $selector.attr( 'value' ),
			price        = $selector.data( 'price' ),
			priceHTML    = $selector.data( 'price_html' ),
			attributes   = $selector.data( 'attributes' ),
			image        = $selector.data( 'image' ),
			image_ori	 = $product.find('.thumbnail .thumb-ori img').attr( 'src' );

		if ( $product.length ) {
			if( $button.val() == 0 ) {
				$button.attr( 'value', $productID );
			}

			if ( $product.attr( 'data-type' ) == 'variable' ) {
				$productPrice.attr( 'data-price', price );
		  	}

			$productID.attr( 'data-id', variation_id );
			if ( $product.find( '.product-select' ).hasClass( 'product-current' ) ) {
				$wrapper.find( '.ecomus_variation_id' ).attr( 'value', variation_id );
			}

			if ( image && image !== image_ori ) {
				// change image
				$product.find('.thumbnail .thumb-ori').css( 'opacity', '0' );
				$product.find('.thumbnail .thumb-new').html('<img src="' + image + '" srcset="' + image + '"/>').css( 'opacity', '1' );
			}

			// change attributes
			$productAttrs.attr('data-attrs', JSON.stringify( attributes ) );
		}

		if( priceHTML ) {
			if( $price.hasClass( 'hidden' ) && $_price.hasClass( 'hidden' ) ) {
				$product.find( '.product-variation-price' ).remove();
				$_product.find( '.product-variation-price' ).remove();
			} else {
				$price.addClass( 'hidden' );
				$_price.addClass( 'hidden' );
			}

			if( $product.find( '.product-price-new' ).length && $_product.find( '.product-price-new' ).length ) {
				$product.find( '.product-price-new' ).html( priceHTML );
				$_product.find( '.product-price-new' ).html( priceHTML );
			} else {
				$price.after( '<div class="product-price-new">' + priceHTML + '</div>' );
				$_price.after( '<div class="product-price-new">' + priceHTML + '</div>' );
			}
		}

		variationProduct( $product, $_product, variation_id );
	};

	function reset_data( $wrapper, $selector, productID ) {
		if( $selector.closest( 'ul.products' ).length > 0 ) {
			var $product  = $selector.closest('li.product'),
			    $_product = $selector.closest('ul.products').siblings( '.ecomus-product-pbt__lists' ).find( '.product-select--list[data-id="' + productID + '"]' ),
			    $_price   = $selector.closest('ul.products').siblings( '.ecomus-product-pbt__lists' ).find( '.product-select--list[data-id="' + productID + '"] div.price');
		} else {
			var $product  = $selector.closest( '.ecomus-product-pbt__lists' ).siblings( 'ul.products' ).find( '#pbt-product-' + productID ),
			    $_product = $selector.closest( '.product-select--list' ),
			    $_price   = $selector.closest( '.product-select--list' ).find( 'div.price' );
		}

		var $price        = $product.find( 'div.price' ),
			$productPrice = $product.find( '.s-price' ),
		    $productAttrs = $product.find( '.s-attrs' ),
		    productPrice  = parseFloat( $product.find( '.s-price' ).attr('data-price') ),
		    $productID    = $product.find( '.product-id' ),

		    subTotal      = parseFloat( $wrapper.find('#ecomus-data_subtotal').attr('data-price') ),
		    $subTotalData = $wrapper.find('#ecomus-data_subtotal'),
			image 		  = $product.find('.thumbnail .thumb-new img').attr( 'src' ),
			image_ori      = $product.find('.thumbnail .thumb-ori img').attr( 'src' );

		if ( $product.length ) {
			$productID.attr( 'data-id', 0 );
			$productAttrs.attr('data-attrs', '');

			// reset thumb
			if( image !== image_ori ) {
				$product.find('.thumbnail .thumb-new').css( 'opacity', '0' );
				$product.find('.thumbnail .thumb-ori').css( 'opacity', '1' );
			}

		  	// reset price
			if ( $product.attr( 'data-type' ) == 'variable' ) {
				$productPrice.attr( 'data-price', 0 );
			}

			if ( $product.find( '.product-select' ).hasClass('product-current') ) {
				$wrapper.find( '.ecomus_variation_id' ).attr( 'value', 0 );
			}

			$subTotalData.attr( 'data-price', subTotal - productPrice );
		}

		if( $price.hasClass( 'hidden' ) && $_price.hasClass( 'hidden' ) ) {
			$price.removeClass( 'hidden' );
			$_price.removeClass( 'hidden' );

			$product.find( '.product-price-new' ).remove();
			$product.find( '.product-variation-price' ).remove();

			$_product.find( '.product-price-new' ).remove();
			$_product.find( '.product-variation-price' ).remove();
		}

		variationProduct( $product, $_product, $productID.attr( 'data-id' ) );
	};

	function variationProduct ( $product, $_product, productID = 0 ) {
		if( $product.attr( 'data-type' ) !== 'variable' ) {
			return;
		}

		if( $product.find( '.product-select' ).hasClass( 'unckeck' ) ) {
			return;
		}

		var $pbtProducts            = $product.closest('#ecomus-product-pbt'),
		    $products               = $pbtProducts.find('li.product'),
		    $productsVariable       = $pbtProducts.find('li.product[data-type="variable"]'),
		    $subTotalHtml           = $pbtProducts.find('.ecomus-pbt-subtotal'),
		    $subTotal               = $pbtProducts.find('.ecomus-pbt-subtotal .woocommerce-Price-amount'),
		    $priceHtml              = $pbtProducts.find('.ecomus-pbt-total-price'),
		    $priceAt                = $pbtProducts.find('.ecomus-pbt-total-price .woocommerce-Price-amount'),
		    $discountHtml           = $pbtProducts.find('.ecomus-pbt-save-price :not(.woocommerce-price-suffix) .woocommerce-Price-amount'),
		    $ecomus_variation_id    = $pbtProducts.find('input[name="ecomus_variation_id"]'),
		    $ecomus_pbt_ids         = $pbtProducts.find('input[name="ecomus_pbt_ids"]'),
		    $ecomus_variation_attrs = $pbtProducts.find('input[name="ecomus_variation_attrs"]'),
		    $button                 = $pbtProducts.find('.ecomus-pbt-add-to-cart'),
		    $percent                = $pbtProducts.find('.ecomus-pbt-save-price .percent'),
		    $subTotalData           = $pbtProducts.find('#ecomus-data_subtotal'),
		    $totalPriceData         = $pbtProducts.find('#ecomus-data_price'),
			$totalSavePriceData  	= $pbtProducts.find('#ecomus-data_save_price'),
		    $savePriceData          = $pbtProducts.find('#ecomus-data_save-price'),

			discountAll              = parseFloat( $pbtProducts.find('#ecomus-data_discount-all').data('discount')),
		    quantityDiscountAll      = parseFloat( $pbtProducts.find('#ecomus-data_quantity-discount-all').data('quantity') ),
		    ecomus_product_id        = parseFloat( $pbtProducts.find('input[name="ecomus_product_id"]').val()),
		    ecomus_variation_id_val  = $ecomus_variation_id.val(),
		    subTotal                 = parseFloat( $pbtProducts.find('#ecomus-data_subtotal').attr('data-price') ),
			savePrice                = parseFloat( $pbtProducts.find('#ecomus-data_save-price').attr('data-price') ),

		    variation_attrs          = {},
		    product_ids              = '',
		    ecomus_variation_ids     = '',
		    total                    = 0,
		    totalSavePrice           = 0,
		    numberProduct            = [];

		var $i = 0;
		$pbtProducts.find( '.product-select' ).each(function () {
			if ( ! $(this).hasClass( 'uncheck' ) && ! $(this).closest( 'li.product' ).hasClass( 'out-of-stock' ) ) {
				if( $(this).hasClass( 'product-current' ) ) {
					product_ids = $(this).find('.product-id').attr('data-id');
				} else {
					product_ids += ',' + $(this).find('.product-id').attr('data-id');
				}

				if( parseFloat( $(this).find('.product-id').attr('data-id') ) !== 0 && parseFloat( $(this).find('.s-price').attr('data-price') ) !== 0 ) {
					numberProduct[$i] = $(this).find('.product-id').attr('data-id');
				}

				$i++;
			}
		});

		numberProduct = jQuery.grep( numberProduct, function(n){ return (n); });

		$ecomus_pbt_ids.attr( 'value', product_ids );
		$button.attr( 'value', product_ids );

		if( ecomus_variation_id_val == 0 && ! $product.hasClass( 'out-of-stock' ) ) {
			$ecomus_variation_id.attr( 'value', productID );

			variation_attrs[productID] = $product.find('.s-attrs').attr( 'data-attrs' );
			$ecomus_variation_attrs.attr( 'value', JSON.stringify(variation_attrs) );
		} else {
			$productsVariable.find( '.product-select' ).each( function () {
				if ( ! $(this).hasClass( 'uncheck' ) && ! $(this).closest( 'li.product' ).hasClass( 'out-of-stock' ) ) {
					var $pid 	= $(this).find('.product-id').attr('data-id'),
						$pattrs = $(this).find('.s-attrs').attr('data-attrs');

					ecomus_variation_ids += $pid + ',';
					variation_attrs[$pid] = $pattrs;
				}
			});

			$ecomus_variation_id.attr( 'value', ecomus_variation_ids );
			$ecomus_variation_attrs.attr( 'value', JSON.stringify(variation_attrs) );
		}

		$products.find( '.product-select' ).each( function () {
			if ( ! $(this).hasClass( 'uncheck' ) && ! $(this).closest( 'li.product' ).hasClass( 'out-of-stock' ) ) {
				var $pPrice = $(this).find('.s-price').attr('data-price');

				total += parseFloat($pPrice);

				if( discountAll > 0 ) {
					totalSavePrice += roundLikePHP( parseFloat($pPrice) - ( parseFloat($pPrice) / 100 * discountAll ), ecomusPbt.price_decimals );
				}
			}
		});

		subTotal = total;

		if( discountAll !== 0 && quantityDiscountAll <= numberProduct.length ) {
			savePrice = subTotal - totalSavePrice;
			$percent.text(discountAll);

			$product.closest( 'ul.products' ).find( '.price-ori' ).addClass( 'hidden' );
			$product.closest( 'ul.products' ).find( '.price-new' ).removeClass( 'hidden' );

			$_product.closest( '.ecomus-product-pbt__lists' ).find( '.price-ori' ).addClass( 'hidden' );
			$_product.closest( '.ecomus-product-pbt__lists' ).find( '.price-new' ).removeClass( 'hidden' );

			$priceHtml.addClass( 'ins' );
			$subTotalHtml.removeClass( 'hidden' );
		} else {
			savePrice = 0;
			$percent.text(0);
			$priceHtml.removeClass( 'ins' );
			$subTotalHtml.addClass( 'hidden' );

			$product.closest( 'ul.products' ).find( '.price-ori' ).removeClass( 'hidden' );
			$product.closest( 'ul.products' ).find( '.price-new' ).addClass( 'hidden' );

			$_product.closest( '.ecomus-product-pbt__lists' ).find( '.price-ori' ).removeClass( 'hidden' );
			$_product.closest( '.ecomus-product-pbt__lists' ).find( '.price-new' ).addClass( 'hidden' );
		}

		if( ecomus_product_id == 0 ) {
			savePrice = 0;

			if( ecomus_variation_id_val !== 0 && quantityDiscountAll <= numberProduct.length ) {
				savePrice = subTotal - totalSavePrice;
				$percent.text(discountAll);

				$product.closest( 'ul.products' ).find( '.product-variation-price' ).addClass( 'active' );
				$product.closest( 'ul.products' ).find( '.product-variation-price .price' ).addClass( 'hidden' );
				$product.closest( 'ul.products' ).find( '.product-variation-price .price-variation-new' ).removeClass( 'hidden' );

				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price' ).addClass( 'active' );
				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price .price' ).addClass( 'hidden' );
				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price .price-variation-new' ).removeClass( 'hidden' );
			} else {
				$product.closest( 'ul.products' ).find( '.product-variation-price' ).removeClass( 'active' );
				$product.closest( 'ul.products' ).find( '.product-variation-price .price' ).removeClass( 'hidden' );
				$product.closest( 'ul.products' ).find( '.product-variation-price .price-variation-new' ).addClass( 'hidden' );

				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price' ).removeClass( 'active' );
				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price .price' ).removeClass( 'hidden' );
				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price .price-variation-new' ).addClass( 'hidden' );

				$percent.text(0);
			}
		} else {
			if( discountAll !== 0 && quantityDiscountAll <= numberProduct.length ) {
				$product.closest( 'ul.products' ).find( '.product-variation-price' ).addClass( 'active' );
				$product.closest( 'ul.products' ).find( '.product-variation-price .price' ).addClass( 'hidden' );
				$product.closest( 'ul.products' ).find( '.product-variation-price .price-variation-new' ).removeClass( 'hidden' );

				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price' ).addClass( 'active' );
				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price .price' ).addClass( 'hidden' );
				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price .price-variation-new' ).removeClass( 'hidden' );

				$priceHtml.addClass( 'ins' );
				$subTotalHtml.removeClass( 'hidden' );
			} else {
				$product.closest( 'ul.products' ).find( '.product-variation-price' ).removeClass( 'active' );
				$product.closest( 'ul.products' ).find( '.product-variation-price .price' ).removeClass( 'hidden' );
				$product.closest( 'ul.products' ).find( '.product-variation-price .price-variation-new' ).addClass( 'hidden' );

				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price' ).removeClass( 'active' );
				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price .price' ).removeClass( 'hidden' );
				$_product.closest( '.ecomus-product-pbt__lists' ).find( '.product-variation-price .price-variation-new' ).addClass( 'hidden' );

				$priceHtml.removeClass( 'ins' );
				$subTotalHtml.addClass( 'hidden' );
			}
		}

		$savePriceData.attr( 'data-price', savePrice );
		$discountHtml.html(formatNumber(savePrice));

		$subTotalData.attr( 'data-price', subTotal );
		$subTotal.html(formatNumber(subTotal));
		$totalPriceData.attr( 'data-price', subTotal - savePrice );
		$totalSavePriceData.attr( 'data-price', subTotal - savePrice );
		$priceAt.html(formatNumber(subTotal - savePrice ));
		$pbtProducts.find('#ecomus-data_price').attr( 'data-price', subTotal - savePrice );
	}

	function sync_select_variation() {
		$('#ecomus-product-pbt').find( '.variations_form' ).on('change', 'select', function (e) {
			if( $(this).closest( '.ecomus-product-pbt__products' ).length < 1 ) {
				return;
			}

			var $this          = $(this),
			    optionSelected = $("option:selected", this),
			    attributes     = optionSelected.data('attributes'),
			    productID      = $this.closest( 'form' ).attr( 'data-product_id' ),
			    $select        = null,
				$form    	   = null;

			if( $this.closest( 'ul.products' ).length > 0 ) {
			    $select = $this.closest( 'ul.products' ).siblings( '.ecomus-product-pbt__lists' ).find( '.product-select--list[data-id="' + productID + '"] .variations_form select');
			    $form = $this.closest( 'ul.products' ).siblings( '.ecomus-product-pbt__lists' ).find( '.product-select--list[data-id="' + productID + '"] .variations_form');
			} else {
                $select = $this.closest( '.ecomus-product-pbt__lists' ).siblings( 'ul.products' ).find( '#pbt-product-' + productID + ' .variations_form select' );
                $form = $this.closest( '.ecomus-product-pbt__lists' ).siblings( 'ul.products' ).find( '#pbt-product-' + productID + ' .variations_form' );
            }

			$select.find( 'option' ).each(function() {
				var attributes2 = $(this).data('attributes');

				if( attributes2 !== undefined ) {
					if ( JSON.stringify( attributes2  ) === JSON.stringify( attributes  ) ) {
						for( var key in attributes2) {
							$form.find('input[name="'+ key +'"]').val( attributes[key] );
						}

						$(this).prop('selected', true);
					}
				} else {
					$form.find('input').val( '' );
				}
			});

			// Check
			check_ready();
		});
	}

	function check_ready( $wrap = $( '#ecomus-product-pbt' ) ) {
		var $products    	= $wrap.find( 'ul.products' ),
			$alert          = $wrap.find( '.ecomus-pbt-alert' ),
			$selection_name = '',
			$is_selection   = false;

		$products.find( 'li.product' ).each(function() {
			var $this = $(this),
				$type = $this.attr( 'data-type' );

			if ( ! $this.find( '.product-select' ).hasClass( 'uncheck' ) && $type == 'variable' && ( ! $this.find( '.variation-attribute' ).first().val() || $this.hasClass( 'out-of-stock' ) ) ) {
				$is_selection = true;

				if( $selection_name ) {
					$selection_name += ', ';
				}

				$selection_name += $this.attr( 'data-name' );
			}
		});


		if ( $is_selection ) {
			if( $alert.hasClass( 'hidden' ) ) {
				$alert.removeClass( 'hidden' );
			}

			$alert.html( ecomusPbt.alert.replace( '[name]', '<strong>' + $selection_name + '</strong>') );
			$(document).trigger( 'ecomus_pbt_check_ready', [false, $is_selection, $wrap] );
		} else {
			if( ! $alert.hasClass( 'hidden' ) ) {
				$alert.addClass( 'hidden' );
			}

			$alert.html('');
			$(document).trigger( 'ecomus_pbt_check_ready', [true, $is_selection, $wrap] );
		}

		check_button();
	}

	function check_button() {
		var $pbtProducts  = $('#ecomus-product-pbt'),
			$products     = $pbtProducts.find( 'ul.products' ),
		    total         = parseFloat( $pbtProducts.find( '#ecomus-data_price' ).attr( 'data-price' ) ),
		    $pID          = parseFloat( $pbtProducts.find( '.ecomus_product_id' ).val() ),
		    $pVID         = parseFloat( $pbtProducts.find( '.ecomus_variation_id' ).val() ),
		    $button       = $pbtProducts.find( '.ecomus-pbt-add-to-cart' );

		if( parseFloat( $pbtProducts.find( '.product-select.product-current .s-price' ).attr( 'data-price' ) ) == 0 ) {
			$button.addClass( 'disabled' );
		} else {
			if( total == 0 || ( $pID == 0 && $pVID == 0 ) ) {
				$button.addClass( 'disabled' );
			} else {
				$button.removeClass( 'disabled' );
			}
		}

		$products.find( 'li.product' ).each(function() {
			var $this = $(this),
				$type = $this.attr( 'data-type' );

			if ( ! $this.find( '.product-select' ).hasClass( 'uncheck' ) && $type == 'variable' && ( ! $this.find( '.variation-attribute' ).first().val() || $this.hasClass( 'out-of-stock' ) ) ) {
				$button.addClass( 'disabled' );
			}
		});
	}

	function formatNumber( $number ) {
		var currency       = ecomusPbt.currency_symbol,
			thousand       = ecomusPbt.thousand_sep,
			decimal        = ecomusPbt.decimal_sep,
			price_decimals = ecomusPbt.price_decimals,
			currency_pos   = ecomusPbt.currency_pos,
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
				return currency + n;
				break;
			case 'right' :
				return n + currency;
				break;
			case 'left_space' :
				return currency + ' ' + n;
				break;
			case 'right_space' :
				return n + ' ' + currency;
				break;
		}
	}

	function roundLikePHP(num, dec){
		var num_sign = num >= 0 ? 1 : -1;
		return parseFloat((Math.round((num * Math.pow(10, dec)) + (num_sign * 0.0001)) / Math.pow(10, dec)).toFixed(dec));
	}

	function add_to_cart_ajax() {
		$(document).on( 'click', '.ecomus-pbt-add-to-cart', function (e) {
			var $thisbutton = $(this),
				$cartForm = $thisbutton.closest('form.cart');

			if ( $thisbutton.is('.disabled') ) {
				return;
			}

			if ( $cartForm.length > 0 ) {
				e.preventDefault();
			} else {
				return;
			}

			if ( $thisbutton.data('requestRunning') ) {
				return;
			}

			$thisbutton.data( 'requestRunning', true );

			var found = false;

			$thisbutton.removeClass( 'added' );
			$thisbutton.addClass( 'loading' );
			progressBar();

			if ( found ) {
				return;
			}

			found = true;

			// Allow 3rd parties to validate and quit early.
			if ( false === $( document.body ).triggerHandler( 'should_send_ajax_request.adding_to_cart', [ $thisbutton ] ) ) {
				$( document.body ).trigger( 'ajax_request_not_sent.adding_to_cart', [ false, false, $thisbutton ] );
				return true;
			}

			var formData = $cartForm.serializeArray(),
				formAction = $cartForm.attr('action');

			var data = {};
			
			if( $thisbutton.hasClass( 'ecomus-pbt-add-to-cart') ) {
				var product_id      = $thisbutton.closest('form').find( '.ecomus_product_id' ).val(),
					current_product_id = $thisbutton.closest('form').find( '.ecomus_current_product_id' ).val();

				data = formData;
				if( product_id > 0 ) {
					data.push({name: 'ecomus-pbt-add-to-cart-ajax', value: product_id});
				} else {
					data.push({name: 'ecomus-pbt-add-to-cart-ajax', value: current_product_id});

					var variation_id = $thisbutton.val().substring(0, $thisbutton.val().indexOf(",")) ? $thisbutton.val().substring(0, $thisbutton.val().indexOf(",")) : $thisbutton.val();
					data.push({name: 'variation_id', value: variation_id});
				}

				formData.push({name: $thisbutton.attr('name'), value: $thisbutton.val()});
			}

			// Trigger event.
			$( document.body ).trigger( 'adding_to_cart', [ $thisbutton, formData ] );

			var ecomus_ajax_url = '';
			if (typeof ecomusData !== 'undefined') {
				ecomus_ajax_url = ecomusData.ajax_url;
			} else if (typeof wc_add_to_cart_params !== 'undefined') {
				ecomus_ajax_url = wc_add_to_cart_params.wc_ajax_url;
			}

			if( !ecomus_ajax_url ) {
				return;
			}

			$.ajax({
				url: ecomus_ajax_url.toString().replace( '%%endpoint%%', 'ecomus_add_to_cart_ajax' ),
				method: 'post',
				data: data,
				error: function (response) {
					window.location = formAction;
				},
				success: function ( response ) {
					if ( ! response ) {
						window.location = formAction;
					}

					if (typeof wc_add_to_cart_params !== 'undefined') {
						if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
							window.location = wc_add_to_cart_params.cart_url;
							return;
						}
					}

					// Trigger event so themes can refresh other areas.
					if( ! response.error ) {
						$( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $thisbutton ] );
					} else {
						$thisbutton.removeClass( 'loading' );
					}

					if ( $.fn.notify && response.error ) {
						var $checkIcon = '<span class="ecomus-svg-icon message-icon"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="50px" height="50px"><path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 25 11 A 3 3 0 0 0 22 14 A 3 3 0 0 0 25 17 A 3 3 0 0 0 28 14 A 3 3 0 0 0 25 11 z M 21 21 L 21 23 L 22 23 L 23 23 L 23 36 L 22 36 L 21 36 L 21 38 L 22 38 L 23 38 L 27 38 L 28 38 L 29 38 L 29 36 L 28 36 L 27 36 L 27 21 L 26 21 L 22 21 L 21 21 z"/></svg></span>',
							$closeIcon = '<span class="ecomus-svg-icon svg-active"><svg class="svg-icon" aria-hidden="true" role="img" focusable="false" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 1L1 14M1 1L14 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>',
							className  = 'error',
							$message   = response.error,
							button     = '<a href="' + ecomusATCA.view_cart_link + '" class="btn-button">' + ecomusATCA.view_cart_text + '</a>';

						$.notify.addStyle('ecomus', {
							html: '<div>' + $checkIcon + '<div class="message-box">' + $message + '</div>' + $closeIcon + '</div>'
						});

						$.notify('&nbsp', {
							autoHideDelay: 5000,
							className: className,
							style: 'ecomus',
							showAnimation: 'fadeIn',
							hideAnimation: 'fadeOut'
						});

						progressBar(false);
					}

					$thisbutton.data('requestRunning', false);
					found = false;
				},
				complete: function () {
					$(document.body).on( 'added_to_cart wc_fragments_refreshed', function () {
						progressBar(false);
					});
				}
			});
		});
    }

    /**
     * Progressbar
     */
    function progressBar( show = true ) {
		if ( ! show ) {
			$(document.body).find( '.em-progress-bar' ).css( 'transform', 'scaleX(1)' );

			setTimeout( function() {
				$(document.body).find( '.em-progress-bar' ).css( 'display', 'none' );
				$(document.body).find( '.em-progress-bar' ).css( 'transform', 'scaleX(0)' );
			}, 600);

			setTimeout( function() {
				$(document.body).find( '.em-progress-bar' ).removeAttr('style');
			}, 700);
		} else {
			$(document.body).find( '.em-progress-bar' ).css( 'transform', 'scaleX(0.8)' );
		}
    }

    /**
     * Document ready
     */
    $(function () {
		if ( typeof ecomusPbt === 'undefined' ) {
			return false;
		}

		if (! $('body').hasClass('single-product')) {
			return;
		}

		var $pbtProducts = $('#ecomus-product-pbt');

		if ( $pbtProducts.length <= 0) {
			return;
		}

		$(window).on('load', function () {
			$pbtProducts.find( 'select[name="variation_id"] option' ).prop( 'selected', function () {
				return this.defaultSelected;
			});
		});

		add_to_cart_ajax();

		check_button();

        selectProduct();

		setTimeout(() => {
			check_ready();
		}, 10);

		productVariationChange();
		sync_select_variation();
    });

})(jQuery);