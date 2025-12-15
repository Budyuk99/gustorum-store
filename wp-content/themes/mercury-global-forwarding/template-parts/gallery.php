<?php
/**
 * Gallery section template
 */

// Получаем текущий язык
$current_lang = mgf_get_current_language();
?>
<section class="slider">
    <h2 class="h2_basic h2_basic-slider"><?php echo mgf_translate(get_option('mgf_title_gallery', 'Галерея'), 'gallery_title'); ?></h2>
    
    <?php
    // Получаем изображения галереи
    $gallery_args = array(
        'post_type' => 'gallery',
        'posts_per_page' => -1,
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
    
    // Если Polylang активен, фильтруем по языку
    if (function_exists('pll_current_language')) {
        $gallery_args['lang'] = $current_lang;
    }
    
    $gallery_query = new WP_Query($gallery_args);
    
    if ($gallery_query->have_posts()) :
    ?>
        <div class="owl-carousel gallery-slider owl-theme">
            <?php while ($gallery_query->have_posts()) : $gallery_query->the_post(); ?>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="slide">
                        <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <!-- Fallback - статические изображения, если нет записей в галерее -->
        <div class="owl-carousel gallery-slider owl-theme">
            <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/slide_1.png" alt="<?php echo mgf_translate('Слайд 1', 'slide_1'); ?>"></div>
            <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/slide_1.png" alt="<?php echo mgf_translate('Слайд 2', 'slide_2'); ?>"></div>
        </div>
    <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
</section>