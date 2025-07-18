<?php
/**
 * Регистрация кастомных типов записей (CPT) для темы biotropika.
 * Все CPT поддерживают редактор блоков (Gutenberg).
 *
 * @package biotropika
 */
add_action('init', function() {
    // 1. ОТЗЫВЫ
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
        'show_in_rest' => true,
        'has_archive' => true,
    ]);

    // 2. ПАРТНЕРЫ
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
        'show_in_rest' => true,
        'has_archive' => true,
    ]);

    // 3. НОВОСТИ
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
        'show_in_rest' => true,
        'has_archive' => true,
    ]);

    // 4. ПРЕИМУЩЕСТВА
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
        'show_in_rest' => true,
        'has_archive' => true,
        // Таксономии добавятся в taxonomies.php (event_param, contest)
    ]);

    // 5. ИНТЕРВЬЮ
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
        'supports' => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
        'has_archive' => true,
    ]);

    // 6. ЛЮДИ
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
        'show_in_rest' => true,
        'has_archive' => true,
        // Таксономии добавятся в taxonomies.php (honor_board)
    ]);

    // 7. ТАБЛИЦЫ
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
        'show_in_rest' => true,
        'has_archive' => true,
        // Таксономии добавятся в taxonomies.php (contest)
    ]);

    // 8. РЕКЛАМНЫЕ ПАКЕТЫ
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
        'supports' => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
        'has_archive' => true,
    ]);
});
