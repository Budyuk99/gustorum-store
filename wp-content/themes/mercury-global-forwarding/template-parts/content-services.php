<?php
/**
 * Services section template
 */

// Получаем текущий язык
$current_lang = isset($_GET['lang']) ? sanitize_text_field($_GET['lang']) : 'ru';
?>
<section class="content content-services" id="services">
    <h2 class="h2_basic"><?php echo mgf_translate(get_option('mgf_title_services', 'Услуги'), 'services_title'); ?></h2>
    
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
    
    // Если Polylang активен, фильтруем по языку
    if (function_exists('pll_current_language')) {
        $services_args['lang'] = $current_lang;
    }
    
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
                                <a href="#" class="toggle-text-link" data-learn-more="<?php echo esc_attr(mgf_translate(get_option('mgf_button_learn_more', 'Узнать больше'), 'learn_more')); ?>" data-hide-text="<?php echo esc_attr(mgf_translate(get_option('mgf_button_hide', 'Скрыть'), 'hide_text')); ?>">
                                    <?php echo mgf_translate(get_option('mgf_button_learn_more', 'Узнать больше'), 'learn_more'); ?>
                                </a>
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
                    <div class="content-block_item-first"><?php echo mgf_translate('Международные перевозки', 'international_shipping'); ?></div>
                    <div class="content-block_item-second">
                        <?php
                        // Разные тексты для разных языков
                        switch ($current_lang) {
                            case 'ru':
                                echo 'Мы обеспечиваем быструю и безопасную логистику
                                на ключевых мировых направлениях. Наша задача —
                                предложить оптимальное решение и взять на себя
                                все сложности перевозки. Доверьте нам доставку
                                вашего груза — мы выполним её в срок и в строгом
                                соответствии с вашими требованиями.';
                                break;
                            case 'en':
                                echo 'We provide fast and secure logistics
                                on key global routes. Our task is to
                                offer the optimal solution and take on
                                all the complexities of transportation. Entrust us with the delivery
                                of your cargo — we will complete it on time and in strict
                                accordance with your requirements.';
                                break;
                            case 'zh':
                                echo '我们在全球主要航线上提供快速安全的物流服务。我们的任务是
                                提供最优解决方案并承担运输的所有复杂性。将您的货物
                                交付给我们——我们将按时并严格按照您的要求完成。';
                                break;
                            case 'fi':
                                echo 'Tarjoamme nopean ja turvallisen logistiikan
                                keskeisillä maailmanlaajuisilla reiteillä. Tehtävämme on
                                tarjota optimaalinen ratkaisu ja ottaa vastaan
                                kaikki kuljetuksen monimutkaisuudet. Luota meille toimituksen suorittamiseen
                                lastistasi — suoritamme sen ajallaan ja tiukasti
                                vaatimustesi mukaisesti.';
                                break;
                            default:
                                echo 'Мы обеспечиваем быструю и безопасную логистику
                                на ключевых мировых направлениях. Наша задача —
                                предложить оптимальное решение и взять на себя
                                все сложности перевозки. Доверьте нам доставку
                                вашего груза — мы выполним её в срок и в строгом
                                соответствии с вашими требованиями.';
                        }
                        ?>
                    </div>
                    <div class="content-block_item-second full-text">
                        <?php
                        switch ($current_lang) {
                            case 'ru':
                                echo 'Мир стремительно меняется, мы принимаем вызов и предлагаем качественные 
                                логистические решения, чтобы вы могли двигаться вперёд. Узнайте о новых 
                                возможностях в сфере международной доставки грузов. Мы поможем во всех 
                                вопросах, связанных с транспортировкой в международном сообщении и 
                                осуществим перевозку груза с соблюдением всех правил и условий.';
                                break;
                            case 'en':
                                echo 'The world is rapidly changing, we accept the challenge and offer quality
                                logistics solutions so you can move forward. Learn about new
                                opportunities in the field of international cargo delivery. We will help with all
                                issues related to transportation in international traffic and
                                carry out cargo transportation in compliance with all rules and conditions.';
                                break;
                            case 'zh':
                                echo '世界正在迅速变化，我们接受挑战并提供高质量的物流解决方案，让您能够向前迈进。了解
                                国际货物交付领域的新机遇。我们将帮助解决与国际交通运输相关的所有问题，
                                并按照所有规则和条件执行货物运输。';
                                break;
                            case 'fi':
                                echo 'Maailma muuttuu nopeasti, hyväksymme haasteen ja tarjoamme laadukkaita
                                logistiikkaratkaisuja, jotta voit edetä. Opi uusista
                                mahdollisuuksista kansainvälisen rahdin toimituksen alalla. Autamme kaikissa
                                liittyvissä kysymyksissä kansainvälisen liikenteen kuljetuksiin ja
                                suoritamme rahdinkuljetuksen kaikkien sääntöjen ja ehtojen mukaisesti.';
                                break;
                            default:
                                echo 'Мир стремительно меняется, мы принимаем вызов и предлагаем качественные 
                                логистические решения, чтобы вы могли двигаться вперёд. Узнайте о новых 
                                возможностях в сфере международной доставки грузов. Мы поможем во всех 
                                вопросах, связанных с транспортировкой в международном сообщении и 
                                осуществим перевозку груза с соблюдением всех правил и условий.';
                        }
                        ?>

                        <div class="full-text_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/international_transportation.svg" alt="international_transportation">
                        </div>
                    </div>
                    <div class="content-block_item-third">
                        <a href="#" class="toggle-text-link" data-learn-more="<?php echo esc_attr(mgf_translate(get_option('mgf_button_learn_more', 'Узнать больше'), 'learn_more')); ?>" data-hide-text="<?php echo esc_attr(mgf_translate(get_option('mgf_button_hide', 'Скрыть'), 'hide_text')); ?>">
                            <?php echo mgf_translate(get_option('mgf_button_learn_more', 'Узнать больше'), 'learn_more'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Добавьте остальные статические услуги по аналогии -->
        </div>
    <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
</section>