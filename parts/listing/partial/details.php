<?php
$bua = get_field('bua');
$plot = get_field('plot');
$gross_area = get_field('gross_area');
$net_area = get_field('net_area');
$bedrooms = get_field('bedrooms');
$bathrooms = get_field('bathrooms');
$listing_status = get_field('listing_status');
$project_country = get_field('country');
$country_slug = $project_country->slug ?? '';
$listing_unit = ($country_slug === 'uae') ? 'sqft' : (($country_slug === 'turkiye') ? 'sqm' : '');
?>
<div class="listing-details">
    <?php if ($bua) : ?>
        <div class="item bua">
            <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/bua.svg" alt="bua">
            <p class="label"><?php echo __('BUA:', 'REM'); ?></p>
            <p class="value"><?php echo $bua . ' ' . $listing_unit; ?></p>
        </div>
    <?php endif; ?>
    <?php if ($plot) : ?>
        <div class="item plot">
            <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/plot.svg" alt="plot">
            <p class="label"><?php echo __('Plot:', 'REM'); ?></p>
            <p class="value"><?php echo $plot . ' ' . $listing_unit; ?></p>
        </div>
    <?php endif; ?>
    <?php if ($net_area) : ?>
        <div class="item net-area">
            <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/bua.svg" alt="net-area">
            <p class="label"><?php echo __('Net Area:', 'REM'); ?></p>
            <p class="value"><?php echo $net_area . ' ' . $listing_unit; ?></p>
        </div>
    <?php endif; ?>
    <?php if ($gross_area) : ?>
        <div class="item gross-area">
            <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/plot.svg" alt="gross-area">
            <p class="label"><?php echo __('Gross Area:', 'REM'); ?></p>
            <p class="value"><?php echo $gross_area . ' ' . $listing_unit; ?></p>
        </div>
    <?php endif; ?>
    <?php if ($bedrooms) : ?>
        <div class="item bedrooms">
            <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/bedrooms.svg" alt="bedrooms">
            <p class="label"><?php echo __('Bedrooms:', 'REM'); ?></p>
            <p class="value"><?php echo $bedrooms; ?></p>
        </div>
    <?php endif; ?>
    <?php if ($bathrooms) : ?>
        <div class="item bathrooms">
            <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/bathrooms.svg" alt="bathrooms">
            <p class="label"><?php echo __('Bathrooms:', 'REM'); ?></p>
            <p class="value"><?php echo $bathrooms; ?></p>
        </div>
    <?php endif; ?>
    <?php if ($listing_status) : ?>
        <div class="item listing-status">
            <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/compleation_date.svg" alt="listing-status">
            <p class="label"><?php echo __('Listing Status:', 'REM'); ?></p>
            <p class="value"><?php echo $listing_status->name; ?></p>
        </div>
    <?php endif; ?>
</div>