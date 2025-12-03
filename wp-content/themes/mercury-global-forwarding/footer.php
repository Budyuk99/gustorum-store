<?php
/**
 * The footer for our theme
 */

// Получаем текущий язык
$current_lang = isset($_GET['lang']) ? sanitize_text_field($_GET['lang']) : 'ru';

// Проверяем, это финская версия?
$is_finnish_version = ($current_lang === 'fi');

// Класс для логотипа в зависимости от версии
$logo_class = $is_finnish_version ? 'footer_item logo logo-extra-wide' : 'footer_item logo';

// Класс для контейнера в зависимости от версии
$container_class = $is_finnish_version ? 'footer_container footer-finnish' : 'footer_container';
?>
</main>

<footer class="footer" id="contacts">
    <div class="<?php echo esc_attr($container_class); ?>">
        <!-- Логотип -->
        <div class="<?php echo esc_attr($logo_class); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_footer.svg" alt="logo">
        </div>

        <!-- Казахстан -->
        <div class="footer_item">
            <?php 
            $kz_company = mgf_translate(get_option('mgf_contacts_kz_company', 'Mercury Global Forwarding Ltd'), 'kz_company');
            if ($kz_company && trim($kz_company) !== ''): 
            ?>
                <p class="line line_coord">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/coordinates.svg" alt="coordinates">
                    <?php echo esc_html($kz_company); ?>
                </p>
            <?php endif; ?>
            
            <div class="footer_item_without-ing">
                <?php 
                $kz_address = mgf_translate(get_option('mgf_contacts_kz_address', '100017 Республика Казахстан, Карагандинская область, г. Караганда, ул. Ерубаева, дом 50а, н.п. 6.'), 'kz_address');
                if ($kz_address && trim(strip_tags($kz_address)) !== ''): 
                ?>
                    <p class="line line_second"><?php echo wp_kses_post(str_replace("\n", '<br>', trim($kz_address))); ?></p>
                <?php endif; ?>
                
                <?php 
                $kz_bin = mgf_translate(get_option('mgf_contacts_kz_bin', 'БИН: 230340020517'), 'bin');
                if ($kz_bin && trim($kz_bin) !== ''): 
                ?>
                    <p class="line"><?php echo esc_html($kz_bin); ?></p>
                <?php endif; ?>
                
                <?php 
                $kz_phone = get_option('mgf_contacts_kz_phone', '+7 (705) 850-38-45');
                if ($kz_phone && trim($kz_phone) !== ''): 
                ?>
                    <p class="line"><?php echo mgf_translate('Тел:', 'phone'); ?> <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $kz_phone)); ?>"><?php echo esc_html($kz_phone); ?></a></p>
                <?php endif; ?>
                
                <?php 
                $kz_email = get_option('mgf_contacts_kz_email', 'info.kz@mercury-gf.com');
                if ($kz_email && trim($kz_email) !== ''): 
                ?>
                    <p class="line"><?php echo mgf_translate('Эл. почта:', 'email'); ?> <a href="mailto:<?php echo esc_attr($kz_email); ?>"><?php echo esc_html($kz_email); ?></a></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Финляндия -->
        <div class="footer_item">
            <?php 
            $fi_company = mgf_translate(get_option('mgf_contacts_fi_company', 'Mercury Global Forwarding Oy'), 'fi_company');
            if ($fi_company && trim($fi_company) !== ''): 
            ?>
                <p class="line line_coord">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/coordinates.svg" alt="coordinates">
                    <?php echo esc_html($fi_company); ?>
                </p>
            <?php endif; ?>
            
            <div class="footer_item_without-ing">
                <?php 
                $fi_address = mgf_translate(get_option('mgf_contacts_fi_address', 'Haarlankatu 4 B 2, FI-33230 Tampere, Finland'), 'fi_address');
                if ($fi_address && trim(strip_tags($fi_address)) !== ''): 
                ?>
                    <p class="line line_second"><?php echo wp_kses_post(str_replace("\n", '<br>', trim($fi_address))); ?></p>
                <?php endif; ?>
                
                <?php 
                $fi_business_id = mgf_translate(get_option('mgf_contacts_fi_business_id', 'Business ID: 3289135-4'), 'business_id');
                if ($fi_business_id && trim($fi_business_id) !== ''): 
                ?>
                    <p class="line"><?php echo esc_html($fi_business_id); ?></p>
                <?php endif; ?>
                
                <?php 
                $fi_phone = get_option('mgf_contacts_fi_phone', '+358 41 570 8237');
                if ($fi_phone && trim($fi_phone) !== ''): 
                ?>
                    <p class="line"><?php echo mgf_translate('Тел:', 'phone'); ?> <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $fi_phone)); ?>"><?php echo esc_html($fi_phone); ?></a></p>
                <?php endif; ?>
                
                <?php 
                $fi_email = get_option('mgf_contacts_fi_email', 'info.fi@mercury-gf.com');
                if ($fi_email && trim($fi_email) !== ''): 
                ?>
                    <p class="line"><?php echo mgf_translate('Эл. почта:', 'email'); ?> <a href="mailto:<?php echo esc_attr($fi_email); ?>"><?php echo esc_html($fi_email); ?></a></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Россия - скрываем только в финской версии -->
        <?php if (!$is_finnish_version): ?>
        <div class="footer_item">
            <?php 
            $ru_company = mgf_translate(get_option('mgf_contacts_ru_company', 'ООО "Меркури Глобал Форвардинг"'), 'ru_company');
            if ($ru_company && trim($ru_company) !== ''): 
            ?>
                <p class="line line_coord">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/coordinates.svg" alt="coordinates">
                    <?php echo esc_html($ru_company); ?>
                </p>
            <?php endif; ?>
            
            <div class="footer_item_without-ing">
                <?php 
                $ru_address = mgf_translate(get_option('mgf_contacts_ru_address', '197082 Россия, г. Санкт-Петербург, ул. Оптиков д.37, стр. 1, пом. 135-Н, р.м.2'), 'ru_address');
                if ($ru_address && trim(strip_tags($ru_address)) !== ''): 
                ?>
                    <p class="line line_second"><?php echo wp_kses_post(str_replace("\n", '<br>', trim($ru_address))); ?></p>
                <?php endif; ?>
                
                <?php 
                $ru_inn = mgf_translate(get_option('mgf_contacts_ru_inn', 'ИНН 7839045340'), 'inn');
                if ($ru_inn && trim($ru_inn) !== ''): 
                ?>
                    <p class="line"><?php echo esc_html($ru_inn); ?></p>
                <?php endif; ?>
                
                <?php 
                $ru_phone = get_option('mgf_contacts_ru_phone', '+7 (911) 180-98-20');
                if ($ru_phone && trim($ru_phone) !== ''): 
                ?>
                    <p class="line"><?php echo mgf_translate('Тел:', 'phone'); ?> <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $ru_phone)); ?>"><?php echo esc_html($ru_phone); ?></a></p>
                <?php endif; ?>
                
                <?php 
                $ru_email = get_option('mgf_contacts_ru_email', 'info.ru@mercury-gf.com');
                if ($ru_email && trim($ru_email) !== ''): 
                ?>
                    <p class="line"><?php echo mgf_translate('Эл. почта:', 'email'); ?> <a href="mailto:<?php echo esc_attr($ru_email); ?>"><?php echo esc_html($ru_email); ?></a></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</footer>

