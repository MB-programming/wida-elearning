<?php
/**
 * Wida Academy Theme Functions
 *
 * @package wida-academy
 */

defined('ABSPATH') || exit;

// =============================================
// Theme Setup
// =============================================
function wida_setup() {
    // RTL Arabic support
    load_theme_textdomain('wida-academy', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    add_theme_support('woocommerce');

    // Register menus
    register_nav_menus([
        'primary'    => __('القائمة الرئيسية', 'wida-academy'),
        'footer'     => __('قائمة الفوتر', 'wida-academy'),
    ]);

    // Image sizes
    add_image_size('course-thumb', 400, 240, true);
    add_image_size('doc-thumb', 100, 100, true);
}
add_action('after_setup_theme', 'wida_setup');

// =============================================
// Enqueue Scripts & Styles
// =============================================
function wida_enqueue_assets() {
    // Google Fonts - Arabic
    wp_enqueue_style(
        'wida-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&display=swap',
        [],
        null
    );

    // Font Awesome
    wp_enqueue_style(
        'wida-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        [],
        '6.5.0'
    );

    // Main stylesheet
    wp_enqueue_style('wida-style', get_stylesheet_uri(), ['wida-google-fonts'], '1.0.0');

    // Main JS
    wp_enqueue_script(
        'wida-main',
        get_template_directory_uri() . '/assets/js/main.js',
        ['jquery'],
        '1.0.0',
        true
    );

    // Localize script
    wp_localize_script('wida-main', 'widaAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('wida_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'wida_enqueue_assets');

// =============================================
// Custom Post Types
// =============================================

// Training Courses CPT
function wida_register_cpt_courses() {
    register_post_type('wida_course', [
        'labels' => [
            'name'               => __('الدورات التدريبية', 'wida-academy'),
            'singular_name'      => __('دورة تدريبية', 'wida-academy'),
            'add_new'            => __('إضافة دورة', 'wida-academy'),
            'add_new_item'       => __('إضافة دورة جديدة', 'wida-academy'),
            'edit_item'          => __('تعديل الدورة', 'wida-academy'),
            'view_item'          => __('عرض الدورة', 'wida-academy'),
            'search_items'       => __('بحث في الدورات', 'wida-academy'),
            'not_found'          => __('لا توجد دورات', 'wida-academy'),
            'menu_name'          => __('الدورات التدريبية', 'wida-academy'),
        ],
        'public'             => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'courses'],
        'menu_position'      => 5,
    ]);
}
add_action('init', 'wida_register_cpt_courses');

// Guidance Documents CPT
function wida_register_cpt_documents() {
    register_post_type('wida_document', [
        'labels' => [
            'name'               => __('الأدلة الإرشادية', 'wida-academy'),
            'singular_name'      => __('دليل إرشادي', 'wida-academy'),
            'add_new'            => __('إضافة دليل', 'wida-academy'),
            'add_new_item'       => __('إضافة دليل جديد', 'wida-academy'),
            'edit_item'          => __('تعديل الدليل', 'wida-academy'),
            'view_item'          => __('عرض الدليل', 'wida-academy'),
            'search_items'       => __('بحث في الأدلة', 'wida-academy'),
            'not_found'          => __('لا توجد أدلة', 'wida-academy'),
            'menu_name'          => __('الأدلة الإرشادية', 'wida-academy'),
        ],
        'public'             => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'          => 'dashicons-media-document',
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'documents'],
        'menu_position'      => 6,
    ]);
}
add_action('init', 'wida_register_cpt_documents');

