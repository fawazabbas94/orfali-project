<?php get_header(); ?>

<div class="archive-content">
    <div class="carrers-container">
        <div class="archive-header">
            <h1><?php post_type_archive_title(); ?></h1>
        </div>
        <div id="carrers" class="careers-grid">
            <?php if (have_posts()) : while (have_posts()) : the_post();
                    get_template_part('parts/career/card', get_post_format());
                endwhile;
            endif; ?>
        </div>
        <?php the_posts_pagination(); ?>
    </div>
</div>
<?php get_footer(); ?>