<?php
if (have_rows('payment_plan')):
    $payment_alt = get_field('payment_alt');
?>
    <div class="payment-plan">
        <h2 class="payment-plan-title"><?php echo __('Payment Plan', 'REM'); ?></h2>
        <?php if ($payment_alt): ?>
            <p class="payment_alt"><?php echo $payment_alt; ?></p>
        <?php endif; ?>
        <div class="payment-plan-items">
            <?php
            while (have_rows('payment_plan')): the_row();
                $payment_label = get_sub_field('payment_label');
                $payment_value = get_sub_field('payment_value');
                $other_payment_value = get_sub_field('other_payment_value');
                $installments = get_sub_field('installments');
            ?>
                <div class="payment-plan-item">
                    <h2 class="payment-plan-item-value">
                        <?php
                        if ($payment_value == 'Other' && $other_payment_value) {
                            echo $other_payment_value . '%';
                        } else {
                            echo $payment_value;
                        }
                        ?>
                    </h2>
                    <h4 class="payment-plan-item-label">
                        <?php echo $payment_label; ?>
                    </h4>
                </div>
                <?php
                if ($installments) {
                ?>
                    <div class="payment-plan-item">
                        <h2 class="payment-plan-item-value">
                            <?php
                            echo $installments . ' ' . __('months', 'REM');
                            ?>
                        </h2>
                        <h4 class="payment-plan-item-label">
                            <?php echo  __('Installments', 'REM'); ?>
                        </h4>
                    </div>
            <?php
                }
            endwhile;
            ?>
        </div>
    </div>
<?php endif; ?>