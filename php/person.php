<?php
// person columns
function custom_person_columns($columns)
{
    $new_columns = array(
        'cb' => $columns['cb'],
        'featured_image' => __('Image'),
        'title' => __('Name'),
        'taxonomy-person_type' => __('Type'),
        'taxonomy-position' => __('Position'),
        'taxonomy-language' => __('Speaks'),
        'companies' => __('Works at'),
    );
    return $new_columns;
}
add_filter('manage_person_posts_columns', 'custom_person_columns');
function custom_person_column_content($column_name, $post_id)
{
    switch ($column_name) {
        case 'featured_image':
            $thumbnail = get_the_post_thumbnail($post_id, array(50, 50));
            echo $thumbnail ? $thumbnail : __('No Image');
            break;
        case 'companies':
            $companies = get_field('companies', $post_id);
            if ($companies) {
                $company_links = array();
                foreach ($companies as $company) {
                    $company_name = get_the_title($company->ID);
                    $company_link = get_post_permalink($company->ID);
                    $company_links[] = '<a target="_blank" href="' . esc_url($company_link) . '">' . esc_html($company_name) . '</a>';
                }
                echo implode(', ', $company_links);
            } else {
                echo __('No Companies Assigned');
            }
            break;
    }
}
add_action('manage_person_posts_custom_column', 'custom_person_column_content', 10, 2);
function custom_person_sortable_columns($columns)
{
    $columns['taxonomy-position'] = 'taxonomy-position';
    $columns['taxonomy-language'] = 'taxonomy-language';
    $columns['taxonomy-person_type'] = 'taxonomy-person_type';
    $columns['companies'] = 'companies';
    return $columns;
}
add_filter('manage_edit-person_sortable_columns', 'custom_person_sortable_columns');
// taxonomies columns
function reorder_language_columns($columns, $taxonomy)
{
    switch ($taxonomy) {
        case 'language':
            $new_columns = array(
                'cb' => $columns['cb'],
                'flag' => __('Flag'),
                'name' => __('Name'),
                'native_name' => __('Native Name'),
                'posts' => __('People'),
                'slug' => __('Slug'),
            );
            break;
    }
    return $new_columns;
}
add_filter('manage_edit-language_columns', function ($columns) {
    return reorder_language_columns($columns, 'language');
});
function display_language_columns($content, $column_name, $term_id, $taxonomy)
{
    switch ($taxonomy) {
        case 'language':
            if ($column_name === 'native_name') {
                $native_name = get_field('native_name', 'language_' . $term_id);
                $content = $native_name ? esc_html($native_name) : '-';
            } elseif ($column_name === 'flag') {
                $flag_url = get_field('flag', 'language_' . $term_id);
                if ($flag_url) {
                    $content = '<img src="' . esc_url($flag_url) . '" alt="Flag" style="max-width: 50px; height: auto;" />';
                } else {
                    $content = '-';
                }
            }
            break;
    }
    return $content;
}
add_action('manage_language_custom_column', function ($content, $column_name, $term_id) {
    return display_language_columns($content, $column_name, $term_id, 'language');
}, 10, 3);
