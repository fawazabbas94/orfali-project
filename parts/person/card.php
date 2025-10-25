<?php
$permalink = get_permalink(get_the_ID());
$person_default_image = get_field('person_default_image', 'option');
$featured_image = get_the_post_thumbnail(get_the_ID(), 'memberimage');
$companies = get_field('companies');
$positions = get_field('positions');
$languages = get_field('languages');
$default_company_exists = false;
if ($companies) {
    foreach ($companies as $company) {
        $default_company = get_field('default_company', 'option');
        if ($company->ID === $default_company) {
            $default_company_exists = true;
            break;
        }
    }
} ?>
<article id="person-<?php the_ID(); ?>" class="single-person-card <?php if ($default_company_exists === true) : echo 'member';
                                                                    endif; ?>">
    <a href="<?php echo $permalink; ?>" class="person-link">
        <div class="person-image">
            <?php
            if ($featured_image) : echo $featured_image;
            else : ?><img src="<?php echo $person_default_image; ?>" alt="person-without-image"><?php endif; ?>
        </div>
    </a>
    <a href="<?php echo $permalink; ?>" class="person-link">
        <h2 class="person-name"><?php echo get_the_title(); ?></h2>
    </a>
    <?php get_template_part('parts/person/meta', get_post_format()); ?>
</article>