// Visual Identity CPT
function wida_register_cpt_identity() {
    register_post_type('wida_identity', [
        'labels' => [
            'name'               => __('الهوية البصرية', 'wida-academy'),
            'singular_name'      => __('عنصر هوية بصرية', 'wida-academy'),
            'add_new'            => __('إضافة عنصر', 'wida-academy'),
            'add_new_item'       => __('إضافة عنصر جديد', 'wida-academy'),
            'edit_item'          => __('تعديل العنصر', 'wida-academy'),
            'view_item'          => __('عرض العنصر', 'wida-academy'),
            'menu_name'          => __('الهوية البصرية', 'wida-academy'),
        ],
        'public'             => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'          => 'dashicons-art',
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'identity'],
        'menu_position'      => 7,
    ]);
}
add_action('init', 'wida_register_cpt_identity');

// News/Events CPT
function wida_register_cpt_news() {
    register_post_type('wida_news', [
        'labels' => [
            'name'               => __('الأخبار والفعاليات', 'wida-academy'),
            'singular_name'      => __('خبر أو فعالية', 'wida-academy'),
            'add_new'            => __('إضافة خبر', 'wida-academy'),
            'add_new_item'       => __('إضافة خبر جديد', 'wida-academy'),
            'edit_item'          => __('تعديل الخبر', 'wida-academy'),
            'menu_name'          => __('الأخبار', 'wida-academy'),
        ],
        'public'             => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'          => 'dashicons-megaphone',
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'news'],
        'menu_position'      => 8,
    ]);
}
add_action('init', 'wida_register_cpt_news');

// =============================================
// Custom Taxonomies
// =============================================
function wida_register_taxonomies() {
    // Course Category
    register_taxonomy('course_category', ['wida_course'], [
        'labels' => [
            'name'              => __('أقسام الدورات', 'wida-academy'),
            'singular_name'     => __('قسم', 'wida-academy'),
            'menu_name'         => __('أقسام الدورات', 'wida-academy'),
        ],
        'hierarchical'  => true,
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'course-category'],
    ]);

    // Department Taxonomy
    register_taxonomy('wida_department', ['wida_course', 'wida_document', 'wida_news'], [
        'labels' => [
            'name'              => __('الأقسام والإدارات', 'wida-academy'),
            'singular_name'     => __('قسم', 'wida-academy'),
            'menu_name'         => __('الأقسام', 'wida-academy'),
        ],
        'hierarchical'  => true,
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'department'],
    ]);
}
add_action('init', 'wida_register_taxonomies');

