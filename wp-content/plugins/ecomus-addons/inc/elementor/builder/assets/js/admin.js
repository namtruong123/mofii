(function($) {
	$(function() {
		$('.ecomus-builder__toggle-button').on('change', '.ecomus-builder__enabled', function(e) {
			e.preventDefault();
			var $button = $(this),
				newState = 0,
				post_ID = $button.data("builder-id"),
				nonce = $button.data("nonce");

			if (true === e.target.checked) {
				newState = 1;
			}

			$(this).closest('table').addClass('ecomus-loading');

			$.ajax({
				type: "POST",
				dataType: "json",
				url: ajaxurl,
				data: {
					action: "ecomus_save_builder_enable",
					nonce: nonce,
					post_ID: post_ID,
					enabled: newState
				},
				success: function (response) {
					$button.closest('table').removeClass('ecomus-loading');
				}
			});
		});


		$( 'body.post-type-ecomus_builder #wpcontent' ).on( 'click', '.page-title-action', function(e) {
			e.preventDefault();
			var $button = $(this),
				$modal = $('#ecomus-builder-template-modal');

			$modal.fadeIn().addClass('modal--open');
		} );

		$( '#ecomus-builder-template-modal').on( 'click', '.modal__button-close, .modal__backdrop', function(e) {
			e.preventDefault();
			var $modal = $('#ecomus-builder-template-modal');

			$modal.fadeOut().removeClass('modal--open');
		} );

		$( '#ecomus-builder-template-modal__submit').on( 'click', function(e) {
			e.preventDefault();
			var $button = $(this),
				$form = $button.closest('.modal-content__form'),
				nonce = $form.find('._wpnonce').val(),
				post_title = $form.find('#ecomus-builder-template-modal__post-title').val(),
				template_type = $form.find('#ecomus-builder-template-modal-type').val(),
				enable_builder = $form.find('#ecomus-builder-template-modal__post-enable').is(":checked") ? 'yes' : 'no';

			$form.find('.modal-content-form-message').html('');

			if( ! post_title ) {
				$form.find('#ecomus-builder-template-modal__post-title').focus();
				return false;
			}

			$button.addClass('ecomus-loading');

			$button.prop( 'disabled', true );

			$.ajax({
				type: "POST",
				dataType: "json",
				url: ajaxurl,
				data: {
					action: "ecomus_builder_template_type",
					nonce: nonce,
					post_title: post_title,
					template_type: template_type,
					enable_builder: enable_builder
				},
				success: function (response) {
					var $data = response.data;

					if( $data.id ) {
						var $action = $form.attr('action') + '?post=' + $data.id + '&action=elementor';
						window.location.replace($action);
					} else if( $data.message ) {
						$form.find('.modal-content-form-message').html( $data.message );
						$button.removeClass('ecomus-loading');
						$button.prop( 'disabled', false );
					} else {
						$button.removeClass('ecomus-loading');
						$button.prop( 'disabled', false );
					}

				}
			});
		} );

		$('tbody#the-list').sortable({
			items: 'tr.type-ecomus_builder',
			opacity: 0.6,
			cursor: 'move',
			axis: 'y',
			update: function() {
				var paged = getUrlParameter('paged');
				if(typeof paged === 'undefined') {
					paged = 1;
				}

				$(this).addClass('loading');

				$.ajax({
					type: "POST",
					dataType: "json",
					url: ajaxurl,
					data: {
						action: "ecomus_sortable_builder",
						order: $(this).sortable('serialize'),
						paged: paged
					},
					success: function (response) {
						$('tbody#the-list').removeClass( 'loading' );
					}
				});
			},
		});

		function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };
	});
})(jQuery);