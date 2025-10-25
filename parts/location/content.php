<?php
$location_id = get_the_ID();
$country = get_field('country');
$city = get_field('city');
$district = get_field('district');
$location_on_map = get_field('location_on_map');
$icon = get_field('icon');
$photos = get_field('photos');
$overview = get_the_content();
?>
<article id="location-<?php the_ID(); ?>" class="location-<?php the_ID(); ?> location">
    <div class="location-inner">
        <div class="location-section about">
            <div class="location-information">
                <h1 class="location-name"><?php the_title(); ?></h1>
                <div class="address">
                    <h3><?php echo __('Address', 'REM') ?></h3>
                    <p>
                        <?php
                        if ($district) : echo $district->name . ', ';
                        endif;
                        if ($city) : echo $city->name . ', ';
                        endif;
                        if ($country) : echo $country->name;
                        endif;
                        ?>
                    </p>
                </div>
                <?php if ($overview) : ?>
                    <div class="overview">
                        <h3><?php echo __('Overview', 'REM') ?></h3>
                        <p><?php echo $overview; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="location-map">
                <?php
                if ($location_on_map) : ?>
                    <div class="google-map">
                        <div class="acf-map" data-zoom="16">
                            <div class="marker" data-lat="<?php echo esc_attr($location_on_map['lat']); ?>" data-lng="<?php echo esc_attr($location_on_map['lng']); ?>"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div id="gallery" class="gallery">
            <?php
            if ($photos) : ?>
                <div id="slider">
                    <div class="f-carousel" id="photos-gallery"> 
                        <?php foreach ($photos as $photo) :
                        ?>
                            <div class="f-carousel__slide">
                                <a href="<?php echo esc_url($photo['url']); ?>" data-fancybox="gallery-photos" data-caption="<?php echo esc_attr($photo['alt']); ?>">
                                    <img class="slide-single-photo" src="<?php echo esc_url($photo['sizes']['slider']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>" />
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="overlooking-listings">
            <h2 class="listings-title"><?php echo __('Listings overlooking', 'REM'); ?> <?php the_title(); ?></h2>
            <?php
            if ($location_id) {
                $args = array(
                    'post_type' => 'listing',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => 'listing_view',
                            'value' => '"' . $location_id . '"',
                            'compare' => 'IN'
                        )
                    )
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) { ?>
                    <div id="listings" class="listings-area">
                        <?php
                        while ($query->have_posts()) {
                            $query->the_post();
                            get_template_part('parts/listing/card', get_post_format());
                        } ?>
                    </div>
            <?php
                } else {
                    echo __('No listings found.', 'REM');
                }
                wp_reset_postdata();
            } else {
                echo __('No valid location ID found.', 'REM');
            }
            ?>
        </div>
    </div>
</article>