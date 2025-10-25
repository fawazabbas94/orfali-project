<?php
$headline = get_field('headline');
$delivery_date = get_field('delivery_date');
$construction_start_date = get_field('construction_start_date');
$project_type = get_field('project_type');
$project_status = get_field('project_status');
$title_deed_type = get_field('title_deed_type');
$title_deed_status = get_field('title_deed_status');
$country = get_field('country');
$project_currency = ($country->slug === 'uae') ? 'AED' : (($country->slug === 'turkiye') ? 'USD' : '');
$min_price = get_field('min_price');
$formatted_price = number_format($min_price, 0, '.', ',');
$city = get_field('city');
$district = get_field('district');
$siteplan = get_field('siteplan');
$floorplan = get_field('floorplan');
$number_of_blocks = get_field('number_of_blocks');
$number_of_floors = get_field('number_of_floors');
$number_of_units = get_field('number_of_units');
// Turkey only
$eligibility_for_citizenship = get_field('eligibility_for_citizenship');
$residence_permit_availability = get_field('residence_permit_availability');
$government_guarantee = get_field('government_guarantee');
$vat_sales_price = get_field('vat_sales_price');
$custom_vat_sales_price = get_field('custom_vat_sales_price');
$energy_performance_certificate = get_field('energy_performance_certificate');
$gross_net_difference = get_field('gross_net_difference');
if ($project_type) {
    $project_type_names = array_map(function ($term) {
        return $term->name;
    }, $project_type);
    $project_type_list = implode(', ', $project_type_names);
}
$construction_companies = get_field('construction_companies');
if ($construction_companies) :
    $construction_companies_permalink = get_permalink($construction_companies->ID);
    $construction_companies_title = $construction_companies->post_title;
