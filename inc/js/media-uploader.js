jQuery(function($){
    $('.biotropika-media-btn').on('click', function(e){
        e.preventDefault();
        const target   = $(this).data('target');
        const $input   = $('#' + target);
        const $preview = $('#' + target + '_preview');

        const frame = wp.media({
            title:  'Выберите изображение',
            button: { text: 'Использовать' },
            multiple: false
        });

        frame.on('select', function(){
            const attachment = frame.state().get('selection').first().toJSON();

            // Сохраняем ID и показываем превью
            $input.val(attachment.id);
            const url = attachment.sizes?.thumbnail?.url || attachment.url;
            $preview.attr('src', url).show();

            // Закрываем модалку привычным методом
            frame.close();

            // А ещё принудительно убираем элементы из DOM
            $('.media-modal').remove();
            $('.media-modal-backdrop').remove();
            $('body').removeClass('media-modal-open');
        });

        frame.open();
    });

    $('.biotropika-media-remove').on('click', function(e){
        e.preventDefault();
        const target   = $(this).data('target');
        $('#' + target).val('');
        $('#' + target + '_preview').hide();
    });
});
