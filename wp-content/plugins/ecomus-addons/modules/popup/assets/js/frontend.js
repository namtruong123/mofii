(function($) {

	function closePopup($popup) {
		var date = new Date(),
			value = date.getTime(),
			options = $popup.data('options'),
			post_ID = options.post_ID,
			days = options.frequency;

		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		document.cookie = 'ecomus_popup_'+ post_ID +'=' + value + ';expires=' + date.toGMTString() + ';path=/';

		$popup.removeClass('modal--open').fadeOut();
		$( document.body ).removeClass( 'modal-opened' );
		$(document.body).removeAttr('style');
	}

	function openNextPopup($post_IDs) {
		var $next_popup_ID = $post_IDs[0],
			$next_popup = $('#ecomus_popup_' + $next_popup_ID);
			if( ! $next_popup.length ) {
				return;
			}

		var options = $next_popup.data('options'),
			visible = options.visiblle,
			seconds = options.seconds,
			seconds = Math.max( seconds, 0 );
			seconds = 'delayed' === visible ? seconds : 0;
			setTimeout( function() {
				$next_popup.fadeIn().addClass('modal--open');

				var widthScrollBar = window.innerWidth - $('#page').width();
				if( $('#page').width() < 767 ) {
					widthScrollBar = 0;
				}

				$(document.body).css({'padding-right': widthScrollBar, 'overflow': 'hidden'});
				$( document.body ).addClass( 'modal-opened' );
			}, seconds * 1000 );
	}

	$(function() {
		if ( ! $('.ecomus-popup').length ) {
			return;
		}
		var $post_IDs = [],
			$post_exit_IDs = [];
		$('.ecomus-popup').each(function() {
			var $this = $(this),
				options = $this.data('options'),
				post_ID = options.post_ID,
				visible = options.visiblle,
				frequency = options.frequency,
				seconds = options.seconds;
				seconds = Math.max( seconds, 0 );
				seconds = 'delayed' === visible ? seconds : 0;

				$cookie_name = 'ecomus_popup_' + post_ID;
				if (frequency > 0 && document.cookie.match(new RegExp('(^|;\\s*)' + $cookie_name + '=([^;]*)'))) {
					return;
				}

				if( 'exit' === visible  ) {
					$post_exit_IDs.push( post_ID );
					return;
				}

				if( ! $post_IDs.length ) {
					$( window ).on( 'load', function() {
						setTimeout( function() {
							$this.fadeIn().addClass('modal--open');

							var widthScrollBar = window.innerWidth - $('#page').width();
							if( $('#page').width() < 767 ) {
								widthScrollBar = 0;
							}

							$(document.body).css({'padding-right': widthScrollBar, 'overflow': 'hidden'});
							$( document.body ).addClass( 'modal-opened' );
						}, seconds * 1000 );
					} );
				}


				$post_IDs.push(post_ID);

		});

		$('.ecomus-popup').on('click', '.ecomus-popup__close, .ecomus-popup__backdrop', function (e) {
			e.preventDefault();
			var $this = $(this),
				$popup = $this.closest('.ecomus-popup');

			closePopup($popup);
			$post_IDs.shift();
			if( $post_IDs.length ) {
				openNextPopup($post_IDs);
			}

		});

		document.addEventListener('mouseleave', function(event) {
			setTimeout(function() {
				if ($post_exit_IDs.length ) {
					openNextPopup($post_exit_IDs);
				}
			}, 500);

			$('.ecomus-popup').on('click', '.ecomus-popup__close, .ecomus-popup__backdrop', function (e) {
				e.preventDefault();

				$post_exit_IDs.shift();
				if( $post_exit_IDs.length ) {
					openNextPopup($post_exit_IDs);
				}

			});
		});

	});
})(jQuery);