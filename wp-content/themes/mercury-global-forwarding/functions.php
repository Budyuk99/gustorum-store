<?php
// Theme setup
function mgf_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    
    // Добавляем кастомные размеры изображений для галереи
    add_image_size('gallery-slider', 1200, 600, true);
    
    // Загрузка текстового домена для перевода
    load_theme_textdomain('mgf', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'mgf_theme_setup');

// Enqueue styles and scripts
function mgf_enqueue_assets() {
    // CSS
    wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap');
    wp_enqueue_style('mgf-style', get_template_directory_uri() . '/assets/style.css', array(), filemtime(get_template_directory() . '/assets/style.css'));

    // JS
    wp_enqueue_script('jquery');
    wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), null, true);
    wp_enqueue_script('mgf-script', get_template_directory_uri() . '/assets/script.js', array('jquery'), filemtime(get_template_directory() . '/assets/script.js'), true);
    
    // Локализация скрипта
    wp_localize_script('mgf-script', 'mgf_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mgf_language_nonce'),
        'current_lang' => (!is_admin() && function_exists('pll_current_language')) ? 
            pll_current_language('slug') : 'ru',
        'strings' => array(
            'learn_more' => mgf_translate(get_option('mgf_button_learn_more', 'Узнать больше'), 'learn_more'),
            'hide_text' => mgf_translate(get_option('mgf_button_hide', 'Скрыть'), 'hide_text'),
            'loading' => __('Загрузка...', 'mgf'),
        )
    ));
    
    // Инициализация слайдера только если на странице есть галерея
    if (is_front_page() || has_shortcode(get_post()->post_content, 'mgf_gallery')) {
        wp_add_inline_script('mgf-script', '
            jQuery(document).ready(function($) {
                if ($(".gallery-slider").length) {
                    $(".gallery-slider").owlCarousel({
                        items: 1,
                        loop: true,
                        nav: true,
                        dots: true,
                        autoplay: true,
                        autoplayTimeout: 5000,
                        autoplayHoverPause: true
                    });
                }
            });
        ');
    }
}
add_action('wp_enqueue_scripts', 'mgf_enqueue_assets');

// Регистрация строк для Polylang
function mgf_register_polylang_strings() {
    if (function_exists('pll_register_string')) {
        // Баннер
        pll_register_string('banner_title', 'MERCURY GLOBAL FORWARDING', 'Mercury Theme', true);
        pll_register_string('banner_subtitle', 'Full range of freight forwarding services', 'Mercury Theme', true);
        pll_register_string('browser_no_video', 'Ваш браузер не поддерживает видео.', 'Mercury Theme', true);
        
        // Навигация
        pll_register_string('services_nav', 'Услуги', 'Mercury Theme', true);
        pll_register_string('contacts_nav', 'Контакты', 'Mercury Theme', true);
        
        // Заголовки секций
        pll_register_string('services_title', 'Услуги', 'Mercury Theme', true);
        pll_register_string('gallery_title', 'Галерея', 'Mercury Theme', true);
        
        // Кнопки
        pll_register_string('learn_more', 'Узнать больше', 'Mercury Theme', true);
        pll_register_string('hide_text', 'Скрыть', 'Mercury Theme', true);
        
        // Контакты
        pll_register_string('phone', 'Тел:', 'Mercury Theme', true);
        pll_register_string('email', 'Эл. почта:', 'Mercury Theme', true);
        pll_register_string('bin', 'БИН:', 'Mercury Theme', true);
        pll_register_string('business_id', 'Business ID:', 'Mercury Theme', true);
        pll_register_string('inn', 'ИНН:', 'Mercury Theme', true);
        
        // Имена компаний
        pll_register_string('kz_company', 'Mercury Global Forwarding Ltd', 'Mercury Theme', true);
        pll_register_string('fi_company', 'Mercury Global Forwarding Oy', 'Mercury Theme', true);
        pll_register_string('ru_company', 'ООО "Меркури Глобал Форвардинг"', 'Mercury Theme', true);
        
        // Адреса
        pll_register_string('kz_address', '100017 Республика Казахстан, Карагандинская область, г. Караганда, ул. Ерубаева, дом 50а, н.п. 6.', 'Mercury Theme', true);
        pll_register_string('fi_address', 'Haarlankatu 4 B 2, FI-33230 Tampere, Finland', 'Mercury Theme', true);
        pll_register_string('ru_address', '197082 Россия, г. Санкт-Петербург, ул. Оптиков д.37, стр. 1, пом. 135-Н, р.м.2', 'Mercury Theme', true);
        
        // Названия услуг (fallback)
        pll_register_string('international_shipping', 'Международные перевозки', 'Mercury Theme', false);
        pll_register_string('customs_clearance', 'Таможенное оформление', 'Mercury Theme', false);
        pll_register_string('project_shipping', 'Проектные перевозки', 'Mercury Theme', false);
        pll_register_string('storage', 'Ответственное хранение', 'Mercury Theme', false);
        pll_register_string('purchasing', 'Закупка товара', 'Mercury Theme', false);
        pll_register_string('cargo_insurance', 'Страхование грузов', 'Mercury Theme', false);
        
        // Языки в переключателе
        pll_register_string('russian', 'Русский', 'Mercury Theme', false);
        pll_register_string('english', 'English', 'Mercury Theme', false);
        pll_register_string('chinese', '中文', 'Mercury Theme', false);
        pll_register_string('finnish', 'Suomi', 'Mercury Theme', false);

        // Названия мессенджеров
        pll_register_string('whatsapp', 'WhatsApp', 'Mercury Theme', false);
        pll_register_string('telegram', 'Telegram', 'Mercury Theme', false);
        pll_register_string('teams', 'Teams', 'Mercury Theme', false);
        pll_register_string('wechat', 'WeChat', 'Mercury Theme', false); // Добавили WeChat
        pll_register_string('mail', 'Email', 'Mercury Theme', false);
    }
}
add_action('init', 'mgf_register_polylang_strings');

// Включение перевода для Custom Post Types
function mgf_polylang_cpt_support($post_types) {
    $post_types[] = 'services';
    $post_types[] = 'gallery';
    return $post_types;
}
add_filter('pll_get_post_types', 'mgf_polylang_cpt_support');

// Вспомогательная функция для получения перевода
function mgf_translate($string, $context = '') {
    if (function_exists('pll__')) {
        return pll__($string);
    }
    return __($string, 'mgf');
}

// Получение перевода с параметрами
function mgf_e($string, $context = '') {
    echo mgf_translate($string, $context);
}

