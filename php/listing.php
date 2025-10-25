<?php
// listing columns
function add_listing_columns($columns)
{
   $new_columns = array();
   $new_columns['cb'] = $columns['cb'];
   $new_columns['listing_id'] = __('ID', 'REM');
   $new_columns['title'] = __('Name', 'REM');
   $new_columns['project'] = __('Project', 'REM');
   $new_columns['listing_type'] = __('Listing Type', 'REM');
   $new_columns['listing_status'] = __('Listing Status', 'REM');
   $new_columns['location'] = __('Location', 'REM');


   return $new_columns;
}
add_filter('manage_listing_posts_columns', 'add_listing_columns');


function fill_listing_columns($column, $post_id)
{
   switch ($column) {
       case 'listing_status':
           $term = get_field('listing_status', $post_id);
           $availability = get_field('listing_availability', $post_id);
           $new_action_label = ($availability == 'available') ? __('Mark as Sold Out', 'REM') : __('Mark as Available', 'REM');
           echo $term ? $term->name : '';
           if ($availability === 'sold_out') {
               echo '<br><b style="color:red;line-height: 24px;">Sold Out</b> <div class="row-actions" style="display:inline"><span class="availability"><a style="margin-block-start:2px" title="' . $new_action_label . '" href="#" class="toggle-availability ' . $availability . '" data-post-id="' . $post_id . '">' . $new_action_label . '</a></span></div>';
           } else {
               echo '<br><b style="color:green;line-height: 24px;">Available</b> <div class="row-actions" style="display:inline"><span class="availability"><a style="margin-block-start:2px" title="' . $new_action_label . '" href="#" class="toggle-availability ' . $availability . '" data-post-id="' . $post_id . '">' . $new_action_label . '</a></span></div>';
           }
           break;
       case 'listing_type':
           $listing_type = get_field('listing_type', $post_id);
           $buy_rent = __('For ', 'REM') . get_field('buy_rent', $post_id)['label'];
           echo $listing_type ? $listing_type->name . '<br>' . $buy_rent : '' . '<br>' . $buy_rent;
           break;
       case 'project':
           $listing_project = get_field('project', $post_id);
           $project_type = get_field('project_type', $listing_project);
           $project_type_names = is_array($project_type) ? implode(', ', array_map(function ($type) {
               return $type->name;
           }, $project_type)) : '';
           echo $listing_project ? $listing_project->post_title . '<br>' . $project_type_names : '' . '<br>' . $project_type_names;
           break;
       case 'listing_id':
           echo '<b>' . get_field('listing_id', $post_id) . '</b>';
           break;
       case 'location':
           $listing_project = get_field('project', $post_id);
           $country = get_field('country', $listing_project);
           $city = get_field('city', $listing_project);
           $district = get_field('district', $listing_project);
           if ($country) {
               $flag = get_field('flag', 'country_' . $country->term_id);
               if ($flag) {
                   echo '<img src="' . $flag . '" alt="' . $country->name . '" style="width:20px;height:auto;margin-right:5px;vertical-align:middle;">';
               }
               echo $country->name . ', ';
           } else {
               echo '-, ';
           }
           echo $city ? $city->name . ', ' : '-, ';
           echo $district ? $district->name : '-';
           break;
   }
}
add_action('manage_listing_posts_custom_column', 'fill_listing_columns', 10, 2);


function listing_sortable_columns($columns)
{
   $columns['listing_id'] = 'listing_id';
   $columns['listing_type'] = 'listing_type';
   $columns['project'] = 'project';
   $columns['listing_status'] = 'listing_status';
   $columns['location'] = 'location';


   return $columns;
}
add_filter('manage_edit-listing_sortable_columns', 'listing_sortable_columns');


