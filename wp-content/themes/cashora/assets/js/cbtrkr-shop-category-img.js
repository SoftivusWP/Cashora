jQuery(document).ready(function ($) {
    function wp_media_upload(buttonClass, hiddenField, imageWrapper) {
        var mediaUploader;

        $(buttonClass).click(function (e) {
            e.preventDefault();
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image',
                },
                multiple: false
            });
            mediaUploader.on('select', function () {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $(hiddenField).val(attachment.id);
                $(imageWrapper).html('<img src="' + attachment.url + '" style="max-width:100%;"/>');
            });
            mediaUploader.open();
        });
    }

    wp_media_upload('.cbtrkr_shop_category_image_upload', '#cbtrkr_shop_category_image', '#cbtrkr_shop_category_image_wrapper');

    $('.cbtrkr_shop_category_image_remove').click(function (e) {
        e.preventDefault();
        $('#cbtrkr_shop_category_image').val('');
        $('#cbtrkr_shop_category_image_wrapper').html('');
    });
});