<!-- Кнопка мессенджера -->
<div class="messenger-wrapper">
    <div class="messenger-btn">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/messangers.svg" alt="message" />
    </div>
    <div class="messenger-options">
        <?php
        $messengers = array(
            'whatsapp' => array(
                'class' => 'whatsapp',
                'title' => mgf_translate('WhatsApp', 'whatsapp'),
                'icon' => 'whatsApp.svg',
                'type' => 'regular'
            ),
            'telegram' => array(
                'class' => 'telegram', 
                'title' => mgf_translate('Telegram', 'telegram'),
                'icon' => 'telegram.svg',
                'type' => 'regular'
            ),
            'teams' => array(
                'class' => 'teams',
                'title' => mgf_translate('Teams', 'teams'),
                'icon' => 'teams.svg',
                'type' => 'regular'
            ),
            'wechat' => array(
                'class' => 'wechat',
                'title' => mgf_translate('WeChat', 'wechat'),
                'icon' => 'wechat.svg',
                'type' => 'wechat' // специальный тип для WeChat
            ),
            'mail' => array(
                'class' => 'mail',
                'title' => mgf_translate('Email', 'mail'),
                'icon' => 'mail.svg',
                'type' => 'regular'
            )
        );

        foreach ($messengers as $key => $messenger) {
            $link = get_option('mgf_messenger_' . $key);
            if (!empty($link)) {
                if ($messenger['type'] === 'wechat') {
                    // Для WeChat используем data-атрибут и JavaScript
                    echo '<a href="#" class="messenger-option ' . esc_attr($messenger['class']) . '" title="' . esc_attr($messenger['title']) . '" data-wechat-url="' . esc_attr($link) . '">';
                } else {
                    // Для остальных обычные ссылки
                    echo '<a href="' . esc_url($link) . '" target="_blank" class="messenger-option ' . esc_attr($messenger['class']) . '" title="' . esc_attr($messenger['title']) . '">';
                }
                echo '<img src="' . get_template_directory_uri() . '/assets/images/' . esc_attr($messenger['icon']) . '" alt="' . esc_attr($messenger['title']) . '">';
                echo '</a>';
            }
        }
        ?>
    </div>
