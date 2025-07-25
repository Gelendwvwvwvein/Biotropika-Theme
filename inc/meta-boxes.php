<?php
/**
 * Кастомные поля для кастомных типов записей.
 *
 * @package biotropika
 */

// ===== 1. ОТЗЫВЫ: Оценка =====
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'review_rating',
        'Оценка (1–5)',
        function( WP_Post $post ) {
            $value = get_post_meta( $post->ID, 'rating', true );
            echo '<label>Оценка: <select name="review_rating">';
            for ( $i = 1; $i <= 5; $i++ ) {
                printf(
                    '<option value="%1$d" %2$s>%1$d</option>',
                    $i,
                    selected( $value, $i, false )
                );
            }
            echo '</select></label>';
        },
        'review',
        'side'
    );
});
add_action( 'save_post_review', function( $post_id ) {
    if ( isset( $_POST['review_rating'] ) ) {
        update_post_meta( $post_id, 'rating', intval( $_POST['review_rating'] ) );
    }
});

// ===== 2. ПАРТНЕРЫ: Ссылка =====
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'partner_link',
        'Ссылка на сайт партнера',
        function( WP_Post $post ) {
            $value = get_post_meta( $post->ID, 'partner_link', true );
            printf(
                '<input type="url" name="partner_link" value="%s" style="width:100%%;">',
                esc_attr( $value )
            );
        },
        'partner',
        'side'
    );
});
add_action( 'save_post_partner', function( $post_id ) {
    if ( isset( $_POST['partner_link'] ) ) {
        update_post_meta( $post_id, 'partner_link', esc_url_raw( $_POST['partner_link'] ) );
    }
});

// ===== 3. ИНТЕРВЬЮ: ссылки и выбор текста =====
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'interview_links',
        'Ссылки (видео, текст)',
        'biotropika_interview_links_box',
        'interview',
        'normal'
    );
});
function biotropika_interview_links_box( WP_Post $post ) {
    wp_nonce_field( 'biotropika_save_interview_links', 'biotropika_interview_links_nonce' );

    // — Ссылка на видео
    $video = get_post_meta( $post->ID, 'interview_video', true );
    echo '<p><label>Ссылка на видео:<br>';
    printf(
        '<input type="url" name="interview_video" value="%s" style="width:100%%;">',
        esc_attr( $video )
    );
    echo '</label></p>';

    // — Селект выбора существующего текста интервью
    $text_id = get_post_meta( $post->ID, 'interview_text_id', true );
    $texts   = get_posts( [
        'post_type'   => 'interview_text',
        'numberposts' => -1,
        'post_status' => 'publish',
    ] );
    echo '<p><label>Текст интервью:<br><select name="interview_text_id">';
    echo '<option value="">— Не выбрано —</option>';
    foreach ( $texts as $t ) {
        printf(
            '<option value="%1$u" %2$s>%3$s</option>',
            $t->ID,
            selected( $text_id, $t->ID, false ),
            esc_html( $t->post_title )
        );
    }
    echo '</select></label></p>';

    // — Кнопка для создания нового текста (без автосвязи)
    printf(
        '<p><a href="%1$s" class="button">%2$s</a></p>',
        esc_url( admin_url( 'post-new.php?post_type=interview_text' ) ),
        esc_html__( 'Добавить текст интервью', 'biotropika' )
    );
}
add_action( 'save_post_interview', function( $post_id ) {
    if (
        empty( $_POST['biotropika_interview_links_nonce'] ) ||
        ! wp_verify_nonce( $_POST['biotropika_interview_links_nonce'], 'biotropika_save_interview_links' )
    ) {
        return;
    }
    if ( isset( $_POST['interview_video'] ) ) {
        update_post_meta( $post_id, 'interview_video', esc_url_raw( $_POST['interview_video'] ) );
    }
    if ( isset( $_POST['interview_text_id'] ) ) {
        update_post_meta( $post_id, 'interview_text_id', intval( $_POST['interview_text_id'] ) );
    }
});

