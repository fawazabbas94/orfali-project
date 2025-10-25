<?php
$unit_type_default_image = get_field('unit_type_default_image', 'option');
$terms = get_terms(array(
    'taxonomy' => 'unit-type',
    'hide_empty' => true,
));
if (!empty($terms) && !is_wp_error($terms)) { ?>
    <div class="types-carousel rem-carousel">
        <div class="f-carousel" id="types-carousel">
            <?php

            foreach ($terms as $term) {
                $query = new WP_Query(array(
                    'post_type' => 'project',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'unit-type',
                            'field'    => 'term_id',
                            'terms'    => $term->term_id,
                        ),
                    ),
                    'posts_per_page' => -1,
                ));
                $featured_image = get_field('featured_image', 'unit-type_' . $term->term_id);
                if (is_array($featured_image) && isset($featured_image['url'])) {
                    $featured_image_url = $featured_image['url'];
                } else {
                    $featured_image_url = $unit_type_default_image;
                }
            ?>
                <div class="f-carousel__slide single-card single-type-card" id="type-<?php echo $term->slug; ?>">
                    <div class="content-container">
                        <img class="type-image" src="<?php echo esc_url($featured_image_url) ?>" alt="<?php echo esc_attr($term->name) ?>">
                        <a class="type-content" href="<?php echo __('/projects/', 'REM') ?>?_type=<?php echo $term->slug; ?>">
                            <?php echo $term->name; ?>
                            <span class="type-projects-count"><?php echo $query->found_posts . '&nbsp;' . __('Projects', 'REM'); ?></span>
                        </a>
                    </div>
                </div>
            <?php
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
<?php
} else {
    echo __('No types found.', 'REM');
}
