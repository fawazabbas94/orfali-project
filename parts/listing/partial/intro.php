<?php
$project = get_field('project');
$listing_currency = '';
$price = get_field('price');
$formatted_price = number_format($price, 0, '.', ',');
$listing_view = get_field('listing_view');
if ($project) {
    $project_country = get_field('country', $project->ID);
    $country_slug = $project_country->slug ?? '';
    $listing_currency = ($country_slug === 'uae') ? 'AED' : (($country_slug === 'turkiye') ? 'USD' : '');
} else {
    $country = get_field('country');
    $country_slug = $country->slug ?? '';
    $listing_currency = ($country_slug === 'uae') ? 'AED' : (($country_slug === 'turkiye') ? 'USD' : '');
}
$for = get_field('buy_rent');
$rent_term = get_field('rent_term');
?>
<div class="listing-intro">
    <?php if ($price) : ?>
        <div class="listing-price">
            <h1><?php echo esc_html($listing_currency . ' ' . $formatted_price); ?><small><?php if ($for['value'] == 'rent') : echo __(' / ' . $rent_term, 'REM');
                                                                                            endif; ?></small></h1>
        </div>
    <?php endif; ?>
    <div class="head-info">
        <h4>
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
        </h4>
    </div>
    <p class="listing-title"><?php the_title(); ?></p>
</div>