<?php

add_filter('use_block_editor_for_post_type', function($use_block_editor, $post_type) {
    // CPT, которые должны быть только с классическим редактором
    $classic_cpts = ['review', 'partner', 'interview', 'person', 'ad_package'];
    if (in_array($post_type, $classic_cpts, true)) {
        return false;
    }
    return $use_block_editor;
}, 10, 2);
