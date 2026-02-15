<?php
/**
 * Single post template - covers all CPTs
 */
get_header();

$post_type = get_post_type();
?>

<div class="dashboard-page">
    <?php while (have_posts()): the_post(); ?>

    <!-- Breadcrumb -->
    <nav style="font-size:13px; color:#9CA3AF; margin-bottom:24px;">
        <a href="<?php echo home_url('/'); ?>" style="color:#6B35D9;">الرئيسية</a>
        <span style="margin:0 8px;">›</span>
        <?php if ($post_type === 'wida_course'): ?>
            <a href="<?php echo get_post_type_archive_link('wida_course'); ?>" style="color:#6B35D9;">الدورات التدريبية</a>
        <?php elseif ($post_type === 'wida_document'): ?>
            <a href="<?php echo get_post_type_archive_link('wida_document'); ?>" style="color:#6B35D9;">الأدلة الإرشادية</a>
        <?php elseif ($post_type === 'wida_identity'): ?>
            <a href="<?php echo get_post_type_archive_link('wida_identity'); ?>" style="color:#6B35D9;">الهوية البصرية</a>
        <?php elseif ($post_type === 'wida_news'): ?>
            <a href="<?php echo get_post_type_archive_link('wida_news'); ?>" style="color:#6B35D9;">الأخبار</a>
        <?php endif; ?>
        <span style="margin:0 8px;">›</span>
        <span><?php the_title(); ?></span>
    </nav>

    <div style="display:grid; grid-template-columns:1fr 320px; gap:32px; align-items:start;">

        <!-- Main Content -->
        <div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 2px 8px rgba(107,53,217,0.08); border:1px solid #E5E0F5;">

            <?php if (has_post_thumbnail()): ?>
            <div style="height:300px; overflow:hidden;">
                <?php the_post_thumbnail('full', ['style' => 'width:100%; height:100%; object-fit:cover;']); ?>
            </div>
            <?php else: ?>
            <div style="height:120px; background:linear-gradient(135deg,#6B35D9,#A855F7);"></div>
            <?php endif; ?>

            <div style="padding:32px;">
                <h1 style="font-size:26px; font-weight:800; color:#2D1B69; margin-bottom:16px;"><?php the_title(); ?></h1>

                <div style="display:flex; gap:16px; margin-bottom:24px; font-size:13px; color:#9CA3AF;">
                    <span><i class="fa-regular fa-calendar"></i> <?php echo get_the_date('d/m/Y'); ?></span>
                    <span><i class="fa-regular fa-user"></i> <?php the_author(); ?></span>
                </div>

                <div class="entry-content" style="font-size:16px; line-height:1.8; color:#374151;">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <?php if ($post_type === 'wida_course'): ?>
            <div style="background:#fff; border-radius:16px; padding:24px; border:1px solid #E5E0F5; box-shadow:0 2px 8px rgba(107,53,217,0.08); margin-bottom:20px;">
                <h3 style="font-size:16px; font-weight:700; color:#2D1B69; margin-bottom:16px; padding-bottom:12px; border-bottom:2px solid #6B35D9;">
                    📋 تفاصيل الدورة
                </h3>
                <?php
                $course_date     = get_post_meta(get_the_ID(), '_course_date', true);
                $course_duration = get_post_meta(get_the_ID(), '_course_duration', true);
                $course_platform = get_post_meta(get_the_ID(), '_course_platform', true);
                $course_link     = get_post_meta(get_the_ID(), '_course_link', true);
                ?>
                <?php if ($course_date): ?>
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px; font-size:14px;">
                    <i class="fa-solid fa-calendar" style="color:#6B35D9; width:16px;"></i>
                    <span style="color:#6B7280;">التاريخ:</span>
                    <span style="color:#2D1B69; font-weight:600;"><?php echo date('d F Y', strtotime($course_date)); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($course_duration): ?>
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px; font-size:14px;">
                    <i class="fa-solid fa-clock" style="color:#6B35D9; width:16px;"></i>
                    <span style="color:#6B7280;">المدة:</span>
                    <span style="color:#2D1B69; font-weight:600;"><?php echo esc_html($course_duration); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($course_platform): ?>
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px; font-size:14px;">
                    <i class="fa-solid fa-building" style="color:#6B35D9; width:16px;"></i>
                    <span style="color:#6B7280;">الجهة:</span>
                    <span style="color:#2D1B69; font-weight:600;"><?php echo esc_html($course_platform); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($course_link): ?>
                <a href="<?php echo esc_url($course_link); ?>" target="_blank" class="btn-primary" style="display:block; text-align:center; margin-top:16px;">
                    <i class="fa-solid fa-external-link"></i> الدخول للدورة
                </a>
                <?php endif; ?>
            </div>

            <?php elseif ($post_type === 'wida_document'): ?>
            <div style="background:#fff; border-radius:16px; padding:24px; border:1px solid #E5E0F5; box-shadow:0 2px 8px rgba(107,53,217,0.08); margin-bottom:20px;">
                <h3 style="font-size:16px; font-weight:700; color:#2D1B69; margin-bottom:16px; padding-bottom:12px; border-bottom:2px solid #6B35D9;">
                    📄 تفاصيل الدليل
                </h3>
                <?php
                $file_url = get_post_meta(get_the_ID(), '_doc_file_url', true);
                $doc_date = get_post_meta(get_the_ID(), '_doc_date', true);
                ?>
                <?php if ($doc_date): ?>
                <div style="font-size:14px; color:#6B7280; margin-bottom:16px;">
                    <i class="fa-regular fa-calendar"></i>
                    تاريخ الإصدار: <strong style="color:#2D1B69;"><?php echo date('d F Y', strtotime($doc_date)); ?></strong>
                </div>
                <?php endif; ?>
                <?php if ($file_url): ?>
                <a href="<?php echo esc_url($file_url); ?>" target="_blank" download class="btn-primary" style="display:block; text-align:center; margin-bottom:10px;">
                    <i class="fa-solid fa-download"></i> تحميل الملف
                </a>
                <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="btn-sm btn-sm-outline" style="display:block; text-align:center;">
                    <i class="fa-solid fa-eye"></i> معاينة
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Related Posts -->
            <div style="background:#fff; border-radius:16px; padding:24px; border:1px solid #E5E0F5; box-shadow:0 2px 8px rgba(107,53,217,0.08);">
                <h3 style="font-size:15px; font-weight:700; color:#2D1B69; margin-bottom:16px;">محتوى مشابه</h3>
                <?php
                $related = get_posts([
                    'post_type'      => $post_type,
                    'posts_per_page' => 4,
                    'post__not_in'   => [get_the_ID()],
                    'orderby'        => 'rand',
                ]);
                foreach ($related as $rel_post): ?>
                <a href="<?php echo get_permalink($rel_post->ID); ?>" style="display:block; padding:10px 0; border-bottom:1px solid #F0EDF8; color:#2D1B69; font-size:14px; transition:color 0.2s;">
                    <?php echo esc_html($rel_post->post_title); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
