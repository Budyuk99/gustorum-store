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
            <?php 
            $kz_company = get_option('mgf_contacts_kz_company');
            if ($kz_company && trim($kz_company) !== ''): 
            ?>
                <p class="line line_coord">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/coordinates.svg" alt="coordinates">
                    <?php echo esc_html($kz_company); ?>
                </p>
            <?php endif; ?>
            
            <div class="footer_item_without-ing">
                <?php 
                $kz_address = get_option('mgf_contacts_kz_address');
                if ($kz_address && trim(strip_tags($kz_address)) !== ''): 
                ?>
                    <p class="line line_second"><?php echo wp_kses_post(str_replace("\n", '<br>', trim($kz_address))); ?></p>
                <?php endif; ?>
                
                <?php 
                $kz_bin = get_option('mgf_contacts_kz_bin');
                if ($kz_bin && trim($kz_bin) !== ''): 
                ?>
                    <p class="line"><?php echo esc_html($kz_bin); ?></p>
                <?php endif; ?>
                
                <?php 
                $kz_phone = get_option('mgf_contacts_kz_phone');
                if ($kz_phone && trim($kz_phone) !== ''): 
                ?>
                    <p class="line">Тел: <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $kz_phone)); ?>"><?php echo esc_html($kz_phone); ?></a></p>
                <?php endif; ?>
                
                <?php 
                $kz_email = get_option('mgf_contacts_kz_email');
                if ($kz_email && trim($kz_email) !== ''): 
                ?>
                    <p class="line">Эл. почта: <a href="mailto:<?php echo esc_attr($kz_email); ?>"><?php echo esc_html($kz_email); ?></a></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Финляндия -->
        <div class="footer_item">
            <?php 
            $fi_company = get_option('mgf_contacts_fi_company');
            if ($fi_company && trim($fi_company) !== ''): 
            ?>
                <p class="line line_coord">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/coordinates.svg" alt="coordinates">
                    <?php echo esc_html($fi_company); ?>
                </p>
            <?php endif; ?>
            
            <div class="footer_item_without-ing">
                <?php 
                $fi_address = get_option('mgf_contacts_fi_address');
                if ($fi_address && trim(strip_tags($fi_address)) !== ''): 
                ?>
                    <p class="line line_second"><?php echo wp_kses_post(str_replace("\n", '<br>', trim($fi_address))); ?></p>
                <?php endif; ?>
                
                <?php 
                $fi_business_id = get_option('mgf_contacts_fi_business_id');
                if ($fi_business_id && trim($fi_business_id) !== ''): 
                ?>
                    <p class="line"><?php echo esc_html($fi_business_id); ?></p>
                <?php endif; ?>
                
                <?php 
                $fi_phone = get_option('mgf_contacts_fi_phone');
                if ($fi_phone && trim($fi_phone) !== ''): 
                ?>
                    <p class="line">Тел: <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $fi_phone)); ?>"><?php echo esc_html($fi_phone); ?></a></p>
                <?php endif; ?>
                
                <?php 
                $fi_email = get_option('mgf_contacts_fi_email');
                if ($fi_email && trim($fi_email) !== ''): 
                ?>
                    <p class="line">Эл. почта: <a href="mailto:<?php echo esc_attr($fi_email); ?>"><?php echo esc_html($fi_email); ?></a></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Россия -->
        <div class="footer_item">
            <?php 
            $ru_company = get_option('mgf_contacts_ru_company');
            if ($ru_company && trim($ru_company) !== ''): 
            ?>
                <p class="line line_coord">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/coordinates.svg" alt="coordinates">
                    <?php echo esc_html($ru_company); ?>
                </p>
            <?php endif; ?>
            
            <div class="footer_item_without-ing">
                <?php 
                $ru_address = get_option('mgf_contacts_ru_address');
                if ($ru_address && trim(strip_tags($ru_address)) !== ''): 
                ?>
                    <p class="line line_second"><?php echo wp_kses_post(str_replace("\n", '<br>', trim($ru_address))); ?></p>
                <?php endif; ?>
                
                <?php 
                $ru_inn = get_option('mgf_contacts_ru_inn');
                if ($ru_inn && trim($ru_inn) !== ''): 
                ?>
                    <p class="line"><?php echo esc_html($ru_inn); ?></p>
                <?php endif; ?>
                
                <?php 
                $ru_phone = get_option('mgf_contacts_ru_phone');
                if ($ru_phone && trim($ru_phone) !== ''): 
                ?>
                    <p class="line">Тел: <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $ru_phone)); ?>"><?php echo esc_html($ru_phone); ?></a></p>
                <?php endif; ?>
                
                <?php 
                $ru_email = get_option('mgf_contacts_ru_email');
                if ($ru_email && trim($ru_email) !== ''): 
                ?>
                    <p class="line">Эл. почта: <a href="mailto:<?php echo esc_attr($ru_email); ?>"><?php echo esc_html($ru_email); ?></a></p>
                <?php endif; ?>
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