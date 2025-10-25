<?php
$featured_image = get_the_post_thumbnail_url();
$construction_companies = get_field('construction_companies');
?>
<div class="header-section" style="background-image: url('<?php echo $featured_image; ?>');">
    <div class="overlay">
        <div class="project-header">
            <h1 class="project-name">
                <?php the_title(); ?>
            </h1>
            <?php
            if ($construction_companies) :
                $permalink = get_permalink($construction_companies->ID);
            ?>
                <a class="construction-company" href="<?php echo $permalink ?>"><?php echo __('By', 'REM') . ' ' . $construction_companies->post_title; ?></a>
            <?php
            endif;
            ?>
            <div class="header-buttons">
                <a href="#contact" class="contact button"><?php echo __('Register Interest', 'REM'); ?></a>
                <a href="#pdf" class="pdf button"><?php echo __('Download Brochure', 'REM'); ?></a>
            </div>
        </div>
    </div>
</div>