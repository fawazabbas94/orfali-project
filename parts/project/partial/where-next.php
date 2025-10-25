<div class="where-next">
    <div class="where-next-inner">
        <h3 class="section-title"><?php echo __('Where next?', 'REM') ?></h3>
        <div class="links-list">
            <?php $where_next = get_field('where_next');
            if ($where_next === 'inherit') :
                if (have_rows('where_next', 'option')) : ?>
                    <?php
                    while (have_rows('where_next', 'option')) : the_row();
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
            elseif ($where_next === 'custom') :
                if (have_rows('custom_where_next_links')) :
                    while (have_rows('custom_where_next_links')) : the_row();
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
</div>