// Настройки для ссылок на мессенджеры (мультиязычные)
function mgf_messenger_settings_init() {
    // Регистрируем новую секцию настроек для каждого языка
    $languages = array('ru', 'en', 'zh', 'fi');
    
    foreach ($languages as $lang) {
        $lang_name = '';
        switch ($lang) {
            case 'ru': $lang_name = 'русском'; break;
            case 'en': $lang_name = 'английском'; break;
            case 'zh': $lang_name = 'китайском'; break;
            case 'fi': $lang_name = 'финском'; break;
        }
        
        add_settings_section(
            'mgf_messenger_section_' . $lang,
            sprintf(__('Ссылки на мессенджеры на %s языке', 'mgf'), $lang_name),
            function() use ($lang_name) {
                echo '<p>' . sprintf(__('Введите ссылки для мессенджеров для версии на %s языке. Оставьте поле пустым, чтобы скрыть иконку.', 'mgf'), $lang_name) . '</p>';
            },
            'general'
        );

        // Регистрируем поля для каждого мессенджера для текущего языка
        $messengers = array(
            'whatsapp' => __('WhatsApp', 'mgf'),
            'telegram' => __('Telegram', 'mgf'), 
            'teams' => __('Microsoft Teams', 'mgf'),
            'wechat' => __('WeChat', 'mgf'),
            'mail' => __('Email', 'mgf')
        );

        foreach ($messengers as $key => $name) {
            add_settings_field(
                'mgf_messenger_' . $key . '_' . $lang,
                $name . ' (' . strtoupper($lang) . ')',
                'mgf_messenger_field_callback',
                'general',
                'mgf_messenger_section_' . $lang,
                array(
                    'messenger' => $key,
                    'language' => $lang
                )
            );

            // Для WeChat используем кастомную санитизацию
            if ($key === 'wechat') {
                register_setting('general', 'mgf_messenger_' . $key . '_' . $lang, array(
                    'type' => 'string',
                    'sanitize_callback' => 'mgf_sanitize_wechat_url'
                ));
            } else {
                register_setting('general', 'mgf_messenger_' . $key . '_' . $lang);
            }
        }
    }
}
add_action('admin_init', 'mgf_messenger_settings_init');

// Кастомная функция санитизации для WeChat
function mgf_sanitize_wechat_url($input) {
    if (empty($input)) {
        return '';
    }
    
    // Если это weixin:// ссылка
    if (strpos($input, 'weixin://') === 0) {
        // Разрешаем только определенные команды WeChat
        $allowed_patterns = array(
            '/^weixin:\/\/dl\/chat\?username=[a-zA-Z0-9_\-]+$/',
            '/^weixin:\/\/dl\/add\?username=[a-zA-Z0-9_\-]+$/',
            '/^weixin:\/\/dl\/officialaccounts\?username=[a-zA-Z0-9_\-]+$/'
        );
        
        foreach ($allowed_patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return sanitize_text_field($input);
            }
        }
        
        // Если паттерн не подошел, возвращаем пустую строку
        return '';
    }
    
    // Если это обычный URL (для QR-кода), используем стандартную валидацию
    if (filter_var($input, FILTER_VALIDATE_URL) !== false) {
        return esc_url_raw($input);
    }
    
    // Если это просто WeChat ID (текст)
    return sanitize_text_field($input);
}

// callback функция для секции - ДОБАВЬТЕ ЭТУ ФУНКЦИЮ
function mgf_messenger_section_callback() {
    echo '<p>' . __('Введите ссылки для мессенджеров в футере сайта. Оставьте поле пустым, чтобы скрыть иконку.', 'mgf') . '</p>';
}

// callback функция для полей с WeChat
function mgf_messenger_field_callback($args) {
    $option_name = 'mgf_messenger_' . $args['messenger'] . '_' . $args['language'];
    $option = get_option($option_name);
    
    // Для WeChat используем текстовое поле, для остальных - url поле
    if ($args['messenger'] === 'wechat') {
        echo '<input type="text" name="' . esc_attr($option_name) . '" value="' . esc_attr($option) . '" class="regular-text" />';
    } else {
        echo '<input type="url" name="' . esc_attr($option_name) . '" value="' . esc_url($option) . '" class="regular-text" />';
    }
    
    // Подсказки для популярных мессенджеров
    $examples = array(
        'whatsapp' => __(' (пример: https://wa.me/79001234567 или https://wa.me/79001234567?text=Здравствуйте!)', 'mgf'),
        'telegram' => __(' (пример: https://t.me/username, БЕЗ СИМВОЛА @)', 'mgf'),
        'teams' => __(' (пример: https://teams.microsoft.com/l/chat/0/0?users=email@example.com)', 'mgf'),
        'wechat' => __(' (пример: weixin://dl/chat?username=WeChatID или https://ваш-сайт.com/path/to/qr-code.jpg)', 'mgf'),
        'mail' => __(' (пример: mailto:info@example.com)', 'mgf')
    );
    
    // Дополнительные пояснения для каждого мессенджера
    $descriptions = array(
        'whatsapp' => __('<p class="description"><strong>Формат:</strong><br>Для контакта: https://wa.me/79001234567<br>Для контакта с предзаполненным сообщением: https://wa.me/79001234567?text=Ваше%20сообщение<br><em>Замените 79001234567 на ваш номер телефона в международном формате (без +)</em></p>', 'mgf'),
        
        'telegram' => __('<p class="description"><strong>Формат:</strong><br>Для контакта: https://t.me/username<br>Для контакта с предзаполненным сообщением: https://t.me/username?text=Здравствуйте<br>Для группы: https://t.me/groupname<br><em>Используйте только имя пользователя или группы, без символа @</em></p>', 'mgf'),
        
        'teams' => __('<p class="description"><strong>Формат ссылок Microsoft Teams:</strong><br><strong>1. Для чата с пользователем:</strong><br>https://teams.microsoft.com/l/chat/0/0?users=email@example.com<br><br><strong>2. Для присоединения к собранию:</strong><br>https://teams.microsoft.com/l/meetup-join/19:meeting_ID@thread.v2/0?context={"Tid":"tenant-id","Oid":"user-id"}<br><br><strong>3. Для канала команды:</strong><br>https://teams.microsoft.com/l/channel/19%3Achannel-id%40thread.tacv2/General?groupId=group-id&tenantId=tenant-id<br><br><em>Замените email@example.com на реальный email или используйте ссылку из самого Teams</em></p>', 'mgf'),
        
        'wechat' => __('<p class="description"><strong>Формат ссылок WeChat:</strong><br><br><strong>1. Для перехода в чат по ID пользователя (мобильные):</strong><br>weixin://dl/chat?username=WeChatID<br><br><strong>2. Для добавления контакта по ID (мобильные):</strong><br>weixin://dl/add?username=WeChatID<br><br><strong>3. Ссылка на QR-код (рекомендуется для всех устройств):</strong><br>https://ваш-сайт.com/path/to/wechat-qr-code.jpg<br><br><strong>4. WeChat ID для поиска вручную:</strong><br>WeChatID: your_id_here<br><br><em>Примечание: weixin:// ссылки работают только на мобильных устройствах с установленным WeChat. Для десктопа рекомендуется использовать QR-код.</em></p>', 'mgf'),
        
        'mail' => __('<p class="description"><strong>Формат:</strong><br>Просто email: mailto:info@example.com<br>С темой: mailto:info@example.com?subject=Вопрос<br>С темой и текстом: mailto:info@example.com?subject=Вопрос&body=Здравствуйте%21<br><br><em>Для пробелов используйте %20, для восклицательного знака %21</em></p>', 'mgf')
    );
    
    if (isset($examples[$args['messenger']])) {
        echo '<p class="description">' . $examples[$args['messenger']] . '</p>';
    }
    
    // Выводим подробное описание для первого языка (ru), чтобы не дублировать
    if ($args['language'] === 'ru' && isset($descriptions[$args['messenger']])) {
        echo $descriptions[$args['messenger']];
    }
}

