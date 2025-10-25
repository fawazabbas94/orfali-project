<?php
$project_title = get_the_title();
$construction_companies = get_field('construction_companies');
if ($construction_companies) :
        $construction_companies_title = $construction_companies->post_title;
endif;
$district = get_field('district');
?>
<div class="contact-section" id="contact">
    <div class="contact-section-container">
        <div class="info-column">
            <h2 class="title"><?php echo __('Register your interest in ', 'REM') . $project_title . __(' at ', 'REM') . $district->name . __(' by ', 'REM') . $construction_companies_title; ?></h2>
            <p class="content"><?php echo __('To find out about availability, contact a member of our team or fill out the form and we’ll be in touch.', 'REM'); ?></p>
            <div class="contact-option whatsapp">
                <img src="/wp-content/themes/woodmart-child/icons/interface-icons/whatsapp_solid.svg" alt="whatsapp" class="icon">
                <a href="" class="link"><?php echo __('Click to WhatsApp', 'REM'); ?></a>
            </div>
            <div class="contact-option email">
                <img src="/wp-content/themes/woodmart-child/icons/interface-icons/email.svg" alt="email" class="icon">
                <a href="mailto:info@orfaliproperties.com" class="link">info@orfaliproperties.com</a>
            </div>
        </div>
        <div class="form-column">
            <div class="contact-form-container">
                <?php echo do_shortcode('[contact-form-7 id="a880938" title="Single project form"]'); ?>
            </div>
        </div>
    </div>
</div>