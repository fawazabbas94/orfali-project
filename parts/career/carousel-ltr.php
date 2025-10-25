<div class="rem-carousel">
    <?php
    $career_default_image = get_field('career_default_image', 'option');
    $args = array(
        'post_type' => 'career',
        'posts_per_page' => 9,
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
    ?>
        <div class="f-carousel" id="careers-carousel">
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                $featured_image = get_the_post_thumbnail(get_the_ID(), 'careerfeaturedimage');
                $permalink = get_permalink(get_the_ID());
                $country = get_field('country')->name;
                $city = get_field('city')->name;
            ?>
                <div class="f-carousel__slide single-card single-career-card" id="career-<?php the_ID(); ?>">
                    <a href="<?php echo $permalink; ?>" class="career-link">
                        <div class="career-logo">
                            <?php
                            if ($featured_image) : echo $featured_image;
                            else : ?><img src="<?php echo $career_default_image; ?>" alt="career-without-logo"><?php endif; ?>
                        </div>
                    </a>
                    <div class="vacancy-information">
                        <a href="<?php echo $permalink; ?>" class="career-link">
                            <h2 class="career-name"><?php echo get_the_title(); ?></h2>
                        </a>
                        <div class="vacancy-location">
                            <span class="location-icon"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/pin.svg" alt="location"></span>
                            <span class="location-text"><?php echo $city . ', ' . $country; ?></span>
                        </div>
                    </div>
                </div>
            <?php
            } ?>
        </div>
    <?php
        wp_reset_postdata();
    } else {
        echo __('No careers found.', 'REM');
    }
    ?>
</div>