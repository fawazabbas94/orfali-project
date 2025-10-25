<?php
// Retrieve country, city, and type from shortcode parameters
$country = isset($atts['country']) ? $atts['country'] : '';
$city = isset($atts['city']) ? $atts['city'] : '';
$type = isset($atts['type']) ? $atts['type'] : '';

$unit_type_default_image = get_field('unit_type_default_image', 'option');

// Step 1: Query projects matching the selected country, city, and type
$project_query_args = array(
    'post_type'      => 'project',
    'posts_per_page' => -1,
    'fields'         => 'ids', // Only retrieve project IDs
    'tax_query'      => array(
        'relation' => 'AND',
        !empty($country) ? array(
            'taxonomy' => 'country',
            'field'    => 'slug',
            'terms'    => $country,
        ) : null,
        !empty($city) ? array(
            'taxonomy' => 'city',
            'field'    => 'slug',
            'terms'    => $city,
        ) : null,
        !empty($type) ? array(
            'taxonomy' => 'listing_type',
            'field'    => 'slug',
            'terms'    => $type,
        ) : null,
    ),
);

// Remove null values from the tax_query
$project_query_args['tax_query'] = array_filter($project_query_args['tax_query']);

// Query projects
$projects = new WP_Query($project_query_args);

// Step 2: Extract unique district IDs from the queried projects
$district_ids = array();
if ($projects->have_posts()) {
    foreach ($projects->posts as $project_id) {
        $project_districts = wp_get_post_terms($project_id, 'district', array('fields' => 'ids'));
        $district_ids = array_merge($district_ids, $project_districts);
    }
    $district_ids = array_unique($district_ids);
}

// Step 3: Get district terms using the filtered district IDs
$terms = !empty($district_ids) ? get_terms(array(
    'taxonomy'   => 'district',
    'hide_empty' => true,
    'include'    => $district_ids,
)) : array();

// Check if terms are found
if (!empty($terms) && !is_wp_error($terms)) { ?>
    <div class="districts-carousel rem-carousel">
        <div class="f-carousel" id="districts-carousel">
            <?php
            foreach ($terms as $term) {
                // Query projects for the current district
                $query = new WP_Query(array(
                    'post_type'      => 'project',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'district',
                            'field'    => 'term_id',
                            'terms'    => $term->term_id,
                        ),
                    ),
                    'posts_per_page' => -1,
                ));

                $featured_image = get_field('featured_image', 'district_' . $term->term_id);
                $featured_image_url = is_array($featured_image) && isset($featured_image['url'])
                    ? $featured_image['url']
                    : $unit_type_default_image;
            ?>
                <div class="f-carousel__slide single-card single-district-card" id="district-<?php echo esc_attr($term->slug); ?>">
                    <a class="content-container" href="<?php echo esc_url(add_query_arg(array(
                                                            '_p_country'       => !empty($country) ? $country : null,
                                                            '_p_city'          => !empty($city) ? $city : null,
                                                            '_p_type'          => !empty($type) ? $type : null,
                                                            '_p_district'      => $term->slug,
                                                        ), home_url('/projects/'))); ?>">
                        <img class="district-image" src="<?php echo esc_url($featured_image_url); ?>" alt="<?php echo esc_attr($term->name); ?>">
                        <p class="district-content">
                            <?php echo esc_html($term->name); ?>
                            <span class="district-projects-count"><?php echo esc_html($query->found_posts) . __(' Projects', 'REM'); ?></span>
                        </p>
                    </a>
                </div>
            <?php
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
<?php
} else {
    echo __('No districts found for the selected criteria.', 'REM');
}
?>