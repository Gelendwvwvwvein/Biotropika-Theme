<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="logo">
        <a href="<?php echo esc_url( home_url('/') ); ?>">
            <?php if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                bloginfo('name');
            } ?>
        </a>
    </div>
    <?php
        if ( has_nav_menu('main-menu') ) {
            wp_nav_menu([
                'theme_location' => 'main-menu',
                'container' => 'nav',
                'container_class' => 'main-nav'
            ]);
        }
    ?>
</header>
