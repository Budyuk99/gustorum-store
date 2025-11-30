<?php
/**
 * The footer for our theme
 */
?>
</main>

<footer class="footer" id="contacts">
    <div class="footer_container">
        <!-- Логотип -->
        <div class="footer_item logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_footer.svg" alt="logo">
        </div>

        <!-- Казахстан -->
        <div class="footer_item">
            <p class="line line_coord"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/coordinates.svg" alt="coordinates">Mercury Global Forwarding Ltd</p>
            <div class="footer_item_without-ing">
                <p class="line line_second">100017 Республика Казахстан, Карагандинская область, г. Караганда, ул. Ерубаева, дом 50а, н.п. 6.</p>
                <p class="line">БИН: 230340020517</p>
                <p class="line">Тел: <a href="tel:+77058503845">+7 (705) 850-38-45</a></p>
                <p class="line">Эл. почта: <a href="mailto:info.kz@mercury-gf.com">info.kz@mercury-gf.com</a></p>
            </div>
        </div>

        <!-- Финляндия -->
        <div class="footer_item">
            <p class="line line_coord"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/coordinates.svg" alt="coordinates"> Mercury Global Forwarding Oy</p>
            <div class="footer_item_without-ing">
                <p class="line line_second">Haarlankatu 4 B 2,<br> FI-33230 Tampere,<br> Finland</p>
                <p class="line">Business ID: 3289135-4</p>
                <p class="line">Тел: <a href="tel:+358415708237">+358 41 570 8237</a></p>
                <p class="line">Эл. почта: <a href="mailto:info.fi@mercury-gf.com">info.fi@mercury-gf.com</a></p>
            </div>
        </div>

        <!-- Россия -->
        <div class="footer_item">
            <p class="line line_coord"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/coordinates.svg" alt="coordinates"> ООО "Меркури Глобал Форвардинг"</p>
            <div class="footer_item_without-ing">
                <p class="line line_second">197082 Россия, г. Санкт-Петербург,<br> ул. Оптиков д.37, стр.<br> 1, пом. 135-Н, р.м.2</p>
                <p class="line">ИНН 7839045340</p>
                <p class="line">Тел: <a href="tel:+79111809820">+7 (911) 180-98-20</a></p>
                <p class="line">Эл. почта: <a href="mailto:info.ru@mercury-gf.com">info.ru@mercury-gf.com</a></p>
            </div>
        </div>
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
                'title' => 'WhatsApp',
                'icon' => 'whatsApp.svg'
            ),
            'telegram' => array(
                'class' => 'telegram', 
                'title' => 'Telegram',
                'icon' => 'telegram.svg'
            ),
            'teams' => array(
                'class' => 'teams',
                'title' => 'Teams',
                'icon' => 'teams.svg'
            ),
            'messages' => array(
                'class' => 'messages',
                'title' => 'Сообщения',
                'icon' => 'messages.svg'
            ),
            'mail' => array(
                'class' => 'mail',
                'title' => 'Email',
                'icon' => 'mail.svg'
            )
        );

        foreach ($messengers as $key => $messenger) {
            $link = get_option('mgf_messenger_' . $key);
            if (!empty($link)) {
                echo '<a href="' . esc_url($link) . '" target="_blank" class="messenger-option ' . esc_attr($messenger['class']) . '" title="' . esc_attr($messenger['title']) . '">';
                echo '<img src="' . get_template_directory_uri() . '/assets/images/' . esc_attr($messenger['icon']) . '" alt="' . esc_attr($messenger['title']) . '">';
                echo '</a>';
            }
        }
        ?>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>