// ===== 4. РЕКЛАМНЫЕ ПАКЕТЫ: Стоимость, Выгодно =====
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'ad_package_price',
        'Детали пакета',
        function( WP_Post $post ) {
            $price = get_post_meta( $post->ID, 'package_price', true );
            $best  = get_post_meta( $post->ID, 'package_best', true );
            echo '<p><label>Стоимость (₽):<br>';
            printf(
                '<input type="text" name="package_price" value="%s" style="width:100%%;">',
                esc_attr( $price )
            );
            echo '</label></p>';
            echo '<p><label>';
            printf(
                '<input type="checkbox" name="package_best" value="1" %s> Выгодно',
                checked( $best, 1, false )
            );
            echo '</label></p>';
        },
        'ad_package',
        'side'
    );
});
add_action( 'save_post_ad_package', function( $post_id ) {
    update_post_meta( $post_id, 'package_price', sanitize_text_field( $_POST['package_price'] ?? '' ) );
    update_post_meta( $post_id, 'package_best', isset( $_POST['package_best'] ) ? 1 : 0 );
});

// ===== 5. Перечень услуг в рекламных пакетах =====
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'ad_package_services',
        'Перечень услуг, входящих в пакет',
        function( WP_Post $post ) {
            $services = get_post_meta( $post->ID, 'package_services', true );
            printf(
                '<textarea name="package_services" rows="6" style="width:100%%;">%s</textarea>',
                esc_textarea( $services )
            );
            echo '<p><small>По одному пункту на строку.</small></p>';
        },
        'ad_package',
        'normal'
    );
});
add_action( 'save_post_ad_package', function( $post_id ) {
    update_post_meta( $post_id, 'package_services', sanitize_textarea_field( $_POST['package_services'] ?? '' ) );
});

// ===== 6. Убираем стандартное meta-box “Настроить поля” =====
add_action( 'admin_menu', function() {
    $cpts = [
        'review','partner','news','benefit',
        'interview','person','table','ad_package','interview_text'
    ];
    foreach ( $cpts as $cpt ) {
        remove_meta_box( 'postcustom', $cpt, 'normal' );
    }
} );

// ===== 7. РЕКЛАМНЫЕ ПАКЕТЫ: Стоимость, Выгодно =====
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'ad_package_price',
        'Детали пакета',
        function( $post ) {
            $price = get_post_meta( $post->ID, 'package_price', true );
            $best  = get_post_meta( $post->ID, 'package_best', true );
            echo '<p><label>Стоимость (₽):<br>';
            printf(
                '<input type="text" name="package_price" value="%s" style="width:100%%;">',
                esc_attr( $price )
            );
            echo '</label></p>';
            echo '<p><label>';
            printf(
                '<input type="checkbox" name="package_best" value="1" %s> Выгодно',
                checked( $best, 1, false )
            );
            echo '</label></p>';
        },
        'ad_package',
        'side'
    );
});
add_action( 'save_post_ad_package', function( $post_id ) {
    update_post_meta( $post_id, 'package_price', sanitize_text_field( $_POST['package_price'] ?? '' ) );
    update_post_meta( $post_id, 'package_best', isset( $_POST['package_best'] ) ? 1 : 0 );
} );

// ===== 8. Перечень услуг в рекламных пакетах =====
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'ad_package_services',
        'Перечень услуг, входящих в пакет',
        function( $post ) {
            $services = get_post_meta( $post->ID, 'package_services', true );
            printf(
                '<textarea name="package_services" rows="6" style="width:100%%;">%s</textarea>',
                esc_textarea( $services )
            );
            echo '<p><small>Указывайте по одному пункту на строку.</small></p>';
        },
        'ad_package',
        'normal'
    );
});
add_action( 'save_post_ad_package', function( $post_id ) {
    update_post_meta( $post_id, 'package_services', sanitize_textarea_field( $_POST['package_services'] ?? '' ) );
} );

// ===== 9. Убираем стандартный meta-box “Настроить поля” =====
add_action( 'admin_menu', function() {
    $cpts = [
        'review','partner','news','benefit',
        'interview','person','table','ad_package','interview_text'
    ];
    foreach ( $cpts as $cpt ) {
        remove_meta_box( 'postcustom', $cpt, 'normal' );
    }
} );
