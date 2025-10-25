<?php
get_header(); ?>

<head>
    <link type="text/css" rel="stylesheet" href="/wp-content/themes/woodmart-child/listing-print-template.css">
</head>
<?php
$fields = [
    'listing_id',
    'project',
    'country',
    'city',
    'district',
    'agent',
    'photos',
    'listing_status',
    'listing_project_type',
    'floor_type',
    'listing_view',
    'additional_head_info',
    'building',
    'bua',
    'plot',
    'bedrooms',
    'bathrooms',
    'buy_rent',
    'price',
    'rent_term',
    'features',
    'amenities',
    'listing_availability',
    'pdf_content'
];
foreach ($fields as $field) {
    ${$field} = get_field($field);
}
$project_country = get_field('country', $project->ID);
$country_slug = $project_country->slug ?? '';
$listing_currency = ($country_slug === 'uae') ? 'AED' : (($country_slug === 'turkiye') ? 'USD' : '');
$formatted_price = number_format($price, 0, '.', ',');

if ($agent) :
    $agent_id = $agent->ID;
    $agent_photo = get_the_post_thumbnail($agent_id, 'memberimage');
    $agent_name = get_the_title($agent_id);
    $positions = get_field('positions', $agent_id);
    $companies = get_field('companies', $agent_id);
    $contact_information = get_field('contact_information', $agent_id);
    $phone = get_field('phone', $agent_id);
    $email_address = get_field('email_address', $agent_id);
    
    $positions_list = [];
    if ($positions) {
        foreach ($positions as $position) {
            $positions_list[] = esc_html($position->name);
        }
    }
    $positions_text = !empty($positions_list) ? implode(', ', $positions_list) : 'N/A';
    
    $phone_number = 'N/A';
    $email_text = 'N/A';
    if ($phone && $phone['phone_number']) {
        $phone_number = esc_html($phone['phone_number']);
    }
    if ($email_address) {
        $email_text = esc_html($email_address);
    }
    if ($contact_information === 'inherit' && $companies) {
        $default_company_exists = null;
        foreach ($companies as $company) {
            $default_company = get_field('default_company', 'option');
            if (get_post_field('post_name', $company->ID) === $default_company) {
                $default_company_exists = $company;
                break;
            }
        }
        $companies_to_print = $default_company_exists ? [$default_company_exists] : $companies;
        
        foreach ($companies_to_print as $company) {
            $company_phone = get_field('phone', $company->ID);
            $company_email = get_field('email_address', $company->ID);
            if ($email_text === 'N/A' && $company_email) {
                $email_text = esc_html($company_email);
            }
            if ($phone_number === 'N/A' && $company_phone && $company_phone['phone_number']) {
                $phone_number = esc_html($company_phone['phone_number']);
            }
        }
    }

    $agent_details = __('Orfali Properties | Trusted and recommended Real Estate Group', 'REM') . "<br>{$agent_name} | {$positions_text} | {$phone_number} |<br>{$email_text}";
endif;

function get_facts_boxes($bedrooms, $bathrooms, $plot)
{
    return '
        <div class="facts-boxes">
            <div class="box">
                <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/bedrooms.svg" alt="">
                <p>' . esc_html($bedrooms) . '</p>
            </div>
            <div class="box">
                <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/bathrooms.svg" alt="">
                <p>' . esc_html($bathrooms) . '</p>
            </div>
            <div class="box">
                <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/plot.svg" alt="">
                <p>' . esc_html($plot) . ' ft&sup2;</p>
            </div>
        </div>
    ';
}

function get_specific_page_footer($agent_details, $pdf_logo)
{
    return '
        <div class="page-footer">
            <div class="contact-info">
                <p>' . wp_kses_post($agent_details) . '</p>
            </div>
            <img src="' . esc_url($pdf_logo) . '" alt="" class="logo">
        </div>
    ';
}