function listing_column_orderby($query)
{
   if (!is_admin()) {
       return;
   }


   $orderby = $query->get('orderby');
   switch ($orderby) {
       case 'listing_type':
           $query->set('meta_key', 'listing_type');
           $query->set('orderby', 'meta_value');
           break;
       case 'project':
           $query->set('meta_key', 'project');
           $query->set('orderby', 'meta_value');
           break;
       case 'listing_id':
           $query->set('meta_key', 'listing_id');
           $query->set('orderby', 'meta_value');
           break;
       case 'listing_status':
           $query->set('meta_key', 'listing_status');
           $query->set('orderby', 'meta_value');
           break;
       case 'location':
           $query->set('meta_key', 'district');
           $query->set('orderby', 'meta_value');
           break;
   }
}
add_action('pre_get_posts', 'listing_column_orderby');
// availability switch
function listing_availability_switch($actions, $post)
{
   if ($post->post_type == 'listing') {
       $actions['copy_link'] = '<a title="' . __('Copy listing link', 'REM') . '" href="#" class="copy-listing-link" data-post-id="' . esc_attr($post->ID) . '">' . __('Copy Link', 'REM') . '</a>';
   }
   return $actions;
}
add_filter('page_row_actions', 'listing_availability_switch', 10, 2);
function listing_availability_switch_script()
{
   global $pagenow;
   if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'listing') {
?>
       <script type="text/javascript">
           jQuery(document).ready(function($) {
               $('.toggle-availability').on('click', function(e) {
                   e.preventDefault();
                   var button = $(this);
                   var postId = button.data('post-id');
                   $.ajax({
                       url: ajaxurl,
                       type: 'post',
                       data: {
                           action: 'toggle_listing_availability',
                           post_id: postId,
                           nonce: '<?php echo wp_create_nonce('toggle_listing_availability'); ?>'
                       },
                       success: function(response) {
                           if (response.success) {
                               var newLabel = response.data.new_label;
                               button.text(newLabel);
                               $('.wrap h1').after('<div class="notice notice-success is-dismissible"><p>' + response.data.message + '</p></div>');
                               setTimeout(function() {
                                   location.reload();
                               }, 100);
                           } else {
                               $('.wrap h1').after('<div class="notice notice-error is-dismissible"><p>' + response.data.message + '</p></div>');
                           }
                       },
                       error: function(xhr, status, error) {
                           $('.wrap h1').after('<div class="notice notice-error is-dismissible"><p>AJAX request failed: ' + error + '</p></div>');
                       }
                   });
               });
           });
       </script>
<?php
   }
}
add_action('admin_print_footer_scripts', 'listing_availability_switch_script');
function toggle_listing_availability()
{
   if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'toggle_listing_availability')) {
       wp_send_json_error(array('message' => 'Nonce verification failed.'));
       return;
   }
   $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
   if (!$post_id) {
       wp_send_json_error(array('message' => 'Invalid post ID.'));
       return;
   }
   $availability = get_field('listing_availability', $post_id);
   if ($availability === false) {
       wp_send_json_error(array('message' => 'Failed to get field value.'));
       return;
   }
   if ($availability == 'available') {
       $updated = update_field('listing_availability', 'sold_out', $post_id);
       if ($updated) {
           $new_label = __('Mark as Available', 'text-domain');
           $message = __('The listing has been marked as sold out.', 'text-domain');
           wp_send_json_success(array('new_label' => $new_label, 'message' => $message));
       } else {
           wp_send_json_error(array('message' => 'Failed to update field.'));
       }
   } else {
       $updated = update_field('listing_availability', 'available', $post_id);
       if ($updated) {
           $new_label = __('Mark as Sold Out', 'text-domain');
           $message = __('The listing has been marked as available.', 'text-domain');
           wp_send_json_success(array('new_label' => $new_label, 'message' => $message));
       } else {
           wp_send_json_error(array('message' => 'Failed to update field.'));
       }
   }
}
add_action('wp_ajax_toggle_listing_availability', 'toggle_listing_availability');
// set default amenities
add_filter('acf/load_field/key=field_650a43f472389', 'listing_default_amenities');
function listing_default_amenities($field)
{
   if (is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'listing' && !isset($_GET['post'])) {
       $default_amenities = get_field('default_amenities', 'option');
       if ($default_amenities) {
           $field['value'] = array_map(function ($amenity) {
               return $amenity->term_id;
           }, $default_amenities);
       }
   }
   return $field;
}
// single listing print
function listing_template_redirect()
{
   if (is_singular('listing') && isset($_GET['print']) && $_GET['print'] == 'true') {
       include(get_stylesheet_directory() . '/single-listing-print.php');
       exit;
   }
}
add_action('template_redirect', 'listing_template_redirect');
// unit type and place columns
function reorder_listing_taxonomies_columns($columns, $taxonomy)
{


   switch ($taxonomy) {
       case 'unit-type':
           $new_columns = array(
               'cb' => $columns['cb'],
               'icon' => __('Image'),
               'name' => __('Type'),
               'posts' => __('Counts'),
           );
           break;
       case 'place':
           $new_columns = array(
               'cb' => $columns['cb'],
               'icon' => __('Icon'),
               'name' => __('Place'),
               'category' => __('Category'),
               'linked_location' => __('Linked Location'),
               'posts' => __('Counts'),
           );
           break;
   }
   return $new_columns;
}
add_filter('manage_edit-unit-type_columns', function ($columns) {
   return reorder_listing_taxonomies_columns($columns, 'unit-type');
});
add_filter('manage_edit-place_columns', function ($columns) {
   return reorder_listing_taxonomies_columns($columns, 'place');
});
function display_listing_taxonomies_columns($content, $column_name, $term_id, $taxonomy)
{
   switch ($taxonomy) {
       case 'unit-type':
           if ($column_name === 'icon') {
               $icon_url = get_field('featured_image', "unit-type_{$term_id}");
               $image = $icon_url['url'] ?? '';
               $content = $image ? '<img src="' . esc_url($image) . '" alt="Icon" style="width:50px;height:50px;object-fit:cover">' : __('No Icon Assigned');
           }
           break;
       case 'place':
           if ($column_name === 'category') {
               $category = get_field('location_category', "place_{$term_id}");
               $content = $category ? $category->name : __('No Category Assigned');
           } elseif ($column_name === 'linked_location') {
               $location = get_field('linked_location', "place_{$term_id}");
               if ($location) {
                   $post = get_post($location);
                   if ($post) {
                       $post_title = esc_html($post->post_title);
                       $post_url = get_permalink($post->ID);
                       $content = '<a href="' . esc_url($post_url) . '">' . $post_title . '</a>';
                   } else {
                       $content = __('No Location Assigned');
                   }
               } else {
                   $content = __('No Location Assigned');
               }
           } elseif ($column_name === 'icon') {
               $location = get_field('linked_location', "place_{$term_id}");
               if ($location) {
                   $post = get_post($location);
                   if ($post) {
                       $category = get_field('location_category', $post->ID);
                       $icon_url = $category ? get_field('icon', "location-category_{$category->term_id}") : '';
                   } else {
                       $icon_url = '';
                   }
               } else {
                   $category = get_field('location_category', "place_{$term_id}");
                   $icon_url = $category ? get_field('icon', "location-category_{$category->term_id}") : '';
               }
               $image = $icon_url ?? '';
               $content = $image ? '<img src="' . esc_url($image) . '" alt="Icon" style="width:50px;height:auto;">' : __('No Icon Assigned');
           }
           break;
   }
   return $content;
}


