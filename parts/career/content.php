<?php
$vacancy_id = get_the_ID();
$overview = get_the_content();
$country = get_field('country')->name;
$city = get_field('city')->name;
$employment_type = get_field('employment_type')->name;
$key_responsibilities = get_field('key_responsibilities');
$role_requirements = get_field('role_requirements');
$footer = get_field('footer');
$vacancy_default_image = get_field('vacancy_default_image', 'option');
$vacancy_logo = get_the_post_thumbnail($vacancy_id, 'memberimage');
?>

<article id="vacancy-<?php the_ID(); ?>" class="vacancy-<?php the_ID(); ?> vacancy">
    <div class="vacancy-inner">
        <div class="vacancy-section about">
            <div class="vacancy-information">
                <h1 class="vacancy-name"><?php the_title(); ?></h1>
                <div class="vacancy-meta">
                    <div class="vacancy-meta-item">
                        <span class="meta-icon"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/pin.svg" alt="location"></span>
                        <span class="meta-text"><?php echo $city; ?></span>
                    </div>
                    <div class="vacancy-meta-item">
                        <span class="meta-icon"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/employment_type.svg" alt="employment_type"></span>
                        <span class="meta-text"><?php echo $employment_type; ?></span>
                    </div>
                </div>
                <?php if ($overview) : ?>
                    <div class="overview">
                        <p><?php echo $overview; ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($key_responsibilities) : ?>
                    <div class="key-responsibilities">
                        <h2 class="section-title">Key Responsibilities</h2>
                        <ul class="responsibilities-list">
                            <?php foreach ($key_responsibilities as $responsibility) : ?>
                                <li><?php echo $responsibility['item']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if ($role_requirements) : ?>
                    <div class="key-requirements">
                        <h2 class="section-title">Role Requirements</h2>
                        <ul class="requirements-list">
                            <?php foreach ($role_requirements as $requirement) : ?>
                                <li><?php echo $requirement['item']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if ($footer) : ?>
                    <div class="footer">
                        <p><?php echo $footer; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="vacancy-sidebar">
                <div class="sidebar-widget">
                    <?php echo do_shortcode('[html_block id="4346"]') ?>
                    <div class="share">
                        <h3>Share:</h3>
                        <?php echo do_shortcode('[social_buttons type="share"]'); ?>
                    </div>
                </div>
                <div class="sidebar-widget not-sure">
                    <h3>Not quite the right job for you?</h3>
                    <?php echo do_shortcode('[html_block id="4346"]') ?>
                </div>
            </div>
        </div>
    </div>
</article><!-- #post -->
<style>
    .vacancy .vacancy-inner .about .vacancy-sidebar .sidebar-widget.not-sure .wd-button-wrapper .btn::after {
        content: "<?php echo __('Send us your CV', 'REM'); ?>";
    }
</style>