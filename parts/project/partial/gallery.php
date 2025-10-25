<div class="rem-carousel single-project-gallery-carousel">
    <?php
    $project_default_image = get_field('project_default_image', 'option');
    $photos = get_field('photos');
    if ($photos) : ?>
        <div class="f-carousel" id="project-gallery-carousel">
            <?php foreach ($photos as $photo) : ?>
                <div class="f-carousel__slide single-card single-project-gallery-card">
                    <a href="<?php echo esc_url($photo['url']); ?>" data-fancybox="project-gallery-carousel" data-caption="<?php echo esc_attr($photo['alt']); ?>">
                        <img class="slide-single-photo" src="<?php echo esc_url($photo['sizes']['slider']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>" />
                    </a>
                </div>
            <?php endforeach; ?>
            <?php
            $video_link = get_field('video_link');
            if ($video_link) : ?>
                <a class="video" data-fancybox="video" href="<?php echo esc_url($video_link); ?>"><img src="/wp-content/themes/woodmart-child/icons/project-icons/video.svg" alt=""><?php echo __('Watch the video','REM');?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>