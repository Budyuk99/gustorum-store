<?php
/**
 * Banner section template
 */
$banner_type = get_option('mgf_banner_type', 'video');
$banner_video = get_option('mgf_banner_video');
$banner_image = get_option('mgf_banner_image');
$banner_title = get_option('mgf_banner_title', 'MERCURY GLOBAL FORWARDING');
$banner_subtitle = get_option('mgf_banner_subtitle', 'Full range of freight forwarding services');

// Если нет кастомных настроек, используем значения по умолчанию
$default_video = get_template_directory_uri() . '/assets/video/main-banner-video.mp4';
$default_image = get_template_directory_uri() . '/assets/images/default-banner.jpg';
?>

<section class="banner">
    <?php if ($banner_type === 'video'): ?>
        <?php if ($banner_video): ?>
            <video class="banner-video" autoplay muted loop playsinline>
                <source src="<?php echo esc_url($banner_video); ?>" type="video/mp4">
                Ваш браузер не поддерживает видео.
            </video>
        <?php else: ?>
            <!-- Fallback на видео по умолчанию -->
            <video class="banner-video" autoplay muted loop playsinline>
                <source src="<?php echo esc_url($default_video); ?>" type="video/mp4">
                Ваш браузер не поддерживает видео.
            </video>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($banner_image): ?>
            <div class="banner-image" style="background-image: url('<?php echo esc_url($banner_image); ?>');"></div>
        <?php else: ?>
            <!-- Fallback на изображение по умолчанию -->
            <div class="banner-image" style="background-image: url('<?php echo esc_url($default_image); ?>');"></div>
        <?php endif; ?>
    <?php endif; ?>
    
    <div class="banner-content">
        <div class="banner-content_first"><?php echo esc_html($banner_title); ?></div>
        <div class="banner-content_second"><?php echo esc_html($banner_subtitle); ?></div>
    </div>
</section>

<section class="text-after-banner">
    <div class="banner-content_second-block">
        <h1 class="banner-content_first banner-content_second-block__first"><?php echo esc_html($banner_title); ?></h1>
        <div class="banner-content_second banner-content_second-block__second"><?php echo esc_html($banner_subtitle); ?></div>
    </div>
</section>