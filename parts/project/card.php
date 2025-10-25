<?php
$project_default_image = get_field('project_default_image', 'option');
$project_title = get_the_title($post->ID);
$project_permalink = get_permalink($post->ID);
$featured_image = get_the_post_thumbnail($post->ID, 'projectfeaturedimage');
$project_availability = get_field('project_availability', $post->ID);
$construction_companies = get_field('construction_companies');
if ($construction_companies) :
    $construction_companies_title = $construction_companies->post_title;
endif;
$district = get_field('district');
$delivery_date = get_field('delivery_date');
$min_price = get_field('min_price');
$formatted_price = number_format($min_price, 0, '.', ',');
$project_country = get_field('country')->slug;
$project_currency = ($project_country === 'uae') ? 'AED' : (($project_country === 'turkiye') ? 'USD' : '');
$project_type = get_field('project_type');
$project_status = get_field('project_status');
$agent = get_field('agent', $post->ID);
$phone = get_field('phone', $agent->ID);
$whatsapp_number = null;
if ($phone) {
    $same_number_for = $phone['same_number_for'];
    if ($same_number_for && in_array('WhatsApp', $same_number_for)) {
        $whatsapp_number = $phone['phone_number'];
    } else {
        $whatsapp_number = $phone['whatsapp_number'];
    }
}
?>
<article id="project-<?php the_ID(); ?>" class="single-card single-project-card <?php if ($project_availability === 'sold_out') : echo 'sold-out';
                                                                                endif; ?>">
    <div class="project-image">
        <div class="labels">
            <?php if ($project_availability === 'sold_out') : ?>
                <span class="sold-out"><?php echo __('Sold Out', 'REM'); ?></span>
            <?php endif;
            foreach ($project_type as $type) : ?>
                <span class="project-type"><?php echo $type->name; ?></span>
            <?php endforeach; ?>
        </div>
        <a href="<?php echo esc_url($project_permalink); ?>">
            <?php
            if ($featured_image) : echo $featured_image;
            else : ?>
                <img src="<?php echo $project_default_image; ?>" alt="">
            <?php endif;
            ?>
        </a>
    </div>
    <div class="project-meta">
        <a class="title" href="<?php echo esc_url($project_permalink); ?>"><?php echo esc_html($project_title); ?></a>
        <h5 class="project-location"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/pin.svg" alt="address"><?php echo esc_html($district->name); ?></h5>
        <?php if ($project_status->slug === 'off-plan') : ?>
            <h5 class="delivery-date"><span><?php echo __('Delivery date:', 'REM'); ?></span><?php echo esc_html($delivery_date['month']['label'] . ' ' . $delivery_date['year']); ?></h5>
        <?php endif; ?>
        <h5 class="price"><span><?php echo __('Starting Price:', 'REM'); ?></span><?php echo esc_html($project_currency) . ' ' . esc_html($formatted_price); ?></h5>
        <h5 class="developer"><span><?php echo __('Developer:', 'REM'); ?></span><?php echo esc_html($construction_companies_title); ?></h5>
    </div>
    <div class="project-buttons">
        <?php if ($phone) : ?>
            <a href="tel:<?php echo esc_html($phone['phone_number']); ?>" class="call-button"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/phone.svg" alt="call">Call</a>
            <?php if ($whatsapp_number) : ?>
                <a target="_blank" class="whatsapp-button" href="https://wa.me/<?php echo esc_html($whatsapp_number); ?>"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/whatsapp_solid.svg" alt="whatsapp"><?php echo __('Whatsapp', 'REM'); ?></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</article>