<?php
/**
 * Main Index Template
 */

if (is_front_page()) {
    get_template_part('front-page');
    return;
}

get_header();
?>

<div class="dashboard-page">
    <?php if (have_posts()): ?>
    <div class="section-header">
        <h2 class="section-title"><?php wp_title('', true); ?></h2>
    </div>

    <div class="cards-grid">
        <?php while (have_posts()): the_post(); ?>
        <div class="course-card">
            <?php if (has_post_thumbnail()): ?>
            <div class="course-card-thumb">
                <?php the_post_thumbnail('course-thumb'); ?>
            </div>
            <?php endif; ?>
            <div class="course-card-body">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p style="font-size:13px; color:#6B7280;"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                <div class="course-card-meta">
                    <span class="course-card-date"><?php echo get_the_date(); ?></span>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <?php the_posts_pagination(['mid_size' => 3]); ?>

    <?php else: ?>
    <p style="text-align:center; padding:60px; color:#6B7280;">لا يوجد محتوى متاح.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
