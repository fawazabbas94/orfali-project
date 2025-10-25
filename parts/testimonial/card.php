<?php
$permalink = get_permalink(get_the_ID());
$publish_date = get_the_date();
?>
<article id="testimonial-<?php the_ID(); ?>" class="single-testimonial-card">
    <a href="<?php echo $permalink; ?>" class="testimonial-link">
        <h2 class="testimonial-title"><?php echo get_the_title(); ?></h2>
    </a>
    <div class="testimonial-meta">
        <span class="testimonial-date"><?php echo esc_html($publish_date); ?></span>
    </div>
    <div class="stars">
        <?php for ($i = 0; $i < 5; $i++): ?>
            <span class="star">&#9733;</span>
        <?php endfor; ?>
    </div>
    <p class="testimonial-content"><?php echo get_the_content(); ?></p>
</article>