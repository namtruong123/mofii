jQuery( document ).ready( function( $ ) {
	$( '.ecomus-size-guide-tabs' ).on( 'click', '.ecomus-size-guide-tabs__nav li', function() {
        var $tab = $( this ),
            index = $tab.data( 'target' ),
            $panels = $tab.closest( '.ecomus-size-guide-tabs' ).find( '.ecomus-size-guide-tabs__panels' ),
            $panel = $panels.find( '.ecomus-size-guide-tabs__panel[data-panel="' + index + '"]' );

        if ( $tab.hasClass( 'active' ) ) {
            return;
        }

        $tab.addClass( 'active' ).siblings( 'li.active' ).removeClass( 'active' );

        if ( $panel.length ) {
            $panel.addClass( 'active' ).siblings( '.ecomus-size-guide-tabs__panel.active' ).removeClass( 'active' );
        }
    } );
} );