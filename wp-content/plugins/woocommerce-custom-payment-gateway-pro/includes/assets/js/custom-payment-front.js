jQuery(function() {
	jQuery('body').on('updated_checkout', function(){
		var dateElement = jQuery('.custom_payment_date_input');
		jQuery(dateElement).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange:"c-100:c+25"
		});
		jQuery(dateElement).datepicker("option", "dateFormat", jQuery( dateElement ).attr('data-dateformat'));
		jQuery(dateElement).datepicker("setDate",jQuery( dateElement ).attr('data-defaultdate'));

	});

});
jQuery( function( $ ) {
	$( document ).on( "change", '.custom_payment_file_upload_blocks' ,function() {
		if ( ! this.files.length ) {
			$( '.custom_payment_file_upload_blocks' ).empty();
		} else {

			// we need only the only one for now, right?
			const file = this.files[0];
			const file_field_name = $(this).attr('data-key');
			const formData = new FormData();
			formData.append( file_field_name, file );
			formData.append('file_key', file_field_name);
			formData.append('action', 'custom_payment_file_upload');
			$.ajax({
				url: wc.wcSettings.ADMIN_URL + 'admin-ajax.php?nonce=' + custom_payments.custom_payment_upload_file_nonce,
				type: 'POST',
				data: formData,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				success: function ( response ) {
					$( 'input[name="'+file_field_name+'"]' ).val( response );
					evt = new CustomEvent('file_uploaded', { detail: { url: response } });
					document.dispatchEvent(evt)
				}
			});

		}
	});


});
jQuery( function( $ ) {
	$(document.body).on('updated_checkout', function () {
		$( '.custom_payment_file_upload' ).change( function() {

			if ( ! this.files.length ) {
				$( '.custom_payment_file_upload' ).empty();
			} else {

				// we need only the only one for now, right?
				const file = this.files[0];
				const file_field_name = $(this).attr('data-key');
				const formData = new FormData();
				formData.append( file_field_name, file );
				formData.append('file_key', file_field_name);
				formData.append('action', 'custom_payment_file_upload');
				$.ajax({
					url: wc_checkout_params.ajax_url + '?nonce=' + custom_payments.custom_payment_upload_file_nonce,
					type: 'POST',
					data: formData,
					contentType: false,
					enctype: 'multipart/form-data',
					processData: false,
					success: function ( response ) {
						$( 'input[name="'+file_field_name+'"]' ).val( response );
					}
				});

			}

		} );

	});
});
