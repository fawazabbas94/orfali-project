<?php get_header(); ?>

<div class="archive-content">
    <div class="listings-container">
        <div class="archive-header">
            <h1><?php post_type_archive_title(); ?></h1>
            <div>
                <!-- <button class="active-filter-title"><span class="arrow down"></span></button> -->
                <?php echo facetwp_display('facet', 'sort_by'); ?>
            </div>
        </div>
        <div class="archive-active-filter">
            <?php echo facetwp_display('selections') ?>
        </div>
        <div id="listings" class="listings-area">
            <?php if (have_posts()) : while (have_posts()) : the_post();
                    get_template_part('parts/listing/card', get_post_format());
                endwhile;
            endif; ?>
        </div>
        <?php the_posts_pagination(); ?>
    </div>
</div>
<?php echo do_shortcode('[html_block id="8883"]'); ?>
<?php echo do_shortcode('[html_block id="8885"]'); ?>
<?php get_footer(); ?>