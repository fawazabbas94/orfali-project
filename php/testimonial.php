<?php
// testimonial columns
add_filter('manage_testimonial_posts_columns', 'testimonial_custom_columns');
function testimonial_custom_columns($columns)
{
    $new_columns = [];
    $new_columns['cb'] = $columns['cb'];
    $new_columns['featured_image'] = __('Photo');
    $new_columns['title'] = __('Name');
    $new_columns['date'] = __('Date');
    return $new_columns;
}
add_action('manage_testimonial_posts_custom_column', 'testimonial_custom_column', 10, 2);
function testimonial_custom_column($column, $post_id)
{
    if ($column == 'featured_image') {
        $post_thumbnail_id = get_post_thumbnail_id($post_id);
        if ($post_thumbnail_id) {
            $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');
            echo '<img src="' . $post_thumbnail_img[0] . '" width="50" height="50" />';
        } else {
            echo 'No Image';
        }
    }
}
add_filter('manage_edit-testimonial_sortable_columns', 'testimonial_sortable_columns');
function testimonial_sortable_columns($columns)
{
    $columns['featured_image'] = 'featured_image';
    return $columns;
}
