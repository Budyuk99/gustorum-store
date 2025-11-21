<?php
/**
 * Template Name: Custom Thank You Page
 */
get_header(); 
?>

<section class="thank-you">
  <div class="thank-you-wrapper">
    
    <!-- Левая часть (50%) -->
    <div class="thank-you-left">
      <h1>Спасибо за обращение!</h1>
      <p>Менеджер свяжется с вами в ближайшее время</p>
    </div>

    <!-- Правая часть (50%) -->
    <div class="thank-you-right">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/photo_2025-10-25_20-16-55.webp" 
           alt="Спасибо" 
           class="thank-you-image">
    </div>

  </div>
</section>

<?php get_footer(); ?>