add_filter('manage_unit-type_custom_column', function ($content, $column_name, $term_id) {
   return display_listing_taxonomies_columns($content, $column_name, $term_id, 'unit-type');
}, 10, 3);


add_filter('manage_place_custom_column', function ($content, $column_name, $term_id) {
   return display_listing_taxonomies_columns($content, $column_name, $term_id, 'place');
}, 10, 3);
// Hide active filters button when there is no active filters
function listing_inline_styles()
{
   if (($_SERVER['REQUEST_URI'] === '/listings/' || $_SERVER['REQUEST_URI'] === '/listings')) {
       echo '<style>
           .active-filter-title {
               display:none !important;
           }
       </style>';
   }
}
add_action('wp_head', 'listing_inline_styles');
// Display Project field values under Listing fields.
// Show dynamic project values under ACF fields (on "listing" post type)
add_action('acf/render_field', 'add_dynamic_project_values_to_listing_fields', 10, 1);
function add_dynamic_project_values_to_listing_fields($field)
{
    global $post;
    static $processed_fields = [];

    if (!$post || $post->post_type !== 'listing') return;

    $field_mapping = [
        'country' => 'field_676638aa31990',
        'city' => 'field_676c282415d12',
        'district' => 'field_676c283b15d13',
        'project_status' => 'field_64f7bf2f5bec0',
        'project_type' => 'field_676c285715d15',
        'types' => 'field_676c288115d16',
        'beds' => 'field_676b36c077e86',
        'baths' => 'field_676b36cf77e87',
        'min_price' => 'field_676b374377e89',
        'max_price' => 'field_676b374377e89',
    ];

    $field_labels = [
        'country' => 'Country',
        'city' => 'City',
        'district' => 'District',
        'project_status' => 'Project status',
        'project_type' => 'Project type',
        'types' => 'Units types',
        'beds' => 'Available beds options',
        'baths' => 'Available baths options',
        'min_price' => 'Min price',
        'max_price' => 'Max price',
    ];

    $project_field = array_search($field['key'], $field_mapping);

    if (!$project_field || in_array($field['key'], $processed_fields)) return;

    $processed_fields[] = $field['key'];
    $selected_project_id = get_field('project', $post->ID);

    $output = '';

    if (!$selected_project_id) {
        $output = '<p style="color: #f00;">No project selected.</p>';
    } else {
        $field_label = $field_labels[$project_field] ?? ucfirst($project_field);
        $project_title = get_the_title($selected_project_id);
        $value = get_field($project_field, $selected_project_id);

        if (in_array($project_field, ['beds', 'baths']) && is_array($value)) {
            $output = '<p style="color:#0073aa;margin-block-end:0">' . esc_html($field_label) . ' from "' . esc_html($project_title) . '" project: ' . esc_html(implode(', ', $value)) . '</p>';
        } elseif (in_array($project_field, ['min_price', 'max_price'])) {
            $min = get_field('min_price', $selected_project_id);
            $max = get_field('max_price', $selected_project_id);
            if ($min && $max) {
                $output = '<p style="color:#0073aa;margin-block-end:0">Price should be between "' . esc_html($min) . '" and "' . esc_html($max) . '"</p>';
            } else {
                $output = '<p style="color:#f00;margin-block-end:0">No price range available in "' . esc_html($project_title) . '" project.</p>';
            }
        } elseif (is_object($value) && property_exists($value, 'name')) {
            $output = '<p style="color:#0073aa;margin-block-end:0">' . esc_html($field_label) . ' from "' . esc_html($project_title) . '" project: ' . esc_html($value->name) . '</p>';
        } elseif (is_array($value)) {
            $term_names = array_map(function ($term) {
                return $term->name;
            }, $value);
            $output = '<p style="color:#0073aa;margin-block-end:0">' . esc_html($field_label) . ' from "' . esc_html($project_title) . '" project: ' . esc_html(implode(', ', $term_names)) . '</p>';
        } elseif ($value) {
            $output = '<p style="color:#0073aa;margin-block-end:0">' . esc_html($field_label) . ' from "' . esc_html($project_title) . '" project: ' . esc_html($value) . '</p>';
        } else {
            $output = '<p style="color:#f00;margin-block-end:0">No ' . esc_html($field_label) . ' available in "' . esc_html($project_title) . '" project.</p>';
        }
    }

    echo '<div class="dynamic-project-label" data-field-key="' . esc_attr($project_field) . '">' . $output . '</div>';
}

