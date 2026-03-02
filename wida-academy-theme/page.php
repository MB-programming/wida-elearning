<?php
/**
 * Generic Page Template
 */
get_header();
?>
<div class="dashboard-page">
    <?php while (have_posts()): the_post(); ?>
    <div style="background:#fff; border-radius:16px; padding:40px; box-shadow:0 2px 8px rgba(107,53,217,0.08); border:1px solid #E5E0F5;">
        <h1 style="font-size:28px; font-weight:800; color:#2D1B69; margin-bottom:24px;"><?php the_title(); ?></h1>
        <div class="entry-content" style="font-size:16px; line-height:1.8; color:#374151;">
            <?php the_content(); ?>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>
