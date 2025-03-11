(function ($) {
	"use strict";

	var currentFiles = null;

	function upload() {
        $('#ecomus-customer-reviews-files').on( 'change', function () {
			$('.ecomus-customer-reviews__items').empty();
			$('.ecomus-customer-reviews__message').removeClass( 'error' );
			$('.ecomus-customer-reviews__message').text( ecomusCRA.message );

			let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

			if( ecomusCRA.upload_video ) {
				allowedTypes   = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'video/mp4', 'video/mpeg', 'video/ogg', 'video/webm', 'video/quicktime', 'video/x-msvideo'];
			}

			let uploadFiles    = $('#ecomus-customer-reviews-files');

			var error = ecomusCRA.error,
				label = ecomusCRA.label,
				check = false;

			if( currentFiles ) {
				const dataTransfer = new DataTransfer();

				for ( let i = 0; i < currentFiles.length; i++ ) {
					dataTransfer.items.add(currentFiles[i]);
				}

				for ( let i = 0; i < uploadFiles[0].files.length; i++ ) {
					dataTransfer.items.add(uploadFiles[0].files[i]);
				}

				if( dataTransfer.files.length > ecomusCRA.limit ) {
					$('.ecomus-customer-reviews__message').addClass( 'error' );
					$('.ecomus-customer-reviews__message').text( error.too_many );
					uploadFiles[0].files = currentFiles;
				} else {
					uploadFiles[0].files = dataTransfer.files;

					if( $(this).closest('.ecomus-customer-reviews').find( '.ecomus-customer-reviews__message' ).hasClass( 'error') ) {
						$(this).closest('.ecomus-customer-reviews').find( '.ecomus-customer-reviews__message' ).removeClass( 'error' );
						$(this).closest('.ecomus-customer-reviews').find( '.ecomus-customer-reviews__message' ).text( label );
					}

					for(let i = 0; i < dataTransfer.files.length; i++) {
						if( ! allowedTypes.includes( dataTransfer.files[i].type ) ) {
							$('.ecomus-customer-reviews__message').addClass( 'error' );
							$('.ecomus-customer-reviews__message').text( error.file_type );
							check = true;
							break;
						}
						
						if( dataTransfer.files[i].size && dataTransfer.files[i].size > ecomusCRA.size ) {
							$('.ecomus-customer-reviews__message').addClass('error');
							$('.ecomus-customer-reviews__message').text( error.file_size );
							check = true;
							break;
						}
					}

					if( check ) {
						uploadFiles[0].files = currentFiles;
					} else {
						currentFiles = uploadFiles[0].files;
					}
				}
			} else {
				currentFiles = uploadFiles[0].files;
			}

			let countFiles     = uploadFiles[0].files.length;
			let countUploaded  = $('.ecomus-customer-reviews__items .ecomus-customer-reviews__item').length;

			if( countFiles + countUploaded > ecomusCRA.limit ) {
				$('.ecomus-customer-reviews__message').addClass( 'error' );
				$('.ecomus-customer-reviews__message').text( error.too_many );
				$('.ecomus-customer-reviews__items .ecomus-customer-reviews__item').not( '.uploaded' ).remove();
				uploadFiles.val('');
				return;
			}

			for(let i = 0; i < countFiles; i++) {
				if( ! allowedTypes.includes( uploadFiles[0].files[i].type ) ) {
					$('.ecomus-customer-reviews__message').addClass( 'error' );
					$('.ecomus-customer-reviews__message').text( error.file_type );
					$('.ecomus-customer-reviews__items .ecomus-customer-reviews__item').not( '.uploaded' ).remove();
					uploadFiles.val('');
					return;
				} else if( uploadFiles[0].files[i].size && uploadFiles[0].files[i].size > ecomusCRA.size ) {
					$('.ecomus-customer-reviews__message').addClass('error');
					$('.ecomus-customer-reviews__message').text( error.file_size );
					$('.ecomus-customer-reviews__items .ecomus-customer-reviews__item').not( '.uploaded' ).remove();
					uploadFiles.val('');
					return;
				} else {
					if( -1 === uploadFiles[0].files[i].type.indexOf( 'image' ) && ! ecomusCRA.upload_video ) {
						continue;
					}

					let container = $('<div/>', { class: 'ecomus-customer-reviews__item' });

					if( -1 === uploadFiles[0].files[i].type.indexOf( 'image' ) ) {
						container.append( $('<img>', { id: 'image-preview-' + i, src: $(this).closest( '.ecomus-customer-reviews' ).find( '[name="thumbnail_url"]' ).val() } ) );
						container.append('<span class="ecomus-svg-icon ecomus-svg-icon--play ecomus-customer-reviews__play"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="21" viewBox="0 0 18 21" fill="currentColor"><path d="M18 10.5L0.749999 20.4593L0.75 0.540707L18 10.5Z" fill="currentColor"></path></svg></span>');
					} else{
						container.append( $('<img>', { id: 'image-preview-' + i } ) );
						preview_image( uploadFiles[0].files, i );
					}
					
					container.append('<div class="ecomus-customer-reviews__bg"></div><span class="ecomus-svg-icon ecomus-svg-icon--close ecomus-customer-reviews__delete"><svg aria-hidden="true" role="img" focusable="false" fill="currentColor" width="16" height="16" viewBox="0 0 16 16"><path d="M16 1.4L14.6 0L8 6.6L1.4 0L0 1.4L6.6 8L0 14.6L1.4 16L8 9.4L14.6 16L16 14.6L9.4 8L16 1.4Z" fill="currentColor"></path></svg></span>');

					$('.ecomus-customer-reviews__items').append( container );
				}
			}
		});
    }

    function delete_file() {
        $('.ecomus-customer-reviews__items').on( 'click', '.ecomus-customer-reviews__delete, .ecomus-customer-reviews__bg', function () {
			var input = $(this).closest('.ecomus-customer-reviews').find('#ecomus-customer-reviews-files')[0],
				index = $(this).closest('.ecomus-customer-reviews__item').index(),
				$label = $(this).closest('.ecomus-customer-reviews').find( '.ecomus-customer-reviews__message' ),
				label  = ecomusCRA.label;
				
			if( ! input.files || ! input.files[index] ) {
				return false;
			}

			const dataTransfer = new DataTransfer();

			// Add all files except the one to remove
			for (let i = 0; i < input.files.length; i++) {
				if ( input.files[i].name !== input.files[index].name ) {
					dataTransfer.items.add(input.files[i]);
				}
			}
			
			if( dataTransfer.files ) {
				input.files = dataTransfer.files;
				currentFiles = input.files;
				$(this).closest('.ecomus-customer-reviews__item').remove();

				if( $label.hasClass( 'error') ) {
					$label.removeClass( 'error' );
                    $label.text( label );
				}
			}
		});
    }

	function preview_image( files, index ) {
		var oFReader = new FileReader();
		oFReader.readAsDataURL(files[index]);

		oFReader.onload = function (oFREvent) {
			document.getElementById("image-preview-" + index).src = oFREvent.target.result;
		};
	};

	function lightBox() {
		$('.ecomus-customer-reviews__attachment').on( 'click', 'a', function (e) {
			e.preventDefault();

			var pswpElement = $( '.pswp' )[0],
				items          = getGalleryItems( $(this).closest('.ecomus-customer-reviews__attachments').find( '.ecomus-customer-reviews__attachment' ) ),
				index          = $(this).closest( '.ecomus-customer-reviews__attachment' ).index();

			var options = $.extend( {
				index: index,
				addCaptionHTMLFn: function( item, captionEl ) {
					if ( ! item.title ) {
						captionEl.children[0].textContent = '';
						return false;
					}
					captionEl.children[0].textContent = item.title;
					return true;
				}
			}, wc_single_product_params.photoswipe_options );

			// Initializes and opens PhotoSwipe.
			var photoswipe = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
			photoswipe.init();

			return false;
		});
	}

	function getGalleryItems( $slides ) {
		var items = [];

		if ( $slides.length > 0 ) {
			$slides.each( function( i, el ) {
				if( $( el ).data( 'type' ) == 'image' ) {
					var img = $( el ).find( 'img' );

					if ( img.length ) {
						var large_image_src = img.attr( 'src' ),
							large_image_w   = img.attr( 'width' ),
							large_image_h   = img.attr( 'height' ),
							alt             = img.attr( 'alt' ),
							item            = {
								alt  : alt,
								src  : large_image_src,
								w    : large_image_w,
								h    : large_image_h,
								title: img.attr( 'data-caption' ) ? img.attr( 'data-caption' ) : img.attr( 'title' )
							};
						items.push( item );
					}
				} else {
					var video_src = $( el ).find( 'a' ).attr( 'href' );

					if( video_src.length ) {
						var item = {
                            html: '<div class="pswp__video"><video width="960" src="'+ video_src +'" controls></video></div>'
                        };
                        items.push( item );
					}
				}
			} );
		}

		return items;
	}

	/**
	 * Document ready
	 */
	$(function () {
		if ( typeof ecomusCRA === 'undefined' ) {
			return false;
		}
		
		$('#commentform').attr('enctype', "multipart/form-data");

        upload();
        delete_file();
		lightBox();
    });

})(jQuery);