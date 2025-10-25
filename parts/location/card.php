<?php
$permalink = get_permalink(get_the_ID());
$location_default_image = get_field('location_default_image', 'option');
$featured_image = get_the_post_thumbnail(get_the_ID(), 'memberimage');
$country = get_field('country');
$city = get_field('city');
$district = get_field('district');
?>
<article id="location-<?php the_ID(); ?>" class="single-location-card">
    <?php $flag = get_field('flag', $country); ?>
    <img class="flag" src="<?php echo esc_url($flag); ?>" alt="<?php echo esc_html($country->slug) ?>">
    <a href="<?php echo $permalink; ?>" class="location-link">
        <div class="location-image">
            <?php
            if ($featured_image) : echo $featured_image;
            else : ?><img src="<?php echo $location_default_image; ?>" alt="location-without-image"><?php endif; ?>
        </div>
    </a>
    <a href="<?php echo $permalink; ?>" class="location-link">
        <h2 class="location-name"><?php echo get_the_title(); ?></h2>
    </a>
    <p class="location-address">
        <?php
        if ($city) : echo $city->name;
        endif;
        if ($district) : echo ', ' . $district->name;
        endif;
        ?>
    </p>
</article>