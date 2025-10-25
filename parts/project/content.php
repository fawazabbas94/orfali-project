<?php
$project_availability = get_field('project_availability');
?>
<article id="project-<?php the_ID(); ?>" class="project-<?php the_ID(); ?> project <?php echo $project_availability == 'sold_out' ? 'sold-out' : 'available'; ?>
">
    <?php get_template_part('parts/project/partial/header', get_post_format()); ?>
    <div class="project-inner">
        <?php get_template_part('parts/listing/header/breadcrumb', get_post_format()); ?>
        <?php get_template_part('parts/project/partial/overview', get_post_format()); ?>
        <?php get_template_part('parts/project/partial/gallery', get_post_format()); ?>
        <?php get_template_part('parts/project/partial/details', get_post_format()); ?>
        <?php get_template_part('parts/project/partial/payment', get_post_format()); ?>
        <?php get_template_part('parts/project/partial/contact', get_post_format()); ?>
        <?php get_template_part('parts/project/partial/related-projects', get_post_format()); ?>
        <?php get_template_part('parts/project/partial/where-next', get_post_format()); ?>
    </div>
</article><!-- #post -->
<?php
