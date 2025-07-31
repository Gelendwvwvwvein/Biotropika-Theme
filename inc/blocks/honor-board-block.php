<?php
/**
 * Серверный рендеринг блока «Доска почёта» (honor-board-block)
 *
 * @package biotropika
 */

/**
 * Рендерит блок «Доска почёта» с возможностью показа регалий.
 *
 * @param array $attributes Атрибуты блока.
 * @return string HTML для вывода в шаблоне.
 */
function biotropika_render_honor_board_block( $attributes ) {
    $term_id      = intval( $attributes['term'] ?? 0 );
    $order        = $attributes['order'] ?? 'manual';
    $manual       = $attributes['manualOrder'] ?? [];
    $show_laps    = ! empty( $attributes['showLaps'] );
    $show_desc    = ! empty( $attributes['showDesc'] );
    $show_regalia = ! empty( $attributes['showRegalia'] );

    if ( ! $term_id ) {
        return '<p>' . esc_html__( 'Не выбрана доска почёта', 'biotropika' ) . '</p>';
    }

    $args = [
        'post_type'      => 'person',
        'post_status'    => 'publish',
        'tax_query'      => [
            [
                'taxonomy' => 'honor_board',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ],
        ],
        'posts_per_page' => -1,
    ];

    // Устанавливаем порядок
    if ( 'manual' === $order && ! empty( $manual ) ) {
        $args['post__in'] = $manual;
        $args['orderby']  = 'post__in';
    } elseif ( 'name_asc' === $order ) {
        $args['orderby'] = 'title';
        $args['order']   = 'ASC';
    } elseif ( 'laps_desc' === $order ) {
        $args['meta_key'] = 'person_laps';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = 'DESC';
    } elseif ( 'surname_asc' === $order ) {
        // упрощенно: сортируем по title
        $args['orderby'] = 'title';
        $args['order']   = 'ASC';
    }

    $people = get_posts( $args );
    if ( empty( $people ) ) {
        return '<p>' . esc_html__( 'Нет записей', 'biotropika' ) . '</p>';
    }

    ob_start();
    ?>
    <div class="biotropika-honor-board-block">
      <?php foreach ( $people as $post ) : setup_postdata( $post ); 
          // Фото
          $photo = has_post_thumbnail( $post->ID )
                 ? get_the_post_thumbnail( $post->ID, 'thumbnail', [ 'class' => 'honor-item__photo' ] )
                 : '';
          // Круги
          $laps  = get_post_meta( $post->ID, 'person_laps', true );
          // Регалии
          $regalia_terms = get_the_terms( $post->ID, 'regalia' );
          $regalia_names = [];
          if ( is_array( $regalia_terms ) ) {
              foreach ( $regalia_terms as $term ) {
                  $regalia_names[] = $term->name;
              }
          }
      ?>
        <div class="honor-item">
          <?php echo $photo; ?>

          <h6 class="honor-item__name">
            <?php echo esc_html( get_the_title( $post ) ); ?>
          </h6>

          <?php if ( $show_desc ) : ?>
            <p class="honor-item__desc">
              <?php echo wp_kses_post( apply_filters( 'the_content', $post->post_content ) ); ?>
            </p>
          <?php endif; ?>

          <?php if ( $show_regalia && ! empty( $regalia_names ) ) : ?>
            <p class="honor-item__regalia">
              <?php echo esc_html( implode( ', ', $regalia_names ) ); ?>
            </p>
          <?php endif; ?>

          <?php if ( $show_laps && $laps ) : ?>
            <p class="honor-item__laps">
              <?php 
                /* translators: %d — количество кругов */ 
                echo esc_html( sprintf( __( '%d кругов', 'biotropika' ), intval( $laps ) ) ); 
              ?>
            </p>
          <?php endif; ?>

        </div>
      <?php endforeach; wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}