// Создаем Custom Post Type для галереи
function mgf_gallery_post_type() {
    $labels = array(
        'name' => __('Галерея', 'mgf'),
        'singular_name' => __('Изображение', 'mgf'),
        'add_new' => __('Добавить изображение', 'mgf'),
        'add_new_item' => __('Добавить новое изображение', 'mgf'),
        'edit_item' => __('Редактировать изображение', 'mgf'),
        'new_item' => __('Новое изображение', 'mgf'),
        'view_item' => __('Просмотреть изображение', 'mgf'),
        'search_items' => __('Поиск изображений', 'mgf'),
        'not_found' => __('Изображения не найдены', 'mgf'),
        'not_found_in_trash' => __('В корзине изображений не найдено', 'mgf')
    );
    
    register_post_type('gallery',
        array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-format-gallery',
            'supports' => array('title', 'thumbnail'),
            'show_in_rest' => true,
            'publicly_queryable' => false,
        )
    );
}
add_action('init', 'mgf_gallery_post_type');

// Добавляем метабокс для порядка сортировки
function mgf_gallery_meta_boxes() {
    add_meta_box(
        'gallery_order',
        __('Порядок сортировки', 'mgf'),
        'mgf_gallery_order_callback',
        'gallery',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'mgf_gallery_meta_boxes');

function mgf_gallery_order_callback($post) {
    wp_nonce_field('gallery_order_nonce', 'gallery_order_nonce');
    $order = get_post_meta($post->ID, 'gallery_order', true);
    if (empty($order)) {
        $order = 0;
    }
    echo '<label for="gallery_order">' . __('Порядок (чем меньше число, тем выше в галерее):', 'mgf') . '</label>';
    echo '<input type="number" id="gallery_order" name="gallery_order" value="' . esc_attr($order) . '" class="widefat" min="0" />';
    echo '<p class="description">' . __('Изображения сортируются по возрастанию этого числа', 'mgf') . '</p>';
}

function mgf_save_gallery_order($post_id) {
    if (!isset($_POST['gallery_order_nonce']) || !wp_verify_nonce($_POST['gallery_order_nonce'], 'gallery_order_nonce')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (array_key_exists('gallery_order', $_POST)) {
        $order = sanitize_text_field($_POST['gallery_order']);
        update_post_meta($post_id, 'gallery_order', $order);
    }
}
add_action('save_post_gallery', 'mgf_save_gallery_order');

// Шорткод для вывода галереи
function mgf_gallery_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => -1,
    ), $atts);
    
    ob_start();
    
    $gallery_args = array(
        'post_type' => 'gallery',
        'posts_per_page' => $atts['limit'],
        'meta_key' => 'gallery_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            )
        )
    );
    
    $gallery_query = new WP_Query($gallery_args);
    
    if ($gallery_query->have_posts()) :
        echo '<div class="owl-carousel gallery-slider owl-theme">';
        while ($gallery_query->have_posts()) : $gallery_query->the_post();
            if (has_post_thumbnail()) :
                echo '<div class="slide">';
                the_post_thumbnail('gallery-slider', array(
                    'alt' => get_the_title(),
                    'loading' => 'lazy'
                ));
                echo '</div>';
            endif;
        endwhile;
        echo '</div>';
    else :
        echo '<p>' . __('В галерее пока нет изображений.', 'mgf') . '</p>';
    endif;
    
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('mgf_gallery', 'mgf_gallery_shortcode');

// Добавляем колонку порядка в админку
function mgf_gallery_admin_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key == 'title') {
            $new_columns['gallery_order'] = __('Порядок', 'mgf');
            $new_columns['thumbnail'] = __('Изображение', 'mgf');
        }
    }
    return $new_columns;
}
add_filter('manage_gallery_posts_columns', 'mgf_gallery_admin_columns');

function mgf_gallery_admin_column_content($column_name, $post_id) {
    if ($column_name == 'gallery_order') {
        $order = get_post_meta($post_id, 'gallery_order', true);
        echo !empty($order) ? $order : '0';
    }
    if ($column_name == 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            the_post_thumbnail('thumbnail');
        } else {
            echo '—';
        }
    }
}
add_action('manage_gallery_posts_custom_column', 'mgf_gallery_admin_column_content', 10, 2);

// Делаем колонку порядка сортируемой
function mgf_gallery_sortable_columns($columns) {
    $columns['gallery_order'] = 'gallery_order';
    return $columns;
}
add_filter('manage_edit-gallery_sortable_columns', 'mgf_gallery_sortable_columns');

function mgf_gallery_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    if ($query->get('orderby') == 'gallery_order') {
        $query->set('meta_key', 'gallery_order');
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'mgf_gallery_orderby');

