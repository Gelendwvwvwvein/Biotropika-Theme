<?php
/**
 * Рендер для biotropika/partners-block
 *
 * @package biotropika
 */
function biotropika_render_partners_block( $attributes ) {
    // 1) Год мероприятия из опций
    $opts = get_option( 'biotropika_theme_options', [] );
    $year = intval( $opts['year'] ?? 0 );

    // 2) Берём всех опубликованных партнёров
    $partners = get_posts([
        'post_type'      => 'partner',
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => -1,
    ]);
    if ( empty( $partners ) ) {
        return '<p>' . esc_html__( 'Нет активных партнёров', 'biotropika' ) . '</p>';
    }

    ob_start();
    ?>
    <div class="biotropika-partners-block">
      <?php if ( $year ) : ?>
        <h2 class="biotropika-partners-block__year">
          <?php echo esc_html( $year ); ?>
        </h2>
      <?php endif; ?>

      <div class="biotropika-partners-block__grid">
        <?php foreach ( $partners as $post ) : setup_postdata( $post );
            // логотип
            $logo = has_post_thumbnail( $post->ID )
                ? get_the_post_thumbnail_url( $post->ID, 'full' )
                : get_template_directory_uri() . '/assets/images/placeholder.jpg';
            // ссылка партнёра
            $link = get_post_meta( $post->ID, 'partner_link', true );
        ?>
          <a
            class="biotropika-partners-block__link"
            href="<?php echo esc_url( $link ?: '#' ); ?>"
            target="_blank"
            rel="noopener"
          >
            <img
              class="biotropika-partners-block__logo"
              src="<?php echo esc_url( $logo ); ?>"
              alt="<?php echo esc_attr( get_the_title( $post ) ); ?>"
            />
          </a>
        <?php endforeach; wp_reset_postdata(); ?>
      </div>
    </div>
    <?php
    return ob_get_clean();
}

add_action( 'init', function() {
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/partners-block',
        [ 'render_callback' => 'biotropika_render_partners_block' ]
    );
} );
