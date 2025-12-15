<?php
/**
 * The footer for our theme
 */

// Получаем текущий язык
$current_lang = mgf_get_current_language();

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
                $kz_bin_value = get_option('mgf_contacts_kz_bin', '230340020517');
                if ($kz_bin_value && trim($kz_bin_value) !== ''): 
                ?>
                    <p class="line">
                        <?php echo mgf_translate('БИН:', 'bin'); ?> 
                        <?php echo esc_html(str_replace('БИН:', '', $kz_bin_value)); ?>
                    </p>
                <?php endif; ?>
                
                <?php 
                $kz_phone = get_option('mgf_contacts_kz_phone', '+7 (705) 850-38-45');
                if ($kz_phone && trim($kz_phone) !== ''): 
                ?>
                    <p class="line">
                        <?php echo mgf_translate('Тел:', 'phone'); ?> 
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $kz_phone)); ?>">
                            <?php echo esc_html($kz_phone); ?>
                        </a>
                    </p>
                <?php endif; ?>
                
                <?php 
                $kz_email = get_option('mgf_contacts_kz_email', 'info.kz@mercury-gf.com');
                if ($kz_email && trim($kz_email) !== ''): 
                ?>
                    <p class="line">
                        <?php echo mgf_translate('Эл. почта:', 'email'); ?> 
                        <a href="mailto:<?php echo esc_attr($kz_email); ?>">
                            <?php echo esc_html($kz_email); ?>
                        </a>
                    </p>
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
                $fi_business_id_value = get_option('mgf_contacts_fi_business_id', '3289135-4');
                if ($fi_business_id_value && trim($fi_business_id_value) !== ''): 
                ?>
                    <p class="line">
                        <?php echo mgf_translate('Business ID:', 'business_id'); ?> 
                        <?php echo esc_html(str_replace('Business ID:', '', $fi_business_id_value)); ?>
                    </p>
                <?php endif; ?>
                
                <?php 
                $fi_phone = get_option('mgf_contacts_fi_phone', '+358 41 570 8237');
                if ($fi_phone && trim($fi_phone) !== ''): 
                ?>
                    <p class="line">
                        <?php echo mgf_translate('Phone:', 'phone'); ?> 
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $fi_phone)); ?>">
                            <?php echo esc_html($fi_phone); ?>
                        </a>
                    </p>
                <?php endif; ?>
                
                <?php 
                $fi_email = get_option('mgf_contacts_fi_email', 'info.fi@mercury-gf.com');
                if ($fi_email && trim($fi_email) !== ''): 
                ?>
                    <p class="line">
                        <?php echo mgf_translate('Email:', 'email'); ?> 
                        <a href="mailto:<?php echo esc_attr($fi_email); ?>">
                            <?php echo esc_html($fi_email); ?>
                        </a>
                    </p>
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
                $ru_inn_value = get_option('mgf_contacts_ru_inn', '7839045340');
                if ($ru_inn_value && trim($ru_inn_value) !== ''): 
                ?>
                    <p class="line">
                        <?php echo mgf_translate('ИНН:', 'inn'); ?> 
                        <?php echo esc_html(str_replace('ИНН:', '', $ru_inn_value)); ?>
                    </p>
                <?php endif; ?>
                
                <?php 
                $ru_phone = get_option('mgf_contacts_ru_phone', '+7 (911) 180-98-20');
                if ($ru_phone && trim($ru_phone) !== ''): 
                ?>
                    <p class="line">
                        <?php echo mgf_translate('Тел:', 'phone'); ?> 
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $ru_phone)); ?>">
                            <?php echo esc_html($ru_phone); ?>
                        </a>
                    </p>
                <?php endif; ?>
                
                <?php 
                $ru_email = get_option('mgf_contacts_ru_email', 'info.ru@mercury-gf.com');
                if ($ru_email && trim($ru_email) !== ''): 
                ?>
                    <p class="line">
                        <?php echo mgf_translate('Эл. почта:', 'email'); ?> 
                        <a href="mailto:<?php echo esc_attr($ru_email); ?>">
                            <?php echo esc_html($ru_email); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</footer>

<!-- Кнопка мессенджера -->
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
        'type' => 'wechat'
    ),
    'mail' => array(
        'class' => 'mail',
        'title' => mgf_translate('Email', 'mail'),
        'icon' => 'mail.svg',
        'type' => 'regular'
    )
);

$active_messengers = array();

foreach ($messengers as $key => $messenger) {
    $option_name = 'mgf_messenger_' . $key . '_' . $current_lang;
    $link = get_option($option_name);
    
    if (!empty($link) && trim($link) !== '') {
        $active_messengers[$key] = array(
            'messenger' => $messenger,
            'link' => $link
        );
    }
}

if (!empty($active_messengers)): ?>
<div class="messenger-wrapper">
    <div class="messenger-btn">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/messangers.svg" alt="message" />
    </div>
    <div class="messenger-options">
        <?php foreach ($active_messengers as $key => $data): 
            $messenger = $data['messenger'];
            $link = $data['link'];
            
            if ($messenger['type'] === 'wechat') {
                echo '<a href="#" class="messenger-option ' . esc_attr($messenger['class']) . '" title="' . esc_attr($messenger['title']) . '" data-wechat-url="' . esc_attr($link) . '" data-lang="' . esc_attr($current_lang) . '">';
            } else {
                echo '<a href="' . esc_url($link) . '" target="_blank" class="messenger-option ' . esc_attr($messenger['class']) . '" title="' . esc_attr($messenger['title']) . '" data-lang="' . esc_attr($current_lang) . '">';
            }
            echo '<img src="' . get_template_directory_uri() . '/assets/images/' . esc_attr($messenger['icon']) . '" alt="' . esc_attr($messenger['title']) . '">';
            echo '</a>';
        endforeach; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-wechat-url]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var wechatUrl = this.getAttribute('data-wechat-url');
            var lang = this.getAttribute('data-lang');
            
            var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (isMobile && wechatUrl.startsWith('weixin://')) {
                window.location.href = wechatUrl;
                
                setTimeout(function() {
                    var messages = {
                        'ru': 'Откройте WeChat и добавьте контакт вручную',
                        'en': 'Open WeChat and add contact manually',
                        'zh': '打开微信并手动添加联系人',
                        'fi': 'Avaa WeChat ja lisä yhteystieto manuaalisesti'
                    };
                    var message = messages[lang] || messages['ru'];
                    alert(message);
                }, 500);
            } else {
                if (wechatUrl.startsWith('http')) {
                    window.open(wechatUrl, '_blank');
                } else {
                    var instructions = {
                        'ru': 'WeChat ID для поиска: ' + wechatUrl.replace('weixin://dl/chat?username=', '').replace('weixin://dl/add?username=', ''),
                        'en': 'WeChat ID to search: ' + wechatUrl.replace('weixin://dl/chat?username=', '').replace('weixin://dl/add?username=', ''),
                        'zh': '微信ID搜索: ' + wechatUrl.replace('weixin://dl/chat?username=', '').replace('weixin://dl/add?username=', ''),
                        'fi': 'WeChat ID hakuun: ' + wechatUrl.replace('weixin://dl/chat?username=', '').replace('weixin://dl/add?username=', '')
                    };
                    var instruction = instructions[lang] || instructions['ru'];
                    alert(instruction);
                }
            }
        });
    });
});
</script>
<?php endif; ?>

<style>
    .footer_container.footer-finnish {
        display: grid;
        grid-template-columns: 50% 25% 25% !important;
    }
    
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