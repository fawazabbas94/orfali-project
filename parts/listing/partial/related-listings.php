<?php
$related_listings = get_field('related_listings');
if ($related_listings) : ?>
    <div class="related-listings rem-carousel">
        <h3 class="section-title"><?php echo __('Other listings that may interest you', 'REM') ?></h3>
        <h3 class="section-title mobile-title"><?php echo __('More listings...', 'REM') ?></h3>
        <div class="f-carousel" id="related-listings-carousel">
            <?php
            if ($related_listings === 'auto') :
                $fields = [
                    'title_deed_status', 'title_deed_type', 'listing_status', 'listing_type', 'country'
                ];
                foreach ($fields as $field) {
                    ${$field} = get_query_var($field);
                }
                function get_related_listings($country, $listing_type, $listing_status, $title_deed_type, $title_deed_status)
                {
                    global $post;
                    $current_post_id = $post->ID;
                    $args = array(
                        'post_type' => 'listing',
                        'posts_per_page' => 8,
                        'post__not_in' => array($current_post_id),
                    );
                    $meta_query = array(
                        'relation' => 'AND',
                    );
                    $tax_query = array(
                        'relation' => 'AND',
                    );
                    if ($title_deed_status) {
                        $meta_query[] = array(
                            'key' => 'title_deed_status',
                            'value' => $title_deed_status,
                            'compare' => '=',
                        );
                    }
                    if ($title_deed_type) {
                        $meta_query[] = array(
                            'key' => 'title_deed_type',
                            'value' => $title_deed_type,
                            'compare' => '=',
                        );
                    }
                    if ($listing_status) {
                        $tax_query[] = array(
                            'taxonomy' => 'listing_status',
                            'field' => 'id',
                            'terms' => $listing_status->term_id,
                        );
                    }
                    if ($listing_type) {
                        $tax_query[] = array(
                            'taxonomy' => 'listing_type',
                            'field' => 'id',
                            'terms' => wp_list_pluck($listing_type, 'term_id'),
                            'operator' => 'AND',
                        );
                    }
                    if ($country) {
                        $tax_query[] = array(
                            'taxonomy' => 'country',
                            'field' => 'id',
                            'terms' => $country->term_id,
                        );
                    }
                    $args['meta_query'] = $meta_query;
                    $args['tax_query'] = $tax_query;
                    $query = new WP_Query($args);
                    if (!$query->have_posts()) {
                        if (isset($meta_query[0])) {
                            unset($meta_query[0]);
                            $args['meta_query'] = $meta_query;
                            $query = new WP_Query($args);
                        }
                        if (!$query->have_posts() && isset($meta_query[1])) {
                            unset($meta_query[1]);
                            $args['meta_query'] = $meta_query;
                            $query = new WP_Query($args);
                        }
                        if (!$query->have_posts() && isset($tax_query[2])) {
                            unset($tax_query[2]);
                            $args['tax_query'] = $tax_query;
                            $query = new WP_Query($args);
                        }
                        if (!$query->have_posts() && isset($tax_query[1])) {
                            unset($tax_query[1]);
                            $args['tax_query'] = $tax_query;
                            $query = new WP_Query($args);
                        }
                        if (!$query->have_posts() && isset($tax_query[0])) {
                            unset($tax_query[0]);
                            $args['tax_query'] = $tax_query;
                            $query = new WP_Query($args);
                        }
                    }
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
                get_related_listings($country, $listing_type, $listing_status, $title_deed_type, $title_deed_status);
            elseif ($related_listings === 'custom') :
                $custom_related_listings = get_field('custom_related_listings');
                if ($custom_related_listings) :
                    foreach ($custom_related_listings as $listing) : ?>
                        <div class="f-carousel__slide">
                            <?php get_template_part('parts/listing/card', get_post_format()); ?>
                        </div>
            <?php
                    endforeach;
                endif;
            endif; ?>
        </div>
    </div>
<?php
endif;
?>