// AJAX handler to return dynamic label text from selected project
add_action('wp_ajax_get_project_field_text', function () {
    if (!current_user_can('edit_posts')) wp_send_json_error();

    $project_id = absint($_POST['project_id'] ?? 0);
    $field = sanitize_text_field($_POST['field'] ?? '');

    if (!$project_id || get_post_type($project_id) !== 'project') wp_send_json_error();

    $label_map = [
        'country' => 'Country',
        'city' => 'City',
        'district' => 'District',
        'project_status' => 'Project status',
        'project_type' => 'Project type',
        'types' => 'Units types',
        'beds' => 'Available beds options',
        'baths' => 'Available baths options',
        'min_price' => 'Min price',
        'max_price' => 'Max price',
    ];

    $field_label = $label_map[$field] ?? ucfirst($field);
    $project_title = get_the_title($project_id);
    $value = get_field($field, $project_id);

    ob_start();

    if (in_array($field, ['beds', 'baths']) && is_array($value)) {
        echo '<p style="color:#0073aa;margin-block-end:0">' . esc_html($field_label) . ' from "' . esc_html($project_title) . '" project: ' . esc_html(implode(', ', $value)) . '</p>';
    } elseif (in_array($field, ['min_price', 'max_price'])) {
        $min = get_field('min_price', $project_id);
        $max = get_field('max_price', $project_id);
        if ($min && $max) {
            echo '<p style="color:#0073aa;margin-block-end:0">Price should be between "' . esc_html($min) . '" and "' . esc_html($max) . '"</p>';
        } else {
            echo '<p style="color:#f00;margin-block-end:0">No price range available in "' . esc_html($project_title) . '" project.</p>';
        }
    } elseif (is_object($value) && property_exists($value, 'name')) {
        echo '<p style="color:#0073aa;margin-block-end:0">' . esc_html($field_label) . ' from "' . esc_html($project_title) . '" project: ' . esc_html($value->name) . '</p>';
    } elseif (is_array($value)) {
        $term_names = array_map(function ($term) {
            return $term->name;
        }, $value);
        echo '<p style="color:#0073aa;margin-block-end:0">' . esc_html($field_label) . ' from "' . esc_html($project_title) . '" project: ' . esc_html(implode(', ', $term_names)) . '</p>';
    } elseif ($value) {
        echo '<p style="color:#0073aa;margin-block-end:0">' . esc_html($field_label) . ' from "' . esc_html($project_title) . '" project: ' . esc_html($value) . '</p>';
    } else {
        echo '<p style="color:#f00;margin-block-end:0">No ' . esc_html($field_label) . ' available in "' . esc_html($project_title) . '" project.</p>';
    }

    wp_send_json_success(ob_get_clean());
});

