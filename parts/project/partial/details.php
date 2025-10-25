<div class="project-details">
    <?php
    $tagline = get_field('tagline');
    $details_sections = get_field('details_sections');
    if ($tagline) : ?>
        <h2 class="tagline"><?php echo $tagline; ?></h2>
        <?php endif;
    if (have_rows('details_sections')):
        while (have_rows('details_sections')): the_row();
            $section_title = get_sub_field('section_title');
            $section_content = get_sub_field('section_content');
            $section_image = get_sub_field('section_image');
        ?>
            <div class="details-section">
                <div class="info">
                    <?php if ($section_title) : ?>
                        <h3 class="title"><?php echo $section_title; ?></h3>
                    <?php endif; ?>
                    <?php if ($section_content) : ?>
                        <p class="content">
                            <?php echo $section_content; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php if ($section_image) : ?>
                    <div class="image">
                        <img src="<?php echo $section_image; ?>">
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
    <?php
    $location_map = get_field('location_map');
    $country = get_field('country');
    $city = get_field('city');
    $district = get_field('district');
    ?>
    <div class="details-section">
        <div class="info">
            <h3 class="title"><?php echo __('Location', 'REM'); ?></h3>
            <div class="address">
                <?php if ($country) : ?>
                    <p><?php echo esc_html($country->name) ?></p>
                <?php endif; ?>
                <?php if ($city) : ?>
                    <p><?php echo ', ' . esc_html($city->name) ?></p>
                <?php endif; ?>
                <?php if ($district) : ?>
                    <p><?php echo ', ' . esc_html($district->name) ?></p>
                <?php endif; ?>
            </div>
            <?php
            if (have_rows('nearby_places')): ?>
                <h4 class="section-title"><?php echo __('Nearby Places', 'REM'); ?></h4>
                <ul class="nearby-places">
                    <?php
                    while (have_rows('nearby_places')): the_row();
                        $place = get_sub_field('place');
                        $distance = get_sub_field('distance');
                        $measurement_unit = get_sub_field('measurement_unit');
                    ?>
                        <li class="place">
                            <b><?php echo esc_html($place->name) . ': '; ?></b><?php echo esc_html($distance) . ' ' . esc_html($measurement_unit); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php
        $location_map = get_field('location_map');
        if ($location_map) : ?>
            <div class="google-map image">
                <div class="acf-map" data-zoom="16">
                    <div class="marker" data-lat="<?php echo esc_attr($location_map['lat']); ?>" data-lng="<?php echo esc_attr($location_map['lng']); ?>"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php $amenities_section_title = get_field('amenities_section_title');
    $amenities_section_content = get_field('amenities_section_content');
    $amenities_section_image = get_field('amenities_section_image'); ?>
    <div class="details-section">
        <div class="info">
            <?php if ($amenities_section_title) : ?>
                <h3 class="title"><?php echo $amenities_section_title; ?></h3>
            <?php endif; ?>
            <?php if ($amenities_section_content) : ?>
                <p class="content">
                    <?php echo $amenities_section_content; ?>
                </p>
            <?php endif; ?>
        </div>
        <?php if ($amenities_section_image) : ?>
            <div class="image">
                <img src="<?php echo $amenities_section_image; ?>">
            </div>
        <?php endif; ?>
    </div>
    <?php
    $amenities = get_field('amenities');
    $amenities_secondary_image = get_field('amenities_secondary_image');
    $amenity_default_icon = get_field('amenity_default_icon', 'option');
    ?>
    <?php if ($amenities): ?>
        <div class="details-section amenities-section">
            <h3 class="title"><?php echo __('Amenities', 'REM'); ?></h3>
            <div class="amenities">
                <?php
                foreach ($amenities as $amenity):
                    $icon = get_field('icon', 'amenity_' . $amenity->term_id);
                ?>
                    <div class="amenity">
                        <img src="<?php
                                    if ($icon) {
                                        echo $icon;
                                    } else {
                                        echo $amenity_default_icon;
                                    }
                                    ?>">
                        <p><?php echo esc_html($amenity->name); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php $contact_title = get_field('contact_title');
    $contact_content = get_field('contact_content');
    $contact_image = get_field('contact_image'); ?>
    <div class="details-section">
        <div class="info">
            <?php if ($contact_title) : ?>
                <h3 class="title"><?php echo $contact_title; ?></h3>
            <?php endif; ?>
            <?php if ($contact_content) : ?>
                <p class="content">
                    <?php echo $contact_content; ?>
                </p>
            <?php endif; ?>
        </div>
        <?php if ($contact_image) : ?>
            <div class="image">
                <img src="<?php echo $contact_image; ?>">
            </div>
        <?php endif; ?>
    </div>
</div>