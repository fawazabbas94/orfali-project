<?php
// register content scripts
function register_content_scripts()
{
    $styles = [
        'blog-card' => '/parts/blog-card.css',
        'single-post' => '/parts/single-post.css',
        'filter' => '/parts/filter.css',


        'company-card' => '/parts/company/card.css',
        'company-content' => '/parts/company/content.css',
        'company-header' => '/parts/company/partial/header.css',
        'company-content-details' => '/parts/company/partial/details.css',
        'company-contact' => '/parts/company/partial/contact.css',
        'company-payment' => '/parts/company/partial/payment.css',
        'company-type-card' => '/parts/company/type/card.css',


        'career-card' => '/parts/career/card.css',
        'career-content' => '/parts/career/content.css',
        'person-card' => '/parts/person/card.css',
        'person-content' => '/parts/person/content.css',
        'person-meta' => '/parts/person/meta.css',
        'person-type-card' => '/parts/person/type/card.css',

        'project-card' => '/parts/project/card.css',
        'project-mini-card' => '/parts/project/mini-card.css',
        'project-content' => '/parts/project/content.css',
        'project-header' => '/parts/project/partial/header.css',
        'project-content-overview' => '/parts/project/partial/overview.css',
        'project-gallery' => '/parts/project/partial/gallery.css',
        'project-content-details' => '/parts/project/partial/details.css',
        'project-payment' => '/parts/project/partial/payment.css',
        'project-contact' => '/parts/project/partial/contact.css',
        'project-related-projects' => '/parts/project/partial/related-projects.css',
        'project-where-next' => '/parts/project/partial/where-next.css',
        'project-type-card' => '/parts/project/type/card.css',
        'project-area-card' => '/parts/project/area/card.css',


        'listing-card' => '/parts/listing/card.css',
        'listing-carousel' => '/parts/listing/carousel.css',
        'listing-header-breadcrumb' => '/parts/listing/header/breadcrumb.css',
        'listing-header-gallery' => '/parts/listing/header/gallery.css',
        'listing-content' => '/parts/listing/content.css',
        'listing-content-amenities' => '/parts/listing/partial/amenities.css',
        'listing-content-details' => '/parts/listing/partial/details.css',
        'listing-content-intro' => '/parts/listing/partial/intro.css',
        'listing-content-location' => '/parts/listing/partial/location.css',
        'listing-content-mortgage-calculator' => '/parts/listing/partial/mortgage-calculator.css',
        'listing-content-overview' => '/parts/listing/partial/overview.css',
        'listing-content-related-listings' => '/parts/listing/partial/related-listings.css',
        'listing-content-sidebar' => '/parts/listing/partial/sidebar.css',
        'listing-content-useful-to-know' => '/parts/listing/partial/useful-to-know.css',
        'listing-sidebar-video' => '/parts/listing/partial/sidebar/video.css',
        'listing-sidebar-agent' => '/parts/listing/partial/sidebar/agent.css',
        'listing-sidebar-contact' => '/parts/listing/partial/sidebar/contact.css',
        'listing-type-card' => '/parts/listing/type/card.css',
        'testimonial-card' => '/parts/testimonial/card.css',
        'testimonial-content' => '/parts/testimonial/content.css',
        'location-card' => '/parts/location/card.css',
        'location-content' => '/parts/location/content.css',
        'pages-template-center-text' => '/css/template/center-text.css',
        'pages-template-details-row' => '/css/template/details-row.css',
        'pages-template-faqs-row' => '/css/template/faqs-row.css',
        'pages-template-hero' => '/css/template/hero.css',
        'pages-template-photo-text' => '/css/template/photo-text.css',
        'pages-template-text-photo' => '/css/template/text-photo.css',
        'pages-template-where-next' => '/css/template/where-next.css',
        'pages-template-category-index' => '/css/template/category-index.css',
        'pages-template-category-contact' => '/css/template/category-contact.css',
        'pages-template-images-carousel' => '/css/template/images-carousel.css',
        'pages-template-testimonials-row' => '/css/template/testimonials-row.css',
        'pages-template-videos-row' => '/css/template/videos-row.css',
        'pages-template-vacancies-row' => '/css/template/vacancies-row.css',
        'pages-template-icons-grid' => '/css/template/icons-grid.css',
        'pages-template-landing' => '/css/pages/landing.css',
        'pages-template-landing-project' => '/css/pages/landing-project.css',
        'pages-template-off-plan' => '/css/pages/off-plan.css',
        // pages
        'page-home' => '/css/pages/home.css',
        'page-contact' => '/css/pages/contact.css',
        'global' => '/css/global.css',
    ];
    foreach ($styles as $handle => $path) {
        wp_enqueue_style($handle, get_stylesheet_directory_uri() . $path, array(), woodmart_get_theme_info('Version'));
    }
    wp_enqueue_style('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
    wp_enqueue_script('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', array('jquery'), null, true);
    wp_enqueue_style('carousel', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.css');
    wp_enqueue_script('carousel', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.umd.js', array('jquery'), null, true);
    wp_enqueue_style('panzoom', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/panzoom/panzoom.css');
    wp_enqueue_script('panzoom', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/panzoom/panzoom.umd.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'register_content_scripts');
// register admin scripts
function register_admin_scripts()
{
    $admin_theme = get_field('admin_theme', 'option');
    wp_enqueue_script('row-action-icons', get_stylesheet_directory_uri() . '/js/row-action-icons.js', array('jquery'), null, true);
    wp_enqueue_style('admin-css', get_stylesheet_directory_uri() . '/css/admin.css');
    if ($admin_theme == 'lisco') :
        wp_enqueue_style('rem-theme', get_stylesheet_directory_uri() . '/css/rem-theme/main.css');
    endif;
}
add_action('admin_enqueue_scripts', 'register_admin_scripts');