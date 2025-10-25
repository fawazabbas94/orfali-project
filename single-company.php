<?php
get_header();
$classes = '';
$style   = '';

if (woodmart_has_sidebar_in_page()) {
    $classes .= ' wd-grid-col';
    $style   .= ' style="' . woodmart_get_content_inline_style() . '"';
}
// $content_class = woodmart_get_content_class();
?>
<div class="site-content" role="main">
    <?php ?>
    <?php while (have_posts()) : the_post();
        get_template_part('parts/company/content', get_post_format());
    endwhile; ?>
</div>
<?php
get_footer();
?>