<?php $photos = get_field('photos');
$video_link = get_field('video_link');
?>
<div class="single-listing-gallery" style="<?php if (empty($photos)) : echo 'margin-block-end:0 !important';
                                            endif; ?>">
    <?php if ($photos) : ?>
        <div class="f-carousel" id="single-listing-gallery">
            <?php foreach ($photos as $photo) : ?>
                <div class="f-carousel__slide">
                    <a href="<?php echo esc_url($photo['url']); ?>" data-fancybox="single-listing-gallery" data-caption="<?php echo esc_attr($photo['alt']); ?>">
                        <img class="slide-single-photo" src="<?php echo esc_url($photo['sizes']['slider']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>" />
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="buttons">
        <?php if ($video_link) : ?>
            <a class="video" target="_blank" href="<?php echo esc_url($video_link); ?>"><?php echo __('Watch Video', 'REM'); ?></a>
        <?php endif; ?>
    </div>
</div>