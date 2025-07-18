<?php
/**
 * Регистрация кастомных типов записей для темы biotropika.
 * Все типы поддерживают редактор блоков (Gutenberg).
 *
 * @package biotropika
 */
add_action('after_setup_theme', function() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    register_nav_menus([
        'main-menu' => 'Главное меню',
    ]);
});
