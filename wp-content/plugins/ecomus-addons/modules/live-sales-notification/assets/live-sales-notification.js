(function ($) {
	"use strict";

	var timeOut1 = null,
		timeOut2 = null,
		timeOut3 = null,
		timeOut4 = null,
		timeOut5 = null,
		myTime = null;

	function popup_runner () {
		var $counter = 0,
			$animation = 'animate__fadeInLeft',
        	$closing_animation = 'animate__fadeOutLeft';

		if( $(document).find( '.live-sales-notification' ).length > 0 ) {
			setTimeout(function() {
				$( '.live-sales-notification' ).removeClass( $animation );
				$( '.live-sales-notification' ).addClass( $closing_animation );

				setTimeout(function() {
					$( '.live-sales-notification' ).remove();
				}, 1000);
			}, 3000);
		}

		$.ajax({
			type: 'POST',
			dataType: "json",
			data: {
				action: 'live_sales_notification'
			},
			url: ecomusSBP.ajax_url,
			success: function ( response ) {
				if( ! response.data ) {
					return;
				}

				var $html = shuffle(response.data);
				
				timeOut1 = setTimeout(function () {
					$( 'body' ).append( $html[$counter] );
					$( '.live-sales-notification' ).addClass( $animation );

					timeOut2 = setTimeout(function() {
						$( '.live-sales-notification' ).removeClass( $animation );
						$( '.live-sales-notification' ).addClass( $closing_animation );

						timeOut3 = setTimeout(function() {
							$( '.live-sales-notification' ).remove();
						}, 1000);
					}, ecomusSBP.time_keep);

					var interval = parseInt(ecomusSBP.time_between) + parseInt(ecomusSBP.time_keep);

					myTime = setInterval(function () {
						if ( $counter >= ecomusSBP.numberShow ) {
							return;
						}

						if( $counter == 0 ) {
							$counter = 1;
						}

						$( 'body' ).append( $html[$counter] );
						$( '.live-sales-notification' ).addClass( $animation );

						timeOut4 = setTimeout(function () {
							$( '.live-sales-notification' ).removeClass( $animation );
							$( '.live-sales-notification' ).addClass( $closing_animation );

							timeOut5 = setTimeout(function() {
								$( '.live-sales-notification' ).remove();
							}, 1000);

							$counter += 1;
						}, ecomusSBP.time_keep);
					}, interval);
				}, ecomusSBP.time_start);
			}
		});
	}

	function close_button() {
		$(document).on( 'click', '.live-sales-notification__close', function (e) {
			e.preventDefault();

			$(this).closest( '.live-sales-notification' ).remove();
		});
	}

	/**
	 *
	 * Shuffle used to shuffle value,
	 *  so even if there is server caching of content user will get random output
	 */
	function shuffle(array) {
		var currentIndex = array.length, temporaryValue, randomIndex;

		while (0 !== currentIndex) {
			randomIndex = Math.floor(Math.random() * currentIndex);
			currentIndex -= 1;
			temporaryValue = array[currentIndex];
			array[currentIndex] = array[randomIndex];
			array[randomIndex] = temporaryValue;
		}

		return array;
	}

	/**
	 * Document ready
	 */
	$(function () {
		if ( typeof ecomusSBP === 'undefined' ) {
			return false;
		}

		if( ! timeOut1 || ! myTime ) {
        	popup_runner();
		}

		$(document).on( 'mouseenter', '.live-sales-notification', function() {
			if( ! $(this).hasClass( 'selected' ) ) {
				$(this).addClass( 'selected' );
				clearTimeout( timeOut1 );
				clearTimeout( timeOut2 );
				clearTimeout( timeOut3 );
				clearTimeout( timeOut4 );
				clearTimeout( timeOut5 );
				clearInterval( myTime );
			}
		});

		$(document).on( 'mouseleave', '.live-sales-notification', function() {
			if( $(this).hasClass( 'selected' ) ) {
				$(this).removeClass( 'selected' );
				timeOut1 = null;
				timeOut2 = null;
				timeOut3 = null;
				timeOut4 = null;
				timeOut5 = null;
				myTime = null;
				popup_runner();
			}
		});

		close_button();
    });

})(jQuery);