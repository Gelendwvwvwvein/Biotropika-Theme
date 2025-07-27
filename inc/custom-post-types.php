<?php
/**
 * Регистрация кастомных типов записей (CPT) для темы biotropika.
 * С учетом типа редактора (Gutenberg/Classic) для каждого CPT.
 *
 * @package biotropika
 */

add_action('init', function() {
    // 1. ОТЗЫВЫ (classic)
    register_post_type('review', [
        'label' => 'Отзывы',
        'labels' => [
            'singular_name' => 'Отзыв',
            'add_new' => 'Добавить отзыв',
            'add_new_item' => 'Новый отзыв',
            'edit_item' => 'Редактировать отзыв',
            'all_items' => 'Все отзывы',
        ],  
        'public' => true,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,  // Classic editor
        'has_archive' => true,
        'capability_type' => 'post',
        'capabilities' => [
            'create_posts' => 'edit_others_posts',
        ],
        'map_meta_cap' => true,
    ]);

    // 2. ПАРТНЕРЫ (classic)
    register_post_type('partner', [
        'label' => 'Партнеры',
        'labels' => [
            'singular_name' => 'Партнер',
            'add_new' => 'Добавить партнера',
            'add_new_item' => 'Новый партнер',
            'edit_item' => 'Редактировать партнера',
            'all_items' => 'Все партнеры',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'thumbnail', 'custom-fields'],
        'show_in_rest' => true, // Classic editor
        'has_archive' => true,
        'capability_type' => 'post',
        'capabilities' => [
            'create_posts' => 'edit_others_posts',
        ],
        'map_meta_cap' => true,
    ]);

    // 3. НОВОСТИ (gutenberg)
    register_post_type('news', [
        'label' => 'Новости',
        'labels' => [
            'singular_name' => 'Новость',
            'add_new' => 'Добавить новость',
            'add_new_item' => 'Новая новость',
            'edit_item' => 'Редактировать новость',
            'all_items' => 'Все новости',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true, // Gutenberg
        'has_archive' => false,
        'rewrite'     => [ 'slug' => 'news-item' ],
        'capability_type' => 'post',
        'capabilities' => [
            'create_posts' => 'edit_others_posts',
        ],
        'map_meta_cap' => true,
    ]);

    // 4. ПРЕИМУЩЕСТВА (gutenberg)
    register_post_type('benefit', [
        'label' => 'Преимущества',
        'labels' => [
            'singular_name' => 'Преимущество',
            'add_new' => 'Добавить преимущество',
            'add_new_item' => 'Новое преимущество',
            'edit_item' => 'Редактировать преимущество',
            'all_items' => 'Все преимущества',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-awards',
        'supports' => ['title', 'editor', 'custom-fields', 'page-attributes'],
        'show_in_rest' => true, // Gutenberg
        'has_archive' => true,
        'capability_type' => 'post',
        'capabilities' => [
            'create_posts' => 'edit_others_posts',
        ],
        'map_meta_cap' => true,
    ]);

    // 5. ИНТЕРВЬЮ (classic)
    register_post_type('interview', [
        'label' => 'Интервью',
        'labels' => [
            'singular_name' => 'Интервью',
            'add_new' => 'Добавить интервью',
            'add_new_item' => 'Новое интервью',
            'edit_item' => 'Редактировать интервью',
            'all_items' => 'Все интервью',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-microphone',
        'supports' => ['title', 'editor', 'custom-fields', 'thumbnail'],
        'show_in_rest' => true, // Classic editor
        'has_archive' => true,
        'capability_type' => 'post',
        'capabilities' => [
            'create_posts' => 'edit_others_posts',
        ],
        'map_meta_cap' => true,
    ]);

    // 6. ЛЮДИ (classic)
    register_post_type('person', [
        'label' => 'Люди',
        'labels' => [
            'singular_name' => 'Человек',
            'add_new' => 'Добавить человека',
            'add_new_item' => 'Новый человек',
            'edit_item' => 'Редактировать человека',
            'all_items' => 'Все люди',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-id',
        'supports' => ['title', 'thumbnail', 'editor', 'custom-fields'],
        'show_in_rest' => true, // Classic editor
        'has_archive' => true,
        'capability_type' => 'post',
        'capabilities' => [
            'create_posts' => 'edit_others_posts',
        ],
        'map_meta_cap' => true,
    ]);

    // 7. ТАБЛИЦЫ (gutenberg)
    register_post_type('table', [
        'label' => 'Таблицы',
        'labels' => [
            'singular_name' => 'Таблица',
            'add_new' => 'Добавить таблицу',
            'add_new_item' => 'Новая таблица',
            'edit_item' => 'Редактировать таблицу',
            'all_items' => 'Все таблицы',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-editor-table',
        'supports' => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true, // Gutenberg
        'has_archive' => true,
        'capability_type' => 'post',
        'capabilities' => [
            'create_posts' => 'edit_others_posts',
        ],
        'map_meta_cap' => true,
    ]);

    // 8. РЕКЛАМНЫЕ ПАКЕТЫ (classic)
    register_post_type('ad_package', [
        'label' => 'Рекламные пакеты',
        'labels' => [
            'singular_name' => 'Рекламный пакет',
            'add_new' => 'Добавить пакет',
            'add_new_item' => 'Новый пакет',
            'edit_item' => 'Редактировать пакет',
            'all_items' => 'Все пакеты',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-cart',
        'supports' => ['title', 'custom-fields'],
        'show_in_rest' => true, // Classic editor
        'has_archive' => true,
        'capability_type' => 'post',
        'capabilities' => [
            'create_posts' => 'edit_others_posts',
        ],
        'map_meta_cap' => true,
    ]);

    // 9. ТЕКСТЫ ИНТЕРВЬЮ (Gutenberg)
    register_post_type('interview_text', [
        'label'           => 'Тексты интервью',
        'labels'          => [
            'singular_name'   => 'Текст интервью',
            'add_new'         => 'Добавить текст',
            'add_new_item'    => 'Новый текст интервью',
            'edit_item'       => 'Редактировать текст интервью',
            'all_items'       => 'Все тексты интервью',
        ],
        'public'          => true,
        'menu_icon'       => 'dashicons-media-document',
        'supports'        => ['title', 'editor', 'excerpt'],
        'show_in_rest'    => true,   // Gutenberg
        'has_archive'     => true,
        'capability_type' => 'post',
        'capabilities'    => [
            'create_posts' => 'edit_others_posts',
        ],
        'map_meta_cap'    => true,
    ] );

    // Регистрируем мета-поле interview_parent_id
    register_post_meta( 'interview_text', 'interview_parent_id', [
        'show_in_rest' => true,    // чтобы Gutenberg API принял его в meta[]
        'single'       => true,
        'type'         => 'integer',
    ] );

});
