<?php

/**
 * The header for our theme
 */

// Получаем текущий язык только для фронтенда
// Админка использует свои языковые настройки
$current_lang = 'ru'; // Значение по умолчанию

// Определяем язык только для фронтенда
if (!is_admin()) {
    // Сначала проверяем параметр URL
    if (isset($_GET['lang'])) {
        $current_lang = sanitize_text_field($_GET['lang']);
        // Сохраняем в куки для фронтенда
        setcookie('mgf_frontend_language', $current_lang, time() + (365 * 24 * 60 * 60), '/');
    }
    // Затем проверяем куки фронтенда
    elseif (isset($_COOKIE['mgf_frontend_language'])) {
        $current_lang = $_COOKIE['mgf_frontend_language'];
    }

    // Устанавливаем язык в Polylang ТОЛЬКО для фронтенда
    if (function_exists('pll_set_current_language') && in_array($current_lang, array('ru', 'en', 'ch', 'fi'))) {
        pll_set_current_language($current_lang);
    }

    // Для языкового переключателя всегда используем URL с параметром lang
    add_filter('home_url', function ($url) use ($current_lang) {
        if (strpos($url, 'wp-admin') !== false || strpos($url, 'wp-login') !== false) {
            return $url;
        }
        // Добавляем параметр lang ко всем ссылкам на фронтенде
        return add_query_arg('lang', $current_lang, remove_query_arg('lang', $url));
    }, 10, 1);
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> lang="<?php echo esc_attr($current_lang); ?>">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right');
            bloginfo('name'); ?></title>

    <!-- hreflang теги для SEO -->
    <?php if (!is_admin() && function_exists('pll_the_languages')): ?>
        <?php
        $languages = pll_the_languages(array('raw' => 1, 'hide_if_no_translation' => 0));
        foreach ($languages as $lang) {
            $url_with_lang = add_query_arg('lang', $lang['slug'], remove_query_arg('lang', $lang['url']));
            echo '<link rel="alternate" hreflang="' . esc_attr($lang['locale']) . '" href="' . esc_url($url_with_lang) . '" />' . "\n";
        }
        // x-default
        if (isset($languages['ru'])) {
            $default_url = add_query_arg('lang', 'ru', remove_query_arg('lang', $languages['ru']['url']));
            echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($default_url) . '" />' . "\n";
        }
        ?>
    <?php endif; ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class('lang-' . $current_lang); ?> data-current-lang="<?php echo esc_attr($current_lang); ?>">

    <header>
        <div class="logo">
            <a href="<?php
                        echo esc_url(add_query_arg('lang', $current_lang, home_url('/')));
                        ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="logo">
            </a>
        </div>
        <div class="mobile_logo">
            <a href="<?php
                        echo esc_url(add_query_arg('lang', $current_lang, home_url('/')));
                        ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mobile_logo.svg" alt="mobile_logo">
            </a>
        </div>

        <nav class="main-nav">
            <a href="<?php
                        echo esc_url(add_query_arg('lang', $current_lang, home_url('/#services')));
                        ?>">
                <?php echo mgf_translate('Услуги', 'services_nav'); ?>
            </a>
            <a href="<?php
                        echo esc_url(add_query_arg('lang', $current_lang, home_url('/#contacts')));
                        ?>" class="contacts_a">
                <?php echo mgf_translate('Контакты', 'contacts_nav'); ?>
            </a>

            <div class="divider"></div>

            <div class="lang-dropdown">
                <div><img src="<?php echo get_template_directory_uri(); ?>/assets/images/Vector.svg" alt="vector"></div>
                <div class="lang-btn">
                    <?php
                    // Маппинг языков для кнопки (должен совпадать с JavaScript маппингом)
                    $language_codes = array(
                        'ru' => 'RU',
                        'en' => 'EN',
                        'zh' => '中文',
                        'fi' => 'SU'
                    );
                    echo isset($language_codes[$current_lang]) ? $language_codes[$current_lang] : strtoupper($current_lang);
                    ?>
                </div>
                <div class="lang-menu">
                    <?php
                    // Получаем текущий URL без параметра lang
                    $current_url = home_url($_SERVER['REQUEST_URI']);
                    $clean_url = remove_query_arg('lang', $current_url);

                    // Языки - ВСЕГДА показываем на родном языке
                    $languages = array(
                        'en' => array(
                            'name' => 'English',
                            'external' => false
                        ),
                        'fi' => array(
                            'name' => 'Suomi',
                            'external' => false,
                        ),
                        'zh' => array(
                            'name' => '中文',
                            'external' => false
                        ),
                        'ru' => array(
                            'name' => 'Русский',
                            'external' => false
                        ),
                    );

                    foreach ($languages as $code => $lang_data) {
                        $active_class = ($current_lang === $code) ? 'active' : '';

                        // URL для языка
                        if (!empty($lang_data['external'])) {
                            $url = $lang_data['url'];
                            $target = ' target="_blank"';
                        } else {
                            $url = add_query_arg('lang', $code, $clean_url);
                            $target = '';
                        }
                    ?>
                        <a href="<?php echo esc_url($url); ?>"
                            class="lang-option <?php echo esc_attr($active_class); ?>"
                            data-lang="<?php echo esc_attr($code); ?>"
                            <?php echo $target; ?>>
                            <?php echo esc_html($lang_data['name']); ?>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <main id="main">

        <script>
            // Маппинг языков для кнопки
            var languageCodes = {
                'ru': 'RU',
                'en': 'EN',
                'zh': '中文',
                'fi': 'SU'
            };

            // Функция для установки куки языка и перехода
            function switchLanguage(lang, url) {
                // Устанавливаем куки
                document.cookie = "mgf_frontend_language=" + lang + "; path=/; max-age=" + (365 * 24 * 60 * 60);
                document.cookie = "pll_language=" + lang + "; path=/; max-age=" + (365 * 24 * 60 * 60);

                // Обновляем кнопку МГНОВЕННО перед переходом
                var langBtn = document.querySelector('.lang-btn');
                if (langBtn) {
                    langBtn.textContent = languageCodes[lang] || lang.toUpperCase();
                }

                // Обновляем язык в теге html
                document.documentElement.lang = lang;
                document.body.className = document.body.className.replace(/\blang-\w+\b/g, 'lang-' + lang);
                document.body.setAttribute('data-current-lang', lang);

                // Немедленный переход
                window.location.href = url;
            }

            // Вешаем обработчики при загрузке страницы
            document.addEventListener('DOMContentLoaded', function() {
                // Удаляем все старые обработчики onclick
                document.querySelectorAll('.lang-option').forEach(function(option) {
                    option.removeAttribute('onclick');
                });

                // Добавляем новые обработчики
                document.querySelectorAll('.lang-option').forEach(function(option) {
                    option.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();

                        var lang = this.getAttribute('data-lang');
                        var target = this.getAttribute('target');

                        // Если ссылка открывается в новом окне
                        if (target === '_blank') {
                            window.open(this.href, '_blank');
                            return;
                        }

                        // Для обычных ссылок
                        switchLanguage(lang, this.href);

                        // Возвращаем false для полного предотвращения дефолтного поведения
                        return false;
                    });

                    // Также предотвращаем события по умолчанию через onmousedown
                    option.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                        return false;
                    });
                });
            });

            // Также предотвращаем дефолтное поведение для всех ссылок в выпадающем меню
            document.addEventListener('mousedown', function(e) {
                if (e.target.closest('.lang-menu a')) {
                    e.preventDefault();
                }
            }, true);
        </script>