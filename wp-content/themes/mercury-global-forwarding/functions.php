<?php
// Theme setup
function mgf_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    
    // Добавляем кастомные размеры изображений для галереи
    add_image_size('gallery-slider', 1200, 600, true);
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

// Настройки для ссылок на мессенджеры
function mgf_messenger_settings_init() {
    // Регистрируем новую секцию настроек
    add_settings_section(
        'mgf_messenger_section',
        'Ссылки на мессенджеры',
        'mgf_messenger_section_callback',
        'general'
    );

    // Регистрируем поля для каждого мессенджера
    $messengers = array(
        'whatsapp' => 'WhatsApp',
        'telegram' => 'Telegram', 
        'teams' => 'Microsoft Teams',
        'messages' => 'Сообщения',
        'mail' => 'Email'
    );

    foreach ($messengers as $key => $name) {
        add_settings_field(
            'mgf_messenger_' . $key,
            $name,
            'mgf_messenger_field_callback',
            'general',
            'mgf_messenger_section',
            array('messenger' => $key)
        );

        register_setting('general', 'mgf_messenger_' . $key);
    }
}
add_action('admin_init', 'mgf_messenger_settings_init');

// callback функция для секции
function mgf_messenger_section_callback() {
    echo '<p>Введите ссылки для мессенджеров в футере сайта. Оставьте поле пустым, чтобы скрыть иконку.</p>';
}

// callback функция для полей
function mgf_messenger_field_callback($args) {
    $option = get_option('mgf_messenger_' . $args['messenger']);
    echo '<input type="url" name="mgf_messenger_' . $args['messenger'] . '" value="' . esc_url($option) . '" class="regular-text" />';
    
    // Подсказки для популярных мессенджеров
    $examples = array(
        'whatsapp' => ' (пример: https://wa.me/79001234567)',
        'telegram' => ' (пример: https://t.me/username, БЕЗ СИМВОЛА @)',
        'mail' => ' (пример: mailto:info@example.com)'
    );
    
    if (isset($examples[$args['messenger']])) {
        echo '<p class="description">' . $examples[$args['messenger']] . '</p>';
    }
}

// Создаем Custom Post Type для галереи
function mgf_gallery_post_type() {
    register_post_type('gallery',
        array(
            'labels' => array(
                'name' => 'Галерея',
                'singular_name' => 'Изображение',
                'add_new' => 'Добавить изображение',
                'add_new_item' => 'Добавить новое изображение',
                'edit_item' => 'Редактировать изображение',
                'new_item' => 'Новое изображение',
                'view_item' => 'Просмотреть изображение',
                'search_items' => 'Поиск изображений',
                'not_found' => 'Изображения не найдены',
                'not_found_in_trash' => 'В корзине изображений не найдено'
            ),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-format-gallery',
            'supports' => array('title', 'thumbnail'),
            'show_in_rest' => true,
            'publicly_queryable' => false, // Запрещаем прямые ссылки на изображения
        )
    );
}
add_action('init', 'mgf_gallery_post_type');

