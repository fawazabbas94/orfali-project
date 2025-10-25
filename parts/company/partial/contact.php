<?php
$company_name = get_the_title();
?>
<div class="contact-section">
    <div class="contact-section-container">
        <div class="info-column">
            <h2 class="title"><?php echo __('Join the ', 'REM') . $company_name . __(' priority list', 'REM'); ?></h2>
            <p class="content"><?php echo __('Stay up to date with the latest launches and get access to exclusive inventory.', 'REM'); ?></p>
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
<?php if (have_rows('faqs')): ?>
    <div class="faqs">
        <h2 class="faqs-title"><?php echo $company_name . ' ' . __('FAQs', 'REM'); ?></h2>
        <div class="accordion">
            <?php
            while (have_rows('faqs')): the_row();
                $question = get_sub_field('question');
                $answer = get_sub_field('answer');
            ?>
                <div class="accordion-item">
                    <button id="accordion-button-<?php echo get_row_index(); ?>" aria-expanded="false">
                        <span class="accordion-title"><?php echo $question ?></span>
                        <span class="icon" aria-hidden="true"></span>
                    </button>
                    <div class="accordion-content">
                        <p><?php echo $answer; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>
<div class="contact-section last">
    <div class="section-container">
        <h2 class="title"><?php echo __('Whether you’re ready to get started or still unsure, we’re here to help.', 'REM'); ?></h2>
        <p class="content"><?php echo __('Our Off Plan & Investment specialists can guide you towards the right choice and provide professional advice.', 'REM'); ?></p>
        <a href="/contact" class="contact-button">Contact our team</a>
    </div>
</div>