// JavaScript to auto-update field labels when the project changes
add_action('acf/input/admin_footer', function () {
?>
<script>
(function($){
    acf.add_action('ready append', function($el){
        const $projectSelect = $('[data-key="field_676639c154773"] select'); // Replace with your actual project field key

        $projectSelect.on('change', function(){
            const projectID = $(this).val();

            $('.dynamic-project-label').each(function(){
                const $label = $(this);
                const fieldKey = $label.data('field-key');

                $.post(ajaxurl, {
                    action: 'get_project_field_text',
                    project_id: projectID,
                    field: fieldKey
                }, function(response){
                    if (response.success) {
                        $label.html(response.data);
                    }
                });
            });
        });
    });
})(jQuery);
</script>
<?php
});


// Dynamically set the 'Append' attribute of the Price field based on the selected project's country.
add_filter('acf/prepare_field/key=field_676b374377e89', 'set_price_field_append_based_on_country');
function set_price_field_append_based_on_country($field)
{
    global $post;
    if (!$post || $post->post_type !== 'listing') {
        return $field;
    }
    
    // Get the country from the listing itself
    $country = get_field('country', $post->ID);
    if (!$country) {
        $field['append'] = '';
        return $field;
    }
    
    switch ($country->slug) {
        case 'turkiye':
            $field['append'] = 'USD';
            break;
        case 'uae':
            $field['append'] = 'AED';
            break;
        default:
            $field['append'] = '';
            break;
    }
    
    return $field;
}
// Dynamically set the 'Append' attribute of the Price field based on the selected country.
add_filter('acf/prepare_field/key=field_676f0a573816e', 'set_price_field_append_for_project_based_on_country');
add_filter('acf/prepare_field/key=field_676f0a7938170', 'set_price_field_append_for_project_based_on_country');
function set_price_field_append_for_project_based_on_country($field)
{
   global $post;
   if (!$post || $post->post_type !== 'project') {
       return $field;
   }
   $country = get_field('country', $post->ID);
   if (!$country) {
       $field['append'] = '';
       return $field;
   }
   switch ($country->slug) {
       case 'turkiye':
           $field['append'] = 'USD';
           break;
       case 'uae':
           $field['append'] = 'AED';
           break;
       default:
           $field['append'] = '';
           break;
   }
   return $field;
}