function get_image_page($photos, $start, $end, $agent_details, $pdf_logo)
{
    $output = '';
    for ($i = $start; $i < $end; $i++) {
        if (isset($photos[$i])) {
            $output .= '<div class="image-page page">
                <div class="content-section">
                    <div class="photos">
                        <img class="photo" src="' . esc_url($photos[$i]['sizes']['slider']) . '" alt="' . esc_attr($photos[$i]['alt']) . '" />
                    </div>
                </div>
                ' . get_specific_page_footer($agent_details, $pdf_logo) . '
            </div>';
        }
    }
    return $output;
}
?>
<div class="listing-print-template">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            global $post;
            $pdf_logo = get_field('pdf_logo', 'option');
            $featured_image = get_the_post_thumbnail_url($post->ID, 'listingfeaturedimage');
    ?>
            <div class="first-page">
                <div class="header">
                    <img src="<?php echo esc_url($pdf_logo); ?>" alt="" class="logo">
                    <h1 class="headline"><?php echo __('Unlock opportunities.', 'REM'); ?></h1>
                </div>
                <img src="<?php echo esc_url($featured_image); ?>" alt="" class="featured-image">
                <div class="listing-info">
                    <div class="listing-title-address">
                        <h2 class="listing-title"><?php the_title(); ?></h2>
                        <h2 class="listing-district-city">
                            <?php echo ', ' . esc_html($district->name) . ', ' . esc_html($city->name); ?>
                        </h2>
                    </div>
                    <div class="listing-info-footer">
                        <p>
                            <?php echo esc_html("{$agent_name} | {$positions_text} | {$phone_number} | {$email_text}"); ?>
                        </p>
                        <?php echo get_facts_boxes($bedrooms, $bathrooms, $plot); ?>
                    </div>
                </div>
            </div>
            <?php if ($photos) : ?>
                <div class="second-page page">
                    <div class="content-section">
                        <div class="photos">
                            <?php
                            for ($i = 0; $i < min(2, count($photos)); $i++) :
                            ?>
                                <img class="photo" src="<?php echo esc_url($photos[$i]['sizes']['slider']); ?>" alt="<?php echo esc_attr($photos[$i]['alt']); ?>" />
                            <?php endfor; ?>
                        </div>
                        <div class="info">
                            <h2 class="listing-title"><?php the_title(); ?></h2>
                            <h2 class="listing-district-city">
                                <?php echo esc_html($district->name) . ', ' . esc_html($city->name); ?>
                            </h2>
                            <?php echo get_facts_boxes($bedrooms, $bathrooms, $plot); ?>
                            <div class="pdf-content">
                                <?php the_field('pdf_content'); ?>
                            </div>
                            <h1 class="price">
                                <?php echo esc_html($listing_currency . ' ' . $formatted_price); ?>
                                <small><?php if ($buy_rent['value'] == 'rent') : echo __(' / ' . $rent_term, 'REM');
                                        endif; ?></small>
                            </h1>
                        </div>
                    </div>
                    <?php echo get_specific_page_footer($agent_details, $pdf_logo); ?>
                </div>
            <?php endif; ?>
            <?php
            if ($photos) {
                $total_photos = count($photos);
                for ($i = 2; $i < $total_photos; $i++) {
                    if ($i == 2 || $i == 3 || $i == 4) {
                        echo get_image_page($photos, $i, $i + 1, $agent_details, $pdf_logo);
                    }
                }
                if ($total_photos > 5) {
                    echo '<div class="images-page page">
                        <div class="content-section">
                            <div class="photos">';
                    for ($i = 5; $i < min(9, $total_photos); $i++) {
                        echo '<img class="photo" id="' . $i . '" src="' . esc_url($photos[$i]['sizes']['slider']) . '" alt="' . esc_attr($photos[$i]['alt']) . '" />';
                    }
                    echo '</div>
                        </div>
                        ' . get_specific_page_footer($agent_details, $pdf_logo) . '
                    </div>';
                }
                if ($total_photos > 9) {
                    echo '<div class="image-page page">
                        <div class="content-section">
                            <div class="photos">';
                    echo '<img class="photo" id="' . 9 . '" src="' . esc_url($photos[9]['sizes']['slider']) . '" alt="' . esc_attr($photos[9]['alt']) . '" />';
                    echo '</div>
                        </div>
                        ' . get_specific_page_footer($agent_details, $pdf_logo) . '
                    </div>';
                }
            }
            ?>
            <div class="last-page page">
                <div class="contact">
                    <h1><?php echo __('For viewing and more information,', 'REM'); ?></h1>
                    <p><?php echo __('please contact our property specialist:', 'REM'); ?></p>
                    <div class="agent-card">
                        <div class="agent-photo">
                            <?php if ($agent_photo) : echo $agent_photo;
                            endif; ?>
                        </div>
                        <div class="agent-info">
                            <h2 class="agent-name"><?php echo $agent_name; ?></h2>
                            <p class="agent-contact">
                                <?php echo $positions_text; ?><br>
                                <?php echo $phone_number; ?><br>
                                <?php echo $email_text; ?><br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="disclaimer">
                    <h3>Disclaimer:</h3>
                    <p><?php echo __('While we strive for accuracy, these property details are approximate and for illustrative purposes only. No structural survey has been conducted, and services, appliances, and fittings remain untested. All photos, measurements, and floor plans are for guidance only. Lease details, service charges, and ground rent should be verified before purchase. Copyright belongs exclusively to Orfali Properties Real Estate Broker.', 'REM'); ?></p>
                </div>
                <div class="page-footer">
                    <div class="contact-info">
                        <p><?php echo __('Orfali Properties | www.orfaliproperties.com'); ?></p>
                    </div>
                    <img src="<?php echo esc_url($pdf_logo); ?>" alt="" class="logo">
                </div>
            </div>
    <?php
        endwhile;
    endif;
    ?>
</div>
<script type="text/javascript">
    window.onload = function() {
        window.print();
    };
</script>
<?php get_footer(); ?>