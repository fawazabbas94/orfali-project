<?php
$mortgage_calculator = get_field('mortgage_calculator', 'option');
$mortgage_calculator_link = get_field('mortgage_calculator_link', 'option');
$project = get_field('project');
$listing_currency = '';
if ($project) {
    $project_country = get_field('country', $project->ID);
    $country_slug = $project_country->slug ?? '';
    $listing_currency = ($country_slug === 'uae') ? 'AED' : (($country_slug === 'turkiye') ? 'USD' : '');
} else {
    $country = get_field('country');
    $country_slug = $country->slug ?? '';
    $listing_currency = ($country_slug === 'uae') ? 'AED' : (($country_slug === 'turkiye') ? 'USD' : '');
}
if (empty($listing_currency)) {
    $listing_currency = 'USD';
}
?>
<div class="mortgage-calculator">
    <h3 class="section-title"><?php echo __('Mortgage Calculator', 'REM'); ?></h3>
    <p><?php echo __('Estimate your monthly mortgage payments', 'REM'); ?></p>
    <form>
        <div class="property_price">
            <div class="property_price">
                <label for="property_price"><?php echo __('Property Price', 'REM'); ?></label>
                <input type="text" id="property_price" name="property_price" step="0.01" value="1,000,000" required>
                <span><?php echo esc_html($listing_currency); ?></span>
            </div>
        </div>
        <div class="deposit">
            <div class="deposit">
                <label for="deposit"><?php echo __('Deposit', 'REM'); ?></label>
                <input type="text" id="deposit" name="deposit" step="0.01" value="100,000" required>
                <span><?php echo esc_html($listing_currency); ?></span>
            </div>
        </div>
        <div class="loan_term">
            <div class="loan_term_field">
                <label for="loan_term"><?php echo __('Mortgage Period', 'REM'); ?></label>
                <input type="text" id="loan_term" name="loan_term" value="20" required>
                <span><?php echo __('Years', 'REM'); ?></span>
            </div>
            <div id="loan_term_error" class="error"></div>
        </div>
        <div class="interest_rate">
            <div class="interest_rate_field">
                <label for="interest_rate"><?php echo __('Interest Rate', 'REM'); ?></label>
                <input type="text" id="interest_rate" name="interest_rate" step="0.01" value="10" required>
                <span>%</span>
            </div>
            <div id="interest_rate_error" class="error"></div>
        </div>
    </form>
    <div class="calculator-footer">
        <p><?php echo __('Monthly Payment', 'REM'); ?></p>
        <h4 id="monthly_payment"></h4>
        <a href="<?php if ($mortgage_calculator_link) : echo $mortgage_calculator_link;
                    else : echo '#';
                    endif ?>"><?php echo __('View Mortgage Costs and Fees', 'REM'); ?></a>
    </div>
</div>