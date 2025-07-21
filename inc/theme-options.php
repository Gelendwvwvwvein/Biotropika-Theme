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

// Страница настроек
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

// Зарегистрировать настройки и поля
add_action('admin_init', function(){
    register_setting('biotropika_theme_options', 'biotropika_theme_options');

    add_settings_section('biotropika_main', '', null, 'biotropika_theme_options');

    // Год мероприятия
    add_settings_field('year', 'Год мероприятия', function(){
        $options = get_option('biotropika_theme_options');
        echo '<input type="text" name="biotropika_theme_options[year]" value="'.esc_attr($options['year'] ?? '').'">';
    }, 'biotropika_theme_options', 'biotropika_main');

    // Ссылка на регистрацию
    add_settings_field('reg_link', 'Ссылка на регистрацию', function(){
        $options = get_option('biotropika_theme_options');
        echo '<input type="url" name="biotropika_theme_options[reg_link]" value="'.esc_attr($options['reg_link'] ?? '').'" style="width:100%;">';
    }, 'biotropika_theme_options', 'biotropika_main');

    // Страница новостей
    add_settings_field('news_page', 'Страница новостей', function(){
        $options = get_option('biotropika_theme_options');
        wp_dropdown_pages([
            'name' => 'biotropika_theme_options[news_page]',
            'selected' => $options['news_page'] ?? '',
            'show_option_none' => '-- Не выбрано --'
        ]);
    }, 'biotropika_theme_options', 'biotropika_main');

    // Главная страница
    add_settings_field('home_page', 'Главная страница', function(){
        $options = get_option('biotropika_theme_options');
        wp_dropdown_pages([
            'name' => 'biotropika_theme_options[home_page]',
            'selected' => $options['home_page'] ?? '',
            'show_option_none' => '-- Не выбрано --'
        ]);
    }, 'biotropika_theme_options', 'biotropika_main');

    // Прейсхолдер (выбор изображения)
    add_settings_field('placeholder_img', 'Прейсхолдер (по умолчанию)', function(){
        $options = get_option('biotropika_theme_options');
        $id = $options['placeholder_img'] ?? '';
        $url = $id ? wp_get_attachment_image_url($id, 'thumbnail') : '';
        ?>
        <div class="biotropika-media-wrap">
            <img src="<?php echo esc_url($url); ?>" style="max-width:80px; max-height:80px; <?php echo $url?'':'display:none'; ?>" id="placeholder_img_preview">
            <input type="hidden" name="biotropika_theme_options[placeholder_img]" id="placeholder_img" value="<?php echo esc_attr($id); ?>">
            <button type="button" class="button biotropika-media-btn" data-target="placeholder_img">Выбрать изображение</button>
            <button type="button" class="button biotropika-media-remove" data-target="placeholder_img">Удалить</button>
        </div>
        <?php
    }, 'biotropika_theme_options', 'biotropika_main');

    // Логотип для шапки
    add_settings_field('header_logo', 'Логотип для шапки', function(){
        $options = get_option('biotropika_theme_options');
        $id = $options['header_logo'] ?? '';
        $url = $id ? wp_get_attachment_image_url($id, 'thumbnail') : '';
        ?>
        <div class="biotropika-media-wrap">
            <img src="<?php echo esc_url($url); ?>" style="max-width:80px; max-height:80px; <?php echo $url?'':'display:none'; ?>" id="header_logo_preview">
            <input type="hidden" name="biotropika_theme_options[header_logo]" id="header_logo" value="<?php echo esc_attr($id); ?>">
            <button type="button" class="button biotropika-media-btn" data-target="header_logo">Выбрать изображение</button>
            <button type="button" class="button biotropika-media-remove" data-target="header_logo">Удалить</button>
        </div>
        <?php
    }, 'biotropika_theme_options', 'biotropika_main');

    // Логотип для футера
    add_settings_field('footer_logo', 'Логотип для футера', function(){
        $options = get_option('biotropika_theme_options');
        $id = $options['footer_logo'] ?? '';
        $url = $id ? wp_get_attachment_image_url($id, 'thumbnail') : '';
        ?>
        <div class="biotropika-media-wrap">
            <img src="<?php echo esc_url($url); ?>" style="max-width:80px; max-height:80px; <?php echo $url?'':'display:none'; ?>" id="footer_logo_preview">
            <input type="hidden" name="biotropika_theme_options[footer_logo]" id="footer_logo" value="<?php echo esc_attr($id); ?>">
            <button type="button" class="button biotropika-media-btn" data-target="footer_logo">Выбрать изображение</button>
            <button type="button" class="button biotropika-media-remove" data-target="footer_logo">Удалить</button>
        </div>
        <?php
    }, 'biotropika_theme_options', 'biotropika_main');

});

add_action('admin_footer', function(){
    $screen = get_current_screen();
    if ($screen->id !== 'appearance_page_biotropika-theme-options') return;
    ?>
    <script>
    (function($){
        let frame;
        $('.biotropika-media-btn').on('click', function(e){
            e.preventDefault();
            const target = $(this).data('target');
            frame = wp.media({
                title: 'Выберите изображение',
                multiple: false,
                library: { type: 'image' }
            });
            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();
                $('#' + target).val(attachment.id);
                $('#' + target + '_preview').attr('src', attachment.sizes.thumbnail.url).show();
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

