<?php
if (have_rows('payment_plan')): ?>
    <div class="payment-plan">
        <h2 class="payment-plan-title"><?php echo __('Payment Plan', 'REM'); ?></h2>
        <div class="payment-plan-items">
            <?php
            while (have_rows('payment_plan')): the_row();
                $payment_label = get_sub_field('payment_label');
                $payment_value = get_sub_field('payment_value');
            ?>
                <div class="payment-plan-item">
                    <h2 class="payment-plan-item-value">
                        <?php echo $payment_value; ?>
                    </h2>
                    <h4 class="payment-plan-item-label">
                        <?php echo $payment_label; ?>
                    </h4>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>