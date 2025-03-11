jQuery(document).ready(function ($) {
    $('#ecomus_customer_reviews_upload').on( 'change', function () {
        $('.ecomus-customer-reviews-upload__message').removeClass( 'error' );
        $('.ecomus-customer-reviews-upload__message').text( ecomusCRA.message );

        let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

        if( ecomusCRA.upload_video ) {
            allowedTypes   = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'video/mp4', 'video/mpeg', 'video/ogg', 'video/webm', 'video/quicktime', 'video/x-msvideo'];
        }

        let uploadFiles    = $('#ecomus_customer_reviews_upload');
        let countFiles     = uploadFiles[0].files.length;

        for(let i = 0; i < countFiles; i++) {
            if( ! allowedTypes.includes( uploadFiles[0].files[i].type ) ) {
                $('.ecomus-customer-reviews-upload__message').addClass( 'error' );
                $('.ecomus-customer-reviews-upload__message').text( ecomusCRA.file_type );
                uploadFiles.val('');
                return;
            }
        }
    });

    $( '.ecomus-customer-reviews-upload__button' ).on( 'click', function(e) {
        e.preventDefault();

        var upload_files = $( '#ecomus_customer_reviews_upload' );
        var count_files = upload_files[0].files.length;

        if( count_files < 1 ) {
            return;
        }

        var i = 0,
            form_data = new FormData();

        form_data.append( 'action', 'ecomus_customer_reviews_upload' );
        form_data.append( 'post_id', $(this).attr('data-postid') );
        form_data.append( 'comment_id', $(this).attr('data-commentid') );
        form_data.append( 'ecomus_nonce', $(this).attr('data-nonce') );
        form_data.append( 'count_files', $('.ecomus-customer-reviews__items').find('.ecomus-customer-reviews__item').length );

        for( i = 0; i < count_files; i++ ) {
            form_data.append('files_' + i, upload_files[0].files[i]);
        }

        $.ajax({
            url        : ecomusCRA.ajax_url,
            data       : form_data,
            processData: false,
            contentType: false,
            type       : 'POST',
            beforeSend: function() {
                $('.ecomus-customer-reviews-upload__message').removeClass( 'success' );
                $('.ecomus-customer-reviews-upload__message').removeClass( 'warning' );
                $('.ecomus-customer-reviews-upload__message').removeClass( 'error' );
                $('.ecomus-customer-reviews-upload__message').text( ecomusCRA.uploading );

                $('.ecomus-customer-reviews-upload__button').addClass( 'disabled' );
                $('#ecomus_customer_reviews_upload').addClass( 'disabled' );
            },
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();

                if ( myXhr.upload ) {
                    myXhr.upload.addEventListener( 'progress', function(e) {
                        if ( e.lengthComputable ) {
                            var perc = ( e.loaded / e.total ) * 100;
                                perc = perc.toFixed(0);

                            $('.ecomus-customer-reviews-upload__message').text( ecomusCRA.uploading + ' (' + perc + '%)' );
                        }
                    }, false );
                }

                return myXhr;
            },
            success: function(response) {
                if( 200 === response['code'] ) {
                    $('.ecomus-customer-reviews-upload__message').addClass( 'success' );
                } else if( 201 === response['code'] ) {
                    $('.ecomus-customer-reviews-upload__message').addClass( 'warning' );
                } else {
                    $('.ecomus-customer-reviews-upload__message').addClass( 'error' );
                }

                $('.ecomus-customer-reviews-upload__message').text( '' );
                $.each( response['message'], function(index, message) {
                    $('.ecomus-customer-reviews-upload__message').append( message );
                });

                $('#ecomus_customer_reviews_upload').val( '' );
                $('.ecomus-customer-reviews-upload__button').removeClass( 'disabled' );
                $('#ecomus_customer_reviews_upload').removeClass( 'disabled' );

                if( 'files' in response && response['files'].length > 0 ) {
                    $.each( response['files'], function( index, file ) {
                        let file_html = '';

                        if( 'video' === file['type'] && ecomusCRA.upload_video ) {
                            file_html = '<div class="ecomus-customer-reviews__item ecomus-customer-reviews__item-' + file['id'] + '" data-type="'+ file['type'] +'">';
                                if ( 'video' === file['type'] ) {
                                    file_html += '<video preload="metadata" class="ecomus-video" src="' + file['url'] + '"></video>';
                                    file_html += '<span class="ecomus-svg-icon ecomus-svg-icon--play ecomus-customer-reviews__play"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="21" viewBox="0 0 18 21" fill="currentColor"><path d="M18 10.5L0.749999 20.4593L0.75 0.540707L18 10.5Z" fill="currentColor"></path></svg></span>';
                                } else {
                                    file_html += '<img src="' + file['url'] + '" alt="' + file['author'] + '">';
                                }

                                file_html += '<div class="ecomus-customer-reviews__bg"></div><span class="ecomus-svg-icon ecomus-svg-icon--close ecomus-customer-reviews__detach"><svg aria-hidden="true" role="img" focusable="false" fill="currentColor" width="16" height="16" viewBox="0 0 16 16"><path d="M16 1.4L14.6 0L8 6.6L1.4 0L0 1.4L6.6 8L0 14.6L1.4 16L8 9.4L14.6 16L16 14.6L9.4 8L16 1.4Z" fill="currentColor"></path></svg></span>';
                                file_html += '<div class="ecomus-customer-reviews__condition hidden"><span class="yes" data-nonce="' + file['nonce'] + '" data-attachment="' + file['id'] + '">'+ ecomusCRA.detach_yes +'</span><span class="no">'+ ecomusCRA.detach_no +'</span></div>';
                            file_html += '</div>';

                            $( '.ecomus-customer-reviews__items' ).append( file_html );
                        }
                    });
                }
            }
        });
    });

    $('.ecomus-customer-reviews__detach').on( 'click', function() {
        $(this).addClass( 'hidden' );
        $(this).closest('.ecomus-customer-reviews__item').find('.ecomus-customer-reviews__condition').removeClass( 'hidden' );
    });

    $('.ecomus-customer-reviews__condition span.no').on( 'click', function() {
        $(this).closest('.ecomus-customer-reviews__condition').addClass( 'hidden' );
        $(this).closest('.ecomus-customer-reviews__item').find('.ecomus-customer-reviews__detach').removeClass( 'hidden' );
    });

    $('.ecomus-customer-reviews__condition span.yes').on( 'click', function() {
        var data = {
            'action'       : 'ecomus_customer_reviews_detach',
            'nonce'        : $(this).attr( 'data-nonce' ),
            'comment_id'   : $('.ecomus-customer-reviews-upload__button').attr( 'data-commentid' ),
            'attachment_id': $(this).attr( 'data-attachment' ),
        };

        $(this).closest('.ecomus-customer-reviews__item').addClass( 'detached' );
        $.post( ecomusCRA.ajax_url, data, function(response) {
            if( response['code'] ) {
                $('.ecomus-customer-reviews__item-' + response['attachment']).remove();
            } else {
                $('.ecomus-customer-reviews__items' ).find( '.ecomus-customer-reviews__item.detached').removeClass( 'detached' );
            }
        });
    });
});
