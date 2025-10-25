<?php
$listing_default_image = get_field('listing_default_image', 'option');
$title = get_the_title($post->ID);
$permalink = get_permalink($post->ID);
$featured_image = get_the_post_thumbnail($post->ID, 'listingfeaturedimage');
$listing_view = get_field('listing_view');
$bua = get_field('bua');
$plot = get_field('plot');
$gross_area = get_field('gross_area');
$net_area = get_field('net_area');
$bedrooms = get_field('bedrooms');
$bathrooms = get_field('bathrooms');
$project = get_field('project');
$project_country = get_field('country');
$country_slug = $project_country->slug ?? '';
$flag = get_field('flag', $project_country);
if ($project) {
    $project_id = $project->ID;

    // Create the address parts array
    $address_parts = [
        get_field('district', $project->ID)->name ?? '',
        get_field('city', $project->ID)->name ?? '',
    ];

    // Format the address
    $formatted_address = implode(', ', array_filter($address_parts));
}

$for = get_field('buy_rent');
$rent_term = get_field('rent_term');
$listing_currency = ($country_slug === 'uae') ? 'AED' : (($country_slug === 'turkiye') ? 'USD' : '');
$listing_unit = ($country_slug === 'uae') ? 'sqft' : (($country_slug === 'turkiye') ? 'sqm' : '');
$price = get_field('price', $post->ID);
$formatted_price = number_format($price, 0, '.', ',');
$agent = get_field('agent', $post->ID);
$whatsapp_number = null;
$phone = get_field('phone', $agent->ID);
if ($phone) {
    $same_number_for = $phone['same_number_for'];
    if ($same_number_for && in_array('WhatsApp', $same_number_for)) {
        $whatsapp_number = $phone['phone_number'];
    } else {
        $whatsapp_number = $phone['whatsapp_number'];
    }
}
$listing_status = get_field('listing_status');
?>
<article id="listing-<?php the_ID(); ?>" class="single-card single-listing-card">
    <div class="listing-image">
        <div class="labels">
            <?php if ($for['value'] === 'rent') : ?>
                <span class="for"><?php echo __('For Rent', 'REM'); ?></span>
            <?php
            elseif ($for['value'] === 'buy') : ?>
                <span class="for"><?php echo __('For Sale', 'REM'); ?></span>
            <?php
            endif;
            if ($listing_status->slug === 'off-plan') : ?>
                <span class="listing-status"><?php echo $listing_status->name; ?></span>
            <?php endif; ?>
        </div>
        <a href="<?php echo esc_url($permalink); ?>">
            <?php
            if ($featured_image) : echo $featured_image;
            else : ?>
                <img src="<?php echo $listing_default_image; ?>" alt="">
            <?php endif;
            ?>
        </a>
    </div>
    <div class="listing-meta">
        <a class="listing-price" href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($listing_currency . ' ' . $formatted_price); ?><small><?php if ($for['value'] == 'rent') : echo __(' / ' . $rent_term, 'REM');
                                                                                                                                                        endif; ?></small></a>
        <h5 class="listing-location">
            <img src="/wp-content/themes/woodmart-child/icons/interface-icons/pin.svg" alt="address">
            <?php if (!empty($formatted_address)) : ?>
                <?php echo esc_html($formatted_address); ?>
            <?php endif; ?>
        </h5>
        <h5 class="head-info">
            <?php
            if ($listing_view) {
                $listing_view_names = [];
                if (is_array($listing_view)) {
                    foreach ($listing_view as $view) {
                        if (isset($view->name)) {
                            $listing_view_names[] = esc_html($view->name);
                        }
                    }
                } elseif (isset($listing_view->name)) {
                    $listing_view_names[] = esc_html($listing_view->name);
                }
                echo implode(', ', $listing_view_names) . __(' View', 'REM') . '<span class="info-separator">|</span>';
            }
            if (have_rows('additional_head_info')) :
                while (have_rows('additional_head_info')) : the_row();
                    $info = get_sub_field('info');
                    if ($info) {
                        echo esc_html($info) . '<span class="info-separator">|</span>';
                    }
                endwhile;
            endif;
            ?>
        </h5>
        <div class="listing-info">
            <?php if ($bedrooms) : ?>
                <div class="item bedrooms">
                    <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/bedrooms.svg" alt="bedrooms">
                    <p class="value"><?php echo $bedrooms; ?></p>
                </div>
            <?php endif; ?>
            <?php if ($bathrooms) : ?>
                <div class="item bathrooms">
                    <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/bathrooms.svg" alt="bathrooms">
                    <p class="value"><?php echo $bathrooms; ?></p>
                </div>
            <?php endif; ?>
            <?php if ($bua) : ?>
                <div class="item bua">
                    <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/bua.svg" alt="bua">
                    <p class="value"><?php echo __('BUA: ', 'REM') . $bua . ' ' . $listing_unit; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="listing-buttons">
        <?php if ($phone) : ?>
            <a href="tel:<?php echo esc_html($phone['phone_number']); ?>" class="call-button"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/phone.svg" alt="call">Call</a>
            <?php if ($whatsapp_number) : ?>
                <a target="_blank" class="whatsapp-button" href="https://wa.me/<?php echo esc_html($whatsapp_number); ?>"><img src="/wp-content/themes/woodmart-child/icons/interface-icons/whatsapp_solid.svg" alt="whatsapp"><?php echo __('Whatsapp', 'REM'); ?></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</article>