// Dynamically set the 'Append' attribute of the Area field based on the selected project's country.
add_filter('acf/prepare_field/key=field_676b368677e85', 'set_area_field_append_based_on_country');
add_filter('acf/prepare_field/key=field_676b371877e88', 'set_area_field_append_based_on_country');
add_filter('acf/prepare_field/key=field_68f974dc04edb', 'set_area_field_append_based_on_country');
add_filter('acf/prepare_field/key=field_68f974e904edc', 'set_area_field_append_based_on_country');
function set_area_field_append_based_on_country($field)
{
    global $post;
    if (!$post || $post->post_type !== 'listing') {
        return $field;
    }

    // Get the country from the listing itself
    $country = get_field('country', $post->ID);
    if (!$country) {
        $field['append'] = '';
        return $field;
    }

    switch ($country->slug) {
        case 'turkiye':
            $field['append'] = 'sqm';
            break;
        case 'uae':
            $field['append'] = 'sqft';
            break;
        default:
            $field['append'] = '';
            break;
    }

    return $field;
}

function update_auto_search_field($post_id, $post, $update)
{
   if ($post->post_type !== 'listing') {
       return;
   }
   if (wp_is_post_revision($post_id)) {
       return;
   }
   $project = get_field('project', $post_id);
   $project_title = get_the_title($project);
   $city = get_field('city', $post_id);
   $district = get_field('district', $post_id);
   $building = get_post_meta($post_id, 'building', true);
   if (!empty($project_title) && !empty($city) && !empty($district) && !empty($building)) {
       $auto_search_value = $building . ' ' . $project_title . ' (' . $district->name . ', ' . $city->name . ')';
       update_post_meta($post_id, 'auto_search', $auto_search_value);
   } elseif (!empty($project_title) && !empty($city) && !empty($district)) {
       $auto_search_value = $project_title . ' (' . $district->name . ', ' . $city->name . ')';
       update_post_meta($post_id, 'auto_search', $auto_search_value);
   } elseif (!empty($project_title) && !empty($city)) {
       $auto_search_value = $project_title . ' (' . $city->name . ')';
       update_post_meta($post_id, 'auto_search', $auto_search_value);
   } elseif (!empty($project_title)) {
       $auto_search_value = $project_title;
       update_post_meta($post_id, 'auto_search', $auto_search_value);
   } else {
       update_post_meta($post_id, 'auto_search', '');
   }
}
add_action('save_post', 'update_auto_search_field', 10, 3);



