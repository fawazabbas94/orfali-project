<?php
$person_default_image = get_field('person_default_image', 'option');
$agent = get_field('agent');
$language_display = get_field('language_display', 'option');
if ($agent) :
    $agent_id = $agent->ID;
    $agent_name = get_the_title($agent_id);
    $agent_photo = get_the_post_thumbnail($agent_id, 'memberimage');
    $positions = get_field('positions', $agent_id);
    $languages = get_field('languages', $agent_id);
    $contact_information = get_field('contact_information', $agent_id);
    $phone = get_field('phone', $agent_id);
    $email_address = get_field('email_address', $agent_id); ?>
    <div class="sidebar-widget agent">
        <div class="agent-header">
            <?php
            if ($agent_photo) : echo $agent_photo;
            else : ?><img src="<?php echo $person_default_image; ?>" alt="person-without-image"><?php endif; ?>
            <div class="agent-info">
                <h3 class="agent-name"><?php echo $agent_name; ?></h3>
                <p class="agent-positions">
                    <?php
                    $positions_list = [];
                    foreach ($positions as $position) {
                        $positions_list[] = esc_html($position->name);
                    }
                    echo implode(', ', $positions_list);
                    ?>
                </p>
                <p class="agent-languages">
                    <?php
                    $language_list = [];
                    foreach ($languages as $language) {
                        $native_name = get_field('native_name', $language);
                        if ($language_display === 'both') {
                            $language_list[] = esc_html($language->name) . ' (' . esc_html($native_name) . ')';
                        } elseif ($language_display === 'active') {
                            $language_list[] = esc_html($language->name);
                        } elseif ($language_display === 'native') {
                            $language_list[] = esc_html($native_name);
                        }
                    }
                    echo implode(', ', $language_list);
                    ?>
                </p>
            </div>
        </div>
        <div class="agent-contact">
            <?php if ($phone['same_number_for'] && in_array('WhatsApp', $phone['same_number_for'])) : ?>
                <a target="_blank" class="whatsapp" href="https://wa.me/<?php echo $phone['phone_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/whatsapp_flat.svg" alt="whatsapp"></a>
                <?php
            else :
                if ($phone['whatsapp_number']) :
                ?>
                    <a target="_blank" class="whatsapp" href="https://wa.me/<?php echo $phone['whatsapp_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/whatsapp_flat.svg" alt="whatsapp"></a>
                <?php
                endif;
            endif;
            if ($phone['same_number_for'] && in_array('Telegram', $phone['same_number_for'])) : ?>
                <a target="_blank" class="telegram" href="https://t.me/<?php echo $phone['phone_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/telegram.svg" alt="telegram"></a>
                <?php
            else :
                if ($phone['telegram_number']) :
                ?>
                    <a target="_blank" class="telegram" href="https://t.me/<?php echo $phone['telegram_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/telegram.svg" alt="telegram"></a>
                <?php
                endif;
            endif;
            if ($email_address) : ?>
                <a target="_blank" class="email" href="mailto:<?php echo $email_address; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/email.svg" alt="email"></a>
            <?php endif;
            if ($phone) : ?>
                <a target="_blank" class="phone" href="tel:<?php echo $phone['phone_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/phone.svg" alt="phone"></a>
            <?php endif; ?>
        </div>
        <div class="share-widget">
            <h3>Share:</h3>
            <?php echo do_shortcode('[social_buttons type="share"]'); ?>
        </div>
    </div>
<?php
endif;
?>