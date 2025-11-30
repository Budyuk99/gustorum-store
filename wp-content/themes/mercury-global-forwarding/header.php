<?php
/**
 * The header for our theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>
    <div class="logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="logo">
        </a>
    </div>
    <div class="mobile_logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mobile_logo.svg" alt="mobile_logo">
        </a>
    </div>

    <nav class="main-nav">
        <a href="#services">Услуги</a>
        <a href="#contacts" class="contacts_a">Контакты</a>

        <div class="divider"></div>

        <div class="lang-dropdown">
            <div><img src="<?php echo get_template_directory_uri(); ?>/assets/images/Vector.svg" alt="vector"></div>
            <div class="lang-btn">RU</div>
            <div class="lang-menu">
                <a href="#" data-lang="ru">Русский</a>
                <a href="#" data-lang="en">English</a>
                <a href="#" data-lang="ch">中文</a>
                <a href="#" data-lang="fi">Suomalainen</a>
            </div>
        </div>
    </nav>
</header>

<main id="main">