<?php
$country = isset($atts['country']) ? $atts['country'] : '';
$position = isset($atts['position']) ? $atts['position'] : '';
$person_query_args = array(
    'post_type'      => 'person',
    'posts_per_page' => -1,
    'tax_query'      => array(
        'relation' => 'AND',
        !empty($country) ? array(
            'taxonomy' => 'country',
            'field'    => 'slug',
            'terms'    => $country,
        ) : null,
        !empty($position) ? array(
            'taxonomy' => 'position',
            'field'    => 'slug',
            'terms'    => $position,
        ) : null,
    ),
);
$person_query_args['tax_query'] = array_filter($person_query_args['tax_query']);
$people = new WP_Query($person_query_args);
if ($people->have_posts()) { ?>
    <div class="people-carousel rem-carousel">
        <div class="f-carousel" id="people-carousel">
            <?php while ($people->have_posts()) {
                $people->the_post();
                $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $featured_image_url = $featured_image ? $featured_image : 'path/to/default/image.jpg';
            ?>
                <div class="f-carousel__slide single-card single-person-card" id="person-<?php echo esc_attr(get_post_field('post_name', get_the_ID())); ?>">
                    <a class="content-container" href="<?php echo esc_url(get_permalink()); ?>">
                        <img class="person-image" src="<?php echo esc_url($featured_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        <div class="person-content">
                            <h3 class="person-name">
                                <?php echo esc_html(get_the_title()); ?>
                            </h3>
                            <p class="person-position">
                                <?php
                                $positions = get_the_terms(get_the_ID(), 'position');
                                if ($positions && !is_wp_error($positions)) {
                                    $position_names = array();
                                    foreach ($positions as $position) {
                                        $position_names[] = $position->name;
                                    }
                                    echo  esc_html(implode(' - ', $position_names));
                                }
                                ?>
                            </p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php
} else {
    echo __('No people found for the selected criteria.', 'REM');
}
wp_reset_postdata();
?>