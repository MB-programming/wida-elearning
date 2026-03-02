<?php
/**
 * Search Results Template
 */
get_header();
?>
<div class="dashboard-page">
    <div class="section-header">
        <h2 class="section-title">
            نتائج البحث عن: "<?php echo esc_html(get_search_query()); ?>"
        </h2>
        <span style="font-size:14px; color:#9CA3AF;"><?php echo $wp_query->found_posts; ?> نتيجة</span>
    </div>

    <?php if (have_posts()): ?>
    <div class="cards-grid">
        <?php while (have_posts()): the_post(); ?>
        <div class="course-card">
            <div class="course-card-thumb" style="background:linear-gradient(135deg,#6B35D9,#A855F7);">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('course-thumb', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                <?php else: ?>
                    <i class="fa-solid fa-search" style="font-size:36px; color:rgba(255,255,255,0.7);"></i>
                <?php endif; ?>
            </div>
            <div class="course-card-body">
                <h3><a href="<?php the_permalink(); ?>" style="color:inherit;"><?php the_title(); ?></a></h3>
                <p style="font-size:13px; color:#6B7280; line-height:1.5;"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                <div class="course-card-meta">
                    <span class="course-card-date"><?php echo get_the_date(); ?></span>
                    <a href="<?php the_permalink(); ?>" style="color:#6B35D9; font-size:13px; font-weight:600;">عرض ←</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php the_posts_pagination(); ?>

    <?php else: ?>
    <div style="background:#fff; border-radius:12px; padding:60px; text-align:center; border:1px solid #E5E0F5;">
        <i class="fa-solid fa-magnifying-glass" style="font-size:56px; color:#D8B4FE; margin-bottom:16px;"></i>
        <h2 style="color:#2D1B69; margin-bottom:8px;">لا توجد نتائج</h2>
        <p style="color:#6B7280;">جرّب كلمات بحث أخرى</p>
    </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
