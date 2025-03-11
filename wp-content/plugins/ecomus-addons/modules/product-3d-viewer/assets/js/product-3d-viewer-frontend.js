jQuery( document ).ready(function($) {
	$(document.body).on( 'click', '.ecomus-product-3d-viewer__item', function( event ) {
		event.preventDefault();

		var $this  = $(this),
			$button  = $this.find('.ecomus-product-3d-viewer__button'),
			$model = $this.find('.ecomus-product-3d-viewer__model');

		$model.get(0).addEventListener('mousedown', function (event) {
			$this.attr( 'aria-control', '1' );
		}, true);
		  
		$model.get(0).addEventListener( 'mousemove', function (event) {
			$this.attr( 'aria-control', '0' );
		}, true);

		if( $this.hasClass( 'disable' ) ) {
			if( $this.closest( '.woocommerce-product-gallery__wrapper' ).length > 0 && ! $this.hasClass('fullscreen') ) {
				$this.closest( '.woocommerce-product-gallery__wrapper' ).get(0).swiper.allowTouchMove = false;
			}
			$button.addClass( 'hidden' );
			$this.removeClass( 'disable' );
			$model.get(0).dismissPoster();
		} else {
			if( $this.attr( 'aria-control' ) == '1' ) {
				if( $this.closest( '.woocommerce-product-gallery__wrapper' ).length > 0 && ! $this.hasClass('fullscreen') ) {
					$this.closest( '.woocommerce-product-gallery__wrapper' ).get(0).swiper.allowTouchMove = true;
				}
		
				$button.removeClass( 'hidden' );
				$this.addClass( 'disable' );
				$model.get(0).cameraOrbit = '0deg 75deg 105%';
				$model.get(0).fieldOfView = 'auto';
				$model.get(0).showPoster();
			}
		}
	});
	
	$(document.body).on( 'click', '.ecomus-product-3d-viewer__buttons > span', function( event ) {
		event.preventDefault();
		
		var $item  = $(this).closest('.ecomus-product-3d-viewer__item'),
			$model = $item.find('.ecomus-product-3d-viewer__model');

		if( $(this).hasClass( 'plus' ) ) {
			$model.get(0).zoom(1);
		}

		if( $(this).hasClass( 'minus' ) ) {
			$model.get(0).zoom(-1);
		}

		if( $(this).hasClass( 'fullscreen' ) ) {
			$item.addClass( 'fullscreen' );

			if( $(this).closest( '.woocommerce-product-gallery__wrapper' ).length > 0 ) {
				$(this).closest( '.woocommerce-product-gallery__wrapper' ).get(0).swiper.allowTouchMove = false;
			}

			if ( $item.get(0).requestFullscreen ) {
				$item.get(0).requestFullscreen();
			} else if ( $item.get(0).mozRequestFullScreen ) { /* Firefox */
				$item.get(0).mozRequestFullScreen();
			} else if ( $item.get(0).webkitRequestFullscreen ) { /* Chrome, Safari & Opera */
				$item.get(0).webkitRequestFullscreen();
			} else if ( $item.get(0).msRequestFullscreen ) { /* IE/Edge */
				$item.get(0) = window.top.document.body; //To break out of frame in IE
				$item.get(0).msRequestFullscreen();
			}
		}

		if( $(this).hasClass( 'exit-fullscreen' ) ) {
			$item.removeClass( 'fullscreen' );

			if ( document.exitFullscreen ) {
				document.exitFullscreen();
			} else if ( document.mozCancelFullScreen ) {
				document.mozCancelFullScreen();
			} else if ( document.webkitExitFullscreen ) {
				document.webkitExitFullscreen();
			} else if ( document.msExitFullscreen ) {
				window.top.document.msExitFullscreen();
			}
		}
	});

	$(document).on( 'fullscreenchange webkitfullscreenchange mozfullscreenchange msfullscreenchange', function(e) {
		var fullscreenElement = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullscreenElement || document.msFullscreenElement;

		if ( ! fullscreenElement ) {
            var $item = $('.ecomus-product-3d-viewer__item.fullscreen');
			$item.removeClass( 'fullscreen' );
		}
	});

	$(document.body).on( 'ecomus_product_thumbnails_init', function() {
		var $gallery = $('.woocommerce-product-gallery'),
			$pagination = $gallery.find('.woocommerce-product-thumbnail__nav'),
			$viewer = $gallery.find('.woocommerce-product-gallery__image.ecomus-product-3d-viewer');

		if ($viewer.length > 0) {
			var viewerNumber = $viewer.index();
			$gallery.addClass('has-3d-viewer');
			$pagination.find('.woocommerce-product-gallery__image').eq(viewerNumber).append('<div class="ecomus-i-3d-viewer"><span class="ecomus-svg-icon ecomus-svg-icon--3d-model"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 21"><path d="M7.67998 20.629L1.28002 16.723C0.886205 16.4784 0.561675 16.1368 0.337572 15.731C0.113468 15.3251 -0.00274623 14.8686 -1.39464e-05 14.405V6.59497C-0.00238367 6.13167 0.113819 5.6755 0.33751 5.26978C0.561202 4.86405 0.884959 4.52227 1.278 4.27698L7.67796 0.377014C8.07524 0.131403 8.53292 0.000877102 8.99999 9.73346e-08C9.46678 -0.000129605 9.92446 0.129369 10.322 0.374024V0.374024L16.722 4.27399C17.1163 4.51985 17.4409 4.86287 17.6647 5.27014C17.8885 5.67742 18.0039 6.13529 18 6.59998V14.409C18.0026 14.8725 17.8864 15.3289 17.6625 15.7347C17.4386 16.1405 17.1145 16.4821 16.721 16.727L10.321 20.633C9.92264 20.8742 9.46565 21.0012 8.99999 21C8.53428 20.9998 8.07761 20.8714 7.67998 20.629V20.629ZM8.72398 2.078L2.32396 5.97803C2.22303 6.04453 2.14066 6.13551 2.08452 6.24255C2.02838 6.34959 2.00031 6.46919 2.00298 6.59003V14.4C2.00026 14.5205 2.02818 14.6396 2.08415 14.7463C2.14013 14.853 2.22233 14.9438 2.32298 15.01L7.99999 18.48V10.919C8.00113 10.5997 8.08851 10.2867 8.25292 10.0129C8.41732 9.73922 8.65267 9.51501 8.93401 9.36401L15.446 5.841L9.28001 2.08002C9.19614 2.02738 9.09901 1.99962 8.99999 2C8.90251 1.99972 8.8069 2.02674 8.72398 2.078V2.078Z" fill="currentColor"></path></svg></span></div>');
		}
	} );
});