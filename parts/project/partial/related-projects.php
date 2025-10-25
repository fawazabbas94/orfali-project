<?php
$related_projects = get_field('related_projects');
if ($related_projects) : ?>
    <div class="related-projects rem-carousel">
        <h3 class="section-title"><?php echo __('Other projects that may interest you', 'REM') ?></h3>
        <h3 class="section-title mobile-title"><?php echo __('More projects...', 'REM') ?></h3>
        <div class="f-carousel" id="related-projects-carousel">
            <?php
            if ($related_projects === 'auto') :
                $fields = [
                    'project_status',
                    'project_type',
                    'district'
                ];
                foreach ($fields as $field) {
                    ${$field} = get_field($field);
                }
                function get_related_projects($district, $project_type, $project_status)
                {
                    global $post;
                    $current_post_id = $post->ID;
                    $args = array(
                        'post_type' => 'project',
                        'posts_per_page' => 8,
                        'post__not_in' => array($current_post_id),
                    );
                    $meta_query = array(
                        'relation' => 'AND',
                    );
                    $tax_query = array(
                        'relation' => 'AND',
                    );
                    if ($project_status) {
                        $tax_query[] = array(
                            'taxonomy' => 'project_status',
                            'field' => 'id',
                            'terms' => $project_status->term_id,
                        );
                    }
                    if ($project_type) {
                        $tax_query[] = array(
                            'taxonomy' => 'project_type',
                            'field' => 'id',
                            'terms' => wp_list_pluck($project_type, 'term_id'),
                            'operator' => 'AND',
                        );
                    }
                    if ($district) {
                        $tax_query[] = array(
                            'taxonomy' => 'district',
                            'field' => 'id',
                            'terms' => $district->term_id,
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
                                <?php get_template_part('parts/project/mini-card', get_post_format()); ?>
                            </div>
                        <?php
                        }
                    } else {
                        echo __('No related projects found.', 'REM');
                    }
                    wp_reset_postdata();
                }
                get_related_projects($district, $project_type, $project_status);
            elseif ($related_projects === 'custom') :
                $custom_related_projects = get_field('custom_related_projects');
                if ($custom_related_projects) :
                    foreach ($custom_related_projects as $project) : ?>
                        <div class="f-carousel__slide">
                            <?php get_template_part('parts/project/mini-card', get_post_format()); ?>
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