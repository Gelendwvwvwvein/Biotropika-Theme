<?php
/**
 * Хук для глобального скрытия блоков biotropika/* по атрибуту isHidden
 *
 * @package biotropika
 */
add_filter( 'render_block', function( $block_content, $block ) {
    if ( ! empty( $block['blockName'] ) && 0 === strpos( $block['blockName'], 'biotropika/' ) ) {
        if ( ! empty( $block['attrs']['isHidden'] ) ) {
            return '';
        }
    }
    return $block_content;
}, 10, 2 );


/**
 * Возвращает URL placeholder-изображения из опций темы.
 *
 * @return string
 */
function biotropika_get_placeholder_url() {
    $opts = get_option( 'biotropika_theme_options', [] );
    $id   = $opts['placeholder_img'] ?? 0;
    if ( $id ) {
        $url = wp_get_attachment_image_url( $id, 'full' );
        if ( $url ) {
            return $url;
        }
    }
    return get_template_directory_uri() . '/assets/images/placeholder.jpg';
}


/**
 * Локализует URL placeholder’а для фронтенд-JS всех блоков.
 *
 * (Хэндл должен совпадать с тем, что вы регистрируете при enqueue скрипта фронтенда)
 */
add_action( 'wp_enqueue_scripts', function() {
    wp_localize_script(
        'biotropika-blocks-frontend',
        'BiotropikaSettings',
        [ 'placeholderUrl' => biotropika_get_placeholder_url() ]
    );
} );


/**
 * Подключаем скрипт, который в админке проставляет isHidden в атрибуты блока
 */
add_action( 'enqueue_block_editor_assets', function() {
    $file = get_template_directory() . '/inc/js/block-filters.js';
    if ( ! file_exists( $file ) ) {
        return;
    }
    wp_enqueue_script(
        'biotropika-block-filters',
        get_template_directory_uri() . '/inc/js/block-filters.js',
        [
            'wp-blocks',
            'wp-element',
            'wp-hooks',
            'wp-compose',
            'wp-block-editor',
            'wp-components',
        ],
        filemtime( $file ),
        true
    );
} );