<?php
$permalink = get_permalink(get_the_ID());
$person_default_image = get_field('person_default_image', 'option');
$featured_image = get_the_post_thumbnail(get_the_ID(), 'memberimage');
$overview = get_the_content();
$fields = [
    'person_type',
    'companies',
    'positions',
    'languages',
    'phone',
    'email_address'
];
foreach ($fields as $field) {
    $value = get_field($field);
    set_query_var($field, $value);
    ${$field} = get_query_var($field);
}
?>
<article id="person-<?php the_ID(); ?>" class="person-<?php the_ID(); ?> person <?php if ($person_type) : echo esc_html($person_type->slug);
                                                                                endif; ?>">
    <div class="person-inner">
        <div class="person-section about">
            <div class="person-information">
                <h1 class="person-name"><?php the_title(); ?></h1>
                <?php get_template_part('parts/person/meta', get_post_format()); ?>
                <div class="person-contact-information">
                    <?php
                    if ($phone['same_number_for'] && in_array('WhatsApp', $phone['same_number_for'])) : ?>
                        <a target="_blank" class="whatsapp" href="https://wa.me/<?php echo $phone['phone_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/whatsapp_flat.svg" alt="whatsapp"><?php echo __('Whatsapp', 'REM'); ?></a>
                        <?php
                    else :
                        if ($phone['whatsapp_number']) :
                        ?>
                            <a target="_blank" class="whatsapp" href="https://wa.me/<?php echo $phone['whatsapp_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/whatsapp_flat.svg" alt="whatsapp"><?php echo __('Whatsapp', 'REM'); ?></a>
                        <?php
                        endif;
                    endif;
                    if ($email_address) : ?>
                        <a target="_blank" class="email" href="mailto:<?php echo $email_address; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/email.svg" alt="email"><?php echo __('Email', 'REM'); ?></a>
                    <?php endif;
                    if ($phone) : ?>
                        <a target="_blank" class="phone" href="tel:<?php echo $phone['phone_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/phone.svg" alt="phone"><?php echo __('Call', 'REM'); ?></a>
                    <?php endif; ?>
                    <?php
                    if ($phone['same_number_for'] && in_array('Telegram', $phone['same_number_for'])) : ?>
                        <a target="_blank" class="telegram" href="https://t.me/<?php echo $phone['phone_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/telegram.svg" alt="telegram"><?php echo __('Telegram', 'REM'); ?></a>
                        <?php
                    else :
                        if ($phone['telegram_number']) :
                        ?>
                            <a target="_blank" class="telegram" href="https://t.me/<?php echo $phone['telegram_number']; ?>"><img src="/wp-content/themes/woodmart-child/icons/team-icons/telegram.svg" alt="telegram"><?php echo __('Telegram', 'REM'); ?></a>
                    <?php
                        endif;
                    endif; ?>
                </div>
                <?php if ($overview) : ?>
                    <div class="overview">
                        <h3><?php echo __('Overview:', 'REM'); ?></h3>
                        <p><?php echo $overview; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="person-image">
                <?php
                if ($featured_image) : echo $featured_image;
                else : ?><img src="<?php echo $person_default_image; ?>" alt="person-without-image"><?php endif; ?>
            </div>
        </div>
    </div>
</article>