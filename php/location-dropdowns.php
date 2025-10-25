<?php

/**
 * Custom Location Metabox - Separate from ACF
 * Creates a custom metabox with cascading dropdowns that sync to ACF on save
 */

// Add the custom metabox
add_action('add_meta_boxes', 'add_custom_location_metabox');
function add_custom_location_metabox()
{
    $post_types = array('project', 'listing', 'location', 'company');

    foreach ($post_types as $post_type) {
        add_meta_box(
            'custom_location_selection',
            'Location',
            'render_custom_location_metabox',
            $post_type,
            'side',
            'high'
        );
    }
}

// Render the metabox content
function render_custom_location_metabox($post)
{
    // Add nonce for security
    wp_nonce_field('custom_location_metabox', 'custom_location_nonce');

    // Get ACF field keys for current post type
    $field_keys = array(
        'project' => array(
            'country' => 'field_67662757353b0',
            'city' => 'field_67662757353e6',
            'district' => 'field_676627573541d'
        ),
        'listing' => array(
            'country' => 'field_676638aa31990',
            'city' => 'field_676c282415d12',
            'district' => 'field_676c283b15d13'
        ),
        'location' => array(
            'country' => 'field_667f63c4d563c',
            'city' => 'field_667f63e8d563d',
            'district' => 'field_667f63f1d563e'
        ),
        'company' => array(
            'country' => 'field_66804944bcbb3',
            'city' => 'field_668094da42183',
            'district' => 'field_668094e342184'
        )
    );

    $post_type = get_post_type($post);
    $keys = isset($field_keys[$post_type]) ? $field_keys[$post_type] : null;

    if (!$keys) {
        echo '<p>Configuration not found for this post type.</p>';
        return;
    }

    // Get current values from ACF
    $current_country = get_field($keys['country'], $post->ID);
    $current_city = get_field($keys['city'], $post->ID);
    $current_district = get_field($keys['district'], $post->ID);

    $country_id = $current_country ? $current_country->term_id : '';
    $city_id = $current_city ? $current_city->term_id : '';
    $district_id = $current_district ? $current_district->term_id : '';

?>
    <style>
        #custom_location_selection .location-field {
            margin-bottom: 15px;
        }

        #custom_location_selection label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        #custom_location_selection select {
            width: 100%;
            max-width: 100%;
        }

        #custom_location_selection .loading {
            color: #666;
            font-style: italic;
            font-size: 12px;
        }

        #custom_location_selection .description {
            color: #666;
            font-size: 12px;
            margin-top: 10px;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 3px;
        }

        .acf-field-67662757353b0,
        .acf-field-67662757353e6,
        .acf-field-676627573541d,
        .acf-field-676638aa31990,
        .acf-field-676c282415d12,
        .acf-field-676c283b15d13,
        .acf-field-667f63c4d563c,
        .acf-field-667f63e8d563d,
        .acf-field-667f63f1d563e,
        .acf-field-66804944bcbb3,
        .acf-field-668094da42183,
        .acf-field-668094e342184 {
            display: none;
        }
    </style>

    <div class="location-field">
        <label for="custom_country">Country</label>
        <select id="custom_country" name="custom_country">
            <option value="">— Select Country —</option>
            <?php
            $countries = get_terms(array(
                'taxonomy' => 'country',
                'hide_empty' => false,
                'orderby' => 'name',
                'order' => 'ASC'
            ));

            foreach ($countries as $country) {
                $selected = ($country_id == $country->term_id) ? 'selected' : '';
                echo '<option value="' . esc_attr($country->term_id) . '" ' . $selected . '>' . esc_html($country->name) . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="location-field">
        <label for="custom_city">City</label>
        <select id="custom_city" name="custom_city" <?php echo !$country_id ? 'disabled' : ''; ?>>
            <option value="">— Select City —</option>
            <?php
            if ($country_id) {
                // Load cities for the selected country
                $all_cities = get_terms(array(
                    'taxonomy' => 'city',
                    'hide_empty' => false,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ));

                foreach ($all_cities as $city) {
                    $city_country = get_field('field_667ece2e85c5c', 'city_' . $city->term_id);
                    if ($city_country && is_object($city_country) && $city_country->term_id == $country_id) {
                        $selected = ($city_id == $city->term_id) ? 'selected' : '';
                        echo '<option value="' . esc_attr($city->term_id) . '" ' . $selected . '>' . esc_html($city->name) . '</option>';
                    }
                }
            }
            ?>
        </select>
        <div class="loading" style="display: none;">Loading cities...</div>
    </div>

    <div class="location-field">
        <label for="custom_district">District</label>
        <select id="custom_district" name="custom_district" <?php echo !$city_id ? 'disabled' : ''; ?>>
            <option value="">— Select District —</option>
            <?php
            if ($city_id) {
                // Load districts for the selected city
                $all_districts = get_terms(array(
                    'taxonomy' => 'district',
                    'hide_empty' => false,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ));

                foreach ($all_districts as $district) {
                    $district_city = get_field('field_667ece87c5d6f', 'district_' . $district->term_id);
                    if ($district_city && is_object($district_city) && $district_city->term_id == $city_id) {
                        $selected = ($district_id == $district->term_id) ? 'selected' : '';
                        echo '<option value="' . esc_attr($district->term_id) . '" ' . $selected . '>' . esc_html($district->name) . '</option>';
                    }
                }
            }
            ?>
        </select>
        <div class="loading" style="display: none;">Loading districts...</div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Country change
            $('#custom_country').on('change', function() {
                var countryId = $(this).val();
                var $citySelect = $('#custom_city');
                var $districtSelect = $('#custom_district');

                // Reset city and district
                $citySelect.html('<option value="">— Select City —</option>').prop('disabled', true);
                $districtSelect.html('<option value="">— Select District —</option>').prop('disabled', true);

                if (countryId) {
                    // Show loading
                    $citySelect.next('.loading').show();

                    // AJAX call to get cities
                    $.post(ajaxurl, {
                        action: 'get_cities_for_country',
                        country_id: countryId,
                        nonce: '<?php echo wp_create_nonce('location_ajax'); ?>'
                    }, function(response) {
                        $citySelect.next('.loading').hide();

                        if (response.success) {
                            var html = '<option value="">— Select City —</option>';
                            $.each(response.data, function(index, city) {
                                html += '<option value="' + city.id + '">' + city.name + '</option>';
                            });
                            $citySelect.html(html).prop('disabled', false);
                        }
                    });
                }
            });

            // City change
            $('#custom_city').on('change', function() {
                var cityId = $(this).val();
                var $districtSelect = $('#custom_district');

                // Reset district
                $districtSelect.html('<option value="">— Select District —</option>').prop('disabled', true);

                if (cityId) {
                    // Show loading
                    $districtSelect.next('.loading').show();

                    // AJAX call to get districts
                    $.post(ajaxurl, {
                        action: 'get_districts_for_city',
                        city_id: cityId,
                        nonce: '<?php echo wp_create_nonce('location_ajax'); ?>'
                    }, function(response) {
                        $districtSelect.next('.loading').hide();

                        if (response.success) {
                            var html = '<option value="">— Select District —</option>';
                            $.each(response.data, function(index, district) {
                                html += '<option value="' + district.id + '">' + district.name + '</option>';
                            });
                            $districtSelect.html(html).prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
<?php
}

// AJAX handler for cities
add_action('wp_ajax_get_cities_for_country', 'ajax_get_cities_for_country');
function ajax_get_cities_for_country()
{
    check_ajax_referer('location_ajax', 'nonce');

    $country_id = intval($_POST['country_id']);
    $cities = array();

    if ($country_id) {
        $all_cities = get_terms(array(
            'taxonomy' => 'city',
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC'
        ));

        foreach ($all_cities as $city) {
            $city_country = get_field('field_667ece2e85c5c', 'city_' . $city->term_id);
            if ($city_country && is_object($city_country) && $city_country->term_id == $country_id) {
                $cities[] = array(
                    'id' => $city->term_id,
                    'name' => $city->name
                );
            }
        }
    }

    wp_send_json_success($cities);
}

// AJAX handler for districts
add_action('wp_ajax_get_districts_for_city', 'ajax_get_districts_for_city');
function ajax_get_districts_for_city()
{
    check_ajax_referer('location_ajax', 'nonce');

    $city_id = intval($_POST['city_id']);
    $districts = array();

    if ($city_id) {
        $all_districts = get_terms(array(
            'taxonomy' => 'district',
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC'
        ));

        foreach ($all_districts as $district) {
            $district_city = get_field('field_667ece87c5d6f', 'district_' . $district->term_id);
            if ($district_city && is_object($district_city) && $district_city->term_id == $city_id) {
                $districts[] = array(
                    'id' => $district->term_id,
                    'name' => $district->name
                );
            }
        }
    }

    wp_send_json_success($districts);
}

// Save the custom metabox data and update ACF fields
add_action('save_post', 'save_custom_location_metabox', 10, 2);
function save_custom_location_metabox($post_id, $post)
{
    // Check nonce
    if (!isset($_POST['custom_location_nonce']) || !wp_verify_nonce($_POST['custom_location_nonce'], 'custom_location_metabox')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if our fields are set
    if (!isset($_POST['custom_country']) || !isset($_POST['custom_city']) || !isset($_POST['custom_district'])) {
        return;
    }

    // Get field keys for this post type
    $field_keys = array(
        'project' => array(
            'country' => 'field_67662757353b0',
            'city' => 'field_67662757353e6',
            'district' => 'field_676627573541d'
        ),
        'listing' => array(
            'country' => 'field_676638aa31990',
            'city' => 'field_676c282415d12',
            'district' => 'field_676c283b15d13'
        ),
        'location' => array(
            'country' => 'field_667f63c4d563c',
            'city' => 'field_667f63e8d563d',
            'district' => 'field_667f63f1d563e'
        ),
        'company' => array(
            'country' => 'field_66804944bcbb3',
            'city' => 'field_668094da42183',
            'district' => 'field_668094e342184'
        )
    );

    $post_type = get_post_type($post_id);
    if (!isset($field_keys[$post_type])) {
        return;
    }

    $keys = $field_keys[$post_type];

    // Get the values from our custom dropdowns
    $country_id = intval($_POST['custom_country']);
    $city_id = intval($_POST['custom_city']);
    $district_id = intval($_POST['custom_district']);

    // Update ACF fields
    if ($country_id) {
        update_field($keys['country'], $country_id, $post_id);
    }

    if ($city_id) {
        update_field($keys['city'], $city_id, $post_id);
    }

    if ($district_id) {
        update_field($keys['district'], $district_id, $post_id);
    }
}
