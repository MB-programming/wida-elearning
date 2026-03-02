<?php
/**
 * Template Name: صفحة تسجيل الدخول
 * Description: Wida Academy custom login page
 */

// Redirect if already logged in
if (is_user_logged_in()) {
    wp_redirect(home_url('/dashboard/'));
    exit;
}

get_header();
?>

<!-- =============================================
     Header Bar
     ============================================= -->
<header class="site-header" role="banner">
    <div class="header-logo">
        <span class="logo-text-en">wida</span>
        <span class="logo-text-ar">أكاديمية وايدا</span>
    </div>
    <button class="header-menu-toggle" aria-label="القائمة" id="menuToggle">
        <span></span><span></span><span></span>
    </button>
</header>

<!-- =============================================
     Login Hero Section
     ============================================= -->
<section class="login-hero">
    <div class="login-container">

        <!-- Right side: Branding / Hero text -->
        <div class="login-hero-content">
            <h1 class="hero-title-ar">أكاديمية وايدا</h1>
            <h2 class="hero-title-en">Wida Academy</h2>
            <p class="hero-tagline">منصة المعرفة لموظفي وايدا</p>
            <div class="hero-badges">
                <span class="hero-badge badge-solid">تعلم</span>
                <span class="hero-badge badge-outline">طوّر</span>
                <span class="hero-badge badge-outline">وشارك المعرفة</span>
            </div>
        </div>

        <!-- Left side: Login Card -->
        <div class="login-card">
            <div class="card-logo">
                <span class="logo-en">wida</span>
            </div>

            <?php
            // Show login error if any
            if (isset($_GET['login']) && $_GET['login'] === 'failed') {
                echo '<div style="background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; padding:12px; margin-bottom:16px; color:#DC2626; font-size:14px; text-align:center;">
                    ⚠️ بيانات الدخول غير صحيحة. حاول مرة أخرى.
                </div>';
            }
            if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
                echo '<div style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:8px; padding:12px; margin-bottom:16px; color:#16A34A; font-size:14px; text-align:center;">
                    ✅ تم تسجيل الخروج بنجاح.
                </div>';
            }
            ?>

            <?php
            // Google Login Button (if Google Client ID is configured)
            $google_client_id = get_option('wida_google_client_id', '');
            if (!empty($google_client_id)):
            ?>
            <button class="btn-google" id="googleLoginBtn" type="button">
                <svg class="google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                تسجيل الدخول عن طريق جوجل
            </button>

            <div class="login-divider">
                <span>أو</span>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>" class="login-form" id="widaLoginForm">
                <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url('/dashboard/')); ?>">
                <input type="hidden" name="testcookie" value="1">

                <div class="form-group">
                    <input
                        type="text"
                        name="log"
                        id="user_login"
                        class="form-control"
                        placeholder="اسم المستخدم"
                        required
                        autocomplete="username"
                    >
                </div>

                <div class="form-group" style="position:relative;">
                    <input
                        type="password"
                        name="pwd"
                        id="user_pass"
                        class="form-control"
                        placeholder="كلمة المرور"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" id="togglePassword" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9CA3AF; font-size:16px;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; font-size:13px;">
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer; color:#6B7280;">
                        <input type="checkbox" name="rememberme" value="forever" style="accent-color:#6B35D9;">
                        تذكرني
                    </label>
                    <a href="<?php echo wp_lostpassword_url(); ?>" style="color:#6B35D9; font-size:13px;">نسيت كلمة المرور؟</a>
                </div>

                <button type="submit" name="wp-submit" class="btn-primary">
                    الاستمرار
                </button>
            </form>
        </div>
    </div>

    <!-- 3D Decorative element (SVG) -->
    <svg class="hero-3d-decor" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <defs>
            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#6B35D9;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#A855F7;stop-opacity:1" />
            </linearGradient>
            <linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#4A1FA8;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#6B35D9;stop-opacity:1" />
            </linearGradient>
        </defs>
        <!-- Abstract 3D geometric shapes representing Wida brand -->
        <polygon points="100,10 180,60 180,140 100,190 20,140 20,60" fill="url(#grad1)" opacity="0.7" transform="rotate(15, 100, 100)"/>
        <polygon points="100,30 160,70 160,130 100,170 40,130 40,70" fill="url(#grad2)" opacity="0.5" transform="rotate(-5, 100, 100)"/>
        <circle cx="100" cy="100" r="25" fill="rgba(255,255,255,0.15)"/>
        <polygon points="100,20 170,65 170,145 100,185 30,145 30,65" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1.5" transform="rotate(8, 100, 100)"/>
    </svg>
</section>

<!-- Footer -->
<?php get_footer(); ?>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const passField = document.getElementById('user_pass');
    const icon = this.querySelector('i');
    if (passField.type === 'password') {
        passField.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        passField.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});

<?php if (!empty($google_client_id)): ?>
// Google Login
document.getElementById('googleLoginBtn').addEventListener('click', function() {
    const clientId = '<?php echo esc_js($google_client_id); ?>';
    const redirectUri = '<?php echo esc_js(home_url('/google-auth-callback/')); ?>';
    const scope = 'openid email profile';
    const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${clientId}&redirect_uri=${encodeURIComponent(redirectUri)}&response_type=code&scope=${encodeURIComponent(scope)}&prompt=select_account`;
    window.location.href = authUrl;
});
<?php endif; ?>
</script>
