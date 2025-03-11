jQuery(document).ready(function ($) {
	var $selector = $( '.product-variations-listing-products' ),
	    $table    = $selector.closest( 'table' ),
	    $class    = $( '.' + $selector.val() + '-show' );

	$table.find( '.product-variations--condition' ).closest( 'tr' ).addClass( 'hidden' );
	$table.find( $class ).closest( 'tr' ).removeClass( 'hidden' );

	$selector.on( 'change', function() {
		var $tableNew = $(this).closest( 'table' ),
			$classNew = $( '.' + $(this).val() + '-show' );

		$tableNew.find( '.product-variations--condition' ).closest( 'tr' ).addClass( 'hidden' );
		$tableNew.find( $classNew ).closest( 'tr' ).removeClass( 'hidden' );
	});
});