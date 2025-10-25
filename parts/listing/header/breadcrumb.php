<?php
$project = get_field('project');
if ($project) {
    $project_id = $project->ID;
    $project_country = get_field('country', $project->ID);
    $project_city = get_field('city', $project->ID);
    $project_district = get_field('district', $project->ID);
}
$country = get_field('country');
$city = get_field('city');
$district = get_field('district');
$for = get_field('buy_rent');
$listing_status = get_field('listing_status');
?>
<div class="breadcrumb project-breadcrumb">
    <div class="back-to-projects">
        <a href="<?php echo __('/projects/', 'REM'); ?>?_p_country=<?php echo esc_html($country->slug) ?>"><?php echo __('Back to Projects', 'REM'); ?></a>
    </div>
    <div class="home-link">
        <a href="<?php echo __('/', 'REM'); ?>">Home</a>
    </div>
    <?php if ($city) : ?>
        <div class="city-link">
            <a href="<?php echo __('/projects/', 'REM') ?>?_p_country=<?php echo esc_html($country->slug) ?>&_p_city=<?php echo esc_html($city->slug) ?>"><?php echo esc_html($city->name) ?></a>
        </div>
    <?php endif; ?>
    <?php if ($district) : ?>
        <div class="district-link">
            <a href="<?php echo __('/projects/', 'REM') ?>?_p_country=<?php echo esc_html($country->slug) ?>&_p_city=<?php echo esc_html($city->slug) ?>&_p_district=<?php echo esc_html($district->slug) ?>"><?php echo esc_html($district->name) ?></a>
        </div>
    <?php endif; ?>
    <a title="Print" href="<?php echo add_query_arg('print', 'true', get_permalink()); ?>" class="print-button" target="_blank"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/pdf-download.svg" alt="Print"></a>
    <div class="share">
        <button id="share-toggle-button">
            <img src="/wp-content/themes/woodmart-child/icons/interface-icons/share.svg" alt="Share"> <?php echo __('Share', 'REM'); ?>
        </button>
        <div id="share-buttons" style="display: none;">
            <?php echo do_shortcode('[social_buttons type="share"]'); ?>
        </div>
    </div>
</div>
<div class="breadcrumb listing-breadcrumb">
    <div class="back-to-projects">
        <a href="<?php echo __('/listings/', 'REM'); ?>?_country=<?php echo esc_html($country->slug) ?>"><?php echo __('Back to Listings', 'REM'); ?></a>
    </div>
    <div class="home-link">
        <a href="/<?php echo esc_html($country->slug) ?>/?_country=<?php echo esc_html($country->slug) ?>&_city=<?php echo esc_html($city->slug) ?>"><?php echo __('Home', 'REM'); ?></a>
    </div>
    <?php if ($city) : ?>
        <div class="city-link">
            <a href="<?php echo __('/listings/', 'REM') ?>?_country=<?php echo esc_html($country->slug) ?>&_city=<?php echo esc_html($city->slug) ?>"><?php echo esc_html($city->name) ?></a>
        </div>
    <?php endif; ?>
    <?php if ($district) : ?>
        <div class="district-link">
            <a href="<?php echo __('/listings/', 'REM') ?>?_country=<?php echo esc_html($country->slug) ?>&_city=<?php echo esc_html($city->slug) ?>&_district=<?php echo esc_html($district->slug) ?>"><?php echo esc_html($district->name) ?></a>
        </div>
    <?php endif; ?>
    <?php if ($listing_status) : ?>
        <div class="listing-status-link">
            <a href="<?php echo __('/listings/', 'REM') ?>?_country=<?php echo esc_html($country->slug) ?>&_city=<?php echo esc_html($city->slug) ?>&_district=<?php echo esc_html($district->slug) ?>&_listing_status=<?php echo esc_html($listing_status->slug); ?>"><?php echo esc_html($listing_status->name); ?></a>
        </div>
    <?php endif; ?>
    <?php if ($for && $for['value'] === 'buy') : ?>
        <div class="for-link">
            <a href="<?php echo __('/listings/', 'REM') ?>?_country=<?php echo esc_html($country->slug) ?>&_city=<?php echo esc_html($city->slug) ?>&_district=<?php echo esc_html($district->slug) ?>&_listing_status=<?php echo esc_html($listing_status->slug); ?>&_for=buy"><?php echo __('For Sale', 'REM'); ?></a>
        </div>
    <?php elseif ($for && $for['value'] === 'rent') : ?>
        <div class="for-link">
            <a href="<?php echo __('/listings/', 'REM') ?>?_country=<?php echo esc_html($country->slug) ?>&_city=<?php echo esc_html($city->slug) ?>&_district=<?php echo esc_html($district->slug) ?>&_listing_status=<?php echo esc_html($listing_status->slug); ?>&_for=rent"><?php echo __('For Rent', 'REM'); ?></a>
        </div>
    <?php endif; ?>
    <a title="Print" href="<?php echo add_query_arg('print', 'true', get_permalink()); ?>" class="print-button" target="_blank"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/pdf-download.svg" alt="Print"></a>
    <div class="share">
        <button id="share-toggle-button">
            <img src="/wp-content/themes/woodmart-child/icons/interface-icons/share.svg" alt="Share"> <?php echo __('Share', 'REM'); ?>
        </button>
        <div id="share-buttons" style="display: none;">
            <?php echo do_shortcode('[social_buttons type="share"]'); ?>
        </div>
    </div>
</div>
<div class="breadcrumb-seperator"></div>