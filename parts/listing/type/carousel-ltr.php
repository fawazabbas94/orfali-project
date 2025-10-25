<?php
// Retrieve country and city from shortcode parameters
$country = isset($atts['country']) ? $atts['country'] : '';
$city = isset($atts['city']) ? $atts['city'] : '';

$unit_type_default_image = get_field('unit_type_default_image', 'option');
$terms = get_terms(array(
    'taxonomy' => 'unit-type',
    'hide_empty' => true,
));

if (!empty($terms) && !is_wp_error($terms)) { ?>
    <div class="types-carousel rem-carousel">
        <div class="f-carousel" id="types-carousel">
            <?php
            foreach ($terms as $term) {
                // Build the tax_query
                $tax_query = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'unit-type',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id,
                    ),
                );

                // Add country and city taxonomies to tax_query if provided
                if (!empty($country)) {
                    $tax_query[] = array(
                        'taxonomy' => 'country',
                        'field'    => 'slug',
                        'terms'    => $country,
                    );
                }
                if (!empty($city)) {
                    $tax_query[] = array(
                        'taxonomy' => 'city',
                        'field'    => 'slug',
                        'terms'    => $city,
                    );
                }

                $query = new WP_Query(array(
                    'post_type'      => 'listing',
                    'tax_query'      => $tax_query,
                    'posts_per_page' => -1,
                ));

                $featured_image = get_field('featured_image', 'unit-type_' . $term->term_id);
                $featured_image_url = is_array($featured_image) && isset($featured_image['url'])
                    ? $featured_image['url']
                    : $unit_type_default_image;
            ?>
                <div class="f-carousel__slide single-card single-type-card" id="type-<?php echo esc_attr($term->slug); ?>">
                    <div class="content-container">
                        <img class="type-image" src="<?php echo esc_url($featured_image_url); ?>" alt="<?php echo esc_attr($term->name); ?>">
                        <a class="type-content" href="<?php echo esc_url(add_query_arg(array(
                                                            '_country'       => !empty($country) ? $country : null,
                                                            '_city'          => !empty($city) ? $city : null,
                                                            '_listing_type'  => $term->slug,
                                                        ), home_url('/listings/'))); ?>">
                            <?php echo esc_html($term->name); ?>
                            <span class="type-listings-count"><?php echo esc_html($query->found_posts) . __(' Listings', 'REM'); ?></span>
                        </a>
                    </div>
                </div>
            <?php
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
<?php
} else {
    echo __('No types found.', 'REM');
}
?>