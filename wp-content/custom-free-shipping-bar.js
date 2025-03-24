jQuery(document).ready(function ($) {
    $('#billing_state').on('change', function () {
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'update_city'
            },
            success: function () {
                location.reload(); // Reload trang khi có sự thay đổi
            }
        });
    });
});
