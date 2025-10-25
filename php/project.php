<?php
// copy model
function copy_link_button()
{
?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".copy-model-link").forEach(function(link) {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    const getText = (selector) => document.querySelector(selector)?.innerText;
                    const getModelText = (model, subSelector) => model.querySelector(subSelector)?.innerText;

                    const model = this.querySelector(".model");

                    const modelText = `
${getText(".project-title h1")}

${getText(".project-inner .project-intro .project-info p")}

${getText(".project-inner .project-intro .citizenship-residence p")}

Title deed:
  Type: ${getText(".details-list .title_deed_type .value")}
  Status: ${getText(".details-list .title_deed_status .value")}

Model details:
  (Availability: ${getModelText(model, ".floor-type .sold-model")})
  Type: ${getModelText(model, ".type")}
  Floor-type: ${getModelText(model, ".floor-type .copy-text-span")}
  Model: ${getModelText(model, ".model-model p")}
  Area: From ${getModelText(model, ".model-area .min-area")} To ${getModelText(model, ".model-area .max-area")}
  Price: From ${getModelText(model, ".model-price .min-price")} To ${getModelText(model, ".model-price .max-price")}
`;
                    const tempInput = document.createElement("textarea");
                    tempInput.value = modelText.trim();
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempInput);
                    this.classList.add("copied");
                    setTimeout(function() {
                        this.classList.remove("copied");
                    }.bind(this), 1000);
                });
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'copy_link_button');
// project columns
function add_project_columns($columns)
{
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['project_id'] = __('ID', 'REM');
    $new_columns['title'] = __('Name', 'REM');
    $new_columns['project_type'] = __('Project Type', 'REM');
    $new_columns['project_status'] = __('Project Status', 'REM');
    $new_columns['title_deed'] = __('Title Deed', 'REM');
    $new_columns['location'] = __('Location', 'REM');
    $new_columns['construction_companies'] = __('Construction Companies', 'REM');

    return $new_columns;
}
add_filter('manage_project_posts_columns', 'add_project_columns');

function fill_project_columns($column, $post_id)
{
    switch ($column) {
        case 'project_status':
            $term = get_field('project_status', $post_id);
            $availability = get_field('project_availability', $post_id);
            $new_action_label = ($availability == 'available') ? __('Mark as Sold Out', 'REM') : __('Mark as Available', 'REM');
            echo $term ? $term->name : '';
            if ($availability === 'sold_out') {
                echo '<br><b style="color:red;line-height: 24px;">Sold Out</b> <div class="row-actions" style="display:inline"><span class="availability"><a style="margin-block-start:2px" title="' . $new_action_label . '" href="#" class="toggle-availability ' . $availability . '" data-post-id="' . $post_id . '">' . $new_action_label . '</a></span></div>';
            } else {
                echo '<br><b style="color:green;line-height: 24px;">Available</b> <div class="row-actions" style="display:inline"><span class="availability"><a style="margin-block-start:2px" title="' . $new_action_label . '" href="#" class="toggle-availability ' . $availability . '" data-post-id="' . $post_id . '">' . $new_action_label . '</a></span></div>';
            }
            break;
        case 'project_type':
            $terms = get_field('project_type', $post_id);
            if ($terms) {
                $term_names = array_map(function ($term) {
                    return $term->name;
                }, $terms);
                echo implode(', ', $term_names);
            }
            break;
        case 'project_id':
            echo '<b>' . get_field('project_id', $post_id) . '</b>';
            break;
        case 'location':
            $country = get_field('country', $post_id);
            $city = get_field('city', $post_id);
            $district = get_field('district', $post_id);

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
        case 'construction_companies':
            $construction_companies = get_field('construction_companies', $post_id);
            echo $construction_companies->post_title;
            break;
        case 'title_deed':
            $title_deed_type = get_field('title_deed_type', $post_id);
            $title_deed_status = get_field('title_deed_status', $post_id);
            echo $title_deed_type ? $title_deed_type['label'] . '<br><b>' : '';
            echo $title_deed_status ? $title_deed_status['label'] . '</b>' : '';
            break;
    }
}
add_action('manage_project_posts_custom_column', 'fill_project_columns', 10, 2);

