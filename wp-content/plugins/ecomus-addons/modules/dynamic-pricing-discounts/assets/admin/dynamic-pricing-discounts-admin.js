jQuery(document).ready(function ($) {
	// Switch status
	$('.dynamic-pricing-discount__switch').on( 'change', 'input', function () {
		var $switch = $(this).closest('.dynamic-pricing-discount__switch'),
			$text	= $(this).siblings( '.text' ),
			status  = $switch.hasClass( 'enabled' ) ? 'yes' : 'no';

		if( $switch.hasClass( 'enable' ) ) {
			$switch.removeClass( 'enable' ).addClass( 'disable' );
            $text.text( $text.data( 'disable' ) );
			status = 'no';
		} else {
			$switch.removeClass( 'disable' ).addClass( 'enable' );
            $text.text( $text.data( 'enable' ) );
			status = 'yes';
		}

		if( $switch.hasClass( 'dynamic-pricing-discount__switch--column' ) ) {
			var post_id = $switch.data( 'post_id' );

			if ( $switch.data( 'requestRunning' ) ) {
				return;
			}

			$switch.data( 'requestRunning', true );

			$.ajax({
				type: "POST",
				url: ajaxurl,
				data: {
					action: 'ecomus_dynamic_pricing_discount_status_update',
					post_id: post_id,
					status: status
				},
				success: function( response ) {
					$switch.data( 'requestRunning', false );
				}
			});
		}
	});

	// Change field product tab type
	var $settings = $('#ecomus-dynamic-pricing-discounts-display'),
		$layout = $settings.find('select[name="_dynamic_pricing_discounts_layout"]'),
		$display = $settings.find('select[name="_dynamic_pricing_discounts_display"]'),
		$product = $settings.find('.ecomus-dynamic-pricing-discounts--product'),
		$categories = $settings.find('.ecomus-dynamic-pricing-discounts--categories'),
		$field_layout = $( '.ecomus-dynamic-pricing-discounts__items .form-field--layout' );

	$display.on( 'change', function() {
		var display = $(this).val();

		if( display == 'products' ) {
			$product.removeClass( 'hidden' );
			$categories.addClass( 'hidden' );

		} else if( display == 'categories' ) {
			$product.addClass( 'hidden' );
			$categories.removeClass( 'hidden' );
		}
	});

	$layout.on( 'change', function() {
		var layout = $(this).val();

		if( layout == 'list' ) {
			$field_layout.addClass( 'hidden' );

		} else if( layout == 'grid' ) {
			$field_layout.removeClass( 'hidden' );
		}
	});

	$(document.body).on( 'click', '.ecomus-dynamic-pricing-discount__addnew', function ( e ) {
		e.preventDefault();

		var $clone = $(this).closest( '.ecomus-dynamic-pricing-discounts' ).find( '.ecomus-dynamic-pricing-discount__group' ).first().clone(),
			$last  = $(this).closest( '.ecomus-dynamic-pricing-discounts' ).find( '.group-items' ).last(),
			number = $last.find( '#dynamic_pricing_discounts_to' ).val();

			console.log(number);
		if( ! number || isNaN( number ) || number === 'undefined' ) {
			number = $last.find( '#dynamic_pricing_discounts_from' ).val();
		}

		console.log(number);

		$clone.find( 'input' ).val( '' );
		$clone.find( '#remove-thumbnail' ).addClass( 'hidden' );
		$clone.find( '#set-thumbnail' ).html( $clone.find( '#remove-thumbnail' ).data('set-text') );
		$clone.find( '.ecomus-dynamic-pricing-discount__thumbnail' ).removeClass( 'has-thumnail' );
		$clone.find( '#dynamic_pricing_discounts_popular' ).val( 'no' ).prop( 'checked', false );

		if( number && number !== 0 ) {
			$clone.find( '#dynamic_pricing_discounts_from' ).val( parseInt( number ) + 1 );
		}

		$clone.addClass( 'ecomus-dynamic-pricing-discount__group--clone' );
		$clone.find( '.ecomus-dynamic-pricing-discount__remove' ).removeClass( 'hidden' );
		$(this).closest( '.ecomus-dynamic-pricing-discounts' ).find( '.ecomus-dynamic-pricing-discount__button' ).before( $clone );
	});

	$(document.body).on( 'click', '.ecomus-dynamic-pricing-discount__remove', function ( e ) {
        e.preventDefault();
        $(this).closest( '.ecomus-dynamic-pricing-discount__group--clone' ).remove();
    });

	$(document.body).on( 'change', '#dynamic_pricing_discounts_from', function () {
		var $item = $(this).closest( '.group-items' ),
			$value = $(this).val(),
			$prevFrom = $item.prev().find( '#dynamic_pricing_discounts_from' ),
			prevFromVal = $item.prev().find( '#dynamic_pricing_discounts_from' ).val(),
			$prevTo = $item.prev().find( '#dynamic_pricing_discounts_to' ),
			prevToVal = $item.prev().find( '#dynamic_pricing_discounts_to' ).val();

		if( prevFromVal > ( parseInt( $value ) - 2 ) ) {
			$prevFrom.val( parseInt( $value ) - 2 );
		}

		if( prevToVal > ( parseInt( $value ) - 1 ) ) {
			$prevTo.val( parseInt( $value ) - 1 );
		}
	});

	$(document.body).on( 'change', '#dynamic_pricing_discounts_to', function () {
		var $item = $(this).closest( '.group-items' ),
			$value = $(this).val(),
			$nextFrom = $item.next().find( '#dynamic_pricing_discounts_from' ),
			nextFromVal = $item.next().find( '#dynamic_pricing_discounts_from' ).val(),
			$nextTo = $item.next().find( '#dynamic_pricing_discounts_to' ),
			nextToVal = $item.next().find( '#dynamic_pricing_discounts_to' ).val();

		$nextFrom.attr( 'min', parseInt( $value ) + 1 );
		if( nextFromVal < ( parseInt( $value ) + 1 ) ) {
			$nextFrom.val( parseInt( $value ) + 1 );
		}

		$nextTo.attr( 'min', parseInt( $value ) + 2 );

		if( nextToVal < ( parseInt( $value ) + 2 ) ) {
			$nextTo.val( parseInt( $value ) + 2 );
		}
	});

	var product_gallery_frame;
	$( document.body ).on( 'click', '#set-thumbnail', function( event ) {
		var $el = $( this ),
			$selector = $el.closest('.form-field').find('.ecomus-dynamic-pricing-discount__thumbnail'),
			$thumbnail_id = $el.closest('.form-field').find('#dynamic_pricing_discounts_thumbnail_id'),
			$remove_button = $el.closest('.form-field').find('#remove-thumbnail');

		event.preventDefault();

		// Create the media frame.
		if ( ! product_gallery_frame ) {
			product_gallery_frame = wp.media({
				// Set the title of the modal.
				title: $el.data( 'choose' ),
				button: {
					text: $el.data( 'update' )
				},
				states: [
					new wp.media.controller.Library({
						title: $el.data( 'choose' ),
						filterable: 'all',
					})
				]
			});
		}

		product_gallery_frame.off( 'select' );

		// When an image is selected, run a callback.
		product_gallery_frame.on( 'select', function() {
			var selection = product_gallery_frame.state().get( 'selection' );

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();

				if ( attachment.id ) {
					var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

					$el.html(
						'<img width="80px" src="' + attachment_image +
						'" />'
					);

					$remove_button.removeClass('hidden');

					$thumbnail_id.val( attachment.id );
					$selector.addClass( 'has-thumnail' );
				}
			});

		});

		// Finally, open the modal.
		product_gallery_frame.open();
	});


	// Remove images.
	$( document.body ).on( 'click', '#remove-thumbnail', function() {
		var $el = $( this ),
			$selector = $el.closest('.form-field').find('.ecomus-dynamic-pricing-discount__thumbnail'),
			$thumbnail_id = $el.closest('.form-field').find('#dynamic_pricing_discounts_thumbnail_id'),
			$set_button = $el.closest('.form-field').find('#set-thumbnail');

		$el.addClass('hidden');

		$thumbnail_id.val(0);
		$set_button.html( $el.data('set-text') );
		$selector.removeClass( 'has-thumnail' );

		return false;
	});
});