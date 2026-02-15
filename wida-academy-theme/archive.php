<?php
/**
 * Archive Template - for courses, documents, identity, news
 */
get_header();

$post_type = get_post_type();
$post_type_obj = get_post_type_object($post_type);
$archive_title = $post_type_obj ? $post_type_obj->labels->name : get_the_archive_title();

// Icon mapping
$icons = [
    'wida_course'   => 'fa-graduation-cap',
    'wida_document' => 'fa-book-open',
    'wida_identity' => 'fa-palette',
    'wida_news'     => 'fa-megaphone',
];
$icon = $icons[$post_type] ?? 'fa-folder';
?>

<div class="dashboard-page">
    <!-- Page Header -->
    <div class="dashboard-hero" style="padding:36px; margin-bottom:32px;">
        <i class="fa-solid <?php echo $icon; ?>" style="font-size:36px; margin-bottom:12px; display:block; opacity:0.8;"></i>
        <h1><?php echo esc_html($archive_title); ?></h1>
    </div>

    <!-- Filter Bar -->
    <div style="background:#fff; border-radius:12px; padding:16px 24px; margin-bottom:24px; border:1px solid #E5E0F5; display:flex; align-items:center; gap:16px;">
        <span style="font-size:14px; color:#6B7280; font-weight:500;">ترتيب حسب:</span>
        <a href="?orderby=date&order=DESC" style="padding:6px 16px; border-radius:50px; font-size:13px; color:#6B35D9; border:1px solid #E5E0F5; transition:all 0.2s;" onmouseover="this.style.background='#6B35D9';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color='#6B35D9'">الأحدث</a>
        <a href="?orderby=title&order=ASC" style="padding:6px 16px; border-radius:50px; font-size:13px; color:#6B35D9; border:1px solid #E5E0F5; transition:all 0.2s;" onmouseover="this.style.background='#6B35D9';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color='#6B35D9'">أبجدياً</a>
        <span style="margin-right:auto; font-size:13px; color:#9CA3AF;">
            إجمالي: <strong style="color:#6B35D9;"><?php echo $wp_query->found_posts; ?></strong> عنصر
        </span>
    </div>

    <?php if (have_posts()): ?>

    <?php if ($post_type === 'wida_document'): ?>
    <!-- Documents Grid -->
    <div class="cards-grid cards-grid-2">
        <?php while (have_posts()): the_post(); ?>
        <?php
        $file_url = get_post_meta(get_the_ID(), '_doc_file_url', true);
        $doc_date = get_post_meta(get_the_ID(), '_doc_date', true);
        ?>
        <div class="doc-card">
            <div class="doc-card-icon"><i class="fa-solid fa-file-pdf"></i></div>
            <div class="doc-card-content">
                <h3><?php the_title(); ?></h3>
                <?php if (get_the_excerpt()): ?>
                <p><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                <?php endif; ?>
                <?php if ($doc_date): ?>
                <p style="font-size:11px; color:#9CA3AF;"><i class="fa-regular fa-calendar"></i> <?php echo date('F Y', strtotime($doc_date)); ?></p>
                <?php endif; ?>
                <div class="doc-card-actions">
                    <?php if ($file_url): ?>
                    <a href="<?php echo esc_url($file_url); ?>" target="_blank" download class="btn-sm btn-sm-primary">
                        <i class="fa-solid fa-download"></i> تحميل
                    </a>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="btn-sm btn-sm-outline">
                        <i class="fa-solid fa-eye"></i> قراءة
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <?php elseif ($post_type === 'wida_news'): ?>
    <!-- News Grid -->
    <div class="cards-grid cards-grid-3">
        <?php while (have_posts()): the_post(); ?>
        <div class="news-card">
            <div class="news-card-header">
                <div class="news-card-date-num"><?php echo get_the_date('d'); ?></div>
                <div class="news-card-date-month"><?php echo get_the_date('F Y'); ?></div>
            </div>
            <div class="news-card-body">
                <h3><a href="<?php the_permalink(); ?>" style="color:inherit;"><?php the_title(); ?></a></h3>
                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                <a href="<?php the_permalink(); ?>" style="color:#6B35D9; font-size:13px; font-weight:600; display:inline-block; margin-top:8px;">اقرأ أكثر ←</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <?php else: ?>
    <!-- Courses / Identity Grid -->
    <div class="cards-grid">
        <?php $i = 0; while (have_posts()): the_post(); $i++; ?>
        <div class="course-card">
            <div class="course-card-thumb" style="background:<?php echo wida_card_gradient($i - 1); ?>;">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('course-thumb', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                <?php else: ?>
                    <i class="fa-solid <?php echo $icon; ?> thumb-icon"></i>
                <?php endif; ?>
                <?php
                $course_date = get_post_meta(get_the_ID(), '_course_date', true);
                if ($course_date): ?>
                <span class="thumb-badge"><?php echo date('F Y', strtotime($course_date)); ?></span>
                <?php endif; ?>
            </div>
            <div class="course-card-body">
                <h3><a href="<?php the_permalink(); ?>" style="color:inherit;"><?php the_title(); ?></a></h3>
                <?php if (get_the_excerpt()): ?>
                <p style="font-size:13px; color:#6B7280; line-height:1.5;"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                <?php endif; ?>
                <div class="course-card-meta">
                    <span class="course-card-date"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date('Y/m/d'); ?></span>
                    <a href="<?php the_permalink(); ?>" style="color:#6B35D9; font-size:13px; font-weight:600;">التفاصيل ←</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>

    <!-- Pagination -->
    <div style="margin-top:32px; text-align:center;">
        <?php
        the_posts_pagination([
            'mid_size'  => 3,
            'prev_text' => '→ السابق',
            'next_text' => 'التالي ←',
        ]);
        ?>
    </div>

    <?php else: ?>
    <div style="background:#fff; border-radius:12px; padding:60px; text-align:center; border:1px solid #E5E0F5;">
        <i class="fa-solid <?php echo $icon; ?>" style="font-size:56px; color:#D8B4FE; margin-bottom:20px;"></i>
        <h2 style="color:#2D1B69; margin-bottom:8px;">لا يوجد محتوى حالياً</h2>
        <p style="color:#6B7280;">سيتم إضافة المحتوى قريباً.</p>
    </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
