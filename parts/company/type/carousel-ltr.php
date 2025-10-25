<?php
// Retrieve country, city, and type from shortcode parameters
$country = isset($atts['country']) ? $atts['country'] : '';
$city = isset($atts['city']) ? $atts['city'] : '';
$type = isset($atts['type']) ? $atts['type'] : '';

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

// Step 2: Extract unique company IDs from the queried projects
$company_ids = array();
if ($projects->have_posts()) {
    foreach ($projects->posts as $project_id) {
        $construction_company = get_field('construction_companies', $project_id);
        if ($construction_company && is_object($construction_company)) {
            $company_ids[] = $construction_company->ID; // Collect company IDs
        }
    }
    $company_ids = array_unique($company_ids);
}

// Step 3: Query the companies using the filtered company IDs
$companies = !empty($company_ids) ? get_posts(array(
    'post_type'      => 'company',
    'posts_per_page' => -1,
    'post__in'       => $company_ids,
)) : array();

// Step 4: Display the companies
if (!empty($companies)) { ?>
    <div class="companies-carousel rem-carousel">
        <div class="f-carousel" id="companies-carousel">
            <?php foreach ($companies as $company) { 
                $featured_image = get_the_post_thumbnail_url($company->ID, 'full');
                $featured_image_url = $featured_image ? $featured_image : 'path/to/default/image.jpg'; // Provide a fallback image
            ?>
                <div class="f-carousel__slide single-card single-company-card" id="company-<?php echo esc_attr($company->post_name); ?>">
                    <a class="content-container" href="<?php echo esc_url(get_permalink($company->ID)); ?>">
                        <img class="company-image" src="<?php echo esc_url($featured_image_url); ?>" alt="<?php echo esc_attr($company->post_title); ?>">
            </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php
} else {
    echo __('No companies found for the selected criteria.', 'REM');
}
?>
