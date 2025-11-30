<?php
/**
 * Gallery section template
 */
?>
<section class="slider">
    <h2 class="h2_basic h2_basic-slider"><?php echo esc_html(get_option('mgf_title_gallery', 'Галерея')); ?></h2>
    
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
            <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/slide_1.png" alt="Слайд 1"></div>
            <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/slide_1.png" alt="Слайд 2"></div>
        </div>
    <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
</section>