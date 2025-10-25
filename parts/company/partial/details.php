<div class="company-details">
    <?php
    $company_id = get_the_ID();
    $company_name = get_the_title();
    $about = get_field('about');
    $key_highlights_picture = get_field('key_highlights_picture');
    $secondary_about_section_title = get_field('secondary_about_section_title');
    $secondary_about_section_description = get_field('secondary_about_section_description');
    $secondary_about_section_image = get_field('secondary_about_section_image');
    ?>
    <div class="about">
        <h2><?php echo __('About', 'REM') . ' ' . $company_name; ?></h2>
        <p><?php echo $about; ?></p>
    </div>
    <?php if (have_rows('key_highlights')): ?>
        <div class="key-highlights details-section">
            <?php if ($key_highlights_picture) : ?>
                <div class="image">
                    <img src="<?php echo $key_highlights_picture; ?>">
                </div>
            <?php endif; ?>
            <div class="content">
                <?php
                $key_highlights_title = get_field('key_highlights_title');
                ?>
                <?php if ($key_highlights_title) : ?>
                    <h2 class="key-highlights-title"><?php echo $key_highlights_title; ?></h2>
                <?php else : ?>
                    <h2 class="key-highlights-title"><?php echo __('Key Highlights', 'REM'); ?></h2>
                <?php endif; ?>
                <div class="accordion">
                    <?php
                    while (have_rows('key_highlights')): the_row();
                        $title = get_sub_field('title');
                        $description = get_sub_field('description');
                    ?>
                        <div class="accordion-item">
                            <button id="accordion-button-<?php echo get_row_index(); ?>" aria-expanded="false">
                                <span class="accordion-title"><?php echo $title ?></span>
                                <span class="icon" aria-hidden="true"></span>
                            </button>
                            <div class="accordion-content">
                                <p><?php echo $description; ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php
    $args = array(
        'post_type' => 'project',
        'posts_per_page' => 8,
        'meta_query' => array(
            array(
                'key' => 'construction_companies',
                'value' => $company_id,
                'compare' => 'LIKE'
            )
        )
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) { ?>
        <div class="related-projects rem-carousel">
            <h3 class="section-title"><?php echo $company_name .  ' ' . __('Properties for sale', 'REM') ?></h3>
            <div class="f-carousel" id="related-projects-carousel">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                ?>
                    <div class="f-carousel__slide">
                        <?php get_template_part('parts/project/card', get_post_format()); ?>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    <?php
    } else {
        echo __('No projects found for this company.', 'REM');
    }
    wp_reset_postdata();
    ?>
    <div class="secondary-about details-section">
        <div class="content">
            <h2><?php echo $secondary_about_section_title; ?></h2>
            <p><?php echo $secondary_about_section_description; ?></p>
        </div>
        <div class="image">
            <?php if ($secondary_about_section_image) : ?>
                <img src="<?php echo $secondary_about_section_image; ?>">
            <?php endif; ?>
        </div>
    </div>
</div>