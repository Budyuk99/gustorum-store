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
    add_filter('home_url', function($url) use ($current_lang) {
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
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    
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
            <div class="lang-btn"><?php echo strtoupper($current_lang); ?></div>
            <div class="lang-menu">
                <?php
                // Получаем текущий URL без параметра lang
                $current_url = home_url($_SERVER['REQUEST_URI']);
                $clean_url = remove_query_arg('lang', $current_url);
                
                // Языки - ВСЕГДА показываем на родном языке
                // Это фиксированные названия, которые не должны переводиться
                $languages = array(
                    'ru' => array(
                        'name' => 'Русский', // Русский всегда на русском
                        'external' => false
                    ),
                    'en' => array(
                        'name' => 'English', // Английский всегда на английском
                        'external' => false
                    ),
                    'ch' => array(
                        'name' => '中文', // Китайский всегда на китайском
                        'external' => false
                    ),
                    'fi' => array(
                        'name' => 'Suomi', // Финский всегда на финском
                        'external' => false,
                    )
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
                       <?php echo $target; ?>
                       onclick="if(!this.target) mgfSetLanguageCookie('<?php echo esc_js($code); ?>')">
                        <?php echo esc_html($lang_data['name']); // Всегда показываем родное название ?>
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
// Функция для установки куки языка (только для фронтенда)
function mgfSetLanguageCookie(lang) {
    document.cookie = "mgf_frontend_language=" + lang + "; path=/; max-age=" + (365*24*60*60);
    document.cookie = "pll_language=" + lang + "; path=/; max-age=" + (365*24*60*60);
    
    // Обновляем кнопку языка (только код языка)
    var langBtn = document.querySelector('.lang-btn');
    if (langBtn) {
        langBtn.textContent = lang.toUpperCase();
    }
    
    // Обновляем все ссылки на странице с параметром lang
    document.querySelectorAll('a').forEach(function(link) {
        var href = link.getAttribute('href');
        if (href && !link.target && href.indexOf(window.location.hostname) !== -1 && 
            !href.includes('wp-admin') && !href.includes('wp-login')) {
            // Удаляем старый параметр lang и добавляем новый
            var url = new URL(href, window.location.origin);
            url.searchParams.set('lang', lang);
            link.setAttribute('href', url.toString());
        }
    });
    
    // Обновляем язык в теге html
    document.documentElement.lang = lang;
    document.body.className = document.body.className.replace(/\blang-\w+\b/g, 'lang-' + lang);
    document.body.setAttribute('data-current-lang', lang);
}
</script>