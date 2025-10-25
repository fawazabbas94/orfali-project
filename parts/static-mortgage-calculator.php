<?php
// Default values for static pages
$currency = 'USD';
$property_price = '1,000,000';
$deposit = '100,000';
$interest_rate = '10';
$loan_term = '20';
?>

<div class="mortgage-calculator">
    <h3 class="section-title"><?php echo __('Mortgage Calculator', 'REM'); ?></h3>
    <p><?php echo __('Estimate your monthly mortgage payments', 'REM'); ?></p>
    <form>
        <div class="property_price">
            <div class="property_price">
                <label for="static_property_price"><?php echo __('Property Price', 'REM'); ?></label>
                <input type="text" id="static_property_price" name="property_price" value="<?php echo $property_price; ?>" required>
                <span><?php echo $currency; ?></span>
            </div>
        </div>
        <div class="deposit">
            <div class="deposit">
                <label for="static_deposit"><?php echo __('Deposit', 'REM'); ?></label>
                <input type="text" id="static_deposit" name="deposit" value="<?php echo $deposit; ?>" required>
                <span><?php echo $currency; ?></span>
            </div>
        </div>
        <div class="loan_term">
            <div class="loan_term_field">
                <label for="static_loan_term"><?php echo __('Mortgage Period', 'REM'); ?></label>
                <input type="text" id="static_loan_term" name="loan_term" value="<?php echo $loan_term; ?>" required>
                <span><?php echo __('Years', 'REM'); ?></span>
            </div>
            <div id="static_loan_term_error" class="error"></div>
        </div>
        <div class="interest_rate">
            <div class="interest_rate_field">
                <label for="static_interest_rate"><?php echo __('Interest Rate', 'REM'); ?></label>
                <input type="text" id="static_interest_rate" name="interest_rate" value="<?php echo $interest_rate; ?>" required>
                <span>%</span>
            </div>
            <div id="static_interest_rate_error" class="error"></div>
        </div>
    </form>
    <div class="calculator-footer">
        <p><?php echo __('Monthly Payment', 'REM'); ?></p>
        <h4 id="static_monthly_payment">Calculating...</h4>
    </div>
</div>

<script>
(function() {
    function initStaticMortgageCalculator() {
        const currency = '<?php echo $currency; ?>';
        
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function validateInput(value, min, max) {
            return value >= min && value <= max;
        }

        function calculateStaticMortgage() {
            let propertyPrice = document.getElementById("static_property_price");
            let deposit = document.getElementById("static_deposit");
            let annualInterestRate = document.getElementById("static_interest_rate");
            let loanTerm = document.getElementById("static_loan_term");
            let monthlyPaymentElement = document.getElementById("static_monthly_payment");
            
            if (!propertyPrice || !deposit || !annualInterestRate || !loanTerm || !monthlyPaymentElement) {
                return;
            }
            
            let propertyPriceValue = propertyPrice.value.replace(/,/g, "");
            let depositValue = deposit.value.replace(/,/g, "");
            let annualInterestRateValue = annualInterestRate.value.replace(/,/g, "");
            let loanTermValue = loanTerm.value.trim();
            
            let loanTermError = document.getElementById("static_loan_term_error");
            let interestRateError = document.getElementById("static_interest_rate_error");
            let hasError = false;
            
            if (loanTermError) loanTermError.innerText = "";
            if (interestRateError) interestRateError.innerText = "";
            
            if (!propertyPriceValue || !depositValue || !annualInterestRateValue || !loanTermValue) {
                monthlyPaymentElement.innerText = "Please fill all the fields";
                return;
            }
            
            propertyPriceValue = parseFloat(propertyPriceValue);
            depositValue = parseFloat(depositValue);
            annualInterestRateValue = parseFloat(annualInterestRateValue);
            loanTermValue = parseInt(loanTermValue);
            
            if (isNaN(propertyPriceValue) || isNaN(depositValue) || isNaN(annualInterestRateValue) || isNaN(loanTermValue)) {
                monthlyPaymentElement.innerText = "Invalid input. Please enter valid numbers.";
                return;
            }
            
            if (!validateInput(loanTermValue, 5, 30)) {
                if (loanTermError) loanTermError.innerText = "Mortgage period should be between 5 to 30";
                hasError = true;
            }
            
            if (!validateInput(annualInterestRateValue, 0, 10)) {
                if (interestRateError) interestRateError.innerText = "Interest Rate should be between 1% to 10%";
                hasError = true;
            }
            
            if (hasError) {
                monthlyPaymentElement.innerText = "Please correct the errors";
                return;
            }
            
            let principal = propertyPriceValue - depositValue;
            let monthlyInterestRate = annualInterestRateValue / 12 / 100;
            let numberOfPayments = loanTermValue * 12;
            
            if (monthlyInterestRate === 0) {
                let monthlyPayment = principal / numberOfPayments;
                monthlyPayment = Math.round(monthlyPayment);
                monthlyPaymentElement.innerText = numberWithCommas(monthlyPayment) + ' ' + currency;
            } else {
                let monthlyPayment = (principal * monthlyInterestRate * Math.pow(1 + monthlyInterestRate, numberOfPayments)) / (Math.pow(1 + monthlyInterestRate, numberOfPayments) - 1);
                monthlyPayment = Math.round(monthlyPayment);
                monthlyPaymentElement.innerText = numberWithCommas(monthlyPayment) + ' ' + currency;
            }
        }
        
        // Initial calculation
        calculateStaticMortgage();
        
        // Add event listeners
        let propertyPriceInput = document.getElementById("static_property_price");
        if (propertyPriceInput) {
            propertyPriceInput.addEventListener("input", function() {
                this.value = numberWithCommas(this.value.replace(/,/g, ""));
                calculateStaticMortgage();
            });
        }
        
        let depositInput = document.getElementById("static_deposit");
        if (depositInput) {
            depositInput.addEventListener("input", function() {
                this.value = numberWithCommas(this.value.replace(/,/g, ""));
                calculateStaticMortgage();
            });
        }
        
        let interestRateInput = document.getElementById("static_interest_rate");
        if (interestRateInput) {
            interestRateInput.addEventListener("input", calculateStaticMortgage);
        }
        
        let loanTermInput = document.getElementById("static_loan_term");
        if (loanTermInput) {
            loanTermInput.addEventListener("input", calculateStaticMortgage);
        }
    }
    
    // Initialize immediately
    initStaticMortgageCalculator();
})();
</script>