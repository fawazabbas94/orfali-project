<?php
$permalink = get_permalink(get_the_ID());
$company_default_image = get_field('company_default_image', 'option');
$featured_image = get_the_post_thumbnail(get_the_ID(), 'memberimage');
$company_types = get_field('company_types'); ?>
<article id="company-<?php the_ID(); ?>" class="single-company-card <?php foreach ($company_types as $type) : echo esc_html($type->slug);
                                                                    endforeach; ?>">
    <a href="<?php echo $permalink; ?>" class="company-link">
        <div class="company-logo">
            <?php
            if ($featured_image) : echo $featured_image;
            else : ?><img src="<?php echo $company_default_image; ?>" alt="company-without-logo"><?php endif; ?>
        </div>
    </a>
    <a href="<?php echo $permalink; ?>" class="company-link">
        <h2 class="company-name"><?php echo get_the_title(); ?></h2>
    </a>
    <div class="company-types">
        <?php
        $companies_list = [];
        foreach ($company_types as $type) {
            $companies_list[] = esc_html($type->name);
        ?>
        <?php
        } ?>
        <h2 class="company-type"><?php echo implode(', ', $companies_list); ?></h2>
    </div>
</article>