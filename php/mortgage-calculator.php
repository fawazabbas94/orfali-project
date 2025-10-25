<?php
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
function mortgage_calculator($listing_currency)
{
?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function validateInput(value, min, max) {
                return value >= min && value <= max;
            }

            function calculateMortgage() {
                let propertyPrice = document.getElementById("property_price").value.replace(/,/g, "");
                let deposit = document.getElementById("deposit").value.replace(/,/g, "");
                let annualInterestRate = document.getElementById("interest_rate").value.replace(/,/g, "");
                let loanTerm = document.getElementById("loan_term").value.trim();
                let loanTermError = document.getElementById("loan_term_error");
                let interestRateError = document.getElementById("interest_rate_error");
                let hasError = false;
                loanTermError.innerText = "";
                interestRateError.innerText = "";
                if (propertyPrice === 0 || deposit === 0 || annualInterestRate === 0 || loanTerm === 0) {
                    document.getElementById("monthly_payment").innerText = "Please fill all the fields";
                    return;
                }
                propertyPrice = parseFloat(propertyPrice);
                deposit = parseFloat(deposit);
                annualInterestRate = parseFloat(annualInterestRate);
                loanTerm = parseInt(loanTerm);
                if (isNaN(propertyPrice) || isNaN(deposit) || isNaN(annualInterestRate) || isNaN(loanTerm)) {
                    document.getElementById("monthly_payment").innerText = "Invalid input. Please enter valid numbers.";
                    return;
                }
                if (!validateInput(loanTerm, 5, 30)) {
                    loanTermError.innerText = "Mortgage period should be between 5 to 30";
                    hasError = true;
                }
                if (!validateInput(annualInterestRate, 0, 10)) {
                    interestRateError.innerText = "Interest Rate should be between 1% to 10%";
                    hasError = true;
                }
                if (hasError) {
                    return;
                }
                let principal = propertyPrice - deposit;
                let monthlyInterestRate = annualInterestRate / 12 / 100;
                let numberOfPayments = loanTerm * 12;
                let monthlyPayment = (principal * monthlyInterestRate * Math.pow(1 + monthlyInterestRate, numberOfPayments)) / (Math.pow(1 + monthlyInterestRate, numberOfPayments) - 1);
                monthlyPayment = Math.round(monthlyPayment);
                let formattedMonthlyPayment = numberWithCommas(monthlyPayment);
                document.getElementById("monthly_payment").innerText = `${formattedMonthlyPayment} <?php echo esc_html($listing_currency); ?>`;

            }
            calculateMortgage();
            document.getElementById("property_price").addEventListener("input", function() {
                this.value = numberWithCommas(this.value.replace(/,/g, ""));
                calculateMortgage();
            });
            document.getElementById("deposit").addEventListener("input", function() {
                this.value = numberWithCommas(this.value.replace(/,/g, ""));
                calculateMortgage();
            });
            document.getElementById("interest_rate").addEventListener("input", function() {
                this.value = numberWithCommas(this.value.replace(/,/g, ""));
                calculateMortgage();
            });
            document.getElementById("loan_term").addEventListener("input", calculateMortgage);
        });
    </script>
<?php
}

// Pass $listing_currency to the function
add_action('wp_footer', function () use ($listing_currency) {
    mortgage_calculator($listing_currency);
});
