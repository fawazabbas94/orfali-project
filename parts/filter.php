<?php
$current_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if ($current_path === 'listings') { ?>
    <div class="filters listings-filters">
        <h3 class="filter-sub-heading"><?php echo __('Are you looking for a property to buy or rent?', 'REM'); ?></h3>
        <div class="filter-for">
            <?php echo facetwp_display('facet', 'for'); ?>
        </div>
        <h3 class="filter-sub-heading"><?php echo __('Location', 'REM'); ?></h3>
        <div class="filter-country">
            <?php echo facetwp_display('facet', 'country'); ?>
        </div>
        <div class="filter-city">
            <?php echo facetwp_display('facet', 'city'); ?>
        </div>
        <div class="filter-district">
            <?php echo facetwp_display('facet', 'district'); ?>
        </div>
        <div class="filter-search">
            <?php echo facetwp_display('facet', 'auto_complete'); ?>
        </div>
        <h3 class="filter-sub-heading"><?php echo __('Listing', 'REM'); ?></h3>
        <div class="filter-listing_status">
            <?php echo facetwp_display('facet', 'listing_status'); ?>
        </div>
        <div class="filter-project_type">
            <?php echo facetwp_display('facet', 'project_type'); ?>
        </div>
        <div class="filter-listing_type">
            <?php echo facetwp_display('facet', 'listing_type'); ?>
        </div>
        <div class="filter-price min-price">
            <?php echo facetwp_display('facet', 'min_price'); ?>
        </div>
        <div class="filter-price max-price">
            <?php echo facetwp_display('facet', 'max_price'); ?>
        </div>
        <div class="filter-beds">
            <?php echo facetwp_display('facet', 'beds'); ?>
        </div>
        <div class="filter-baths">
            <?php echo facetwp_display('facet', 'baths'); ?>
        </div>
        <div class="filter-amenities">
            <?php echo facetwp_display('facet', 'amenities'); ?>
        </div>
        <div style="display:none"><?php echo facetwp_display('template', 'listings'); ?></div>
        <div class="filter-button">
            <button class="fwp-submit" data-href="<?php echo __('/listings/', 'REM') ?>"></button>
        </div>
    </div>
<?php
} elseif ($current_path === 'projects') {
?>
    <div class="filters projects-filters">
        <div class="filter-country">
            <?php echo facetwp_display('facet', 'p_country'); ?>
        </div>
        <div class="filter-city">
            <?php echo facetwp_display('facet', 'p_city'); ?>
        </div>
        <div class="filter-district">
            <?php echo facetwp_display('facet', 'p_district'); ?>
        </div>
        <div class="filter-search">
            <?php echo facetwp_display('facet', 'auto_complete_project'); ?>
        </div>
        <div class="filter-price">
            <?php echo facetwp_display('facet', 'p_min_price'); ?>
        </div>
        <div class="filter-price">
            <?php echo facetwp_display('facet', 'p_max_price'); ?>
        </div>
        <div class="filter-beds">
            <?php echo facetwp_display('facet', 'p_beds'); ?>
        </div>
        <div class="filter-type">
            <?php echo facetwp_display('facet', 'p_type'); ?>
        </div>
        <div class="filter-status">
            <?php echo facetwp_display('facet', 'p_status'); ?>
        </div>
        <div class="filter-property_type">
            <?php echo facetwp_display('facet', 'p_property_type'); ?>
        </div>
        <div style="display:none"><?php echo facetwp_display('template', 'projects'); ?></div>
        <div class="filter-button">
            <button class="fwp-submit" data-href="<?php echo __('/projects/', 'REM') ?>"></button>
        </div>
    </div>
<?php
} elseif ($current_path === 'uae/off-plan/projects') {
?>
    <div class="filters">
        <div class="filter-country">
            <?php echo facetwp_display('facet', 'p_country'); ?>
        </div>
        <div class="filter-city">
            <?php echo facetwp_display('facet', 'p_city'); ?>
        </div>
        <div class="filter-district">
            <?php echo facetwp_display('facet', 'p_district'); ?>
        </div>
        <div class="filter-search">
            <?php echo facetwp_display('facet', 'auto_complete_project'); ?>
        </div>
        <div class="filter-price">
            <?php echo facetwp_display('facet', 'p_min_price'); ?>
        </div>
        <div class="filter-price">
            <?php echo facetwp_display('facet', 'p_max_price'); ?>
        </div>
        <div class="filter-beds">
            <?php echo facetwp_display('facet', 'p_beds'); ?>
        </div>
        <div class="filter-type">
            <?php echo facetwp_display('facet', 'p_type'); ?>
        </div>
        <div class="filter-status">
            <?php echo facetwp_display('facet', 'p_status'); ?>
        </div>
        <div class="filter-property_type">
            <?php echo facetwp_display('facet', 'p_property_type'); ?>
        </div>
        <div style="display:none"><?php echo facetwp_display('template', 'off_plan'); ?></div>
        <div class="filter-button">
            <button class="fwp-submit" data-href="<?php echo __('/projects/?_p_country=uae&_p_city=dubai&_p_type=off-plan', 'REM') ?>"></button>
        </div>
    </div>
<?php
} elseif ($current_path === 'turkiye/off-plan/projects') {
?>
    <div class="filters">
        <div class="filter-country">
            <?php echo facetwp_display('facet', 'p_country'); ?>
        </div>
        <div class="filter-city">
            <?php echo facetwp_display('facet', 'p_city'); ?>
        </div>
        <div class="filter-district">
            <?php echo facetwp_display('facet', 'p_district'); ?>
        </div>
        <div class="filter-search">
            <?php echo facetwp_display('facet', 'auto_complete_project'); ?>
        </div>
        <div class="filter-price">
            <?php echo facetwp_display('facet', 'p_min_price'); ?>
        </div>
        <div class="filter-price">
            <?php echo facetwp_display('facet', 'p_max_price'); ?>
        </div>
        <div class="filter-beds">
            <?php echo facetwp_display('facet', 'p_beds'); ?>
        </div>
        <div class="filter-type">
            <?php echo facetwp_display('facet', 'p_type'); ?>
        </div>
        <div class="filter-status">
            <?php echo facetwp_display('facet', 'p_status'); ?>
        </div>
        <div class="filter-property_type">
            <?php echo facetwp_display('facet', 'p_property_type'); ?>
        </div>
        <div style="display:none"><?php echo facetwp_display('template', 'off_plan'); ?></div>
        <div class="filter-button">
            <button class="fwp-submit" data-href="<?php echo __('/projects/?_p_country=turkiye&_p_city=istanbul&_p_type=off-plan', 'REM') ?>"></button>
        </div>
    </div>
<?php
} else {
?>
    <div class="filters">
        <div class="filter-for">
            <?php echo facetwp_display('facet', 'for'); ?>
        </div>
        <div class="filter-project_type">
            <?php echo facetwp_display('facet', 'project_type'); ?>
        </div>
        <div class="filter-beds">
            <?php echo facetwp_display('facet', 'beds'); ?>
        </div>
        <div class="filter-country">
            <?php echo facetwp_display('facet', 'country'); ?>
        </div>
        <div class="filter-district">
            <?php echo facetwp_display('facet', 'district'); ?>
        </div>
        <div class="filter-price">
            <?php echo facetwp_display('facet', 'min_price'); ?>
        </div>
        <div class="filter-price">
            <?php echo facetwp_display('facet', 'max_price'); ?>
        </div>
        <div style="display:none"><?php echo facetwp_display('template', 'listings'); ?></div>
        <div class="filter-button">
            <button class="fwp-submit" data-href="<?php echo __('/listings/', 'REM') ?>"></button>
        </div>
    </div>
<?php
}
?>