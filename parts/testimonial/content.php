<?php
$testimonial_id = get_the_ID();
$testimonial_image = get_the_post_thumbnail($testimonial_id, 'memberimage');
$testimonial_default_image = get_field('testimonial_default_image', 'option');
$overview = get_the_content();
?>
<article id="testimonial-<?php the_ID(); ?>" class="testimonial-<?php the_ID(); ?> testimonial">
    <div class="testimonial-inner">
        <div class="testimonial-section">
            <div class="testimonial-information">
                <h1 class="testimonial-name"><?php the_title(); ?></h1>
                <?php if ($overview) : ?>
                    <div class="overview">
                        <h3><?php echo __('Said about us:', 'REM'); ?></h3>
                        <p><?php echo $overview; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="testimonial-image">
                <?php
                if ($testimonial_image) : echo $testimonial_image;
                else : ?><img src="<?php echo $testimonial_default_image; ?>" alt="testimonial-without-image"><?php endif; ?>
            </div>
        </div>
    </div>
</article><!-- #post -->
<?php