function project_sortable_columns($columns)
{
    $columns['project_id'] = 'project_id';
    $columns['project_type'] = 'project_type';
    $columns['construction_companies'] = 'construction_companies';
    $columns['project_status'] = 'project_status'; // Add project_status column as sortable
    $columns['title_deed'] = 'title_deed'; // Add title_deed column as sortable
    $columns['location'] = 'location'; // Add location column as sortable

    return $columns;
}
add_filter('manage_edit-project_sortable_columns', 'project_sortable_columns');

function project_column_orderby($query)
{
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');
    switch ($orderby) {
        case 'project_type':
            $query->set('meta_key', 'project_type');
            $query->set('orderby', 'meta_value');
            break;
        case 'construction_companies':
            $query->set('meta_key', 'construction_companies');
            $query->set('orderby', 'meta_value');
            break;
        case 'project_id':
            $query->set('meta_key', 'project_id');
            $query->set('orderby', 'meta_value');
            break;
        case 'project_status':
            $query->set('meta_key', 'project_status'); // Sort by project_status meta key
            $query->set('orderby', 'meta_value');
            break;
        case 'title_deed':
            $query->set('meta_key', 'title_deed_type'); // Sort by project_status meta key
            $query->set('orderby', 'meta_value');
            break;
        case 'location':
            $query->set('meta_key', 'district'); // Sort by neighborhood meta key
            $query->set('orderby', 'meta_value');
            break;
    }
}
add_action('pre_get_posts', 'project_column_orderby');
// availability switch
function add_custom_row_action($actions, $post)
{
    if ($post->post_type == 'project') {
        $actions['copy_link'] = '<a title="' . __('Copy project link', 'REM') . '" href="#" class="copy-project-link" data-post-id="' . esc_attr($post->ID) . '">' . __('Copy Link', 'REM') . '</a>';
    }
    return $actions;
}
add_filter('page_row_actions', 'add_custom_row_action', 10, 2);
function enqueue_custom_admin_script()
{
    global $pagenow;
    if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'project') {
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
                            action: 'toggle_project_availability',
                            post_id: postId,
                            nonce: '<?php echo wp_create_nonce('toggle_project_availability'); ?>'
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
add_action('admin_print_footer_scripts', 'enqueue_custom_admin_script');
function toggle_project_availability()
{
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'toggle_project_availability')) {
        wp_send_json_error(array('message' => 'Nonce verification failed.'));
        return;
    }
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    if (!$post_id) {
        wp_send_json_error(array('message' => 'Invalid post ID.'));
        return;
    }
    $availability = get_field('project_availability', $post_id);
    if ($availability === false) {
        wp_send_json_error(array('message' => 'Failed to get field value.'));
        return;
    }
    if ($availability == 'available') {
        $updated = update_field('project_availability', 'sold_out', $post_id);
        if ($updated) {
            $new_label = __('Mark as Available', 'text-domain');
            $message = __('The project has been marked as sold out.', 'text-domain');
            wp_send_json_success(array('new_label' => $new_label, 'message' => $message));
        } else {
            wp_send_json_error(array('message' => 'Failed to update field.'));
        }
    } else {
        $updated = update_field('project_availability', 'available', $post_id);
        if ($updated) {
            $new_label = __('Mark as Sold Out', 'text-domain');
            $message = __('The project has been marked as available.', 'text-domain');
            wp_send_json_success(array('new_label' => $new_label, 'message' => $message));
        } else {
            wp_send_json_error(array('message' => 'Failed to update field.'));
        }
    }
}
add_action('wp_ajax_toggle_project_availability', 'toggle_project_availability');
// set default amenities
add_filter('acf/load_field/key=field_650a43f472389', 'pre_check_default_amenities');
function pre_check_default_amenities($field)
{
    if (is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'project' && !isset($_GET['post'])) {
        $default_amenities = get_field('default_amenities', 'option');
        if ($default_amenities) {
            $field['value'] = array_map(function ($amenity) {
                return $amenity->term_id;
            }, $default_amenities);
        }
    }
    return $field;
}
// mobile share
function mobile_share()
{
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shareToggleButton = document.getElementById('share-toggle-button');
            const shareButtons = document.getElementById('share-buttons');

            shareToggleButton.addEventListener('click', function() {
                if (shareButtons.style.display === 'none' || shareButtons.style.display === '') {
                    shareButtons.style.display = 'block';
                } else {
                    shareButtons.style.display = 'none';
                }
            });
        });
    </script>
