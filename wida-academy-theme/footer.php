<?php if (!is_page_template('page-login.php')): ?>
</main><!-- /#main -->
<?php endif; ?>

<!-- =============================================
     Site Footer
     ============================================= -->
<footer class="site-footer" role="contentinfo">
    <div class="footer-inner">
        <!-- Brand -->
        <div class="footer-brand">
            <div class="footer-logo">wida</div>
            <p>
                في وايدا نؤمن بأن البداية فقط. نحول رؤيا شركائنا إلى حضور مؤثر، ونصنع من التجارب التكنولوجية.
            </p>
            <div class="footer-social">
                <a href="<?php echo esc_url(get_option('wida_social_instagram', '#')); ?>" aria-label="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="<?php echo esc_url(get_option('wida_social_youtube', '#')); ?>" aria-label="YouTube">
                    <i class="fa-brands fa-youtube"></i>
                </a>
                <a href="<?php echo esc_url(get_option('wida_social_twitter', '#')); ?>" aria-label="X / Twitter">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="<?php echo esc_url(get_option('wida_social_linkedin', '#')); ?>" aria-label="LinkedIn">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
                <a href="<?php echo esc_url(get_option('wida_social_facebook', '#')); ?>" aria-label="Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="footer-contact">
            <div class="footer-contact-item">
                <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                <div>
                    <div class="contact-label">في حال واجهتكم أي مشاكل تقنية:</div>
                    <div class="contact-value"><?php echo esc_html(get_option('wida_site_email_it', 'IT@wida.sa')); ?></div>
                </div>
            </div>
            <div class="footer-contact-item">
                <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                <div>
                    <div class="contact-label">لأي استفسارات تتعلق بالموارد البشرية:</div>
                    <div class="contact-value"><?php echo esc_html(get_option('wida_site_email_hr', 'HR@wida.sa')); ?></div>
                </div>
            </div>
            <div class="footer-contact-item">
                <div class="contact-icon"><i class="fa-solid fa-globe"></i></div>
                <div>
                    <div class="contact-label">الموقع الإلكتروني</div>
                    <div class="contact-value">
                        <a href="<?php echo esc_url(get_option('wida_site_url', 'https://www.wida.sa')); ?>" style="color:inherit;">
                            <?php echo esc_html(get_option('wida_site_url', 'www.wida.sa')); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-contact-item">
                <div class="contact-icon"><i class="fa-solid fa-at"></i></div>
                <div>
                    <div class="contact-label">البريد العام</div>
                    <div class="contact-value"><?php echo esc_html(get_option('wida_site_email_info', 'info@wida.sa')); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> أكاديمية وايدا. جميع الحقوق محفوظة.</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
