<?php
function woodmart_child_enqueue_styles()
{
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('woodmart-style'), woodmart_get_theme_info('Version'));
}
add_action('wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10010);

// router functions
require_once get_stylesheet_directory() . '/php/router.php';
// admin functions
require_once get_stylesheet_directory() . '/php/admin.php';
// REM functions
require_once get_stylesheet_directory() . '/php/rem-functions.php';
// company functions
require_once get_stylesheet_directory() . '/php/company.php';
// location functions
require_once get_stylesheet_directory() . '/php/location.php';
// person functions
require_once get_stylesheet_directory() . '/php/person.php';
// project functions
require_once get_stylesheet_directory() . '/php/project.php';
// listing functions
require_once get_stylesheet_directory() . '/php/listing.php';
// testimonial functions
require_once get_stylesheet_directory() . '/php/testimonial.php';
// Location dropdowns
require_once get_stylesheet_directory() . '/php/location-dropdowns.php';
// mortgage calculator functions
function load_mortgage_calculator()
{
    if (is_singular('listing')) {
        require_once get_stylesheet_directory() . '/php/mortgage-calculator.php';
    }
}
add_action('template_redirect', 'load_mortgage_calculator');

// Get the query parameters from the current URL
$current_query = $_SERVER['QUERY_STRING'];
$css_class = "";
if (strpos($current_query, '_country=uae') !== false || strpos($current_query, '_city=dubai') !== false || strpos($current_query, '_p_country=uae') !== false || strpos($current_query, '_p_city=dubai') !== false) {
    $css_class = "uae";
} elseif (strpos($current_query, '_country=turkiye') !== false || strpos($current_query, '_city=istanbul') !== false || strpos($current_query, '_p_country=turkiye') !== false || strpos($current_query, '_p_city=istanbul') !== false) {
    $css_class = "turkiye";
}

// Add the class to the body
add_filter('body_class', function ($classes) use ($css_class) {
    $classes[] = $css_class;
    return $classes;
});
function add_country_slug_to_body_class($classes)
{
    global $post;
    $custom_post_types = ['career', 'company', 'listing', 'location', 'person', 'project', 'testimonial'];
    if (is_singular($custom_post_types)) {
        $country = get_field('country', $post->ID);
        if ($country) {
            $country_slug = $country->slug;
            $classes[] =  sanitize_html_class($country_slug);
        }
    }
    return $classes;
}
add_filter('body_class', 'add_country_slug_to_body_class');