// Добавляем метабокс для порядка сортировки
function mgf_gallery_meta_boxes() {
    add_meta_box(
        'gallery_order',
        'Порядок сортировки',
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
    echo '<label for="gallery_order">Порядок (чем меньше число, тем выше в галерее):</label>';
    echo '<input type="number" id="gallery_order" name="gallery_order" value="' . esc_attr($order) . '" class="widefat" min="0" />';
    echo '<p class="description">Изображения сортируются по возрастанию этого числа</p>';
}

function mgf_save_gallery_order($post_id) {
    // Проверяем nonce
    if (!isset($_POST['gallery_order_nonce']) || !wp_verify_nonce($_POST['gallery_order_nonce'], 'gallery_order_nonce')) {
        return;
    }
    
    // Проверяем права пользователя
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Проверяем автосохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Сохраняем данные
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
        echo '<p>В галерее пока нет изображений.</p>';
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
            $new_columns['gallery_order'] = 'Порядок';
            $new_columns['thumbnail'] = 'Изображение';
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
    // Регистрируем новую секцию настроек
    add_settings_section(
        'mgf_banner_section',
        'Настройки баннера',
        'mgf_banner_section_callback',
        'general'
    );

    // Поле для типа контента (видео/изображение)
    add_settings_field(
        'mgf_banner_type',
        'Тип контента',
        'mgf_banner_type_callback',
        'general',
        'mgf_banner_section'
    );

    // Поле для видео
    add_settings_field(
        'mgf_banner_video',
        'Видео баннера',
        'mgf_banner_video_callback',
        'general',
        'mgf_banner_section'
    );

    // Поле для изображения
    add_settings_field(
        'mgf_banner_image',
        'Изображение баннера',
        'mgf_banner_image_callback',
        'general',
        'mgf_banner_section'
    );

    // Поле для заголовка
    add_settings_field(
        'mgf_banner_title',
        'Заголовок баннера',
        'mgf_banner_title_callback',
        'general',
        'mgf_banner_section'
    );

    // Поле для подзаголовка
    add_settings_field(
        'mgf_banner_subtitle',
        'Подзаголовок баннера',
        'mgf_banner_subtitle_callback',
        'general',
        'mgf_banner_section'
    );

    // Регистрируем настройки
    register_setting('general', 'mgf_banner_type');
    register_setting('general', 'mgf_banner_video');
    register_setting('general', 'mgf_banner_image');
    register_setting('general', 'mgf_banner_title');
    register_setting('general', 'mgf_banner_subtitle');
}
add_action('admin_init', 'mgf_banner_settings_init');

// callback функция для секции
function mgf_banner_section_callback() {
    echo '<p>Настройте баннер на главной странице. Можно использовать видео или изображение.</p>';
}

// callback функция для типа контента
function mgf_banner_type_callback() {
    $type = get_option('mgf_banner_type', 'video');
    ?>
    <select name="mgf_banner_type" id="mgf_banner_type">
        <option value="video" <?php selected($type, 'video'); ?>>Видео</option>
        <option value="image" <?php selected($type, 'image'); ?>>Изображение</option>
    </select>
    <p class="description">Выберите тип контента для баннера</p>
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

// callback функция для видео
function mgf_banner_video_callback() {
    $video = get_option('mgf_banner_video');
    ?>
    <div class="banner-video-field">
        <input type="url" name="mgf_banner_video" value="<?php echo esc_url($video); ?>" class="regular-text" />
        <button type="button" class="button mgf-upload-video">Выбрать видео</button>
        <p class="description">Загрузите видео в формате MP4 или укажите ссылку на видео</p>
        <?php if ($video): ?>
            <div style="margin-top: 10px;">
                <video style="max-width: 300px; height: auto;" controls>
                    <source src="<?php echo esc_url($video); ?>" type="video/mp4">
                    Ваш браузер не поддерживает видео.
                </video>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

// callback функция для изображения
function mgf_banner_image_callback() {
    $image = get_option('mgf_banner_image');
    ?>
    <div class="banner-image-field" style="display: none;">
        <input type="url" name="mgf_banner_image" value="<?php echo esc_url($image); ?>" class="regular-text" />
        <button type="button" class="button mgf-upload-image">Выбрать изображение</button>
        <p class="description">Загрузите изображение для баннера</p>
        <?php if ($image): ?>
            <div style="margin-top: 10px;">
                <img src="<?php echo esc_url($image); ?>" style="max-width: 300px; height: auto;" alt="Баннер" />
            </div>
        <?php endif; ?>
    </div>
    <?php
}

// callback функция для заголовка
function mgf_banner_title_callback() {
    $title = get_option('mgf_banner_title', 'MERCURY GLOBAL FORWARDING');
    ?>
    <input type="text" name="mgf_banner_title" value="<?php echo esc_attr($title); ?>" class="regular-text" />
    <p class="description">Заголовок баннера</p>
    <?php
}

// callback функция для подзаголовка
function mgf_banner_subtitle_callback() {
    $subtitle = get_option('mgf_banner_subtitle', 'Full range of freight forwarding services');
    ?>
    <input type="text" name="mgf_banner_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="regular-text" />
    <p class="description">Подзаголовок баннера</p>
    <?php
}

// Скрипты для загрузки медиафайлов
function mgf_banner_admin_scripts() {
    wp_enqueue_media();
    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            // Загрузка видео
            $(".mgf-upload-video").click(function(e) {
                e.preventDefault();
                var button = $(this);
                var frame = wp.media({
                    title: "Выберите видео",
                    library: { type: "video" },
                    multiple: false,
                    button: { text: "Выбрать" }
                });
                frame.on("select", function() {
                    var attachment = frame.state().get("selection").first().toJSON();
                    button.prev("input").val(attachment.url);
                });
                frame.open();
            });

            // Загрузка изображения
            $(".mgf-upload-image").click(function(e) {
                e.preventDefault();
                var button = $(this);
                var frame = wp.media({
                    title: "Выберите изображение",
                    library: { type: "image" },
                    multiple: false,
                    button: { text: "Выбрать" }
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
    register_post_type('services',
        array(
            'labels' => array(
                'name' => 'Услуги',
                'singular_name' => 'Услуга',
                'add_new' => 'Добавить услугу',
                'add_new_item' => 'Добавить новую услугу',
                'edit_item' => 'Редактировать услугу',
                'new_item' => 'Новая услуга',
                'view_item' => 'Просмотреть услугу',
                'search_items' => 'Поиск услуг',
                'not_found' => 'Услуги не найдены',
                'not_found_in_trash' => 'В корзине услуг не найдено'
            ),
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
        'Краткое описание',
        'mgf_services_short_description_callback',
        'services',
        'normal',
        'high'
    );
    
    add_meta_box(
        'services_icon',
        'Иконка услуги',
        'mgf_services_icon_callback',
        'services',
        'side',
        'default'
    );
    
    add_meta_box(
        'services_order',
        'Порядок сортировки',
        'mgf_services_order_callback',
        'services',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'mgf_services_meta_boxes');

// callback функция для краткого описания
function mgf_services_short_description_callback($post) {
    wp_nonce_field('services_short_description_nonce', 'services_short_description_nonce');
    $short_description = get_post_meta($post->ID, 'services_short_description', true);
    ?>
    <textarea id="services_short_description" name="services_short_description" rows="4" class="widefat"><?php echo esc_textarea($short_description); ?></textarea>
    <p class="description">Краткое описание, которое отображается в свернутом состоянии</p>
    <?php
}

// callback функция для иконки
function mgf_services_icon_callback($post) {
    wp_nonce_field('services_icon_nonce', 'services_icon_nonce');
    $icon = get_post_meta($post->ID, 'services_icon', true);
    $default_icons = array(
        'earth.svg' => 'Международные перевозки',
        'clipboard.svg' => 'Таможенное оформление',
        'box.svg' => 'Проектные перевозки',
        'building.svg' => 'Ответственное хранение',
        'money.svg' => 'Закупка товара',
        'receipt.svg' => 'Страхование грузов'
    );
    ?>
    <select name="services_icon" id="services_icon" class="widefat">
        <option value="">— Выберите иконку —</option>
        <?php foreach ($default_icons as $icon_file => $icon_name): ?>
            <option value="<?php echo esc_attr($icon_file); ?>" <?php selected($icon, $icon_file); ?>>
                <?php echo esc_html($icon_name); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <p class="description">Выберите иконку для услуги из существующих</p>
    
    <div style="margin-top: 10px;">
        <strong>Или загрузите свою иконку:</strong>
        <input type="url" name="services_custom_icon" value="<?php echo esc_url(get_post_meta($post->ID, 'services_custom_icon', true)); ?>" class="widefat" style="margin: 5px 0;" />
        <button type="button" class="button mgf-upload-icon">Выбрать иконку</button>
    </div>
    <?php
}

// callback функция для порядка сортировки
function mgf_services_order_callback($post) {
    wp_nonce_field('services_order_nonce', 'services_order_nonce');
    $order = get_post_meta($post->ID, 'services_order', true);
    if (empty($order)) {
        $order = 0;
    }
    ?>
    <label for="services_order">Порядок (чем меньше число, тем выше в списке):</label>
    <input type="number" id="services_order" name="services_order" value="<?php echo esc_attr($order); ?>" class="widefat" min="0" />
    <p class="description">Услуги сортируются по возрастанию этого числа</p>
    <?php
}

// Сохраняем метаполя
function mgf_save_services_meta($post_id) {
    // Проверяем nonce
    if (!isset($_POST['services_short_description_nonce']) || 
        !wp_verify_nonce($_POST['services_short_description_nonce'], 'services_short_description_nonce')) {
        return;
    }
    
    // Проверяем права пользователя
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Проверяем автосохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Сохраняем данные
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
            $new_columns['services_icon'] = 'Иконка';
            $new_columns['services_order'] = 'Порядок';
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
            echo '<img src="' . esc_url($custom_icon) . '" style="width: 32px; height: 32px;" alt="Иконка" />';
        } elseif ($icon) {
            echo '<img src="' . get_template_directory_uri() . '/assets/images/' . esc_attr($icon) . '" style="width: 32px; height: 32px;" alt="Иконка" />';
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
function mgf_services_admin_scripts() {
    wp_enqueue_media();
    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            // Загрузка кастомной иконки
            $(".mgf-upload-icon").click(function(e) {
                e.preventDefault();
                var button = $(this);
                var frame = wp.media({
                    title: "Выберите иконку",
                    library: { type: "image" },
                    multiple: false,
                    button: { text: "Выбрать" }
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
    // Регистрируем новую секцию настроек
    add_settings_section(
        'mgf_contacts_section',
        'Контакты в футере',
        'mgf_contacts_section_callback',
        'general'
    );

    // Контакты для Казахстана
    add_settings_field(
        'mgf_contacts_kz_company',
        'Название компании (Казахстан)',
        'mgf_contacts_kz_company_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_kz_address',
        'Адрес (Казахстан)',
        'mgf_contacts_kz_address_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_kz_bin',
        'БИН (Казахстан)',
        'mgf_contacts_kz_bin_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_kz_phone',
        'Телефон (Казахстан)',
        'mgf_contacts_kz_phone_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_kz_email',
        'Email (Казахстан)',
        'mgf_contacts_kz_email_callback',
        'general',
        'mgf_contacts_section'
    );

    // Контакты для Финляндии
    add_settings_field(
        'mgf_contacts_fi_company',
        'Название компании (Финляндия)',
        'mgf_contacts_fi_company_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_fi_address',
        'Адрес (Финляндия)',
        'mgf_contacts_fi_address_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_fi_business_id',
        'Business ID (Финляндия)',
        'mgf_contacts_fi_business_id_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_fi_phone',
        'Телефон (Финляндия)',
        'mgf_contacts_fi_phone_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_fi_email',
        'Email (Финляндия)',
        'mgf_contacts_fi_email_callback',
        'general',
        'mgf_contacts_section'
    );

    // Контакты для России
    add_settings_field(
        'mgf_contacts_ru_company',
        'Название компании (Россия)',
        'mgf_contacts_ru_company_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_ru_address',
        'Адрес (Россия)',
        'mgf_contacts_ru_address_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_ru_inn',
        'ИНН (Россия)',
        'mgf_contacts_ru_inn_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_ru_phone',
        'Телефон (Россия)',
        'mgf_contacts_ru_phone_callback',
        'general',
        'mgf_contacts_section'
    );

    add_settings_field(
        'mgf_contacts_ru_email',
        'Email (Россия)',
        'mgf_contacts_ru_email_callback',
        'general',
        'mgf_contacts_section'
    );

    // Регистрируем все настройки
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

// callback функция для секции
function mgf_contacts_section_callback() {
    echo '<p>Настройте контактную информацию для всех офисов компании. Оставьте поле пустым, чтобы скрыть его на сайте.</p>';
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
    $value = get_option('mgf_contacts_fi_address', "Haarlankatu 4 B 2,<br> FI-33230 Tampere,<br> Finland");
    echo '<textarea name="mgf_contacts_fi_address" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
    echo '<p class="description">Используйте &lt;br&gt; для переносов строк</p>';
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
    $value = get_option('mgf_contacts_ru_address', "197082 Россия, г. Санкт-Петербург,<br> ул. Оптиков д.37, стр.<br> 1, пом. 135-Н, р.м.2");
    echo '<textarea name="mgf_contacts_ru_address" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
    echo '<p class="description">Используйте &lt;br&gt; для переносов строк</p>';
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

?>