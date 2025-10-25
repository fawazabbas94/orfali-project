<div class="listing-location">
    <h3 class="section-title"><?php echo __('Location', 'REM'); ?></h3>
    <?php
    $project = get_field('project');
    if ($project) {
        $project_id = $project->ID;
        $address_parts = [
            get_field('country', $project->ID)->name ?? '',
            get_field('city', $project->ID)->name ?? '',
            get_field('district', $project->ID)->name ?? ''
        ];
        $formatted_address = implode(', ', array_filter($address_parts));
    } else {
        $address_parts = [
            get_field('country')->name ?? '',
            get_field('city')->name ?? '',
            get_field('district')->name ?? ''
        ];
        $formatted_address = implode(', ', array_filter($address_parts));
    }
    ?>
    <div class="address">
        <?php if (!empty($formatted_address)) : ?>
            <p><?php echo esc_html($formatted_address); ?></p>
        <?php endif; ?>
    </div>
    <?php
    if ($project) {
        $project_id = $project->ID;
        $location_map = get_field('location_map', $project->ID);
    } else {
        $location_map = get_field('location_map');
    }
    if ($location_map) : ?>
        <div class="google-map">
            <div class="acf-map" data-zoom="16">
                <div class="marker" data-lat="<?php echo esc_attr($location_map['lat']); ?>" data-lng="<?php echo esc_attr($location_map['lng']); ?>"></div>
            </div>
        </div>
    <?php endif; ?>
</div>