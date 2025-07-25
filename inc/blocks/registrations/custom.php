<?php
/**
 * Регистрируем динамические Gutenberg‑блоки темы Biotropika.
 * @package biotropika
 */

// 1) Подключаем PHP‑файлы с функциями рендера
require_once get_template_directory() . '/inc/blocks/preview-block.php';
require_once get_template_directory() . '/inc/blocks/scroll-animation-block.php';
require_once get_template_directory() . '/inc/blocks/video-slider-block.php';
require_once get_template_directory() . '/inc/blocks/horizontal-blocks.php';
require_once get_template_directory() . '/inc/blocks/prize-fund-block.php';
require_once get_template_directory() . '/inc/blocks/reviews-cards-block.php';

// 2) Регистрация самих блоков с указанием render_callback
add_action( 'init', function() {
    // Preview‑блок
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/preview-block',
        [ 'render_callback' => 'biotropika_render_preview_block' ]
    );

    // Scroll animation‑блок
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/scroll-animation-block',
        [ 'render_callback' => 'biotropika_render_scroll_animation_block' ]
    );

    // Video slider‑блок
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/video-slider-block',
        [ 'render_callback' => 'biotropika_render_video_slider_block' ]
    );

    // Horizontal-blocks
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/horizontal-blocks'
    );

    // Prize-fund-block
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/prize-fund-block'
    );

    // Reviews-cards-block
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/reviews-cards-block',
        [ 'render_callback' => 'biotropika_render_reviews_cards_block' ]
    );

} );