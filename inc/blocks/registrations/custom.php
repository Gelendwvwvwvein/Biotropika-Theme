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
require_once get_template_directory() . '/inc/blocks/partners-block.php';
require_once get_template_directory() . '/inc/blocks/highlight-text-block.php';
require_once get_template_directory() . '/inc/blocks/news-list-block.php';
require_once get_template_directory() . '/inc/blocks/honor-board-block.php';
require_once get_template_directory() . '/inc/blocks/promo-packages-block.php';
require_once get_template_directory() . '/inc/blocks/block-filters.php';

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

    // Partners-block
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/partners-block',
        [ 'render_callback' => 'biotropika_render_partners_block' ]
    );

    // Highlight-text-block
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/highlight-text-block'
    );

    // News-list-block
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/news-list-block',
        [ 'render_callback' => 'biotropika_render_news_list_block' ]
    );

    // Honor-board-block
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/honor-board-block',
        [ 'render_callback' => 'biotropika_render_honor_board_block']
    );

    register_block_type_from_metadata( 
        get_template_directory() . '/build/js/blocks/promo-packages-block'
    );

});


/**
 * Ограничиваем список доступных блоков Gutenberg
 */

add_filter( 'allowed_block_types_all', function( $allowed_block_types, $editor_context ) {
    // здесь — разрешённые кастомные блоки
    $custom = [
        'biotropika/preview-block',
        'biotropika/scroll-animation-block',
        'biotropika/video-slider-block',
        'biotropika/horizontal-blocks',
        'biotropika/prize-fund-block',
        'biotropika/animated-video-block',
        'biotropika/reviews-cards-block',
        'biotropika/donate-widget-block',
        'biotropika/benefits-block',
        'biotropika/partners-block',
        'biotropika/highlight-text-block',
        'biotropika/news-list-block',
        'biotropika/honor-board-block',
        'biotropika/promo-packages-block',
        'biotropika/navigation-block',
        'biotropika/footer-block',
        // и любые другие ваши biotropika/* блоки
    ];

    // разрешённые штатные блоки core
    $core = [
        'core/image',
        'core/gallery',
        'core/video',
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/quote',
        'core/button',
    ];

    return array_merge( $custom, $core );
}, 10, 2 );