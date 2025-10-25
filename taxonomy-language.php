<?php
get_header();
?>
<div class="container">
    <h1><?php echo __('People who speaks', 'REM') . ' '; ?><?php single_term_title(); ?></h1>
    <?php
    $term = get_queried_object();
    $args = array(
        'post_type' => 'person',
        'tax_query' => array(
            array(
                'taxonomy' => 'language',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ),
        ),
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
    } else {
        echo __('No people found who speak this language.', 'REM');
    }
    wp_reset_postdata();
    ?>
</div>
<?php
get_footer();
