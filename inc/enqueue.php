<?php
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style('biotropika-main', get_template_directory_uri() . '/build/css/front-styles.css', [], '1.0.0');
    wp_enqueue_script('biotropika-main', get_template_directory_uri() . '/build/js/frontend.js', [], '1.0.0', true);
});
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style('biotropika-editor', get_template_directory_uri() . '/build/css/editor-styles.css', [], '1.0.0');
});