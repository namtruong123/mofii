(function ($) {
    'use strict';
    var ecomus = ecomus || {};

    ecomus.found_data = false;
    ecomus.variation_id = 0;

    ecomus.foundVariationImages = function( ) {
        $( 'div.product .entry-summary .variations_form:not(.form-cart-pbt)' ).on('found_variation', function(e, $variation){
            if( ecomus.variation_id != $variation.variation_id ) {
                ecomus.changeVariationImagesAjax($variation.variation_id, $(this).data('product_id'));
                ecomus.found_data = true;
                ecomus.variation_id = $variation.variation_id;
            }
        });
    }

    ecomus.resetVariationImages = function( ) {
        $( 'div.product .entry-summary .variations_form:not(.form-cart-pbt)' ).on('reset_data', function(e){
            if( ecomus.found_data ) {
                ecomus.changeVariationImagesAjax(0, $(this).data('product_id'));
                ecomus.found_data = false;
                ecomus.variation_id = 0;
            }

        });
    }

    ecomus.changeVariationImagesAjax = function(variation_id, product_id) {
        var $productGallery = $('.woocommerce-product-gallery'),
            galleryHeight = $productGallery.height();
            $productGallery.addClass('loading').css( {'overflow': 'hidden' });
            if( ! $productGallery.closest('.single-product').hasClass('quick-view-modal') ) {
                $productGallery.css( {'height': galleryHeight });
            }

        var data = {
            'variation_id': variation_id,
            'product_id': product_id,
            nonce: ecomusData.nonce,
        },
        ajax_url = ecomusData.ajax_url.toString().replace('%%endpoint%%', 'ecomus_get_variation_images');

        var xhr = $.post(
            ajax_url,
            data,
            function (response) {
                var $gallery = $(response.data);

                $productGallery.html( $gallery.html() );

                $productGallery.imagesLoaded(function () {
                    setTimeout(function() {
                        $productGallery.removeClass('loading').removeAttr( 'style' ).css('opacity', '1');
                    }, 200);

                } );

                $productGallery.trigger('product_thumbnails_slider_vertical');
                $productGallery.trigger('product_thumbnails_slider_horizontal');
                $('body').trigger('ecomus_product_gallery_zoom');
                $('body').trigger('ecomus_product_gallery_lightbox');

            }
        );
    }
    /**
     * Document ready
     */
    $(function () {
        if( $('.single-product').find('div.product' ).hasClass('product-has-variation-images') ) {
            ecomus.foundVariationImages();
            ecomus.resetVariationImages();
        }
    });

})(jQuery);