// Настройки для баннера
function mgf_banner_settings_init() {
    add_settings_section(
        'mgf_banner_section',
        __('Настройки баннера', 'mgf'),
        'mgf_banner_section_callback',
        'general'
    );

    add_settings_field(
        'mgf_banner_type',
        __('Тип контента', 'mgf'),
        'mgf_banner_type_callback',
        'general',
        'mgf_banner_section'
    );

    add_settings_field(
        'mgf_banner_video',
        __('Видео баннера', 'mgf'),
        'mgf_banner_video_callback',
        'general',
        'mgf_banner_section'
    );

    add_settings_field(
        'mgf_banner_image',
        __('Изображение баннера', 'mgf'),
        'mgf_banner_image_callback',
        'general',
        'mgf_banner_section'
    );

    add_settings_field(
        'mgf_banner_title',
        __('Заголовок баннера', 'mgf'),
        'mgf_banner_title_callback',
        'general',
        'mgf_banner_section'
    );

    add_settings_field(
        'mgf_banner_subtitle',
        __('Подзаголовок баннера', 'mgf'),
        'mgf_banner_subtitle_callback',
        'general',
        'mgf_banner_section'
    );

    register_setting('general', 'mgf_banner_type');
    register_setting('general', 'mgf_banner_video');
    register_setting('general', 'mgf_banner_image');
    register_setting('general', 'mgf_banner_title');
    register_setting('general', 'mgf_banner_subtitle');
}
add_action('admin_init', 'mgf_banner_settings_init');

function mgf_banner_section_callback() {
    echo '<p>' . __('Настройте баннер на главной странице. Можно использовать видео или изображение.', 'mgf') . '</p>';
}

function mgf_banner_type_callback() {
    $type = get_option('mgf_banner_type', 'video');
    ?>
    <select name="mgf_banner_type" id="mgf_banner_type">
        <option value="video" <?php selected($type, 'video'); ?>><?php _e('Видео', 'mgf'); ?></option>
        <option value="image" <?php selected($type, 'image'); ?>><?php _e('Изображение', 'mgf'); ?></option>
    </select>
    <p class="description"><?php _e('Выберите тип контента для баннера', 'mgf'); ?></p>
    <script>
    jQuery(document).ready(function($) {
        function toggleBannerFields() {
            var type = $('#mgf_banner_type').val();
            if (type === 'video') {
                $('.banner-video-field').show();
                $('.banner-image-field').hide();
            } else {
                $('.banner-video-field').hide();
                $('.banner-image-field').show();
            }
        }
        
        $('#mgf_banner_type').change(toggleBannerFields);
        toggleBannerFields();
    });
    </script>
    <?php
}

function mgf_banner_video_callback() {
    $video = get_option('mgf_banner_video');
    ?>
    <div class="banner-video-field">
        <input type="url" name="mgf_banner_video" value="<?php echo esc_url($video); ?>" class="regular-text" />
        <button type="button" class="button mgf-upload-video"><?php _e('Выбрать видео', 'mgf'); ?></button>
        <p class="description"><?php _e('Загрузите видео в формате MP4 или укажите ссылку на видео', 'mgf'); ?></p>
        <?php if ($video): ?>
            <div style="margin-top: 10px;">
                <video style="max-width: 300px; height: auto;" controls>
                    <source src="<?php echo esc_url($video); ?>" type="video/mp4">
                    <?php _e('Ваш браузер не поддерживает видео.', 'mgf'); ?>
                </video>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

function mgf_banner_image_callback() {
    $image = get_option('mgf_banner_image');
    ?>
    <div class="banner-image-field" style="display: none;">
        <input type="url" name="mgf_banner_image" value="<?php echo esc_url($image); ?>" class="regular-text" />
        <button type="button" class="button mgf-upload-image"><?php _e('Выбрать изображение', 'mgf'); ?></button>
        <p class="description"><?php _e('Загрузите изображение для баннера', 'mgf'); ?></p>
        <?php if ($image): ?>
            <div style="margin-top: 10px;">
                <img src="<?php echo esc_url($image); ?>" style="max-width: 300px; height: auto;" alt="<?php _e('Баннер', 'mgf'); ?>" />
            </div>
        <?php endif; ?>
    </div>
    <?php
}

function mgf_banner_title_callback() {
    $title = get_option('mgf_banner_title', 'MERCURY GLOBAL FORWARDING');
    ?>
    <input type="text" name="mgf_banner_title" value="<?php echo esc_attr($title); ?>" class="regular-text" />
    <p class="description"><?php _e('Заголовок баннера', 'mgf'); ?></p>
    <?php
}

function mgf_banner_subtitle_callback() {
    $subtitle = get_option('mgf_banner_subtitle', 'Full range of freight forwarding services');
    ?>
    <input type="text" name="mgf_banner_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="regular-text" />
    <p class="description"><?php _e('Подзаголовок баннера', 'mgf'); ?></p>
    <?php
}

// Скрипты для загрузки медиафайлов
function mgf_banner_admin_scripts($hook) {
    if ('options-general.php' !== $hook) {
        return;
    }
    wp_enqueue_media();
    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            $(".mgf-upload-video").click(function(e) {
                e.preventDefault();
                var button = $(this);
                var frame = wp.media({
                    title: "' . __('Выберите видео', 'mgf') . '",
                    library: { type: "video" },
                    multiple: false,
                    button: { text: "' . __('Выбрать', 'mgf') . '" }
                });
                frame.on("select", function() {
                    var attachment = frame.state().get("selection").first().toJSON();
                    button.prev("input").val(attachment.url);
                });
                frame.open();
            });

            $(".mgf-upload-image").click(function(e) {
                e.preventDefault();
                var button = $(this);
                var frame = wp.media({
                    title: "' . __('Выберите изображение', 'mgf') . '",
                    library: { type: "image" },
                    multiple: false,
                    button: { text: "' . __('Выбрать', 'mgf') . '" }
                });
                frame.on("select", function() {
                    var attachment = frame.state().get("selection").first().toJSON();
                    button.prev("input").val(attachment.url);
                });
                frame.open();
            });
        });
    ');
}
add_action('admin_enqueue_scripts', 'mgf_banner_admin_scripts');

// Создаем Custom Post Type для услуг
function mgf_services_post_type() {
    $labels = array(
        'name' => __('Услуги', 'mgf'),
        'singular_name' => __('Услуга', 'mgf'),
        'add_new' => __('Добавить услугу', 'mgf'),
        'add_new_item' => __('Добавить новую услугу', 'mgf'),
        'edit_item' => __('Редактировать услугу', 'mgf'),
        'new_item' => __('Новая услуга', 'mgf'),
        'view_item' => __('Просмотреть услугу', 'mgf'),
        'search_items' => __('Поиск услуг', 'mgf'),
        'not_found' => __('Услуги не найдены', 'mgf'),
        'not_found_in_trash' => __('В корзине услуг не найдено', 'mgf')
    );
    
    register_post_type('services',
        array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-admin-tools',
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true,
            'publicly_queryable' => false,
        )
    );
}
add_action('init', 'mgf_services_post_type');

