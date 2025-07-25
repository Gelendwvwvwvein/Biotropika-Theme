<?php
/**
 * Серверный рендер для biotropika/reviews-cards-block
 */
function biotropika_render_reviews_cards_block( $attributes ) {
    $posts = get_posts([
        'post_type'      => 'review',
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => -1,
    ]);
    if ( empty( $posts ) ) {
        return '<p>' . esc_html__( 'Нет отзывов', 'biotropika' ) . '</p>';
    }

    ob_start();
    ?>
    <div class="biotropika-reviews-cards-block">
    <?php
    $count = 0;
    foreach ( $posts as $post ) {
        setup_postdata( $post );
        $rating  = get_post_meta( $post->ID, 'rating', true );
        $author  = get_the_title( $post );
        $content = apply_filters( 'the_content', $post->post_content );

        // первые 4 — сразу видны, остальные — скрыты (через inline style)
        $is_visible = ( $count < 4 );
        $classes    = 'review ' . ( $is_visible ? 'visible' : 'hidden' );
        $style_attr = $is_visible ? '' : 'style="display:none;"';
        ?>
        <div class="<?php echo esc_attr( $classes ); ?>" <?php echo $style_attr; ?>>
            <div class="review__rating"><?php echo esc_html( $rating ); ?>/5</div>
            <div class="review__author"><?php echo esc_html( $author ); ?></div>
            <div class="review__text"><?php echo wp_kses_post( $content ); ?></div>
        </div>
        <?php
        $count++;
    }
    wp_reset_postdata();
    ?>
    </div>
    <?php
    return ob_get_clean();
}

add_action( 'init', function() {
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/reviews-cards-block',
        [ 'render_callback' => 'biotropika_render_reviews_cards_block' ]
    );
} );
