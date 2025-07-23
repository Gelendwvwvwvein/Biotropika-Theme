<?php
/**
 * Server‑side render for the video‑slider‑block.
 *
 * @package biotropika
 */

/**
 * Renders the video-slider-block on the frontend.
 *
 * @param array $attributes Block attributes.
 * @return string           Block HTML.
 */
function biotropika_render_video_slider_block( $attributes ) {
    $mode        = $attributes['mode'] ?? 'custom';
    $items       = $attributes['items'] ?? [];
    $select_all  = ! empty( $attributes['selectAllInterviews'] );
    $selected    = $attributes['interviews'] ?? [];

    ob_start();
    echo '<div class="biotropika-video-slider-block">';

    // ==== CUSTOM MODE ====
    if ( 'custom' === $mode ) {
        foreach ( $items as $idx => $item ) {
            $videoUrl   = trim( $item['videoUrl'] ?? '' );
            $previewUrl = trim( $item['previewUrl'] ?? '' );
            $title      = trim( $item['title'] ?? '' );
            $content    = wp_kses_post( $item['content'] ?? '' );
            $btnText    = trim( $item['buttonText'] ?? '' );
            $btnLink    = esc_url( $item['buttonLink'] ?? '' );

            echo '<div class="slide">';

            if ( $videoUrl ) {
                printf(
                    '<a class="slide__link" href="%1$s" target="_blank" rel="noopener">
                        <img class="slide__image" src="%2$s" alt="">
                        <h3 class="slide__title">%3$s</h3>
                     </a>',
                    esc_url( $videoUrl ),
                    esc_url( $previewUrl ?: get_template_directory_uri() . '/assets/images/placeholder.jpg' ),
                    esc_html( $title ?: $videoUrl )
                );
            }

            if ( $content ) {
                printf(
                    '<p class="slide__content">%s</p>',
                    $content
                );
            }

            if ( $btnText && $btnLink ) {
                printf(
                    '<a class="biotropika-btn slide__button" href="%1$s">%2$s</a>',
                    esc_url( $btnLink ),
                    esc_html( $btnText )
                );
            }

            echo '</div>';
        }
    }

    // ==== INTERVIEW MODE ====
    if ( 'interview' === $mode ) {
        $query_args = [
            'post_type'      => 'interview',
            'post_status'    => 'publish',
            'orderby'        => $select_all ? 'date' : 'post__in',
            'order'          => 'DESC',
            'posts_per_page' => -1,
        ];
        if ( ! $select_all && ! empty( $selected ) ) {
            $query_args['post__in'] = $selected;
        }

        $q = new WP_Query( $query_args );
        if ( $q->have_posts() ) {
            while ( $q->have_posts() ) {
                $q->the_post();

                $videoUrl   = get_post_meta( get_the_ID(), 'interview_video', true );
                $textId     = get_post_meta( get_the_ID(), 'interview_text_id', true );
                $textLink   = $textId ? get_permalink( $textId ) : '';
                $previewUrl = get_the_post_thumbnail_url( null, 'full' ) ?: get_template_directory_uri() . '/assets/images/placeholder.jpg';

                echo '<div class="slide">';
                if ( $videoUrl ) {
                    printf(
                        '<a class="slide__link" href="%1$s" target="_blank" rel="noopener">
                            <img class="slide__image" src="%2$s" alt="%3$s">
                            <h3 class="slide__title">%4$s</h3>
                         </a>',
                        esc_url( $videoUrl ),
                        esc_url( $previewUrl ),
                        esc_attr( get_the_title() ),
                        esc_html( get_the_title() )
                    );
                }

                echo '<div class="slide__content">';
                the_content();
                echo '</div>';

                if ( $textLink ) {
                    printf(
                        '<a class="biotropika-btn slide__button" href="%1$s">%2$s</a>',
                        esc_url( $textLink ),
                        esc_html__( 'Читать текст', 'biotropika' )
                    );
                }
                echo '</div>';
            }
            wp_reset_postdata();
        } else {
            printf(
                '<p class="slide__no-items">%s</p>',
                esc_html__( 'Нет доступных интервью', 'biotropika' )
            );
        }
    }

    echo '</div>';
    return ob_get_clean();
}

// Register server‑rendered block:
add_action( 'init', function() {
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/video-slider-block',
        [ 'render_callback' => 'biotropika_render_video_slider_block' ]
    );
} );