// Добавляем метабоксы для дополнительных полей
function mgf_services_meta_boxes() {
    add_meta_box(
        'services_short_description',
        __('Краткое описание', 'mgf'),
        'mgf_services_short_description_callback',
        'services',
        'normal',
        'high'
    );
    
    add_meta_box(
        'services_icon',
        __('Иконка услуги', 'mgf'),
        'mgf_services_icon_callback',
        'services',
        'side',
        'default'
    );
    
    add_meta_box(
        'services_order',
        __('Порядок сортировки', 'mgf'),
        'mgf_services_order_callback',
        'services',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'mgf_services_meta_boxes');

function mgf_services_short_description_callback($post) {
    wp_nonce_field('services_short_description_nonce', 'services_short_description_nonce');
    $short_description = get_post_meta($post->ID, 'services_short_description', true);
    ?>
    <textarea id="services_short_description" name="services_short_description" rows="4" class="widefat"><?php echo esc_textarea($short_description); ?></textarea>
    <p class="description"><?php _e('Краткое описание, которое отображается в свернутом состоянии', 'mgf'); ?></p>
    <?php
}

function mgf_services_icon_callback($post) {
    wp_nonce_field('services_icon_nonce', 'services_icon_nonce');
    $icon = get_post_meta($post->ID, 'services_icon', true);
    $default_icons = array(
        'earth.svg' => __('Международные перевозки', 'mgf'),
        'clipboard.svg' => __('Таможенное оформление', 'mgf'),
        'box.svg' => __('Проектные перевозки', 'mgf'),
        'building.svg' => __('Ответственное хранение', 'mgf'),
        'money.svg' => __('Закупка товара', 'mgf'),
        'receipt.svg' => __('Страхование грузов', 'mgf')
    );
    ?>
    <select name="services_icon" id="services_icon" class="widefat">
        <option value="">— <?php _e('Выберите иконку', 'mgf'); ?> —</option>
        <?php foreach ($default_icons as $icon_file => $icon_name): ?>
            <option value="<?php echo esc_attr($icon_file); ?>" <?php selected($icon, $icon_file); ?>>
                <?php echo esc_html($icon_name); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <p class="description"><?php _e('Выберите иконку для услуги из существующих', 'mgf'); ?></p>
    
    <div style="margin-top: 10px;">
        <strong><?php _e('Или загрузите свою иконку:', 'mgf'); ?></strong>
        <input type="url" name="services_custom_icon" value="<?php echo esc_url(get_post_meta($post->ID, 'services_custom_icon', true)); ?>" class="widefat" style="margin: 5px 0;" />
        <button type="button" class="button mgf-upload-icon"><?php _e('Выбрать иконку', 'mgf'); ?></button>
    </div>
    <?php
}

function mgf_services_order_callback($post) {
    wp_nonce_field('services_order_nonce', 'services_order_nonce');
    $order = get_post_meta($post->ID, 'services_order', true);
    if (empty($order)) {
        $order = 0;
    }
    ?>
    <label for="services_order"><?php _e('Порядок (чем меньше число, тем выше в списке):', 'mgf'); ?></label>
    <input type="number" id="services_order" name="services_order" value="<?php echo esc_attr($order); ?>" class="widefat" min="0" />
    <p class="description"><?php _e('Услуги сортируются по возрастанию этого числа', 'mgf'); ?></p>
    <?php
}

// Сохраняем метаполя
function mgf_save_services_meta($post_id) {
    if (!isset($_POST['services_short_description_nonce']) || 
        !wp_verify_nonce($_POST['services_short_description_nonce'], 'services_short_description_nonce')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    $fields = array(
        'services_short_description',
        'services_icon',
        'services_custom_icon',
        'services_order'
    );
    
    foreach ($fields as $field) {
        if (array_key_exists($field, $_POST)) {
            if ($field === 'services_short_description') {
                $value = sanitize_textarea_field($_POST[$field]);
            } elseif ($field === 'services_custom_icon') {
                $value = esc_url_raw($_POST[$field]);
            } else {
                $value = sanitize_text_field($_POST[$field]);
            }
            update_post_meta($post_id, $field, $value);
        }
    }
}
add_action('save_post_services', 'mgf_save_services_meta');

// Добавляем колонки в админку
function mgf_services_admin_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key == 'title') {
            $new_columns['services_icon'] = __('Иконка', 'mgf');
            $new_columns['services_order'] = __('Порядок', 'mgf');
        }
    }
    return $new_columns;
}
add_filter('manage_services_posts_columns', 'mgf_services_admin_columns');

function mgf_services_admin_column_content($column_name, $post_id) {
    if ($column_name == 'services_icon') {
        $icon = get_post_meta($post_id, 'services_icon', true);
        $custom_icon = get_post_meta($post_id, 'services_custom_icon', true);
        
        if ($custom_icon) {
            echo '<img src="' . esc_url($custom_icon) . '" style="width: 32px; height: 32px;" alt="' . __('Иконка', 'mgf') . '" />';
        } elseif ($icon) {
            echo '<img src="' . get_template_directory_uri() . '/assets/images/' . esc_attr($icon) . '" style="width: 32px; height: 32px;" alt="' . __('Иконка', 'mgf') . '" />';
        } else {
            echo '—';
        }
    }
    if ($column_name == 'services_order') {
        $order = get_post_meta($post_id, 'services_order', true);
        echo !empty($order) ? $order : '0';
    }
}
add_action('manage_services_posts_custom_column', 'mgf_services_admin_column_content', 10, 2);

// Делаем колонку порядка сортируемой
function mgf_services_sortable_columns($columns) {
    $columns['services_order'] = 'services_order';
    return $columns;
}
add_filter('manage_edit-services_sortable_columns', 'mgf_services_sortable_columns');

function mgf_services_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    if ($query->get('orderby') == 'services_order') {
        $query->set('meta_key', 'services_order');
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'mgf_services_orderby');

// Скрипты для загрузки медиафайлов (дополнение)
function mgf_services_admin_scripts($hook) {
    if (!in_array($hook, array('post.php', 'post-new.php'))) {
        return;
    }
    
    $screen = get_current_screen();
    if ($screen && $screen->post_type !== 'services') {
        return;
    }
    
    wp_enqueue_media();
    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            $(".mgf-upload-icon").click(function(e) {
                e.preventDefault();
                var button = $(this);
                var frame = wp.media({
                    title: "' . __('Выберите иконку', 'mgf') . '",
                    library: { type: "image" },
                    multiple: false,
                    button: { text: "' . __('Выбрать', 'mgf') . '" }
                });
                frame.on("select", function() {
                    var attachment = frame.state().get("selection").first().toJSON();
                    button.prev("input").val(attachment.url);
                });
                frame.open();
            });
        });
    ');
}
add_action('admin_enqueue_scripts', 'mgf_services_admin_scripts');

