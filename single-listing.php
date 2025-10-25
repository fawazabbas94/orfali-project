<?php
get_header();

$classes = '';
$style   = '';

if (woodmart_has_sidebar_in_page()) {
    $classes .= ' wd-grid-col';
    $style   .= ' style="' . woodmart_get_content_inline_style() . '"';
}
// $content_class = woodmart_get_content_class();
$country = get_query_var('country');
$city = get_query_var('city');
$district = get_query_var('district'); ?>
<?php
get_template_part('parts/listing/header/breadcrumb', get_post_format());
?>
<div class="site-content" <?php echo wp_kses($style, true); ?> role="main">
    <?php ?>
    <?php while (have_posts()) : the_post();
        get_template_part('parts/listing/content', get_post_format());
    endwhile; ?>
</div>
<?php get_template_part('parts/listing/partial/sidebar', get_post_format());
get_template_part('parts/listing/partial/related-listings', get_post_format());
get_footer();
?>