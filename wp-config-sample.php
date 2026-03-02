<?php
/**
 * WordPress Configuration File - Sample
 * قم بنسخ هذا الملف وتسميته wp-config.php وتعديل القيم
 *
 * أكاديمية وايدا - Wida Academy
 */

// =============================================
// Database Settings - إعدادات قاعدة البيانات
// =============================================
define('DB_NAME',     'wida_academy_db');
define('DB_USER',     'wida_db_user');
define('DB_PASSWORD', 'YOUR_STRONG_PASSWORD_HERE');
define('DB_HOST',     'localhost');
define('DB_CHARSET',  'utf8mb4');
define('DB_COLLATE',  'utf8mb4_unicode_ci');

// =============================================
// Authentication Keys & Salts
// Generate at: https://api.wordpress.org/secret-key/1.1/salt/
// =============================================
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

// =============================================
// WordPress Database Table Prefix
// =============================================
$table_prefix = 'wida_';

// =============================================
// WordPress URLs - روابط الموقع
// =============================================
// define('WP_HOME',    'https://academy.wida.sa');
// define('WP_SITEURL', 'https://academy.wida.sa');

// =============================================
// Debug Mode (set to false in production)
// =============================================
define('WP_DEBUG',         false);
define('WP_DEBUG_LOG',     false);
define('WP_DEBUG_DISPLAY', false);

// =============================================
// Security Settings
// =============================================
define('DISALLOW_FILE_EDIT', true);   // Disable file editing in admin
define('FORCE_SSL_ADMIN',    true);   // Force HTTPS in admin
define('WP_AUTO_UPDATE_CORE', 'minor'); // Auto update minor releases

// =============================================
// Performance Settings - إعدادات الأداء
// =============================================
define('WP_MEMORY_LIMIT',       '256M');
define('WP_MAX_MEMORY_LIMIT',   '512M');
define('WP_CACHE',              true);
define('COMPRESS_SCRIPTS',      true);
define('COMPRESS_CSS',          true);
define('AUTOSAVE_INTERVAL',     300);  // seconds
define('WP_POST_REVISIONS',     5);

// =============================================
// File Uploads
// =============================================
define('UPLOADS', 'wp-content/uploads');

// =============================================
// Bootstrap
// =============================================
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}
require_once ABSPATH . 'wp-settings.php';