// Настройки для контактов в футере
function mgf_contacts_settings_init() {
    add_settings_section(
        'mgf_contacts_section',
        __('Контакты в футере', 'mgf'),
        'mgf_contacts_section_callback',
        'general'
    );

    // Контакты для Казахстана
    add_settings_field(
        'mgf_contacts_kz_company',
        __('Название компании (Казахстан)', 'mgf'),
        'mgf_contacts_kz_company_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_kz_address',
        __('Адрес (Казахстан)', 'mgf'),
        'mgf_contacts_kz_address_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_kz_bin',
        __('БИН (Казахстан)', 'mgf'),
        'mgf_contacts_kz_bin_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_kz_phone',
        __('Телефон (Казахстан)', 'mgf'),
        'mgf_contacts_kz_phone_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_kz_email',
        __('Email (Казахстан)', 'mgf'),
        'mgf_contacts_kz_email_callback',
        'general',
        'mgf_contacts_section'
    );

    // Контакты для Финляндии
    add_settings_field(
        'mgf_contacts_fi_company',
        __('Название компании (Финляндия)', 'mgf'),
        'mgf_contacts_fi_company_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_fi_address',
        __('Адрес (Финляндия)', 'mgf'),
        'mgf_contacts_fi_address_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_fi_business_id',
        __('Business ID (Финляндия)', 'mgf'),
        'mgf_contacts_fi_business_id_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_fi_phone',
        __('Телефон (Финляндия)', 'mgf'),
        'mgf_contacts_fi_phone_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_fi_email',
        __('Email (Финляндия)', 'mgf'),
        'mgf_contacts_fi_email_callback',
        'general',
        'mgf_contacts_section'
    );

    // Контакты для России
    add_settings_field(
        'mgf_contacts_ru_company',
        __('Название компании (Россия)', 'mgf'),
        'mgf_contacts_ru_company_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_ru_address',
        __('Адрес (Россия)', 'mgf'),
        'mgf_contacts_ru_address_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_ru_inn',
        __('ИНН (Россия)', 'mgf'),
        'mgf_contacts_ru_inn_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_ru_phone',
        __('Телефон (Россия)', 'mgf'),
        'mgf_contacts_ru_phone_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_ru_email',
        __('Email (Россия)', 'mgf'),
        'mgf_contacts_ru_email_callback',
        'general',
        'mgf_contacts_section'
    );

    $contacts_fields = array(
        'mgf_contacts_kz_company', 'mgf_contacts_kz_address', 'mgf_contacts_kz_bin', 'mgf_contacts_kz_phone', 'mgf_contacts_kz_email',
        'mgf_contacts_fi_company', 'mgf_contacts_fi_address', 'mgf_contacts_fi_business_id', 'mgf_contacts_fi_phone', 'mgf_contacts_fi_email',
        'mgf_contacts_ru_company', 'mgf_contacts_ru_address', 'mgf_contacts_ru_inn', 'mgf_contacts_ru_phone', 'mgf_contacts_ru_email'
    );

    foreach ($contacts_fields as $field) {
        register_setting('general', $field);
    }
}
add_action('admin_init', 'mgf_contacts_settings_init');

function mgf_contacts_section_callback() {
    echo '<p>' . __('Настройте контактную информацию для всех офисов компании. Оставьте поле пустым, чтобы скрыть его на сайте.', 'mgf') . '</p>';
}

// callback функции для Казахстана
function mgf_contacts_kz_company_callback() {
    $value = get_option('mgf_contacts_kz_company', 'Mercury Global Forwarding Ltd');
    echo '<input type="text" name="mgf_contacts_kz_company" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mgf_contacts_kz_address_callback() {
    $value = get_option('mgf_contacts_kz_address', '100017 Республика Казахстан, Карагандинская область, г. Караганда, ул. Ерубаева, дом 50а, н.п. 6.');
    echo '<textarea name="mgf_contacts_kz_address" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
}

function mgf_contacts_kz_bin_callback() {
    $value = get_option('mgf_contacts_kz_bin', 'БИН: 230340020517');
    echo '<input type="text" name="mgf_contacts_kz_bin" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mgf_contacts_kz_phone_callback() {
    $value = get_option('mgf_contacts_kz_phone', '+7 (705) 850-38-45');
    echo '<input type="text" name="mgf_contacts_kz_phone" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mgf_contacts_kz_email_callback() {
    $value = get_option('mgf_contacts_kz_email', 'info.kz@mercury-gf.com');
    echo '<input type="email" name="mgf_contacts_kz_email" value="' . esc_attr($value) . '" class="regular-text" />';
}

// callback функции для Финляндии
function mgf_contacts_fi_company_callback() {
    $value = get_option('mgf_contacts_fi_company', 'Mercury Global Forwarding Oy');
    echo '<input type="text" name="mgf_contacts_fi_company" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mgf_contacts_fi_address_callback() {
    $value = get_option('mgf_contacts_fi_address', "Haarlankatu 4 B 2, FI-33230 Tampere, Finland");
    echo '<textarea name="mgf_contacts_fi_address" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
    echo '<p class="description">' . __('Используйте &lt;br&gt; для переносов строк', 'mgf') . '</p>';
}

function mgf_contacts_fi_business_id_callback() {
    $value = get_option('mgf_contacts_fi_business_id', 'Business ID: 3289135-4');
    echo '<input type="text" name="mgf_contacts_fi_business_id" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mgf_contacts_fi_phone_callback() {
    $value = get_option('mgf_contacts_fi_phone', '+358 41 570 8237');
    echo '<input type="text" name="mgf_contacts_fi_phone" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mgf_contacts_fi_email_callback() {
    $value = get_option('mgf_contacts_fi_email', 'info.fi@mercury-gf.com');
    echo '<input type="email" name="mgf_contacts_fi_email" value="' . esc_attr($value) . '" class="regular-text" />';
}

// callback функции для России
function mgf_contacts_ru_company_callback() {
    $value = get_option('mgf_contacts_ru_company', 'ООО "Меркури Глобал Форвардинг"');
    echo '<input type="text" name="mgf_contacts_ru_company" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mgf_contacts_ru_address_callback() {
    $value = get_option('mgf_contacts_ru_address', "197082 Россия, г. Санкт-Петербург, ул. Оптиков д.37, стр. 1, пом. 135-Н, р.м.2");
    echo '<textarea name="mgf_contacts_ru_address" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
    echo '<p class="description">' . __('Используйте &lt;br&gt; для переносов строк', 'mgf') . '</p>';
}