</div>

<!-- JavaScript для обработки WeChat ссылок -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Обработка WeChat ссылок
    document.querySelectorAll('[data-wechat-url]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var wechatUrl = this.getAttribute('data-wechat-url');
            
            // Проверяем, мобильное ли устройство
            var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (isMobile) {
                // На мобильных пытаемся открыть через weixin://
                window.location.href = wechatUrl;
                
                // Если через 500ms не открылось, показываем альтернативу
                setTimeout(function() {
                    // Можно показать QR-код или сообщение
                    if (document.querySelector('#wechat-qr-modal')) {
                        document.querySelector('#wechat-qr-modal').style.display = 'block';
                    } else {
                        alert('<?php echo esc_js(mgf_translate("Откройте WeChat и добавьте контакт вручную", "wechat_manual")); ?>');
                    }
                }, 500);
            } else {
                // На десктопе показываем QR-код или инструкции
                if (document.querySelector('#wechat-qr-modal')) {
                    document.querySelector('#wechat-qr-modal').style.display = 'block';
                } else {
                    // Создаем модальное окно с QR-кодом
                    var modal = document.createElement('div');
                    modal.id = 'wechat-qr-modal';
                    modal.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);z-index:9999;display:flex;align-items:center;justify-content:center;';
                    modal.innerHTML = '<div style="background:white;padding:20px;border-radius:10px;text-align:center;"><h3><?php echo esc_js(mgf_translate("WeChat", "wechat")); ?></h3><p><?php echo esc_js(mgf_translate("Отсканируйте QR-код в WeChat", "scan_qr_in_wechat")); ?></p><div style="margin:20px 0;"><img src="<?php echo esc_url(get_option("mgf_messenger_wechat_qr", "")); ?>" alt="WeChat QR" style="max-width:200px;"></div><button onclick="this.parentElement.parentElement.style.display=\'none\'"><?php echo esc_js(mgf_translate("Закрыть", "close")); ?></button></div>';
                    document.body.appendChild(modal);
                    
                    // Закрытие по клику вне окна
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            modal.style.display = 'none';
                        }
                    });
                }
            }
        });
    });
});
</script>

<!-- Добавляем стили для финской версии футера -->
<style>
    .footer_container.footer-finnish {
        display: grid;
        grid-template-columns: 50% 25% 25% !important; /* 50% | 25% | 25% */
    }
    
    /* Адаптация для мобильных устройств */
    @media (max-width: 768px) {
        .footer_container.footer-finnish,
        .footer_container {
            flex-direction: column !important;
            grid-template-columns: 1fr !important;
        }
        
        .footer_container.footer-finnish .logo-extra-wide,
        .footer_container.footer-finnish .footer_item:not(.logo),
        .footer_container .footer_item {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            width: 100% !important;
            margin-bottom: 30px;
        }
        
        .footer_container.footer-finnish .logo-extra-wide {
            margin-bottom: 20px;
        }
    }
    
    /* Адаптация для планшетов */
    @media (min-width: 769px) and (max-width: 1024px) {
        .footer_container.footer-finnish .logo-extra-wide {
            flex: 0 0 40% !important;
            max-width: 40% !important;
        }
        
        .footer_container.footer-finnish .footer_item:not(.logo) {
            flex: 0 0 30% !important;
            max-width: 30% !important;
        }
    }
</style>

<?php wp_footer(); ?>
</body>
</html>