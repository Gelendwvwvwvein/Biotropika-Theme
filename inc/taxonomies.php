<?php
/**
 * Регистрация кастомных таксономий для темы biotropika.
 * Все таксономии поддерживают редактор блоков (Gutenberg).
 *
 * @package biotropika
 */

add_action('init', function() {
    // 1. Параметры мероприятия (только для преимуществ)
    register_taxonomy('event_param', ['benefit'], [
        'label' => 'Параметры мероприятия',
        'labels' => [
            'singular_name' => 'Параметр мероприятия',
            'add_new_item' => 'Добавить параметр',
            'edit_item' => 'Редактировать параметр',
            'all_items' => 'Все параметры'
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ]);

    // 2. Состязания (для преимуществ и таблиц)
    register_taxonomy('contest', ['benefit', 'table'], [
        'label' => 'Состязания',
        'labels' => [
            'singular_name' => 'Состязание',
            'add_new_item' => 'Добавить состязание',
            'edit_item' => 'Редактировать состязание',
            'all_items' => 'Все состязания'
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ]);

    // 3. Доски почета (только для людей)
    register_taxonomy('honor_board', ['person'], [
        'label' => 'Доски почета',
        'labels' => [
            'singular_name' => 'Доска почета',
            'add_new_item' => 'Добавить доску почета',
            'edit_item' => 'Редактировать доску почета',
            'all_items' => 'Все доски почета'
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ]);
    
    // 4. Тип таблицы
    register_taxonomy('table_category', ['table'], [
        'label'             => 'Тип таблицы',
        'labels'            => [
            'singular_name' => 'Тип таблицы',
            'all_items'     => 'Все типы таблиц',
            'add_new_item'  => 'Добавить тип таблицы',
            'edit_item'     => 'Редактировать тип таблицы',
        ],
        'public'            => true,
        'hierarchical'      => true,    // рубрики-иерархия
        'show_in_rest'      => true,    // Gutenberg
        'show_admin_column' => true,
    ]);

    // 5. Год
    register_taxonomy('year', ['table'], [
        'label'             => 'Год',
        'labels'            => [
            'singular_name' => 'Год',
            'all_items'     => 'Все годы',
            'add_new_item'  => 'Добавить год',
            'edit_item'     => 'Редактировать год',
        ],
        'public'            => true,
        'hierarchical'      => false,   // тэги
        'show_in_rest'      => true,
        'show_admin_column' => true,
    ]);
});