function mgf_contacts_ru_inn_callback() {
    $value = get_option('mgf_contacts_ru_inn', 'ИНН 7839045340');
    echo '<input type="text" name="mgf_contacts_ru_inn" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mgf_contacts_ru_phone_callback() {
    $value = get_option('mgf_contacts_ru_phone', '+7 (911) 180-98-20');
    echo '<input type="text" name="mgf_contacts_ru_phone" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mgf_contacts_ru_email_callback() {
    $value = get_option('mgf_contacts_ru_email', 'info.ru@mercury-gf.com');
    echo '<input type="email" name="mgf_contacts_ru_email" value="' . esc_attr($value) . '" class="regular-text" />';
}

// Настройки для заголовков
function mgf_titles_settings_init() {
    add_settings_section(
        'mgf_titles_section',
        __('Заголовки разделов', 'mgf'),
        'mgf_titles_section_callback',
        'general'
    );

    add_settings_field(
        'mgf_title_services',
        __('Заголовок "Услуги"', 'mgf'),
        'mgf_title_services_callback',
        'general',
        'mgf_titles_section'
    );

    add_settings_field(
        'mgf_title_gallery',
        __('Заголовок "Галерея"', 'mgf'),
        'mgf_title_gallery_callback',
        'general',
        'mgf_titles_section'
    );
    
    add_settings_field(
        'mgf_button_hide',
        __('Текст кнопки "Скрыть"', 'mgf'),
        'mgf_button_hide_callback',
        'general',
        'mgf_titles_section'
    );

    register_setting('general', 'mgf_title_services');
    register_setting('general', 'mgf_title_gallery');
    register_setting('general', 'mgf_button_hide');
}
add_action('admin_init', 'mgf_titles_settings_init');

function mgf_titles_section_callback() {
    echo '<p>' . __('Настройте заголовки основных разделов сайта', 'mgf') . '</p>';
}

function mgf_title_services_callback() {
    $value = get_option('mgf_title_services', 'Услуги');
    echo '<input type="text" name="mgf_title_services" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description">' . __('Заголовок раздела услуг', 'mgf') . '</p>';
}

function mgf_title_gallery_callback() {
    $value = get_option('mgf_title_gallery', 'Галерея');
    echo '<input type="text" name="mgf_title_gallery" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description">' . __('Заголовок раздела галереи', 'mgf') . '</p>';
}

function mgf_button_hide_callback() {
    $value = get_option('mgf_button_hide', 'Скрыть');
    ?>
    <input type="text" name="mgf_button_hide" value="<?php echo esc_attr($value); ?>" class="regular-text" />
    <p class="description"><?php _e('Текст кнопки, которая появляется после раскрытия подробного описания', 'mgf'); ?></p>
    <?php
}

// AJAX обработчик для смены языка
add_action('wp_ajax_mgf_switch_language', 'mgf_switch_language_ajax');
add_action('wp_ajax_nopriv_mgf_switch_language', 'mgf_switch_language_ajax');

function mgf_switch_language_ajax() {
    if (!wp_verify_nonce($_POST['nonce'], 'mgf_language_nonce')) {
        wp_die('Security check failed');
    }
    
    // Проверяем, не админка ли
    if (is_admin()) {
        wp_send_json_error(array('message' => 'Cannot switch language in admin area'));
    }
    
    $lang = sanitize_text_field($_POST['lang']);
    
    if (function_exists('pll_set_current_language')) {
        pll_set_current_language($lang);
        
        // Устанавливаем куки ТОЛЬКО для фронтенда
        setcookie('mgf_frontend_language', $lang, time() + (365 * 24 * 60 * 60), '/');
        
        $response = array(
            'success' => true,
            'current_lang' => $lang,
            'url' => pll_current_language_url(),
            'language_name' => pll_current_language('name')
        );
        
        wp_send_json_success($response);
    } else {
        wp_send_json_error(array('message' => 'Polylang not active'));
    }
}

// Добавляем hreflang для SEO
function mgf_add_hreflang_tags() {
    if (function_exists('pll_the_languages')) {
        $languages = pll_the_languages(array('raw' => 1));
        
        foreach ($languages as $lang) {
            echo '<link rel="alternate" hreflang="' . esc_attr($lang['locale']) . '" href="' . esc_url($lang['url']) . '" />' . "\n";
        }
        
        // Добавляем x-default
        $default_lang = pll_default_language();
        foreach ($languages as $lang) {
            if ($lang['slug'] === $default_lang) {
                echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($lang['url']) . '" />' . "\n";
                break;
            }
        }
    }
}
add_action('wp_head', 'mgf_add_hreflang_tags', 2);

// Функция для получения текущего языка с fallback
function mgf_get_current_language() {
    if (function_exists('pll_current_language')) {
        return pll_current_language('slug');
    }
    return 'ru';
}

// Функция для получения языка по умолчанию
function mgf_get_default_language() {
    if (function_exists('pll_default_language')) {
        return pll_default_language();
    }
    return 'ru';
}

// Функция для получения списка языков
function mgf_get_languages() {
    if (function_exists('pll_the_languages')) {
        return pll_the_languages(array('raw' => 1));
    }
    return array(array('slug' => 'ru', 'name' => 'Русский', 'url' => home_url('/')));
}

// Устанавливаем язык из параметра URL
function mgf_set_language_from_url() {
    // Не устанавливаем язык для админки
    if (is_admin() || wp_doing_ajax() || (defined('DOING_CRON') && DOING_CRON)) {
        return;
    }
    
    // Проверяем параметр lang в URL
    if (isset($_GET['lang'])) {
        $lang = sanitize_text_field($_GET['lang']);
        $allowed_langs = array('ru', 'en', 'zh', 'fi');
        
        if (in_array($lang, $allowed_langs)) {
            // Устанавливаем куки ТОЛЬКО для фронтенда
            setcookie('mgf_frontend_language', $lang, time() + (365 * 24 * 60 * 60), '/');
            
            // Устанавливаем язык для Polylang
            if (function_exists('pll_set_current_language')) {
                pll_set_current_language($lang);
            }
        }
    } 
    // Проверяем фронтенд куки
    elseif (isset($_COOKIE['mgf_frontend_language'])) {
        $lang = $_COOKIE['mgf_frontend_language'];
        if (function_exists('pll_set_current_language')) {
            pll_set_current_language($lang);
        }
    }
}
add_action('init', 'mgf_set_language_from_url', 1);

