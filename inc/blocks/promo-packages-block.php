<?php
/**
 * Серверный рендеринг блока promo-packages-block
 *
 * @package biotropika
 */

function biotropika_render_promo_packages_block( $attributes ) {
    // WP_Query: все опубликованные ad_package, отсортированные по цене
    $query = new WP_Query([
        'post_type'      => 'ad_package',
        'post_status'    => 'publish',
        'meta_key'       => 'package_price',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
        'posts_per_page' => -1,
    ]);

    if ( ! $query->have_posts() ) {
        return '<p class="promo-packages--none">'
            . esc_html__( 'Рекламные пакеты не найдены', 'biotropika' )
            . '</p>';
    }

    ob_start();
    ?>
    <div class="biotropika-promo-packages-block">
      <?php
      while ( $query->have_posts() ) :
          $query->the_post();
          $id            = get_the_ID();
          $title         = get_the_title();
          $services_raw  = get_post_meta( $id, 'package_services', true );
          $services      = array_filter( array_map( 'trim', explode( "\n", $services_raw ) ) );
          $price         = get_post_meta( $id, 'package_price', true );
          $is_best       = get_post_meta( $id, 'package_best', true );
      ?>
        <div class="promo-package">
          <h3 class="promo-package__title"><?php echo esc_html( $title ); ?></h3>

          <?php if ( $services ) : ?>
            <ul class="promo-package__services">
              <?php foreach ( $services as $svc ) : ?>
                <li><?php echo esc_html( $svc ); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php if ( '' !== $price ) : ?>
            <p class="promo-package__price">
              <?php
              /* translators: %s — цена пакета */
              echo esc_html( sprintf( __( 'Стоимость: %s', 'biotropika' ), $price ) );
              ?>
            </p>
          <?php endif; ?>

          <?php if ( $is_best ) : ?>
            <p class="promo-package__best"><?php echo esc_html__( 'Выгодно', 'biotropika' ); ?></p>
          <?php endif; ?>
        </div>
      <?php
      endwhile;
      wp_reset_postdata();
      ?>
    </div>
    <?php

    return ob_get_clean();
}

add_action( 'init', function() {
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/promo-packages-block',
        [ 'render_callback' => 'biotropika_render_promo_packages_block' ]
    );
} );
