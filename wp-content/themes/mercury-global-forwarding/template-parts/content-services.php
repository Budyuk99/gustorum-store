<?php
/**
 * Services section template
 */
?>
<section class="content content-services" id="services">
    <h2 class="h2_basic">Услуги</h2>
    
    <?php
    // Получаем услуги
    $services_args = array(
        'post_type' => 'services',
        'posts_per_page' => -1,
        'meta_key' => 'services_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'post_status' => 'publish'
    );
    
    $services_query = new WP_Query($services_args);
    
    if ($services_query->have_posts()) :
    ?>
        <div class="content-block">
            <?php while ($services_query->have_posts()) : $services_query->the_post(); 
                $short_description = get_post_meta(get_the_ID(), 'services_short_description', true);
                $icon = get_post_meta(get_the_ID(), 'services_icon', true);
                $custom_icon = get_post_meta(get_the_ID(), 'services_custom_icon', true);
                
                // Определяем путь к иконке
                $icon_url = '';
                if ($custom_icon) {
                    $icon_url = $custom_icon;
                } elseif ($icon) {
                    $icon_url = get_template_directory_uri() . '/assets/images/' . $icon;
                }
            ?>
                <div class="content-block_item">
                    <?php if ($icon_url): ?>
                        <div class="content-block_item-img">
                            <img src="<?php echo esc_url($icon_url); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="content-block_item-text">
                        <div class="content-block_item-first"><?php the_title(); ?></div>
                        
                        <?php if ($short_description): ?>
                            <div class="content-block_item-second">
                                <?php echo wp_kses_post(wpautop($short_description)); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (get_the_content()): ?>
                            <div class="content-block_item-second full-text">
                                <?php the_content(); ?>
                                
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="full-text_img">
                                        <?php 
                                        $image_url = wp_get_attachment_image_url(get_post_thumbnail_id(), 'large');
                                        if ($image_url) : 
                                        ?>
                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" />
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (get_the_content()): ?>
                            <div class="content-block_item-third">
                                <a href="#" class="toggle-text-link">Узнать больше</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <!-- Fallback - статические услуги, если нет записей -->
        <div class="content-block">
            <div class="content-block_item">
                <div class="content-block_item-img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/earth.svg" alt="Vehicle_Truck_Cube"></div>
                <div class="content-block_item-text">
                    <div class="content-block_item-first">Международные перевозки</div>
                    <div class="content-block_item-second">
                        Мы обеспечиваем быструю и безопасную логистику
                        на ключевых мировых направлениях. Наша задача —
                        предложить оптимальное решение и взять на себя
                        все сложности перевозки. Доверьте нам доставку
                        вашего груза — мы выполним её в срок и в строгом
                        соответствии с вашими требованиями.
                    </div>
                    <div class="content-block_item-second full-text">
                        Мир стремительно меняется, мы принимаем вызов и предлагаем качественные 
                        логистические решения, чтобы вы могли двигаться вперёд. Узнайте о новых 
                        возможностях в сфере международной доставки грузов. Мы поможем во всех 
                        вопросах, связанных с транспортировкой в международном сообщении и 
                        осуществим перевозку груза с соблюдением всех правил и условий.

                        <div class="full-text_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/international_transportation.svg" alt="international_transportation">
                        </div>
                    </div>
                    <div class="content-block_item-third"><a href="#" class="toggle-text-link">Узнать больше</a></div>
                </div>
            </div>
            <!-- Добавьте остальные статические услуги по аналогии -->
        </div>
    <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
</section>