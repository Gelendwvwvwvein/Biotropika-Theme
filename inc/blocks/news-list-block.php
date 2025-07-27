<?php
/**
 * Рендер блока biotropika/news-list-block, ссылка на «Все новости» тянется из page_for_posts
 *
 * @package biotropika
 */
function biotropika_render_news_list_block( $attributes ) {
    // Получаем ID страницы записей из настроек WP
    $news_page_id = (int) get_option( 'page_for_posts' );

    // Собираем нужные посты
    $args = [
        'post_type'      => 'news',
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => empty( $attributes['showAll'] )
            ? intval( $attributes['newsCount'] )
            : -1,
    ];
    $posts = get_posts( $args );
    if ( empty( $posts ) ) {
        return '<p>' . esc_html__( 'Нет новостей', 'biotropika' ) . '</p>';
    }

    ob_start();
    ?>
    <div class="biotropika-news-list-block">
      <?php if ( $news_page_id ) : ?>
        <div class="news-list__all-link-wrap">
          <a
            class="news-list__all-button"
            href="<?php echo esc_url( get_permalink( $news_page_id ) ); ?>"
          >
            <?php echo esc_html__( 'Все новости', 'biotropika' ); ?>
          </a>
        </div>
      <?php endif; ?>

      <?php foreach ( $posts as $post ) :
          setup_postdata( $post );
          $thumb = has_post_thumbnail( $post->ID )
              ? get_the_post_thumbnail_url( $post->ID, 'medium' )
              : get_template_directory_uri() . '/assets/images/placeholder.jpg';
      ?>
        <div class="news-item">
          <img
            class="news-item__image"
            src="<?php echo esc_url( $thumb ); ?>"
            alt="<?php echo esc_attr( get_the_title( $post ) ); ?>"
          />
          <h3 class="news-item__title">
            <?php echo esc_html( get_the_title( $post ) ); ?>
          </h3>
          <p class="news-item__date">
            <?php echo esc_html( get_the_date( '', $post ) ); ?>
          </p>
          <a
            class="news-item__button"
            href="<?php echo esc_url( get_permalink( $post ) ); ?>"
          >
            <?php echo esc_html__( 'Читать', 'biotropika' ); ?>
          </a>
        </div>
      <?php endforeach; wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}

add_action( 'init', function() {
    register_block_type_from_metadata(
        get_template_directory() . '/build/js/blocks/news-list-block',
        [ 'render_callback' => 'biotropika_render_news_list_block' ]
    );
} );
