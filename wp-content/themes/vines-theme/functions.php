<?php
function sweetgift_enqueue_scripts() {
    // Стили
    wp_enqueue_style('main-style', get_stylesheet_uri());
    wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
    wp_enqueue_style('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css');

    // Скрипты
    wp_enqueue_script('jquery');
    wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), null, true);
    wp_enqueue_script('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js', array('jquery'), null, true);
    wp_enqueue_script('inputmask', 'https://unpkg.com/inputmask@5.x/dist/inputmask.min.js', array('jquery'), null, true);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/script.js', array('jquery', 'inputmask'), null, true);

    // Вставляем inline-инициализацию маски
    wp_add_inline_script(
        'inputmask',
        "document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.querySelector('input[name=\"phone\"]');
            if (phoneInput) {
                Inputmask({ mask: '+7 (999) 999-99-99' }).mask(phoneInput);
            }
        });"
    );
}
add_action('wp_enqueue_scripts', 'sweetgift_enqueue_scripts');

function mytheme_register_products_cpt() {
    $labels = array(
        'name' => 'Товары',
        'singular_name' => 'Товар',
        'add_new' => 'Добавить товар',
        'add_new_item' => 'Добавить новый товар',
        'edit_item' => 'Редактировать товар',
        'all_items' => 'Все товары',
        'menu_name' => 'Товары',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'thumbnail'),
        'menu_icon' => 'dashicons-cart',
    );

    register_post_type('product', $args);
}
add_action('init', 'mytheme_register_products_cpt');

function mytheme_register_brand_slider_cpt() {
    $labels = array(
        'name' => 'Брендирование (слайдер)',
        'singular_name' => 'Брендирование',
        'add_new' => 'Добавить бренд',
        'add_new_item' => 'Добавить новый бренд',
        'edit_item' => 'Редактировать бренд',
        'all_items' => 'Все бренды',
        'menu_name' => 'Бренды',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'thumbnail'),
        'menu_icon' => 'dashicons-format-image',
    );

    register_post_type('brand_slider', $args);
}
add_action('init', 'mytheme_register_brand_slider_cpt');

function mytheme_register_reviews_cpt() {
    $labels = array(
        'name' => 'Отзывы',
        'singular_name' => 'Отзыв',
        'add_new' => 'Добавить отзыв',
        'add_new_item' => 'Добавить новый отзыв',
        'edit_item' => 'Редактировать отзыв',
        'all_items' => 'Все отзывы',
        'menu_name' => 'Отзывы',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'thumbnail'), // title - для имени автора, editor - для текста
        'menu_icon' => 'dashicons-testimonial',
    );

    register_post_type('review', $args);
}
add_action('init', 'mytheme_register_reviews_cpt');
?>
