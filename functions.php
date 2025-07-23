<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Security

// Загрузка основных файлов инциализации
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/taxonomies.php';
require_once get_template_directory() . '/inc/gutenberg.php';
require_once get_template_directory() . '/inc/editor-override.php';
require_once get_template_directory() . '/inc/meta-boxes.php';
require_once get_template_directory() . '/inc/admin-customizations.php';
require_once get_template_directory() . '/inc/theme-options.php';
require_once get_template_directory() . '/inc/blocks/registrations/custom.php';
require_once get_template_directory() . '/inc/blocks/registrations/standard.php';

