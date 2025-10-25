<?php
$country = isset($atts['country']) ? $atts['country'] : '';
$city = isset($atts['city']) ? $atts['city'] : '';
$type = isset($atts['type']) ? $atts['type'] : '';
$tag = isset($atts['tag']) ? $atts['tag'] : '';
$args = array(
    'post_type'      => 'project',
    'posts_per_page' => -1,
);
$tax_query = array_filter(array(
    'relation' => 'AND',
    !empty($country) ? array(
        'taxonomy' => 'country',
        'field'    => 'slug',
        'terms'    => $country,
    ) : null,
    !empty($city) ? array(
        'taxonomy' => 'city',
        'field'    => 'slug',
        'terms'    => $city,
    ) : null,
    !empty($type) ? array(
        'taxonomy' => 'listing_type',
        'field'    => 'slug',
        'terms'    => $type,
    ) : null,
    !empty($tag) ? array(
        'taxonomy' => 'listing_tag',
        'field'    => 'slug',
        'terms'    => $tag,
    ) : null,
));
if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
}
$query = new WP_Query($args);

if ($query->have_posts()) { ?>
    <div class="related-projects-carousel rem-carousel">
        <div class="f-carousel" id="<?php echo $tag ?>">
            <?php while ($query->have_posts()) {
                $query->the_post(); ?>
                <div class="f-carousel__slide" id="project-<?php echo esc_attr(get_post_field('post_name', get_the_ID())); ?>">
                    <?php get_template_part('parts/project/card', get_post_format()); ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php
    wp_reset_postdata();
} else {
    echo __('No projects found for the selected criteria.', 'REM');
}

?>

<style>
    
    /* CSS to achieve partial slide view on mobile */
    .related-projects-carousel .f-carousel {
        /* Add padding to the right to show partial next slide */
        padding-right: 15%;
    }

    .related-projects-carousel .f-carousel__slide {
        /* Add gap between slides */
        padding-right: 16px;
    }

    /* Adjust container to prevent horizontal scrolling */
    .related-projects-carousel .f-carousel__container {
        overflow: hidden;
    }

    /* Mobile-specific adjustments */
    @media (max-width: 639px) {
        .related-projects-carousel .f-carousel__viewport {
            /* Ensure overflow is visible for the peek effect */
            overflow: visible;
        }

        .related-projects-carousel .f-carousel {
            padding-right: 15%;
        }

        .related-projects-carousel .f-carousel__slide {
            padding-right: 12px;
        }
    }

    /* Reset padding for larger screens */
    @media (min-width: 640px) {
        .related-projects-carousel .f-carousel {
            padding-right: 0;
        }
    }
</style>