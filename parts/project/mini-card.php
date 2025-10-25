<?php
$project_default_image = get_field('project_default_image', 'option');
$project_title = get_the_title($post->ID);
$project_permalink = get_permalink($post->ID);
$featured_image = get_the_post_thumbnail($post->ID, 'projectfeaturedimage');
$project_availability = get_field('project_availability', $post->ID);
$construction_companies = get_field('construction_companies');
if ($construction_companies) :
    $construction_companies_title = $construction_companies->post_title;
endif;
?>
<article id="project-<?php the_ID(); ?>" class="single-card single-project-card <?php if ($project_availability === 'sold_out') : echo 'sold-out';
                                                                                endif; ?>">
    <div class="project-image">
        <a href="<?php echo esc_url($project_permalink); ?>">
            <?php
            if ($featured_image) : echo $featured_image;
            else : ?>
                <img src="<?php echo $project_default_image; ?>" alt="">
            <?php endif;
            ?>
        </a>
    </div>
    <div class="project-meta">
        <a class="project-title" href="<?php echo esc_url($project_permalink); ?>"><?php echo esc_html($project_title); ?></a>
        <?php if ($construction_companies_title) : ?>
            <p class="construction-companies">
                <?php echo __('by ', 'REM') . esc_html($construction_companies_title); ?>
            </p>
        <?php endif; ?>
    </div>
</article>