// Редирект для сохранения параметра lang на всех страницах
function mgf_redirect_with_language() {
    // Не редиректим в админке и если это AJAX
    if (is_admin() || wp_doing_ajax()) {
        return;
    }
    
    // Проверяем, есть ли куки с языком
    if (isset($_COOKIE['mgf_language'])) {
        $cookie_lang = $_COOKIE['mgf_language'];
        $current_url = home_url($_SERVER['REQUEST_URI']);
        
        // Если в URL нет параметра lang, но есть в куках
        if (!isset($_GET['lang']) && !strpos($current_url, '?lang=')) {
            // Для главной страницы добавляем параметр
            if (is_front_page() || is_home()) {
                wp_redirect(add_query_arg('lang', $cookie_lang, $current_url));
                exit;
            }
        }
    }
}
add_action('template_redirect', 'mgf_redirect_with_language');

// Добавляем поддержку Polylang для параметра lang
function mgf_polylang_lang_param($url, $lang) {
    // Добавляем параметр lang к URL
    return add_query_arg('lang', $lang, remove_query_arg('lang', $url));
}
add_filter('pll_language_link', 'mgf_polylang_lang_param', 10, 2);

// Создаем языковые ссылки для навигации
function mgf_get_language_switcher() {
    if (!function_exists('pll_the_languages')) {
        return array();
    }
    
    $languages = pll_the_languages(array('raw' => 1, 'hide_if_no_translation' => 0));
    
    foreach ($languages as &$lang) {
        // Добавляем параметр lang к URL
        $lang['url'] = add_query_arg('lang', $lang['slug'], remove_query_arg('lang', $lang['url']));
    }
    
    return $languages;
}

// Шорткод для языкового переключателя
function mgf_language_switcher_shortcode($atts) {
    ob_start();
    ?>
    <div class="mgf-language-switcher">
        <?php
        $current_lang = isset($_GET['lang']) ? $_GET['lang'] : 'ru';
        $clean_url = remove_query_arg('lang', home_url($_SERVER['REQUEST_URI']));
        
        $languages = array(
            'ru' => 'Русский',
            'en' => 'English',
            'zh' => '中文',
            'fi' => 'Suomi'
        );
        
        foreach ($languages as $code => $name) {
            $active = ($current_lang === $code) ? 'active' : '';
            $url = ($code === 'fi') 
                ? 'https://mercury-gf.com/fi/' 
                : add_query_arg('lang', $code, $clean_url);
            
            $target = ($code === 'fi') ? ' target="_blank"' : '';
            
            echo '<a href="' . esc_url($url) . '" class="' . esc_attr($active) . '"' . $target . '>' . esc_html($name) . '</a> ';
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('mgf_lang_switcher', 'mgf_language_switcher_shortcode');

// Добавляем параметр lang ко всем ссылкам
function mgf_add_lang_to_links($link) {
    if (is_admin()) {
        return $link;
    }
    
    $current_lang = 'ru';
    if (isset($_GET['lang'])) {
        $current_lang = sanitize_text_field($_GET['lang']);
    } elseif (isset($_COOKIE['mgf_language'])) {
        $current_lang = $_COOKIE['mgf_language'];
    }
    
    // Не добавляем к внешним ссылкам и ссылкам, которые уже имеют параметр
    if (strpos($link, home_url()) !== false && strpos($link, '?lang=') === false) {
        return add_query_arg('lang', $current_lang, $link);
    }
    
    return $link;
}
add_filter('post_link', 'mgf_add_lang_to_links');
add_filter('page_link', 'mgf_add_lang_to_links');
add_filter('term_link', 'mgf_add_lang_to_links');

// JavaScript для переключения языка
function mgf_language_switcher_js() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('.lang-option').on('click', function(e) {
            var lang = $(this).data('lang');
            
            if (!$(this).attr('target')) {
                // Устанавливаем куки ТОЛЬКО для фронтенда
                document.cookie = "mgf_frontend_language=" + lang + "; path=/; max-age=" + (365*24*60*60);
                
                // Обновляем кнопку текущего языка
                $('.lang-btn').text(lang.toUpperCase());
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'mgf_language_switcher_js');

// Сохраняем язык админки отдельно
function mgf_save_admin_language() {
    if (is_admin() && isset($_GET['lang']) && current_user_can('manage_options')) {
        $lang = sanitize_text_field($_GET['lang']);
        setcookie('mgf_admin_language', $lang, time() + (365 * 24 * 60 * 60), '/');
    }
}
add_action('admin_init', 'mgf_save_admin_language', 1);

// Добавление favicon
function mgf_add_favicon() {
    // Путь к favicon в теме
    $favicon_url = get_template_directory_uri() . '/assets/images/favicon.ico';
    
    echo '<link rel="shortcut icon" href="' . esc_url($favicon_url) . '" type="image/x-icon" />' . "\n";
    echo '<link rel="icon" href="' . esc_url($favicon_url) . '" type="image/x-icon" />' . "\n";
    
    // Для современных браузеров (разные размеры)
    $favicon_png_16 = get_template_directory_uri() . '/assets/images/favicon-16x16.png';
    $favicon_png_32 = get_template_directory_uri() . '/assets/images/favicon-32x32.png';
    $favicon_png_180 = get_template_directory_uri() . '/assets/images/apple-touch-icon.png';
    
    if (file_exists(get_template_directory() . '/assets/images/favicon-16x16.png')) {
        echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url($favicon_png_16) . '" />' . "\n";
    }
    
    if (file_exists(get_template_directory() . '/assets/images/favicon-32x32.png')) {
        echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url($favicon_png_32) . '" />' . "\n";
    }
    
    if (file_exists(get_template_directory() . '/assets/images/apple-touch-icon.png')) {
        echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($favicon_png_180) . '" />' . "\n";
    }
    
    // Для Windows 8/10
    $favicon_metro = get_template_directory_uri() . '/assets/images/mstile-150x150.png';
    if (file_exists(get_template_directory() . '/assets/images/mstile-150x150.png')) {
        echo '<meta name="msapplication-TileImage" content="' . esc_url($favicon_metro) . '" />' . "\n";
        echo '<meta name="msapplication-TileColor" content="#ffffff" />' . "\n";
    }
    
    // Web App Manifest
    $manifest_url = get_template_directory_uri() . '/assets/images/site.webmanifest';
    if (file_exists(get_template_directory() . '/assets/images/site.webmanifest')) {
        echo '<link rel="manifest" href="' . esc_url($manifest_url) . '" />' . "\n";
    }
}
add_action('wp_head', 'mgf_add_favicon');
add_action('admin_head', 'mgf_add_favicon'); // Для админки
add_action('login_head', 'mgf_add_favicon'); // Для страницы входа

?>