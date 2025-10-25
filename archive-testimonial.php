<?php get_header(); ?>

<div class="archive-content">
    <div class="testimonials-container">
        <div class="archive-header">
            <h1><?php post_type_archive_title(); ?></h1>
        </div>
        <div id="testimonials" class="testimonials-grid">
            <?php if (have_posts()) : while (have_posts()) : the_post();
                    get_template_part('parts/testimonial/card', get_post_format());
                endwhile;
            endif; ?>
        </div>
        <?php the_posts_pagination(); ?>
    </div>
</div>
<?php get_footer(); ?>