// =============================================
// Custom Meta Boxes
// =============================================
function wida_add_meta_boxes() {
    // Course details
    add_meta_box(
        'wida_course_details',
        __('تفاصيل الدورة', 'wida-academy'),
        'wida_course_details_callback',
        'wida_course',
        'side',
        'high'
    );

    // Document details
    add_meta_box(
        'wida_document_details',
        __('تفاصيل الدليل', 'wida-academy'),
        'wida_document_details_callback',
        'wida_document',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'wida_add_meta_boxes');

function wida_course_details_callback($post) {
    $date     = get_post_meta($post->ID, '_course_date', true);
    $duration = get_post_meta($post->ID, '_course_duration', true);
    $platform = get_post_meta($post->ID, '_course_platform', true);
    $link     = get_post_meta($post->ID, '_course_link', true);
    wp_nonce_field('wida_course_meta', 'wida_course_nonce');
    ?>
    <p>
        <label><?php _e('تاريخ الدورة', 'wida-academy'); ?></label><br>
        <input type="date" name="course_date" value="<?php echo esc_attr($date); ?>" style="width:100%">
    </p>
    <p>
        <label><?php _e('مدة الدورة', 'wida-academy'); ?></label><br>
        <input type="text" name="course_duration" value="<?php echo esc_attr($duration); ?>" placeholder="مثال: 3 ساعات" style="width:100%">
    </p>
    <p>
        <label><?php _e('المنصة / الجهة', 'wida-academy'); ?></label><br>
        <input type="text" name="course_platform" value="<?php echo esc_attr($platform); ?>" placeholder="مثال: Udemy" style="width:100%">
    </p>
    <p>
        <label><?php _e('رابط الدورة', 'wida-academy'); ?></label><br>
        <input type="url" name="course_link" value="<?php echo esc_url($link); ?>" style="width:100%">
    </p>
    <?php
}

function wida_document_details_callback($post) {
    $file_url = get_post_meta($post->ID, '_doc_file_url', true);
    $doc_date = get_post_meta($post->ID, '_doc_date', true);
    wp_nonce_field('wida_document_meta', 'wida_document_nonce');
    ?>
    <p>
        <label><?php _e('رابط ملف PDF', 'wida-academy'); ?></label><br>
        <input type="url" name="doc_file_url" value="<?php echo esc_url($file_url); ?>" placeholder="https://..." style="width:100%">
        <button type="button" class="button" onclick="widaOpenMediaUploader(this)"><?php _e('رفع ملف', 'wida-academy'); ?></button>
    </p>
    <p>
        <label><?php _e('تاريخ الإصدار', 'wida-academy'); ?></label><br>
        <input type="date" name="doc_date" value="<?php echo esc_attr($doc_date); ?>" style="width:100%">
    </p>
    <?php
}

// Save meta
function wida_save_course_meta($post_id) {
    if (!isset($_POST['wida_course_nonce']) || !wp_verify_nonce($_POST['wida_course_nonce'], 'wida_course_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['course_date', 'course_duration', 'course_platform', 'course_link'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_wida_course', 'wida_save_course_meta');

function wida_save_document_meta($post_id) {
    if (!isset($_POST['wida_document_nonce']) || !wp_verify_nonce($_POST['wida_document_nonce'], 'wida_document_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['doc_file_url'])) {
        update_post_meta($post_id, '_doc_file_url', esc_url_raw($_POST['doc_file_url']));
    }
    if (isset($_POST['doc_date'])) {
        update_post_meta($post_id, '_doc_date', sanitize_text_field($_POST['doc_date']));
    }
}
add_action('save_post_wida_document', 'wida_save_document_meta');

// =============================================
// Admin Menu Pages
// =============================================
function wida_admin_menu() {
    // Main admin dashboard
    add_menu_page(
        __('أكاديمية وايدا', 'wida-academy'),
        __('أكاديمية وايدا', 'wida-academy'),
        'manage_options',
        'wida-academy-dashboard',
        'wida_admin_dashboard_page',
        'dashicons-welcome-learn-more',
        2
    );

    add_submenu_page(
        'wida-academy-dashboard',
        __('لوحة التحكم', 'wida-academy'),
        __('لوحة التحكم', 'wida-academy'),
        'manage_options',
        'wida-academy-dashboard',
        'wida_admin_dashboard_page'
    );

    add_submenu_page(
        'wida-academy-dashboard',
        __('إعدادات الموقع', 'wida-academy'),
        __('الإعدادات', 'wida-academy'),
        'manage_options',
        'wida-academy-settings',
        'wida_admin_settings_page'
    );

    add_submenu_page(
        'wida-academy-dashboard',
        __('تقارير الاستخدام', 'wida-academy'),
        __('التقارير', 'wida-academy'),
        'manage_options',
        'wida-academy-reports',
        'wida_admin_reports_page'
    );
}
add_action('admin_menu', 'wida_admin_menu');

// =============================================
// Admin Dashboard Page
// =============================================
function wida_admin_dashboard_page() {
    $courses_count   = wp_count_posts('wida_course')->publish;
    $docs_count      = wp_count_posts('wida_document')->publish;
    $identity_count  = wp_count_posts('wida_identity')->publish;
    $news_count      = wp_count_posts('wida_news')->publish;
    $users_count     = count_users()['total_users'];

    $recent_courses = get_posts([
        'post_type'      => 'wida_course',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    $recent_docs = get_posts([
        'post_type'      => 'wida_document',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    ?>
    <div class="wida-admin-wrap wrap">
        <div class="wida-admin-header">
            <h1>
                <span style="font-style:italic; font-weight:800;">wida</span>
                أكاديمية وايدا — لوحة التحكم
            </h1>
            <p style="opacity:0.8; margin-top:6px;">منصة المعرفة لموظفي وايدا</p>
        </div>

        <!-- Stats -->
        <div class="wida-admin-stats">
            <div class="wida-stat-box">
                <div class="stat-num"><?php echo $courses_count; ?></div>
                <div class="stat-label">📚 الدورات التدريبية</div>
            </div>
            <div class="wida-stat-box">
                <div class="stat-num"><?php echo $docs_count; ?></div>
                <div class="stat-label">📄 الأدلة الإرشادية</div>
            </div>
            <div class="wida-stat-box">
                <div class="stat-num"><?php echo $identity_count; ?></div>
                <div class="stat-label">🎨 عناصر الهوية البصرية</div>
            </div>
            <div class="wida-stat-box">
                <div class="stat-num"><?php echo $users_count; ?></div>
                <div class="stat-label">👥 إجمالي المستخدمين</div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
            <!-- Recent Courses -->
            <div style="background:#fff; border-radius:12px; padding:24px; border:1px solid #E5E0F5;">
                <h2 style="font-size:18px; font-weight:700; margin-bottom:16px; color:#2D1B69; display:flex; align-items:center; gap:8px;">
                    📚 <span>آخر الدورات المضافة</span>
                    <a href="<?php echo admin_url('edit.php?post_type=wida_course'); ?>" style="font-size:12px; margin-right:auto; color:#6B35D9; font-weight:500;">عرض الكل ←</a>
                </h2>
                <?php if ($recent_courses): ?>
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#F5F3FF;">
                            <th style="padding:10px; text-align:right; font-size:13px; color:#6B35D9;">اسم الدورة</th>
                            <th style="padding:10px; text-align:right; font-size:13px; color:#6B35D9;">التاريخ</th>
                            <th style="padding:10px; text-align:right; font-size:13px; color:#6B35D9;">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recent_courses as $course): ?>
                        <tr style="border-bottom:1px solid #F0EDF8;">
                            <td style="padding:10px; font-size:14px; color:#2D1B69;"><?php echo esc_html($course->post_title); ?></td>
                            <td style="padding:10px; font-size:12px; color:#9CA3AF;"><?php echo get_the_date('Y/m/d', $course->ID); ?></td>
                            <td style="padding:10px;">
                                <a href="<?php echo get_edit_post_link($course->ID); ?>" style="color:#6B35D9; font-size:12px;">تعديل</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p style="text-align:center; color:#9CA3AF; padding:20px;">لا توجد دورات بعد. <a href="<?php echo admin_url('post-new.php?post_type=wida_course'); ?>">أضف الأولى ←</a></p>
                <?php endif; ?>

                <div style="margin-top:16px; text-align:left;">
                    <a href="<?php echo admin_url('post-new.php?post_type=wida_course'); ?>" class="button button-primary" style="background:#6B35D9; border-color:#6B35D9;">
                        + إضافة دورة جديدة
                    </a>
                </div>
            </div>

            <!-- Recent Documents -->
            <div style="background:#fff; border-radius:12px; padding:24px; border:1px solid #E5E0F5;">
                <h2 style="font-size:18px; font-weight:700; margin-bottom:16px; color:#2D1B69; display:flex; align-items:center; gap:8px;">
                    📄 <span>آخر الأدلة المضافة</span>
                    <a href="<?php echo admin_url('edit.php?post_type=wida_document'); ?>" style="font-size:12px; margin-right:auto; color:#6B35D9; font-weight:500;">عرض الكل ←</a>
                </h2>
                <?php if ($recent_docs): ?>
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#F5F3FF;">
                            <th style="padding:10px; text-align:right; font-size:13px; color:#6B35D9;">اسم الدليل</th>
                            <th style="padding:10px; text-align:right; font-size:13px; color:#6B35D9;">التاريخ</th>
                            <th style="padding:10px; text-align:right; font-size:13px; color:#6B35D9;">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recent_docs as $doc): ?>
                        <tr style="border-bottom:1px solid #F0EDF8;">
                            <td style="padding:10px; font-size:14px; color:#2D1B69;"><?php echo esc_html($doc->post_title); ?></td>
                            <td style="padding:10px; font-size:12px; color:#9CA3AF;"><?php echo get_the_date('Y/m/d', $doc->ID); ?></td>
                            <td style="padding:10px;">
                                <a href="<?php echo get_edit_post_link($doc->ID); ?>" style="color:#6B35D9; font-size:12px;">تعديل</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p style="text-align:center; color:#9CA3AF; padding:20px;">لا توجد أدلة بعد. <a href="<?php echo admin_url('post-new.php?post_type=wida_document'); ?>">أضف الأول ←</a></p>
                <?php endif; ?>

                <div style="margin-top:16px; text-align:left;">
                    <a href="<?php echo admin_url('post-new.php?post_type=wida_document'); ?>" class="button button-primary" style="background:#6B35D9; border-color:#6B35D9;">
                        + إضافة دليل جديد
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div style="background:#fff; border-radius:12px; padding:24px; margin-top:24px; border:1px solid #E5E0F5;">
            <h2 style="font-size:18px; font-weight:700; margin-bottom:20px; color:#2D1B69;">⚡ إجراءات سريعة</h2>
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <a href="<?php echo admin_url('post-new.php?post_type=wida_course'); ?>" class="button button-primary" style="background:#6B35D9; border-color:#6B35D9; padding:10px 20px; height:auto;">📚 إضافة دورة</a>
                <a href="<?php echo admin_url('post-new.php?post_type=wida_document'); ?>" class="button button-primary" style="background:#8B5CF6; border-color:#8B5CF6; padding:10px 20px; height:auto;">📄 إضافة دليل</a>
                <a href="<?php echo admin_url('post-new.php?post_type=wida_identity'); ?>" class="button button-primary" style="background:#A855F7; border-color:#A855F7; padding:10px 20px; height:auto;">🎨 إضافة هوية بصرية</a>
                <a href="<?php echo admin_url('post-new.php?post_type=wida_news'); ?>" class="button button-primary" style="background:#7C3AED; border-color:#7C3AED; padding:10px 20px; height:auto;">📢 إضافة خبر</a>
                <a href="<?php echo admin_url('user-new.php'); ?>" class="button" style="padding:10px 20px; height:auto;">👤 إضافة مستخدم</a>
                <a href="<?php echo admin_url('admin.php?page=wida-academy-settings'); ?>" class="button" style="padding:10px 20px; height:auto;">⚙️ الإعدادات</a>
            </div>
        </div>
    </div>

    <style>
    .wida-admin-wrap { direction:rtl; font-family:'Cairo',sans-serif; }
    .wida-admin-header { background:linear-gradient(135deg,#6B35D9,#A855F7); border-radius:12px; padding:30px; color:#fff; margin-bottom:24px; }
    .wida-admin-header h1 { font-size:26px; margin:0; }
    .wida-admin-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:24px; }
    .wida-stat-box { background:#fff; border-radius:12px; padding:24px; text-align:center; border:1px solid #E5E0F5; box-shadow:0 2px 8px rgba(107,53,217,0.08); }
    .wida-stat-box .stat-num { font-size:40px; font-weight:800; color:#6B35D9; line-height:1; }
    .wida-stat-box .stat-label { font-size:13px; color:#6B7280; margin-top:8px; }
    </style>
    <?php
}

// =============================================
// Admin Settings Page
// =============================================
function wida_admin_settings_page() {
    if (isset($_POST['wida_save_settings'])) {
        check_admin_referer('wida_settings');
        $fields = ['wida_site_email_it', 'wida_site_email_hr', 'wida_site_email_info', 'wida_site_url', 'wida_hero_title', 'wida_hero_tagline', 'wida_google_client_id'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_option($field, sanitize_text_field($_POST[$field]));
            }
        }
        echo '<div class="notice notice-success"><p>✅ تم حفظ الإعدادات بنجاح!</p></div>';
    }
    ?>
    <div class="wida-admin-wrap wrap">
        <div class="wida-admin-header">
            <h1>⚙️ إعدادات أكاديمية وايدا</h1>
        </div>
        <form method="post" action="">
            <?php wp_nonce_field('wida_settings'); ?>
            <div style="background:#fff; border-radius:12px; padding:30px; border:1px solid #E5E0F5;">
                <h2 style="color:#6B35D9; margin-bottom:20px;">معلومات التواصل</h2>
                <table class="form-table" style="direction:rtl;">
                    <tr>
                        <th style="text-align:right;"><?php _e('بريد IT', 'wida-academy'); ?></th>
                        <td><input type="email" name="wida_site_email_it" value="<?php echo esc_attr(get_option('wida_site_email_it', 'IT@wida.sa')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;"><?php _e('بريد HR', 'wida-academy'); ?></th>
                        <td><input type="email" name="wida_site_email_hr" value="<?php echo esc_attr(get_option('wida_site_email_hr', 'HR@wida.sa')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;"><?php _e('البريد العام', 'wida-academy'); ?></th>
                        <td><input type="email" name="wida_site_email_info" value="<?php echo esc_attr(get_option('wida_site_email_info', 'info@wida.sa')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;"><?php _e('رابط الموقع الرئيسي', 'wida-academy'); ?></th>
                        <td><input type="url" name="wida_site_url" value="<?php echo esc_url(get_option('wida_site_url', 'https://www.wida.sa')); ?>" class="regular-text"></td>
                    </tr>
                </table>

                <h2 style="color:#6B35D9; margin-top:30px; margin-bottom:20px;">إعدادات الصفحة الرئيسية</h2>
                <table class="form-table" style="direction:rtl;">
                    <tr>
                        <th style="text-align:right;"><?php _e('عنوان البطل الرئيسي', 'wida-academy'); ?></th>
                        <td><input type="text" name="wida_hero_title" value="<?php echo esc_attr(get_option('wida_hero_title', 'أكاديمية وايدا')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;"><?php _e('الشعار الفرعي', 'wida-academy'); ?></th>
                        <td><input type="text" name="wida_hero_tagline" value="<?php echo esc_attr(get_option('wida_hero_tagline', 'منصة المعرفة لموظفي وايدا')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;"><?php _e('Google Client ID', 'wida-academy'); ?></th>
                        <td><input type="text" name="wida_google_client_id" value="<?php echo esc_attr(get_option('wida_google_client_id', '')); ?>" class="regular-text" placeholder="your-client-id.apps.googleusercontent.com"></td>
                    </tr>
                </table>
            </div>

            <p style="margin-top:20px;">
                <input type="submit" name="wida_save_settings" class="button button-primary" value="💾 حفظ الإعدادات" style="background:#6B35D9; border-color:#6B35D9; padding:10px 24px; height:auto; font-size:15px;">
            </p>
        </form>
    </div>
    <style>
    .wida-admin-wrap { direction:rtl; font-family:'Cairo',sans-serif; }
    .wida-admin-header { background:linear-gradient(135deg,#6B35D9,#A855F7); border-radius:12px; padding:24px; color:#fff; margin-bottom:24px; }
    .wida-admin-header h1 { font-size:24px; margin:0; color:#fff; }
    </style>
    <?php
}

// =============================================
// Admin Reports Page
// =============================================
function wida_admin_reports_page() {
    global $wpdb;
    $courses_count   = wp_count_posts('wida_course')->publish;
    $docs_count      = wp_count_posts('wida_document')->publish;
    $identity_count  = wp_count_posts('wida_identity')->publish;
    $news_count      = wp_count_posts('wida_news')->publish;
    $users_count     = count_users()['total_users'];
    ?>
    <div class="wida-admin-wrap wrap">
        <div class="wida-admin-header">
            <h1>📊 تقارير الاستخدام</h1>
            <p style="opacity:0.8; margin-top:4px;">إحصائيات شاملة لأكاديمية وايدا</p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:24px;">
            <div style="background:#fff; border-radius:12px; padding:24px; border:1px solid #E5E0F5; text-align:center;">
                <div style="font-size:48px; font-weight:800; color:#6B35D9;"><?php echo $courses_count; ?></div>
                <div style="color:#6B7280; margin-top:8px;">📚 إجمالي الدورات</div>
            </div>
            <div style="background:#fff; border-radius:12px; padding:24px; border:1px solid #E5E0F5; text-align:center;">
                <div style="font-size:48px; font-weight:800; color:#8B5CF6;"><?php echo $docs_count; ?></div>
                <div style="color:#6B7280; margin-top:8px;">📄 إجمالي الأدلة</div>
            </div>
            <div style="background:#fff; border-radius:12px; padding:24px; border:1px solid #E5E0F5; text-align:center;">
                <div style="font-size:48px; font-weight:800; color:#A855F7;"><?php echo $users_count; ?></div>
                <div style="color:#6B7280; margin-top:8px;">👥 إجمالي المستخدمين</div>
            </div>
        </div>

        <div style="background:#fff; border-radius:12px; padding:24px; border:1px solid #E5E0F5;">
            <h2 style="color:#2D1B69; margin-bottom:16px;">📈 ملخص المحتوى</h2>
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#F5F3FF;">
                        <th style="padding:12px; text-align:right; color:#6B35D9; font-size:14px;">نوع المحتوى</th>
                        <th style="padding:12px; text-align:center; color:#6B35D9; font-size:14px;">المنشور</th>
                        <th style="padding:12px; text-align:center; color:#6B35D9; font-size:14px;">المسودة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $types = [
                        ['name' => '📚 الدورات التدريبية', 'type' => 'wida_course'],
                        ['name' => '📄 الأدلة الإرشادية', 'type' => 'wida_document'],
                        ['name' => '🎨 الهوية البصرية', 'type' => 'wida_identity'],
                        ['name' => '📢 الأخبار والفعاليات', 'type' => 'wida_news'],
                    ];
                    foreach ($types as $item):
                        $counts = wp_count_posts($item['type']);
                    ?>
                    <tr style="border-bottom:1px solid #F0EDF8;">
                        <td style="padding:12px; font-size:14px; color:#2D1B69;"><?php echo $item['name']; ?></td>
                        <td style="padding:12px; text-align:center; font-weight:700; color:#6B35D9; font-size:16px;"><?php echo $counts->publish; ?></td>
                        <td style="padding:12px; text-align:center; color:#9CA3AF;"><?php echo $counts->draft; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <style>
    .wida-admin-wrap { direction:rtl; font-family:'Cairo',sans-serif; }
    .wida-admin-header { background:linear-gradient(135deg,#6B35D9,#A855F7); border-radius:12px; padding:24px; color:#fff; margin-bottom:24px; }
    .wida-admin-header h1 { font-size:24px; margin:0; color:#fff; }
    </style>
    <?php
}

// =============================================
// Admin Styles (Custom)
// =============================================
function wida_admin_styles() {
    echo '<style>
        #adminmenu .toplevel_page_wida-academy-dashboard .dashicons:before { content:"\\f118"; }
        #adminmenu .toplevel_page_wida-academy-dashboard { background: rgba(107,53,217,0.1); }
        #adminmenu .toplevel_page_wida-academy-dashboard > a { color: #6B35D9 !important; }
        #adminmenu .toplevel_page_wida-academy-dashboard > a:hover { background:#6B35D9 !important; color:#fff !important; }
        #adminmenu .toplevel_page_wida-academy-dashboard.current > a,
        #adminmenu .toplevel_page_wida-academy-dashboard .current > a { background:#6B35D9 !important; color:#fff !important; }
    </style>';
}
add_action('admin_head', 'wida_admin_styles');

// =============================================
// Customize Login Page
// =============================================
function wida_login_styles() {
    echo '
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap");
        body.login { font-family:"Cairo",sans-serif !important; background:linear-gradient(135deg,#F0EAFF 0%,#EDE9FE 50%,#F5F3FF 100%); direction:rtl; }
        #login h1 a { background-image:none; width:auto; height:auto; text-indent:0; font-size:28px; font-weight:800; font-style:italic; color:#6B35D9; font-family:"Cairo",sans-serif; }
        #login h1 a::before { content:"wida"; }
        .login form { border-radius:16px; box-shadow:0 8px 40px rgba(107,53,217,0.15); border:1px solid rgba(107,53,217,0.1); }
        .login label { text-align:right; display:block; font-family:"Cairo",sans-serif; color:#2D1B69; }
        .login input[type=text], .login input[type=password] { border-radius:50px; border:1.5px solid #E5E0F5; font-family:"Cairo",sans-serif; text-align:right; }
        .login input[type=text]:focus, .login input[type=password]:focus { border-color:#6B35D9; box-shadow:0 0 0 3px rgba(107,53,217,0.1); }
        .wp-core-ui .button-primary { background:linear-gradient(90deg,#7C3AED,#A855F7) !important; border:none !important; border-radius:50px !important; font-family:"Cairo",sans-serif !important; font-weight:600 !important; padding:10px 20px !important; height:auto !important; }
        .wp-core-ui .button-primary:hover { box-shadow:0 4px 20px rgba(107,53,217,0.3) !important; }
        #nav a, #backtoblog a { color:#6B35D9 !important; font-family:"Cairo",sans-serif; }
    </style>';
}
add_action('login_enqueue_scripts', 'wida_login_styles');

function wida_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'wida_login_logo_url');

function wida_login_logo_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'wida_login_logo_title');

// =============================================
// Helper Functions
// =============================================

/**
 * Get courses query
 */
function wida_get_courses($count = 4) {
    return new WP_Query([
        'post_type'      => 'wida_course',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
}

/**
 * Get documents query
 */
function wida_get_documents($count = 4) {
    return new WP_Query([
        'post_type'      => 'wida_document',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
}

/**
 * Get news query
 */
function wida_get_news($count = 3) {
    return new WP_Query([
        'post_type'      => 'wida_news',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
}

/**
 * Course card colors array
 */
function wida_card_gradient($index = 0) {
    $gradients = [
        'linear-gradient(135deg, #6B35D9, #A855F7)',
        'linear-gradient(135deg, #4A1FA8, #7C3AED)',
        'linear-gradient(135deg, #7C3AED, #C084FC)',
        'linear-gradient(135deg, #2D1B69, #6B35D9)',
    ];
    return $gradients[$index % count($gradients)];
}

// =============================================
// Widgets
// =============================================
function wida_register_widgets() {
    register_sidebar([
        'name'          => __('الشريط الجانبي - الدورات', 'wida-academy'),
        'id'            => 'sidebar-courses',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'wida_register_widgets');

// =============================================
// REST API Endpoints (for future app/mobile use)
// =============================================
function wida_register_rest_routes() {
    register_rest_route('wida/v1', '/stats', [
        'methods'             => 'GET',
        'callback'            => function () {
            return [
                'courses'   => wp_count_posts('wida_course')->publish,
                'documents' => wp_count_posts('wida_document')->publish,
                'identity'  => wp_count_posts('wida_identity')->publish,
                'news'      => wp_count_posts('wida_news')->publish,
                'users'     => count_users()['total_users'],
            ];
        },
        'permission_callback' => '__return_true',
    ]);
}
add_action('rest_api_init', 'wida_register_rest_routes');

// Remove WP emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
