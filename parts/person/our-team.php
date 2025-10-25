<?php
$args = array(
    'post_type' => 'person',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'key' => 'person_type',
            'value' => 'member',
            'compare' => '='
        )
    )
);
$query = new WP_Query($args);
if ($query->have_posts()) { ?>
    <div id="people" class="people-grid">
        <?php
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('parts/person/card', get_post_format());
        } ?>
    </div>
<?php
    wp_reset_postdata();
} else {
    echo __('No people found.', 'REM');
}
?>