<?php $overview = get_the_content();
if ($overview) : ?>
    <div class="listing-overview">
        <p><?php echo $overview; ?></p>
    </div>
<?php endif; ?>