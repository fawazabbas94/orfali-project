<div class="rem-carousel">
    <?php
    $country = isset($atts['country']) ? $atts['country'] : '';
    $type = isset($atts['type']) ? $atts['type'] : '';
    $args = array(
        'post_type'      => 'testimonial',
        'posts_per_page' => 9,
        'tax_query'      => array(
            'relation' => 'AND',
            !empty($country) ? array(
                'taxonomy' => 'country',
                'field'    => 'slug',
                'terms'    => $country,
            ) : null,
            !empty($type) ? array(
                'taxonomy' => 'listing_type',
                'field'    => 'slug',
                'terms'    => $type,
            ) : null,
        ),
    );
    $args['tax_query'] = array_filter($args['tax_query']);
    $query = new WP_Query($args);
    if ($query->have_posts()) {
    ?>
        <div class="f-carousel" id="testimonials-carousel">
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                $permalink = get_permalink(get_the_ID());
            ?>
                <div class="f-carousel__slide" id="testimonial-<?php the_ID(); ?>">
                    <?php
                    get_template_part('parts/testimonial/card', get_post_format());
                    ?>
                </div>
            <?php
            } ?>
        </div>
    <?php
        wp_reset_postdata();
    } else {
        echo __('No testimonials found.', 'REM');
    }
    ?>
</div>