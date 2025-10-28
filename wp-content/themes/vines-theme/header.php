<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" />

    <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="container header-inner">
        <div class="mobile-menu__logo mobile-menu__logo-additional">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="logo">
        </div>
        <div class="header-inner_first__logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="logo">
        </div>
        <div class="header-inner_menu">
            <nav>
                <a href="#we-offer">МЫ ПРЕДЛАГАЕМ</a>
                <a href="#assortment">АССОРТИМЕНТ</a>
                <a href="#branding">БРЕНДИРОВАНИЕ</a>
                <a href="#discounts-on-bulk-orders">СКИДКИ НА ОПТОВЫЕ ЗАКАЗЫ</a>
                <a href="#how-we-work">КАК МЫ РАБОТАЕМ</a>
                <a href="#reviews">ОТЗЫВЫ</a>
                <a href="#who-tried-our-gifts">КТО УЖЕ ПОПРОБОВАЛ НАШИ ПОДАРКИ</a>
            </nav>
        </div>
        <div class="header-inner__contact-data">
            <div class="header-inner_first__phone"><a href="#">+7 495 540 47 63</a></div>
        </div>
        <div class="header-inner_second-block">
            <a href="#" class="header-inner_second__make-call" data-popup="call" data-popup-type="callback">Заказать звонок</a>
        </div>
    </div>

    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Открыть меню">
        <span></span><span></span><span></span>
    </button>

    <div class="mobile-menu">
        <div class="mobile-menu__header">
            <div class="mobile-menu__logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="logo" loading="lazy">
            </div>
            <button class="mobile-menu__close" id="mobileMenuClose" aria-label="Закрыть меню">×</button>
        </div>
        <nav class="mobile-menu__nav">
            <a href="#we-offer">МЫ ПРЕДЛАГАЕМ</a>
            <a href="#assortment">АССОРТИМЕНТ</a>
            <a href="#branding">БРЕНДИРОВАНИЕ</a>
            <a href="#discounts-on-bulk-orders">СКИДКИ НА ОПТОВЫЕ ЗАКАЗЫ</a>
            <a href="#how-we-work">КАК МЫ РАБОТАЕМ</a>
            <a href="#reviews">ОТЗЫВЫ</a>
            <a href="#who-tried-our-gifts">КТО УЖЕ ПОПРОБОВАЛ НАШИ ПОДАРКИ</a>
        </nav>
        <div class="mobile-menu__contacts">
            <div class="mobile-menu__phone">+7 495 540 47 63</div>
            <a href="#" class="mobile-menu__call-btn" data-popup="call" data-popup-type="callback">Заказать звонок</a>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>
</header>
