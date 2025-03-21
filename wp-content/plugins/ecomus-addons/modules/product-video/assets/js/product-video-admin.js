(function ($) {
	'use strict';

	var product_gallery_frame;
	function product_video_init() {
		$( '#product_product_video_data' ).on( 'click', '#set-video-thumbnail', function( event ) {
			var $el = $( this ),
				$thumbnail_id = $el.closest('.form-field').find('#video_thumbnail_id'),
				$remove_video = $el.closest('.form-field').find('#remove-video-thumbnail');

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

						$remove_video.removeClass('hidden');

						$thumbnail_id.val( attachment.id );

					}
				});

			});

			// Finally, open the modal.
			product_gallery_frame.open();
		});


		// Remove images.
		$( '#product_product_video_data' ).on( 'click', '#remove-video-thumbnail', function() {
			var $el = $( this ),
				$thumbnail_id = $el.closest('.form-field').find('#video_thumbnail_id'),
				$set_video = $el.closest('.form-field').find('#set-video-thumbnail');

			$el.addClass('hidden');

			$thumbnail_id.val(0);
			$set_video.html( $el.data('set-text') );

			return false;
		});
	}

	/**
	 * Document ready
	 */
	$(function () {
		product_video_init();
	});

})(jQuery);