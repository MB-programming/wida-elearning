<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if (!is_page_template('page-login.php')): ?>
<!-- =============================================
     Site Header
     ============================================= -->
<header class="site-header" role="banner">
    <div class="header-logo">
        <span class="logo-text-en">wida</span>
        <span class="logo-text-ar">أكاديمية وايدا</span>
    </div>

    <button class="header-menu-toggle" aria-label="القائمة" id="menuToggle">
        <span></span>
        <span></span>
        <span></span>
    </button>
</header>

<!-- =============================================
     Site Navigation
     ============================================= -->
<nav class="site-nav" role="navigation" aria-label="القائمة الرئيسية">
    <?php
    $current_url = $_SERVER['REQUEST_URI'];
    $home = home_url('/');

    $nav_items = [
        ['url' => $home,                           'label' => 'الرئيسية',         'icon' => 'fa-house'],
        ['url' => $home . 'departments/',          'label' => 'الأقسام والإدارات', 'icon' => 'fa-sitemap'],
        ['url' => get_post_type_archive_link('wida_document'), 'label' => 'الأدلة الإرشادية', 'icon' => 'fa-book-open'],
        ['url' => get_post_type_archive_link('wida_identity'), 'label' => 'الهوية البصرية',   'icon' => 'fa-palette'],
        ['url' => get_post_type_archive_link('wida_course'),   'label' => 'الدورات التدريبية','icon' => 'fa-graduation-cap'],
    ];

    foreach ($nav_items as $item):
        $active = (rtrim($current_url, '/') === rtrim(parse_url($item['url'], PHP_URL_PATH), '/')) ? 'active' : '';
    ?>
    <a href="<?php echo esc_url($item['url']); ?>" class="<?php echo $active; ?>">
        <i class="fa-solid <?php echo $item['icon']; ?> nav-icon"></i>
        <?php echo esc_html($item['label']); ?>
    </a>
    <?php endforeach; ?>

    <?php if (is_user_logged_in()): ?>
    <a href="<?php echo wp_logout_url(home_url()); ?>" style="margin-right:auto;">
        <i class="fa-solid fa-right-from-bracket nav-icon"></i>
        تسجيل الخروج
    </a>
    <?php endif; ?>
</nav>

<main id="main" class="site-main" role="main">
<?php else: ?>
<main id="main" class="site-main login-page" role="main">
<?php endif; ?>
