/**
 * Admin JavaScript file for Saber de Grana theme
 */

jQuery(document).ready(function($) {
    // Media uploader para imagem de categoria
    function ct_media_upload(button_selector) {
        var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;

        $('body').on('click', button_selector, function() {
            var button_id = $(this).attr('id'),
                self = $(this),
                send_attachment_bkp = wp.media.editor.send.attachment,
                button = $(this),
                id = button.attr('id').replace('_button', '');

            _custom_media = true;

            wp.media.editor.send.attachment = function(props, attachment) {
                if (_custom_media) {
                    $('#category_image').val(attachment.id);
                    $('#category-image-wrapper').html('<img class="custom_media_image" src="' + attachment.url + '" style="margin:0;padding:0;max-height:100px;float:none;" />');
                } else {
                    return _orig_send_attachment.apply(button_id, [props, attachment]);
                }
            };

            wp.media.editor.open(button);
            return false;
        });
    }

    // Remover imagem de categoria
    function ct_media_remove(button_selector) {
        $('body').on('click', button_selector, function() {
            $('#category_image').val('');
            $('#category-image-wrapper').html('');
            return false;
        });
    }

    // Inicializar os seletores de mídia
    ct_media_upload('.ct_tax_media_button');
    ct_media_remove('.ct_tax_media_remove');

    // Meta box para posts em destaque
    $(document).on('ready', function() {
        $('.featured-post-toggle').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('.featured-post-value').val(isChecked ? 'yes' : 'no');
        });
    });
});