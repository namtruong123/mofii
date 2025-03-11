(function ($) {
	"use strict";

	function init() {
		var interval = ecomusPVF.interval,
		    from = ecomusPVF.from,
		    to   = ecomusPVF.to;

		setInterval( function () {
			var number = Math.floor( ( Math.random() * to ) + from );

			number = number < from ? from : number;
			number = number > to ? to : number;

			$( '.ecomus-people-view__numbers' ).text( number );
		}, interval );
	}

	/**
	 * Document ready
	 */
	$(function () {
		if ( typeof ecomusPVF === 'undefined' ) {
			return false;
		}

		init();
    });

})(jQuery);