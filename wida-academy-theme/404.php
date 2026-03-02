<?php
/**
 * 404 Template
 */
get_header();
?>
<div class="dashboard-page" style="display:flex; align-items:center; justify-content:center; min-height:60vh;">
    <div style="text-align:center;">
        <div style="font-size:80px; font-weight:900; color:#E5E0F5; line-height:1;">404</div>
        <div style="font-size:56px; color:#6B35D9; margin:-20px 0 16px;">🔍</div>
        <h1 style="font-size:24px; font-weight:700; color:#2D1B69; margin-bottom:8px;">الصفحة غير موجودة</h1>
        <p style="color:#6B7280; margin-bottom:24px;">عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.</p>
        <a href="<?php echo home_url('/'); ?>" class="btn-primary" style="display:inline-block; width:auto; padding:12px 32px; text-decoration:none;">
            العودة للرئيسية
        </a>
    </div>
</div>
<?php get_footer(); ?>
