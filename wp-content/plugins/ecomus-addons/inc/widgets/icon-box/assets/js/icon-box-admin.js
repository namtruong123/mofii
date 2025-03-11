jQuery( document ).ready( function( $ ) {
	'use strict';

	var wp = window.wp,
		data = {},
		$body = $( document.body ),
		template = wp.template( 'ecomus-icon-box' );

	// Toggle a filter's fields.
	$body.on( 'click', '.ecomus-icon-box__tabs a', function( event ) {
		event.preventDefault();

		if( ! $(this).hasClass('active') ) {
			$(this).siblings('a').removeClass('active');
			$(this).addClass('active');

			$(this).parent().siblings( '.ecomus-icon-box__tab' ).removeClass('active');
			$(this).parent().siblings( '.' + $(this).attr('data-tab') ).addClass('active');
		}
	} );

	// Toggle a filter's fields.
	$body.on( 'click', '.ecomus-icon-box__field-top', function( event ) {
		event.preventDefault();

		$( this )
			.closest( '.ecomus-icon-box__field' )
			.toggleClass( 'open' )
			.children( '.ecomus-icon-box__field-options' )
			.toggle();
	} );

	// Add a new filter.
	$body.on( 'click', '.ecomus-icon-box__add-new', function( event ) {
		event.preventDefault();

		var $button = $( this ),
			$box = $button.closest( '.ecomus-icon-box__section' ).children( '.ecomus-icon-box__fields' ),
			$title = $button.closest( '.widget-content' ).find( 'input' ).first();

		data.name = $button.data( 'name' );
		data.count = $button.data( 'count' );

		$button.data( 'count', data.count + 1 );
		$box.append( template( data ) );
		$box.trigger( 'runColor' );
		$title.trigger( 'change' ); // Support customize preview.
	} );

	// Remove a filter.
	$body.on( 'click', '.ecomus-icon-box__remove', function( event ) {
		event.preventDefault();

		var $button = $( this ),
			$boxs = $button.closest( '.ecomus-icon-box__fields' );

		$button
			.closest( '.ecomus-icon-box__field' )
			.hide()
			.remove();

		$boxs
			.closest( '.widget-content' )
			.find( 'input' )
			.first()
			.trigger( 'change' );
	});

	// Live update for the title.
	$body.on( 'input', '.ecomus-icon-box__field-option[data-option="box:text"] input', function() {
		$( this ).closest( '.ecomus-icon-box__field' ).find( '.ecomus-icon-box__field-title' ).text( this.value );
	} );
} );
