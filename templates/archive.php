<?php
get_header();
if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
    <article>
        <h2><?php the_title(); ?></h2>
        <div><?php the_excerpt(); ?></div>
    </article>
    <?php endwhile;

else :
    echo '<p>Записей не найдено.</p>';
endif;
get_footer();
