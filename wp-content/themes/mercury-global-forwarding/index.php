<?php
/**
 * The main template file
 */
get_header();
?>

<?php
// Баннер секция
get_template_part('template-parts/banner');

// Секция услуг
get_template_part('template-parts/content-services');

// Секция галереи
get_template_part('template-parts/gallery');
?>

<?php get_footer(); ?>