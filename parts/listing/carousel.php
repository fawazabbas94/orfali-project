<?php
$country = isset($atts['country']) ? $atts['country'] : '';
$city = isset($atts['city']) ? $atts['city'] : '';
$tag = isset($atts['tag']) ? $atts['tag'] : '';
?>
<div class="related-listings rem-carousel">
    <div class="f-carousel" id="<?php echo $tag?>">
        <?php
        function get_related_listings($country, $city)
        {
            global $post;
            $current_post_id = $post->ID;
            $args = array(
                'post_type'      => 'listing',
                'posts_per_page' => 8,
                'post__not_in'   => array($current_post_id),
            );
            $tax_query = array('relation' => 'AND');
            if (!empty($country)) {
                $tax_query[] = array(
                    'taxonomy' => 'country',
                    'field'    => 'slug',
                    'terms'    => $country,
                );
            }
            if (!empty($city)) {
                $tax_query[] = array(
                    'taxonomy' => 'city',
                    'field'    => 'slug',
                    'terms'    => $city,
                );
            }
            if (!empty($tag)) {
                $tax_query[] = array(
                    'taxonomy' => 'tag',
                    'field'    => 'slug',
                    'terms'    => $tag,
                );
            }
            if (count($tax_query) > 1) {
                $args['tax_query'] = $tax_query;
            }
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post(); ?>
                    <div class="f-carousel__slide">
                        <?php get_template_part('parts/listing/card', get_post_format()); ?>
                    </div>
        <?php
                }
            } else {
                echo __('No related listings found.', 'REM');
            }
            wp_reset_postdata();
        }
        get_related_listings($country, $city);
        ?>
    </div>
</div>

<style>
    /* CSS to achieve partial slide view on mobile */
    .related-listings
.f-carousel {
    /* Add padding to the right to show partial next slide */
    padding-right: 15%;
}
.related-listings
.f-carousel__slide {
    /* Add gap between slides */
    padding-right: 16px;
}

/* Adjust container to prevent horizontal scrolling */
.related-listings
.f-carousel__container {
    overflow: hidden;
}

/* Mobile-specific adjustments */
@media (max-width: 639px) {
    .related-listings
.f-carousel__viewport {
    /* Ensure overflow is visible for the peek effect */
    overflow: visible;
}
    .related-listings
    .f-carousel {
        padding-right: 15%;
    }
    .related-listings
    .f-carousel__slide {
        padding-right: 12px;
    }
}

/* Reset padding for larger screens */
@media (min-width: 640px) {
    .related-listings
    .f-carousel {
        padding-right: 0;
    }
}
</style>