<?php
/**
 * Front Page / Dashboard Template
 * الصفحة الرئيسية / لوحة البيانات
 */

// Redirect to login if not logged in
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login/'));
    exit;
}

get_header();

$current_user = wp_get_current_user();
$courses_query = wida_get_courses(4);
$docs_query    = wida_get_documents(4);
$news_query    = wida_get_news(3);
?>

<div class="dashboard-page">

    <!-- Welcome Banner -->
    <div class="dashboard-hero">
        <div class="hero-content">
            <h1>مرحباً، <?php echo esc_html($current_user->display_name ?: $current_user->user_login); ?> 👋</h1>
            <p>منصة المعرفة لموظفي وايدا — تعلّم، طوّر، وشارك المعرفة</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            <div class="stat-info">
                <h3><?php echo wp_count_posts('wida_course')->publish; ?></h3>
                <p>الدورات المتاحة</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#8B5CF6; background:#F3E8FF;"><i class="fa-solid fa-book-open"></i></div>
            <div class="stat-info">
                <h3><?php echo wp_count_posts('wida_document')->publish; ?></h3>
                <p>الأدلة الإرشادية</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#A855F7; background:#FAF0FF;"><i class="fa-solid fa-palette"></i></div>
            <div class="stat-info">
                <h3><?php echo wp_count_posts('wida_identity')->publish; ?></h3>
                <p>عناصر الهوية البصرية</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#7C3AED; background:#EDE9FE;"><i class="fa-solid fa-megaphone"></i></div>
            <div class="stat-info">
                <h3><?php echo wp_count_posts('wida_news')->publish; ?></h3>
                <p>الأخبار والفعاليات</p>
            </div>
        </div>
    </div>

    <!-- ========================
         Training Courses Section
         ======================== -->
    <div class="section-header">
        <h2 class="section-title">الدورات التدريبية</h2>
        <a href="<?php echo get_post_type_archive_link('wida_course'); ?>" class="view-all-link">
            عرض جميع الدورات <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>

    <?php if ($courses_query->have_posts()): ?>
    <div class="cards-grid">
        <?php $i = 0; while ($courses_query->have_posts()): $courses_query->the_post(); $i++; ?>
        <div class="course-card">
            <div class="course-card-thumb" style="background: <?php echo wida_card_gradient($i - 1); ?>;">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('course-thumb', ['style' => 'width:100%; height:100%; object-fit:cover; position:absolute; top:0; left:0;']); ?>
                <?php else: ?>
                    <i class="fa-solid fa-graduation-cap thumb-icon"></i>
                <?php endif; ?>
                <span class="thumb-badge">
                    <?php
                    $date = get_post_meta(get_the_ID(), '_course_date', true);
                    echo $date ? date('F Y', strtotime($date)) : date('F Y');
                    ?>
                </span>
            </div>
            <div class="course-card-body">
                <h3><?php the_title(); ?></h3>
                <?php if (get_the_excerpt()): ?>
                <p style="font-size:13px; color:#6B7280; margin-bottom:8px; line-height:1.5;">
                    <?php echo wp_trim_words(get_the_excerpt(), 12); ?>
                </p>
                <?php endif; ?>
                <div class="course-card-meta">
                    <span class="course-card-date">
                        <i class="fa-regular fa-calendar"></i>
                        <?php echo get_the_date('Y/m/d'); ?>
                    </span>
                    <?php
                    $course_link = get_post_meta(get_the_ID(), '_course_link', true);
                    $target_url  = $course_link ?: get_permalink();
                    ?>
                    <a href="<?php echo esc_url($target_url); ?>" <?php echo $course_link ? 'target="_blank"' : ''; ?> style="color:#6B35D9; font-size:13px; font-weight:600;">
                        الدخول ←
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else: ?>
    <div style="background:#fff; border-radius:12px; padding:40px; text-align:center; border:1px solid #E5E0F5; margin-bottom:40px;">
        <i class="fa-solid fa-graduation-cap" style="font-size:48px; color:#D8B4FE; margin-bottom:16px;"></i>
        <p style="color:#6B7280; font-size:16px;">لا توجد دورات متاحة حالياً</p>
        <?php if (current_user_can('manage_options')): ?>
        <a href="<?php echo admin_url('post-new.php?post_type=wida_course'); ?>" class="btn-primary" style="display:inline-block; width:auto; padding:12px 24px; margin-top:16px;">
            + أضف أول دورة
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- ========================
         Guidance Documents
         ======================== -->
    <div class="section-header">
        <h2 class="section-title">الأدلة الإرشادية</h2>
        <a href="<?php echo get_post_type_archive_link('wida_document'); ?>" class="view-all-link">
            عرض جميع الأدلة <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>

    <?php if ($docs_query->have_posts()): ?>
    <div class="cards-grid cards-grid-2" style="margin-bottom:48px;">
        <?php while ($docs_query->have_posts()): $docs_query->the_post(); ?>
        <?php
        $file_url = get_post_meta(get_the_ID(), '_doc_file_url', true);
        $doc_date = get_post_meta(get_the_ID(), '_doc_date', true);
        ?>
        <div class="doc-card">
            <div class="doc-card-icon">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <div class="doc-card-content">
                <h3><?php the_title(); ?></h3>
                <?php if (get_the_excerpt()): ?>
                <p><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                <?php endif; ?>
                <?php if ($doc_date): ?>
                <p style="font-size:11px; color:#9CA3AF; margin-bottom:8px;">
                    <i class="fa-regular fa-calendar"></i>
                    <?php echo date('F Y', strtotime($doc_date)); ?>
                </p>
                <?php endif; ?>
                <div class="doc-card-actions">
                    <?php if ($file_url): ?>
                    <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="btn-sm btn-sm-primary">
                        <i class="fa-solid fa-download"></i> تحميل
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo get_permalink(); ?>" class="btn-sm btn-sm-outline">
                        <i class="fa-solid fa-eye"></i> قراءة
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else: ?>
    <div style="background:#fff; border-radius:12px; padding:40px; text-align:center; border:1px solid #E5E0F5; margin-bottom:40px;">
        <i class="fa-solid fa-book-open" style="font-size:48px; color:#D8B4FE; margin-bottom:16px;"></i>
        <p style="color:#6B7280; font-size:16px;">لا توجد أدلة إرشادية متاحة حالياً</p>
    </div>
    <?php endif; ?>

    <!-- ========================
         News / Events
         ======================== -->
    <div class="section-header">
        <h2 class="section-title">الأخبار والفعاليات</h2>
        <a href="<?php echo get_post_type_archive_link('wida_news'); ?>" class="view-all-link">
            عرض الكل <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>

    <?php if ($news_query->have_posts()): ?>
    <div class="cards-grid cards-grid-3" style="margin-bottom:48px;">
        <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
        <div class="news-card">
            <div class="news-card-header">
                <div class="news-card-date-num"><?php echo get_the_date('d'); ?></div>
                <div class="news-card-date-month"><?php echo get_the_date('F Y'); ?></div>
            </div>
            <div class="news-card-body">
                <h3><?php the_title(); ?></h3>
                <?php if (get_the_excerpt()): ?>
                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                <?php endif; ?>
                <a href="<?php the_permalink(); ?>" style="color:#6B35D9; font-size:13px; font-weight:600; margin-top:8px; display:inline-block;">
                    اقرأ أكثر ←
                </a>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php endif; ?>

    <!-- ========================
         Visual Identity Section
         ======================== -->
    <?php
    $identity_query = new WP_Query([
        'post_type'      => 'wida_identity',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    ]);
    ?>
    <?php if ($identity_query->have_posts()): ?>
    <div class="section-header">
        <h2 class="section-title">الهوية البصرية</h2>
        <a href="<?php echo get_post_type_archive_link('wida_identity'); ?>" class="view-all-link">
            عرض الكل <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>
    <div class="cards-grid cards-grid-3" style="margin-bottom:48px;">
        <?php while ($identity_query->have_posts()): $identity_query->the_post(); ?>
        <div class="course-card">
            <div class="course-card-thumb" style="background:linear-gradient(135deg, #2D1B69, #6B35D9);">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('course-thumb', ['style' => 'width:100%; height:100%; object-fit:cover;']); ?>
                <?php else: ?>
                    <i class="fa-solid fa-palette thumb-icon"></i>
                <?php endif; ?>
            </div>
            <div class="course-card-body">
                <h3><?php the_title(); ?></h3>
                <?php if (get_the_excerpt()): ?>
                <p style="font-size:13px; color:#6B7280; line-height:1.5;"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                <?php endif; ?>
                <div class="course-card-meta">
                    <a href="<?php the_permalink(); ?>" style="color:#6B35D9; font-size:13px; font-weight:600;">
                        عرض التفاصيل ←
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php endif; ?>

</div><!-- /.dashboard-page -->

<?php get_footer(); ?>
