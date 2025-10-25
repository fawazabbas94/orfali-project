<?php
$permalink = get_permalink(get_the_ID());
$career_default_image = get_field('career_default_image', 'option');
$featured_image = get_the_post_thumbnail(get_the_ID(), 'memberimage');
$country = get_field('country')->name;
$city = get_field('city')->name; ?>
<article id="career-<?php the_ID(); ?>" class="single-career-card">
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
</article>