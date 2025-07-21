<?php
/**
 * Кастомные поля для кастомных типов записей.
 * @package biotropika
 */

// ===== 1. ОТЗЫВЫ: Оценка =====
add_action('add_meta_boxes', function() {
    add_meta_box(
        'review_rating',
        'Оценка (1–5)',
        function($post){
            $value = get_post_meta($post->ID, 'rating', true);
            echo '<label>Оценка: <select name="review_rating">';
            for($i=1;$i<=5;$i++){
                echo '<option value="'.$i.'" '.selected($value, $i, false).'>'.$i.'</option>';
            }
            echo '</select></label>';
        },
        'review',
        'side'
    );
});
add_action('save_post_review', function($post_id){
    if(isset($_POST['review_rating'])){
        update_post_meta($post_id, 'rating', intval($_POST['review_rating']));
    }
});

// ===== 2. ПАРТНЕРЫ: Ссылка =====
add_action('add_meta_boxes', function() {
    add_meta_box(
        'partner_link',
        'Ссылка на сайт партнера',
        function($post){
            $value = get_post_meta($post->ID, 'partner_link', true);
            echo '<input type="url" name="partner_link" value="'.esc_attr($value).'" style="width:100%">';
        },
        'partner',
        'side'
    );
});
add_action('save_post_partner', function($post_id){
    if(isset($_POST['partner_link'])){
        update_post_meta($post_id, 'partner_link', esc_url_raw($_POST['partner_link']));
    }
});

// ===== 5. ИНТЕРВЬЮ: ссылки =====
add_action('add_meta_boxes', function() {
    add_meta_box(
        'interview_links',
        'Ссылки (видео, текст)',
        function($post){
            $video = get_post_meta($post->ID, 'interview_video', true);
            $text = get_post_meta($post->ID, 'interview_text', true);
            echo '<p><label>Ссылка на видео:<br><input type="url" name="interview_video" value="'.esc_attr($video).'" style="width:100%"></label></p>';
            echo '<p><label>Ссылка на текст интервью:<br><input type="url" name="interview_text" value="'.esc_attr($text).'" style="width:100%"></label></p>';
        },
        'interview',
        'normal'
    );
});
add_action('save_post_interview', function($post_id){
    if(isset($_POST['interview_video']))
        update_post_meta($post_id, 'interview_video', esc_url_raw($_POST['interview_video']));
    if(isset($_POST['interview_text']))
        update_post_meta($post_id, 'interview_text', esc_url_raw($_POST['interview_text']));
});

// ===== 8. РЕКЛАМНЫЕ ПАКЕТЫ: Стоимость, Выгодно =====
add_action('add_meta_boxes', function() {
    add_meta_box(
        'ad_package_price',
        'Детали пакета',
        function($post){
            $price = get_post_meta($post->ID, 'package_price', true);
            $best = get_post_meta($post->ID, 'package_best', true);
            echo '<p><label>Стоимость (₽):<br><input type="text" name="package_price" value="'.esc_attr($price).'" style="width:100%"></label></p>';
            echo '<p><label><input type="checkbox" name="package_best" value="1" '.checked($best,1,false).'> Выгодно</label></p>';
        },
        'ad_package',
        'side'
    );
});
add_action('save_post_ad_package', function($post_id){
    update_post_meta($post_id, 'package_price', sanitize_text_field($_POST['package_price'] ?? ''));
    update_post_meta($post_id, 'package_best', isset($_POST['package_best']) ? 1 : 0);
});

add_action('admin_menu', function() {
    // CPT, где не нужны произвольные поля
    $cpts = ['review','partner','news','benefit','interview','person','table','ad_package'];
    foreach($cpts as $cpt){
        remove_meta_box('postcustom', $cpt, 'normal');
    }
});

add_action('add_meta_boxes', function() {
    add_meta_box(
        'ad_package_services',
        'Перечень услуг, входящих в пакет',
        function($post){
            $services = get_post_meta($post->ID, 'package_services', true);
            echo '<p><textarea name="package_services" rows="6" style="width:100%;">'.esc_textarea($services).'</textarea></p>';
            echo '<small>Указывайте по одному пункту на строку.</small>';
        },
        'ad_package',
        'normal'
    );
});
add_action('save_post_ad_package', function($post_id){
    update_post_meta($post_id, 'package_services', sanitize_textarea_field($_POST['package_services'] ?? ''));
});

add_action('add_meta_boxes', function() {
    add_meta_box(
        'interview_links',
        'Ссылки (видео, текст)',
        function($post){
            $video = get_post_meta($post->ID, 'interview_video', true);
            $text_id = get_post_meta($post->ID, 'interview_text_id', true);

            // Список всех текстов интервью
            $opts = '';
            $texts = get_posts(['post_type'=>'interview_text', 'numberposts'=>-1, 'post_status'=>'publish']);
            foreach($texts as $it){
                $selected = $text_id == $it->ID ? 'selected' : '';
                $opts .= "<option value='{$it->ID}' $selected>{$it->post_title}</option>";
            }

            echo '<p><label>Ссылка на видео:<br><input type="url" name="interview_video" value="'.esc_attr($video).'" style="width:100%"></label></p>';
            echo '<p><label>Текст интервью:<br><select name="interview_text_id"><option value="">— Не выбрано —</option>'.$opts.'</select></label></p>';
        },
        'interview',
        'normal'
    );
});
add_action('save_post_interview', function($post_id){
    update_post_meta($post_id, 'interview_video', esc_url_raw($_POST['interview_video'] ?? ''));
    update_post_meta($post_id, 'interview_text_id', intval($_POST['interview_text_id'] ?? 0));
});