endif;
?>
<div class="project-overview">
    <h2 class="headline"><?php echo $headline; ?></h2>
    <div class="facts-grid">
        <?php if ($construction_start_date['month'] && $construction_start_date['year']) : ?>
            <div class="fact-box">
                <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/handover_date.svg" alt="">
                <div class="fact-box-inner">
                    <h3 class="fact-name">Construction Start Date</h3>
                    <p class="fact-value">
                        <?php echo esc_html($construction_start_date['month']['label'] . ' ' . $construction_start_date['year']); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($delivery_date['month'] && $delivery_date['year'] && $project_status && $project_status->slug !== 'ready') : ?>
            <div class="fact-box">
                <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/handover_date.svg" alt="">
                <div class="fact-box-inner">
                    <h3 class="fact-name">Delivery Date</h3>
                    <p class="fact-value">
                        <?php echo esc_html($delivery_date['month']['label'] . ' ' . $delivery_date['year']); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <div class="fact-box">
            <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/prices_from.svg" alt="">
            <div class="fact-box-inner">
                <h3 class="fact-name">Prices From</h3>
                <p class="fact-value">
                    <?php echo esc_html($project_currency) . ' ' . esc_html($formatted_price); ?>
                </p>
            </div>
        </div>
        <?php if ($construction_companies_title) : ?>
            <div class="fact-box">
                <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/developer.svg" alt="">
                <div class="fact-box-inner">
                    <h3 class="fact-name">Developer</h3>
                    <p class="fact-value">
                        <?php echo esc_html($construction_companies_title); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($district) : ?>
            <div class="fact-box">
                <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/location.svg" alt="">
                <div class="fact-box-inner">
                    <h3 class="fact-name">Location</h3>
                    <p class="fact-value">
                        <?php echo esc_html($district->name); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($project_type_list) : ?>
            <div class="fact-box">
                <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/development_type.svg" alt="">
                <div class="fact-box-inner">
                    <h3 class="fact-name">Development Type</h3>
                    <p class="fact-value">
                        <?php echo esc_html($project_type_list); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($country->slug == 'turkiye'): ?>
            <?php if ($eligibility_for_citizenship && $eligibility_for_citizenship['value'] !== 'unknown') : ?>
                <div class="fact-box">
                    <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/eligibility_for_citizenship.svg" alt="">
                    <div class="fact-box-inner">
                        <h3 class="fact-name">Eligibility for Citizenship</h3>
                        <p class="fact-value">
                            <?php echo $eligibility_for_citizenship['label']; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($residence_permit_availability && $residence_permit_availability['value'] !== 'unknown') : ?>
                <div class="fact-box">
                    <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/residence_permit_availability.svg" alt="">
                    <div class="fact-box-inner">
                        <h3 class="fact-name">Residence Permit Availability</h3>
                        <p class="fact-value">
                            <?php echo $residence_permit_availability['label']; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($government_guarantee && $government_guarantee['value'] !== 'unknown') : ?>
                <div class="fact-box">
                    <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/government_guarantee.svg" alt="">
                    <div class="fact-box-inner">
                        <h3 class="fact-name">Government Guarantee</h3>
                        <p class="fact-value">
                            <?php echo $government_guarantee['label']; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($vat_sales_price && $vat_sales_price['value'] !== 'unknown') : ?>
                <div class="fact-box">
                    <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/vat_sales_price.svg" alt="">
                    <div class="fact-box-inner">
                        <h3 class="fact-name">VAT / Sales Price</h3>
                        <p class="fact-value">
                            <?php if ($vat_sales_price['value'] !== 'custom') : ?>
                                <?php echo $vat_sales_price['label']; ?>
                            <?php elseif ($vat_sales_price['value'] == 'custom' && $custom_vat_sales_price) : ?>
                                <?php echo $custom_vat_sales_price; ?>%
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($title_deed_type && $title_deed_type['value'] !== 'unknown') : ?>
                <div class="fact-box">
                    <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/title_deed_type.svg" alt="">
                    <div class="fact-box-inner">
                        <h3 class="fact-name">Title Deed</h3>
                        <p class="fact-value">
                            <?php echo $title_deed_type['label']; ?>
                            <?php if ($title_deed_status && $title_deed_status['value'] !== 'unknown') : ?><br class="mobile-only">
                                ( <?php echo $title_deed_status['label']; ?> )
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($energy_performance_certificate && $energy_performance_certificate['value'] !== 'unknown') : ?>
                <div class="fact-box">
                    <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/energy_performance_certificate.svg" alt="">
                    <div class="fact-box-inner">
                        <h3 class="fact-name">Energy Performance Certificate</h3>
                        <p class="fact-value">
                            <?php echo $energy_performance_certificate['label']; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($gross_net_difference) : ?>
                <div class="fact-box">
                    <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/gross_net_difference.svg" alt="">
                    <div class="fact-box-inner">
                        <h3 class="fact-name">Gross / Net Difference</h3>
                        <p class="fact-value">
                            <?php echo $gross_net_difference . '%'; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($number_of_blocks || $number_of_floors || $number_of_units) : ?>
            <div class="fact-box construction">
                <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/construction.svg" alt="">
                <div class="fact-box-inner">
                    <h3 class="fact-name">Construction</h3>
                    <div class="fact-value">
                        <?php if ($number_of_blocks) : ?>
                            <div class="blocks">
                                <h4 class="value"><?php echo esc_html($number_of_blocks); ?></h4>
                                <h4 class="label"><?php echo ($number_of_blocks == 1 ? __(' Block', 'REM') : __(' Blocks', 'REM')) ?></h4>
                            </div>
                        <?php endif; ?>
                        <?php if ($number_of_floors) : ?>
                            <div class="floors">
                                <h4 class="value"><?php echo esc_html($number_of_floors); ?></h4>
                                <h4 class="label"><?php echo ($number_of_floors == 1 ? __(' Floor', 'REM') : __(' Floors', 'REM')) ?></h4>
                            </div>
                        <?php endif; ?>
                        <?php if ($number_of_units) : ?>
                            <div class="units">
                                <h4 class="value"><?php echo esc_html($number_of_units); ?></h4>
                                <h4 class="label"><?php echo ($number_of_units == 1 ? __(' Unit', 'REM') : __(' Units', 'REM')) ?></h4>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="fact-box">
            <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/siteplan.svg" alt="">
            <div class="fact-box-inner">
                <h3 class="fact-name">Siteplan</h3>
                <a class="fact-value" href="<?php echo esc_url($siteplan); ?>" target="_blank">
                    <?php echo __('Download', 'REM'); ?>
                </a>
            </div>
        </div>
        <div class="fact-box">
            <img class="fact-icon" src="/wp-content/themes/woodmart-child/icons/project-icons/floorplan.svg" alt="">
            <div class="fact-box-inner">
                <h3 class="fact-name">Floorplan</h3>
                <a class="fact-value" href="<?php echo esc_url($floorplan); ?>" target="_blank">
                    <?php echo __('Download', 'REM'); ?>
                </a>
            </div>
        </div>
    </div>
</div>