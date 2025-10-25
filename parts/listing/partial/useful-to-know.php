<?php
$useful_to_know = get_field('useful_to_know');
if ($useful_to_know) : ?>
    <div class="useful-links">
        <h3 class="section-title"><?php echo __('Useful to know', 'REM') ?></h3>
        <div class="links-list">
            <?php
            if ($useful_to_know === 'inherit') :
                if (have_rows('useful_links', 'option')) : ?>
                    <?php
                    while (have_rows('useful_links', 'option')) : the_row();
                        $icon = get_sub_field('icon');
                        $title = get_sub_field('title');
                        $short_description = get_sub_field('short_description');
                        $link = get_sub_field('link');
                        $link_text = get_sub_field('link_text'); ?>
                        <div class="item">
                            <img src="<?php echo $icon; ?>" alt="<?php echo $title; ?>">
                            <h5><?php echo $title; ?></h5>
                            <p><?php echo $short_description; ?></p>
                            <a href="<?php echo $link; ?>"><span><?php echo $link_text; ?></span></a>
                        </div>
                    <?php endwhile;
                endif;
            elseif ($useful_to_know === 'custom') :
                if (have_rows('custom_useful_to_know_links')) :
                    while (have_rows('custom_useful_to_know_links')) : the_row();
                        $icon = get_sub_field('icon');
                        $title = get_sub_field('title');
                        $short_description = get_sub_field('short_description');
                        $link = get_sub_field('link');
                        $link_text = get_sub_field('link_text'); ?>
                        <div class="item">
                            <img src="<?php echo $icon; ?>" alt="<?php echo $title; ?>">
                            <h5><?php echo $title; ?></h5>
                            <p><?php echo $short_description; ?></p>
                            <a href="<?php echo $link; ?>"><span><?php echo $link_text; ?></span></a>
                        </div>
            <?php endwhile;
                endif;
            endif; ?>
        </div>
    </div>
<?php
endif;
?>