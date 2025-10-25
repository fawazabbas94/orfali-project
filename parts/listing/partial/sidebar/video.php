<?php
$video_link = get_field('video_link');
$video_thumbnail = get_field('video_thumbnail');
if ($video_link) : ?>
    <div class="sidebar-widget video">
        <a data-fancybox="video" href="<?php echo esc_url($video_link); ?>">
            <img src="<?php echo esc_url($video_thumbnail); ?>" alt="<?php echo get_the_title(); ?>">
            <div class="overflow-video"></div>
        </a>
    </div>
<?php endif; ?>