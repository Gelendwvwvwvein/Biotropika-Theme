<?php
/**
 * Шаблон главной / новости (если вы используете одну и ту же страницу).
 */

get_header();

// 1) Получаем ID страницы, которую вы выбрали в настройках темы
$options     = get_option( 'biotropika_theme_options', [] );
$news_page   = intval( $options['news_page'] ?? 0 );

if ( $news_page ) {
    $page = get_post( $news_page );
    if ( $page && 'publish' === $page->post_status ) {
        // Подготавливаем данные страницы
        setup_postdata( $page );
        echo '<div class="news-page-blocks">';
            // Выводим все блоки, которые вы собрали в Gutenberg
            the_content();
        echo '</div>';
        wp_reset_postdata();
    }
}

// 2) Теперь выводим обычный цикл новостей из CPT "news" (или из обычных постов)
$args = [
    'post_type'      => 'news',      // если у вас CPT называется 'news'
    'posts_per_page' => 10,          // или сколько вам нужно
    'orderby'        => 'date',
    'order'          => 'DESC',
];
$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    echo '<div class="news-list">';
    while ( $query->have_posts() ) {
        $query->the_post();
        ?>
        <article <?php post_class('news-item'); ?>>
            <?php if ( has_post_thumbnail() ): ?>
                <a href="<?php the_permalink(); ?>" class="news-item__thumb">
                    <?php the_post_thumbnail('medium'); ?>
                </a>
            <?php endif; ?>
            <h3 class="news-item__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="news-item__date"><?php echo get_the_date(); ?></p>
            <a class="biotropika-btn news-item__link" href="<?php the_permalink(); ?>">
                Читать новость
            </a>
        </article>
        <?php
    }
    echo '</div>';
    // при необходимости — навигация пагинации
    the_posts_pagination();
    wp_reset_postdata();
} else {
    echo '<p>Новостей пока нет.</p>';
}

get_footer();
