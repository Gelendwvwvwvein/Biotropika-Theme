<?php

add_filter( 'render_block', function( $block_content, $block ) {
    // 1) Если блок получил атрибут isHidden=true → ничего не выводим
    if ( ! empty( $block->attrs['isHidden'] ) ) {
        return '';
    }

    // 2) Подмена пустых картинок на URL плейсхолдера
    //    Подставляем только для <img> без src
    if ( preg_match_all( '/<img[^>]*>/', $block_content, $matches ) ) {
        $opts = get_option( 'biotropika_theme_options', [] );
        $placeholder_id  = $opts['placeholder_img'] ?? 0;
        $placeholder_url = $placeholder_id
            ? wp_get_attachment_image_url( $placeholder_id, 'full' )
            : '';

        $block_content = preg_replace_callback(
            '/<img([^>]*)src=(["\'])(.*?)\2([^>]*)>/i',
            function( $m ) use ( $placeholder_url ) {
                // если src="" или src отсутствует — заменим
                if ( empty( trim( $m[3] ) ) ) {
                    return '<img' . $m[1] . 'src="' . esc_url( $placeholder_url ) . '"' . $m[4] . '>';
                }
                return $m[0];
            },
            $block_content
        );
    }

    return $block_content;
}, 10, 2 );