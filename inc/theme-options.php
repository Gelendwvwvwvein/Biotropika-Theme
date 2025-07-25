<?php
/**
 * Настройки темы Biotropika.
 *
 * @package biotropika
 */

// Создать страницу опций в меню "Внешний вид"
add_action('admin_menu', function(){
    add_theme_page(
        'Настройки Biotropika',
        'Настройки Biotropika',
        'edit_theme_options',
        'biotropika-theme-options',
        'biotropika_theme_options_page'
    );
});

// Рендер формы опций
function biotropika_theme_options_page(){
    ?>
    <div class="wrap">
        <h1>Настройки темы Biotropika</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('biotropika_theme_options');
                do_settings_sections('biotropika_theme_options');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Регистрация настроек и полей
add_action('admin_init', function(){
    register_setting('biotropika_theme_options', 'biotropika_theme_options');

    add_settings_section('biotropika_main', '', null, 'biotropika_theme_options');

    // Год мероприятия
    add_settings_field('year', 'Год мероприятия', function(){
        $opts = get_option('biotropika_theme_options');
        printf(
            '<input type="text" name="biotropika_theme_options[year]" value="%s" />',
            esc_attr($opts['year'] ?? '')
        );
    }, 'biotropika_theme_options', 'biotropika_main');

    // Ссылка на регистрацию
    add_settings_field('reg_link', 'Ссылка на регистрацию', function(){
        $opts = get_option('biotropika_theme_options');
        printf(
            '<input type="url" name="biotropika_theme_options[reg_link]" value="%s" style="width:100%%;" />',
            esc_attr($opts['reg_link'] ?? '')
        );
    }, 'biotropika_theme_options', 'biotropika_main');

    // Прейсхолдер (по умолчанию)
    add_settings_field('placeholder_img', 'Прейсхолдер (по умолчанию)', function(){
        $opts = get_option('biotropika_theme_options');
        $id   = $opts['placeholder_img'] ?? '';
        $url  = $id ? wp_get_attachment_image_url($id, 'thumbnail') : '';
        ?>
        <div class="biotropika-media-wrap">
            <img id="placeholder_img_preview" src="<?php echo esc_url($url); ?>"
                 style="max-width:80px; max-height:80px; <?php echo $url ? '' : 'display:none;'; ?>" />
            <input type="hidden" id="placeholder_img" name="biotropika_theme_options[placeholder_img]"
                   value="<?php echo esc_attr($id); ?>" />
            <button type="button" class="button biotropika-media-btn" data-target="placeholder_img">
                Выбрать изображение
            </button>
            <button type="button" class="button biotropika-media-remove" data-target="placeholder_img">
                Удалить
            </button>
        </div>
        <?php
    }, 'biotropika_theme_options', 'biotropika_main');

    // Логотип для шапки
    add_settings_field('header_logo', 'Логотип для шапки', function(){
        $opts = get_option('biotropika_theme_options');
        $id   = $opts['header_logo'] ?? '';
        $url  = $id ? wp_get_attachment_image_url($id, 'thumbnail') : '';
        ?>
        <div class="biotropika-media-wrap">
            <img id="header_logo_preview" src="<?php echo esc_url($url); ?>"
                 style="max-width:80px; max-height:80px; <?php echo $url ? '' : 'display:none;'; ?>" />
            <input type="hidden" id="header_logo" name="biotropika_theme_options[header_logo]"
                   value="<?php echo esc_attr($id); ?>" />
            <button type="button" class="button biotropika-media-btn" data-target="header_logo">
                Выбрать изображение
            </button>
            <button type="button" class="button biotropika-media-remove" data-target="header_logo">
                Удалить
            </button>
        </div>
        <?php
    }, 'biotropika_theme_options', 'biotropika_main');

    // Логотип для футера
    add_settings_field('footer_logo', 'Логотип для футера', function(){
        $opts = get_option('biotropika_theme_options');
        $id   = $opts['footer_logo'] ?? '';
        $url  = $id ? wp_get_attachment_image_url($id, 'thumbnail') : '';
        ?>
        <div class="biotropika-media-wrap">
            <img id="footer_logo_preview" src="<?php echo esc_url($url); ?>"
                 style="max-width:80px; max-height:80px; <?php echo $url ? '' : 'display:none;'; ?>" />
            <input type="hidden" id="footer_logo" name="biotropika_theme_options[footer_logo]"
                   value="<?php echo esc_attr($id); ?>" />
            <button type="button" class="button biotropika-media-btn" data-target="footer_logo">
                Выбрать изображение
            </button>
            <button type="button" class="button biotropika-media-remove" data-target="footer_logo">
                Удалить
            </button>
        </div>
        <?php
    }, 'biotropika_theme_options', 'biotropika_main');
});

// Подключить WP Media и инициализировать JS
add_action('admin_enqueue_scripts', function($hook){
    if ($hook !== 'appearance_page_biotropika-theme-options') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script(
    'biotropika-media-uploader',
    get_template_directory_uri() . '/inc/js/media-uploader.js',
    ['jquery'],
    filemtime( get_template_directory() . '/inc/js/media-uploader.js' ),
    true
    );


});

// JS-инициализация медиазагрузчика прямо в футере страницы
add_action('admin_footer', function(){
    $screen = get_current_screen();
    if ($screen->id !== 'appearance_page_biotropika-theme-options') {
        return;
    }
    ?>
    <script>
    (function($){
        let frame;
        $('.biotropika-media-btn').on('click', function(e){
            e.preventDefault();
            const target = $(this).data('target');
            if(frame){
                frame.open();
                return;
            }
            frame = wp.media({
                title: 'Выберите изображение',
                button: { text: 'Использовать' },
                multiple: false
            });
            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();
                $('#' + target).val(attachment.id);
                $('#' + target + '_preview')
                    .attr('src', attachment.url)
                    .show();
            });
            frame.open();
        });
        $('.biotropika-media-remove').on('click', function(e){
            e.preventDefault();
            const target = $(this).data('target');
            $('#' + target).val('');
            $('#' + target + '_preview').hide();
        });
    })(jQuery);
    </script>
    <?php
});

// При активации темы создаём "Главную" и "Новости" и настраиваем чтение
add_action('after_switch_theme', function(){
    // Главная
    $front = get_page_by_path('home');
    if (!$front) {
        $front = wp_insert_post([
            'post_title'  => 'Главная',
            'post_name'   => 'home',
            'post_status' => 'publish',
            'post_type'   => 'page',
        ]);
    }
    $front_id = is_int($front) ? $front : $front->ID;

    // Новости
    $posts = get_page_by_path('news');
    if (!$posts) {
        $posts = wp_insert_post([
            'post_title'  => 'Новости',
            'post_name'   => 'news',
            'post_status' => 'publish',
            'post_type'   => 'page',
        ]);
    }
    $posts_id = is_int($posts) ? $posts : $posts->ID;

    update_option('show_on_front', 'page');
    update_option('page_on_front', $front_id);
    update_option('page_for_posts', $posts_id);
});
