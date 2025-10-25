<?php
// location columns
add_filter('manage_location_posts_columns', 'custom_add_location_columns');
function custom_add_location_columns($columns)
{
    $new_columns = array(
        'cb' => $columns['cb'],
        'icon' => __('Icon', 'REM'),
        'title' => $columns['title'],
        'taxonomy-location-category' => __('Category', 'REM'),
        'taxonomy-country' => __('Country', 'REM'),
        'taxonomy-city' => __('City', 'REM'),
        'taxonomy-district' => __('District', 'REM'),
        'listings' => __('Listings', 'REM'),
    );

    return $new_columns;
}
add_filter('manage_edit-location_sortable_columns', 'custom_location_sortable_columns');
function custom_location_sortable_columns($columns)
{
    $columns['title'] = 'title';
    $columns['taxonomy-location-category'] = 'taxonomy-location-category';
    $columns['taxonomy-country'] = 'taxonomy-country';
    $columns['taxonomy-city'] = 'taxonomy-city';
    $columns['taxonomy-district'] = 'taxonomy-district';
    $columns['listings'] = 'listings'; // Added sortable column for listings
    return $columns;
}
add_action('pre_get_posts', 'custom_location_sort_query');
function custom_location_sort_query($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    $orderby = $query->get('orderby');
    switch ($orderby) {
        case 'taxonomy-location-category':
            $query->set('orderby', 'taxonomy-location-category');
            break;
        case 'taxonomy-country':
            $query->set('orderby', 'taxonomy-country');
            break;
        case 'taxonomy-city':
            $query->set('orderby', 'taxonomy-city');
            break;
        case 'taxonomy-district':
            $query->set('orderby', 'taxonomy-district');
            break;
        case 'listings':
            $query->set('orderby', 'meta_value_num'); // Sort by numeric value
            $query->set('meta_key', 'listings'); // Set the meta key for sorting
            break;
        default:
            break;
    }
}
add_action('manage_location_posts_custom_column', 'custom_location_column_content', 10, 2);
function custom_location_column_content($column_name, $post_id)
{
    if ($column_name === 'icon') {
        $category = get_the_terms($post_id, 'location-category');
        if ($category && !is_wp_error($category)) {
            $category_icon = get_field('icon', $category[0]);
            if ($category_icon) {
                echo '<img src="' . esc_url($category_icon) . '" style="max-width: 50px; height: auto;" />';
            } else {
                echo '-';
            }
        } else {
            echo '-';
        }
    } elseif ($column_name === 'listings') {
        $listing_count = 0;
        $args = array(
            'post_type' => 'listing',
            'posts_per_page' => -1,
        );
        $listings = new WP_Query($args);
        if ($listings->have_posts()) {
            while ($listings->have_posts()) {
                $listings->the_post();
                $nearby_places = get_field('nearby_places', get_the_ID());
                if (!empty($nearby_places) && is_array($nearby_places)) {
                    foreach ($nearby_places as $nearby_place) {
                        if (isset($nearby_place['place']) && $nearby_place['place']->ID === $post_id) {
                            $listing_count++;
                            continue 2;
                        }
                    }
                }
                $listing_views = get_field('listing_view', get_the_ID());
                if (!empty($listing_views) && is_array($listing_views)) {
                    foreach ($listing_views as $listing_view) {
                        if ($listing_view->ID === $post_id) {
                            $listing_count++;
                            break;
                        }
                    }
                }
            }
            wp_reset_postdata();
        }
        echo $listing_count;
    }
}
// location taxonomies columns
function reorder_columns($columns, $taxonomy)
{
    switch ($taxonomy) {
        case 'location-category':
            $new_columns = array(
                'cb' => $columns['cb'],
                'icon' => __('Icon'),
                'name' => __('Category'),
                'posts' => __('Counts'),
            );
            break;
        case 'country':
            $new_columns = array(
                'cb' => $columns['cb'],
                'flag' => __('Flag'),
                'name' => __('Country'),
                'counts' => __('Counts'),
            );
            break;
        case 'city':
            $new_columns = array(
                'cb' => $columns['cb'],
                'name' => __('City'),
                'country' => __('Country'),
                'counts' => __('Counts'),
            );
            break;
        case 'district':
            $new_columns = array(
                'cb' => $columns['cb'],
                'name' => __('District'),
                'city' => __('City'),
                'country' => __('Country'),
                'counts' => __('Counts'),
            );
            break;
    }
    return $new_columns;
}
add_filter('manage_edit-location-category_columns', function ($columns) {
    return reorder_columns($columns, 'location-category');
});
add_filter('manage_edit-country_columns', function ($columns) {
    return reorder_columns($columns, 'country');
});
add_filter('manage_edit-city_columns', function ($columns) {
    return reorder_columns($columns, 'city');
});
add_filter('manage_edit-district_columns', function ($columns) {
    return reorder_columns($columns, 'district');
});
function sortable_columns($columns, $taxonomy)
{
    switch ($taxonomy) {
        case 'country':
            $columns['companies'] = 'companies';
        case 'city':
            $columns['country'] = 'country';
            break;
        case 'district':
            $columns['city'] = 'city';
            $columns['country'] = 'country';
            break;
    }
    return $columns;
}
add_filter('manage_edit-country_sortable_columns', function ($columns) {
    return sortable_columns($columns, 'country');
});
add_filter('manage_edit-city_sortable_columns', function ($columns) {
    return sortable_columns($columns, 'city');
});
add_filter('manage_edit-district_sortable_columns', function ($columns) {
    return sortable_columns($columns, 'district');
});
function display_custom_columns($content, $column_name, $term_id, $taxonomy)
{
    switch ($taxonomy) {
        case 'location-category':
            if ($column_name === 'icon') {
                $icon_url = get_field('icon', "location-category_{$term_id}");
                $content = $icon_url ? '<img src="' . esc_url($icon_url) . '" alt="Icon" style="width:50px;height:auto;">' : __('No Icon Assigned');
            }
            break;
        case 'country':
            if ($column_name === 'flag') {
                $flag_url = get_field('flag', "country_{$term_id}");
                $content = $flag_url ? '<img src="' . esc_url($flag_url) . '" alt="Flag" style="width:50px;height:auto;">' : __('No Flag Assigned');
            } elseif ($column_name === 'counts') {
                $content =  display_listing_count($term_id, $taxonomy) . '<br>' . display_companies_count($term_id, $taxonomy) . '<br>' . display_locations_count($term_id, $taxonomy);
            }
            break;
        case 'city':
            if ($column_name === 'country') {
                $country_term = get_field('country', "city_{$term_id}");
                $content = $country_term ? esc_html($country_term->name) : __('No Country Assigned');
            } elseif ($column_name === 'counts') {
                $content =  display_listing_count($term_id, $taxonomy) . '<br>' . display_companies_count($term_id, $taxonomy) . '<br>' . display_locations_count($term_id, $taxonomy);
            }
            break;
        case 'district':
            $city_term = get_field('city', "district_{$term_id}");
            if ($column_name === 'city') {
                $content = $city_term ? esc_html($city_term->name) : __('No City Assigned');
            } elseif ($column_name === 'country') {
                $country_term = $city_term ? get_field('country', "city_{$city_term->term_id}") : null;
                $content = $country_term ? esc_html($country_term->name) : __('No Country Assigned');
            } elseif ($column_name === 'counts') {
                $content =  display_listing_count($term_id, $taxonomy) . '<br>' . display_companies_count($term_id, $taxonomy) . '<br>' . display_locations_count($term_id, $taxonomy);
            }
            break;
    }
    return $content;
}
function display_listing_count($term_id, $taxonomy)
{
    $listing_count_query = new WP_Query(array(
        'post_type' => 'listing',
        'meta_query' => array(
            array(
                'key' => $taxonomy,
                'value' => $term_id,
                'compare' => '='
            )
        )
    ));
    $listing_count = $listing_count_query->found_posts;
    $term = get_term($term_id);
    if ($term) {
        $slug = $term->slug;
        $url = admin_url("edit.php?{$taxonomy}={$slug}&post_type=listing");
        return "<a href='" . esc_url($url) . "'>{$listing_count} Listings</a>";
    }
    return $listing_count;
}
function display_companies_count($term_id, $taxonomy)
{
    $company_count_query = new WP_Query(array(
        'post_type' => 'company',
        'meta_query' => array(
            array(
                'key' => $taxonomy,
                'value' => $term_id,
                'compare' => '='
            )
        )
    ));
    $company_count = $company_count_query->found_posts;
    $term = get_term($term_id);
    if ($term) {
        $slug = $term->slug;
        $url = admin_url("edit.php?{$taxonomy}={$slug}&post_type=company");
        return "<a href='" . esc_url($url) . "'>{$company_count} Companies</a>";
    }
    return $listing_count;
}
function display_locations_count($term_id, $taxonomy)
{
    $location_count_query = new WP_Query(array(
        'post_type' => 'location',
        'meta_query' => array(
            array(
                'key' => $taxonomy,
                'value' => $term_id,
                'compare' => '='
            )
        )
    ));
    $location_count = $location_count_query->found_posts;
    $term = get_term($term_id);
    if ($term) {
        $slug = $term->slug;
        $url = admin_url("edit.php?{$taxonomy}={$slug}&post_type=location");
        return "<a href='" . esc_url($url) . "'>{$location_count} Locations</a>";
    }
    return $listing_count;
}
add_action('manage_location-category_custom_column', function ($content, $column_name, $term_id) {
    return display_custom_columns($content, $column_name, $term_id, 'location-category');
}, 10, 3);
add_action('manage_country_custom_column', function ($content, $column_name, $term_id) {
    return display_custom_columns($content, $column_name, $term_id, 'country');
}, 10, 3);
add_action('manage_city_custom_column', function ($content, $column_name, $term_id) {
    return display_custom_columns($content, $column_name, $term_id, 'city');
}, 10, 3);
add_action('manage_district_custom_column', function ($content, $column_name, $term_id) {
    return display_custom_columns($content, $column_name, $term_id, 'district');
}, 10, 3);
