<?php
/**
 * Регистрация кастомных типов записей для темы biotropika.
 * Все типы поддерживают редактор блоков (Gutenberg).
 *
 * @package biotropika
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Security

// Загрузка основных файлов инциализации
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/taxonomies.php';
require_once get_template_directory() . '/inc/gutenberg.php';
