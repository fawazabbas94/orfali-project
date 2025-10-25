<?php
// prevent default company deletion
function prevent_deletion_of_default_company_post($post_id)
{
    $default_post_id = get_field('default_company', 'option');
    if ($post_id == $default_post_id) {
        add_action('admin_notices', 'default_company_post_deletion_notice');
        wp_redirect(admin_url('edit.php?post_type=company'));
        exit;
    }
}
function default_company_post_deletion_notice()
{
?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e('You cannot delete the default company post.', 'REM'); ?></p>
    </div>
<?php
}
add_action('wp_trash_post', 'prevent_deletion_of_default_company_post');
add_action('before_delete_post', 'prevent_deletion_of_default_company_post');
// custom company columns
function custom_company_columns($columns)
{
    $new_columns = array(
        'cb' => $columns['cb'],
        'featured_image' => __('Logo', 'REM'),
        'title' => __('Name', 'REM'),
        'taxonomy-company_type' => $columns['taxonomy-company_type'],
        'contact_info' => __('Contact Information', 'REM'),
        'counts' => __('Counts', 'REM'),
    );
    return $new_columns;
}
add_filter('manage_company_posts_columns', 'custom_company_columns');
function custom_company_column_data($column, $post_id)
{
    switch ($column) {
        case 'featured_image':
            $thumbnail_id = get_post_thumbnail_id($post_id);
            if ($thumbnail_id) {
                $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'thumbnail')[0];
                echo '<img src="' . esc_url($thumbnail_url) . '" style="max-width: 50px; height: auto;" />';
            } else {
                echo '-';
            }
            break;
        case 'contact_info':
            $email_address = get_field('email_address', $post_id);
            $website = get_field('website', $post_id);
            $phone_group = get_field('phone', $post_id);
            $phone_number = $phone_group['phone_number'];
            if ($email_address) {
                echo '<div><a href="mailto:' . esc_html($email_address) . '">' . esc_html($email_address) . '</a>';
            }
            if ($website) {
                $display_website = preg_replace('#^https?://#', '', $website);
                echo '<div><a href="' . esc_url($website) . '" target="_blank">' . esc_html($display_website) . '</a>';
            }
            if ($phone_number) {
                echo '<div><a href="tel:' . esc_html($phone_number) . '">+' . esc_html($phone_number) . '</a> ';
            }
            break;
        case 'counts':
            $projects_count = 0;
            $projects_args = array(
                'post_type' => 'project',
                'posts_per_page' => -1,
            );
            $projects = new WP_Query($projects_args);
            if ($projects->have_posts()) {
                while ($projects->have_posts()) {
                    $projects->the_post();
                    $companies = get_field('construction_companies', get_the_ID());
                    if (!empty($companies)) {
                        foreach ($companies as $company) {
                            if ($company === $post_id) {
                                $projects_count++;
                                break;
                            }
                        }
                    }
                }
                wp_reset_postdata();
            }
            $people_count = 0;
            $people_args = array(
                'post_type' => 'person',
                'posts_per_page' => -1,
            );
            $people = new WP_Query($people_args);
            if ($people->have_posts()) {
                while ($people->have_posts()) {
                    $people->the_post();
                    $companies = get_field('companies', get_the_ID());
                    if (!empty($companies) && is_array($companies)) {
                        foreach ($companies as $company) {
                            if ($company->ID === $post_id) {
                                $people_count++;
                                break;
                            }
                        }
                    }
                }
                wp_reset_postdata();
            }
            echo $projects_count . ' Projects<br>' . $people_count . ' People';
            break;
    }
}
add_action('manage_company_posts_custom_column', 'custom_company_column_data', 10, 2);
function custom_company_sortable_columns($columns)
{
    $columns['taxonomy-company_type'] = 'taxonomy-company_type';
    return $columns;
}
add_filter('manage_edit-company_sortable_columns', 'custom_company_sortable_columns');
