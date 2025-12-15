<?php
/**
 * Template for individual pages
 */
get_header();

// Получаем текущий язык
$current_lang = mgf_get_current_language();
?>

<main class="page-content">
    <?php if (is_page('privacy-policy') || get_the_ID() == 3): ?>
        <!-- Шаблон для политики конфиденциальности -->
        <section class="privacy-policy-section">
            <div class="container">
                <!-- Заголовок с иконкой -->
                <div class="privacy-policy-header">
                    <div class="privacy-icon">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="#0073aa">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                        </svg>
                    </div>
                    <h1 class="privacy-title">
                        <?php 
                        // Мультиязычный заголовок
                        if ($current_lang === 'en') {
                            echo 'Privacy Policy';
                        } elseif ($current_lang === 'zh') {
                            echo '隐私政策';
                        } elseif ($current_lang === 'fi') {
                            echo 'Tietosuojakäytäntö';
                        } else {
                            the_title();
                        }
                        ?>
                    </h1>
                    <div class="privacy-subtitle">
                        <?php 
                        if ($current_lang === 'en') {
                            echo 'Last updated: ' . date('F j, Y');
                        } elseif ($current_lang === 'zh') {
                            echo '最后更新：' . date('Y年m月d日');
                        } elseif ($current_lang === 'fi') {
                            echo 'Päivitetty: ' . date('j.n.Y');
                        } else {
                            echo 'Последнее обновление: ' . date('d.m.Y');
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Контент политики -->
                <div class="privacy-policy-content">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <div class="privacy-text">
                            <?php the_content(); ?>
                        </div>
                    <?php endwhile; endif; ?>
                    
                    <!-- Контактная информация -->
                    <div class="privacy-contact">
                        <h3>
                            <?php 
                            if ($current_lang === 'en') {
                                echo 'Contact Information';
                            } elseif ($current_lang === 'zh') {
                                echo '联系信息';
                            } elseif ($current_lang === 'fi') {
                                echo 'Yhteystiedot';
                            } else {
                                echo 'Контактная информация';
                            }
                            ?>
                        </h3>
                        <p>
                            <?php 
                            if ($current_lang === 'en') {
                                echo 'For questions about the privacy policy, please contact:';
                            } elseif ($current_lang === 'zh') {
                                echo '有关隐私政策的问题，请联系：';
                            } elseif ($current_lang === 'fi') {
                                echo 'Kysymyksiä tietosuojakäytännöstä, ota yhteyttä:';
                            } else {
                                echo 'По вопросам о политике конфиденциальности обращайтесь:';
                            }
                            ?>
                        </p>
                        <div class="contact-details">
                            <p><strong>Mercury Global Forwarding</strong></p>
                            <p>Email: info@mercury-gf.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    <?php else: ?>
        <!-- Для других страниц -->
        <section class="default-page">
            <div class="container">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="page-content-inner">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>