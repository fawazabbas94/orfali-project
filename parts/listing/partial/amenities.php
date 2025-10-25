<?php
if (have_rows('features')) : ?>
    <div class="listing-features">
        <div class="section-header">
            <h3 class="section-title"><?php echo __('Features', 'REM'); ?></h3>
        </div>
        <ul class="features-list">
            <?php
            while (have_rows('features')) : the_row();
                $feature = get_sub_field('feature'); ?>
                <li class="feature">
                    <?php echo esc_html($feature); ?>
                </li>
            <?php endwhile;
            ?>
        </ul>
    </div>
<?php
endif;
?>
<?php
$amenities = get_field('amenities');
if ($amenities) :
?>
    <div class="listing-amenities">
        <div class="section-header">
            <h3 class="section-title"><?php echo __('Amenities', 'REM'); ?></h3>
        </div>
        <ul class="amenities-list">
            <?php foreach ($amenities as $amenity) : ?>
                <li class="amenity">
                    <img src="/wp-content/themes/woodmart-child/icons/listing-details-icons/amenity.svg" alt="<?php echo esc_html($amenity->name); ?>"><?php echo esc_html($amenity->name); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>