<?php
}
add_action('wp_footer', 'mobile_share');
// gallery navigation
function gallery_navigation()
{
?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabButtons = document.querySelectorAll(".tab-button");
            const tabContents = document.querySelectorAll(".tab-content");
            tabButtons.forEach((button) => {
                button.addEventListener("click", function() {
                    tabButtons.forEach((btn) => btn.classList.remove("active"));
                    tabContents.forEach((content) => content.classList.remove("active"));
                    this.classList.add("active");
                    const target = document.querySelector(this.getAttribute("data-target"));
                    target.classList.add("active");
                });
            });
        });
    </script>

<?php
}
add_action('wp_footer', 'gallery_navigation');
// single project print
function project_template_redirect()
{
    if (is_singular('project') && isset($_GET['print']) && $_GET['print'] == 'true') {
        include(get_stylesheet_directory() . '/single-project-print.php');
        exit;
    }
}
add_action('template_redirect', 'project_template_redirect');
// unit type columns
function reorder_project_taxonomies_columns($columns, $taxonomy)
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
    return reorder_project_taxonomies_columns($columns, 'unit-type');
});
add_filter('manage_edit-place_columns', function ($columns) {
    return reorder_project_taxonomies_columns($columns, 'place');
});
function display_project_taxonomies_columns($content, $column_name, $term_id, $taxonomy)
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
    return display_project_taxonomies_columns($content, $column_name, $term_id, 'unit-type');
}, 10, 3);

add_filter('manage_place_custom_column', function ($content, $column_name, $term_id) {
    return display_project_taxonomies_columns($content, $column_name, $term_id, 'place');
}, 10, 3);
// Hide active filters button when there is no active filters
function custom_inline_styles()
{
    if (($_SERVER['REQUEST_URI'] === '/projects/' || $_SERVER['REQUEST_URI'] === '/projects')) {
        echo '<style>
            .active-filter-title {
                display:none !important;
            }
        </style>';
    }
}
add_action('wp_head', 'custom_inline_styles');
function update_auto_search_project_field($post_id, $post, $update)
{
    if ($post->post_type !== 'project') {
        return;
    }
    if (wp_is_post_revision($post_id)) {
        return;
    }
    $city = get_field('city', $post_id);
    $district = get_field('district', $post_id);
    $construction_companies = get_field('construction_companies', $post_id)->post_title;
    $project = get_the_title($post_id);
    if (!empty($project) && !empty($city) && !empty($district) && !empty($construction_companies)) {
        $auto_search_value = $project . ' by ' . $construction_companies . ' (' . $district->name . ', ' . $city->name . ')';
        update_post_meta($post_id, 'auto_search_project', $auto_search_value);
    } elseif (!empty($project) && !empty($city) && !empty($district)) {
        $auto_search_value = $project . ' (' . $district->name . ', ' . $city->name . ')';
        update_post_meta($post_id, 'auto_search_project', $auto_search_value);
    } elseif (!empty($project) && !empty($city)) {
        $auto_search_value = $project . ' (' . $city->name . ')';
        update_post_meta($post_id, 'auto_search_project', $auto_search_value);
    } elseif (!empty($project)) {
        $auto_search_value = $project;
        update_post_meta($post_id, 'auto_search_project', $auto_search_value);
    } elseif (!empty($construction_companies)) {
        $auto_search_value = $construction_companies;
        update_post_meta($post_id, 'auto_search_project', $auto_search_value);
    } else {
        update_post_meta($post_id, 'auto_search_project', '');
    }
}
add_action('save_post', 'update_auto_search_project_field', 10, 3);
