<article id="company-<?php the_ID(); ?>" class="company-<?php the_ID(); ?> company">
    <?php get_template_part('parts/company/partial/header', get_post_format()); ?>
    <div class="company-inner">
        <?php get_template_part('parts/company/partial/details', get_post_format()); ?>
        <?php get_template_part('parts/company/partial/contact', get_post_format()); ?>
        <?php get_template_part('parts/company/partial/payment', get_post_format()); ?>
    </div>
</article><!-- #post -->
<?php
