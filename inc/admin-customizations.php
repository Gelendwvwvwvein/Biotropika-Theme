<?php
/**
 * Админ-кастомизации: плейсхолдеры, подписи, заголовки блоков в редакторе CPT.
 * @package biotropika
 */

// 1. Плейсхолдер для title ("Добавить заголовок" → "Автор" и др.)
add_filter('enter_title_here', function($title, $post){
    switch ($post->post_type) {
        case 'review':     return 'Автор';
        case 'interview':  return 'Интервьюируемый';
        case 'person':     return 'Имя Фамилия';
        case 'ad_package': return 'Наименование пакета';
        case 'partner':    return 'Наименование партнера';
    }
    return $title;
}, 10, 2);

// 2. JS-кастомизация интерфейса: подписи редактора и заголовок "Изображение записи"
add_action('admin_print_footer_scripts', function () {
    $screen = get_current_screen();

    // ======== Подписи для текстового редактора ========
    $editor_labels = [
        'review'    => 'Текст отзыва',
        'interview' => 'Описание интервью',
        'person'    => 'Регалии или Пояснения',
    ];
    if (isset($editor_labels[$screen->post_type])) {
        $label = esc_js($editor_labels[$screen->post_type]);
        echo <<<HTML
<script>
document.addEventListener('DOMContentLoaded',function(){
    // Пытаемся найти label, если его нет — создаём вручную
    var label = document.querySelector('label[for="content"]');
    if(label) {
        label.textContent = '$label';
    } else {
        // Попробуем найти сам редактор и вставить нашу подпись перед ним
        var editor = document.getElementById('wp-content-editor-container');
        if(editor) {
            var customLabel = document.createElement('div');
            customLabel.textContent = '$label';
            customLabel.style = 'font-weight: 600; margin: 8px 0; font-size: 15px;';
            editor.parentNode.insertBefore(customLabel, editor);
        }
    }
});

</script>
HTML;
    }

    // ======== Заголовок "Изображение записи" ========
    $thumb_labels = [
        'partner' => 'Логотип партнера',
        'person'  => 'Портретное фото',
        'interview' => 'Превью видео',
    ];
    if (isset($thumb_labels[$screen->post_type])) {
        $label = esc_js($thumb_labels[$screen->post_type]);
        echo <<<HTML
<script>
document.addEventListener('DOMContentLoaded',function(){
    var postbox = document.querySelector('#postimagediv h2');
    if(postbox) postbox.textContent = '$label';
});
</script>
HTML;
    }
});

/**
 * Отключаем Gutenberg-редактор для перечисленных CPT,
 * но при этом не трогаем show_in_rest (REST Api остаётся доступным).
 */
add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
    // Список CPT, где нужен только классический редактор
    $classic_editors = [
        'review',
        'partner',
        'interview',
        'person',
        'ad_package',
        // добавьте сюда другие CPT, если нужно
    ];

    if ( in_array( $post_type, $classic_editors, true ) ) {
        return false;
    }

    return $use_block_editor;
}, 10, 2 );
