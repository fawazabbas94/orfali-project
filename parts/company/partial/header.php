<?php
$header_image = get_field('header_image');
$headline = get_field('headline');
$company_slug = get_post_field('post_name', get_post());
$country = get_field('country');
$company_name = get_the_title();
$company_id = get_the_ID();
?>
<div class="header-section" style="background-image: url('<?php echo $header_image; ?>');">
    <div class="overlay">
        <div class="company-header">
            <h1 class="company-name">
                <?php the_title(); ?>
            </h1>
            <p class="headline">
                <?php echo $headline; ?>
            </p>
            <a href="/projects/?_p_country=<?php echo $country->slug ?>&_p_construction_company=<?php echo $company_id ?>" class="button"><?php echo __('View', 'REM') . ' ' . $company_name . ' ' . __('Projects', 'REM'); ?></a>
        </div>
    </div>
</div>