<?php
$listing_availability = get_field('listing_availability');
?>
<article id="listing-<?php the_ID(); ?>" class="listing-<?php the_ID(); ?> listing <?php echo $listing_availability == 'sold_out' ? 'sold-out' : 'available'; ?>
">
    <?php get_template_part('parts/listing/header/gallery', get_post_format()); ?>
    <div class="listing-inner">
        <?php get_template_part('parts/listing/partial/intro', get_post_format()); ?>
        <?php get_template_part('parts/listing/partial/details', get_post_format()); ?>
        <?php get_template_part('parts/listing/partial/overview', get_post_format()); ?>
        <?php get_template_part('parts/listing/partial/amenities', get_post_format()); ?>
        <?php get_template_part('parts/listing/partial/location', get_post_format()); ?>
        <?php get_template_part('parts/listing/partial/mortgage-calculator', get_post_format()); ?>
        <?php get_template_part('parts/listing/partial/useful-to-know', get_post_format()); ?>
    </div>
</article><!-- #post -->
<?php
