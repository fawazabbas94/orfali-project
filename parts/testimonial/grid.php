<div id="testimonials" class="testimonials-grid">
    <?php
    $args = array(
        'post_type' => 'testimonial',
        'posts_per_page' => -1,
    );
    $query = new WP_Query($args);
    $testimonial_default_image = get_field('testimonial_default_image', 'option');
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $featured_image = get_the_post_thumbnail(get_the_ID(), 'testimonialfeaturedimage');
            get_template_part('parts/testimonial/card', get_post_format());
        }
        wp_reset_postdata();
    } else {
        echo __('No testimonials found.', 'REM');
    }
    ?>
</div>