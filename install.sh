#!/bin/bash
# =============================================
# Wida Academy WordPress Installation Script
# أكاديمية وايدا - سكريبت التثبيت
# =============================================

set -e

echo "=================================="
echo "  أكاديمية وايدا - Wida Academy  "
echo "    WordPress Installation Script "
echo "=================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

log_info()    { echo -e "${BLUE}[INFO]${NC} $1"; }
log_success() { echo -e "${GREEN}[✓]${NC} $1"; }
log_warning() { echo -e "${YELLOW}[!]${NC} $1"; }
log_error()   { echo -e "${RED}[✗]${NC} $1"; exit 1; }

# =============================================
# Check Prerequisites
# =============================================
log_info "التحقق من المتطلبات..."

command -v php  >/dev/null 2>&1 || log_error "PHP غير مثبت"
command -v mysql >/dev/null 2>&1 || log_error "MySQL غير مثبت"
command -v curl >/dev/null 2>&1 || log_error "curl غير مثبت"
command -v wp   >/dev/null 2>&1 || log_warning "WP-CLI غير مثبت - سيتم تخطي إعداد WordPress التلقائي"

PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
log_success "PHP ${PHP_VERSION} ✓"

# =============================================
# Configuration
# =============================================
SITE_URL="${WIDA_SITE_URL:-http://localhost}"
SITE_TITLE="${WIDA_SITE_TITLE:-أكاديمية وايدا}"
ADMIN_USER="${WIDA_ADMIN_USER:-wida_admin}"
ADMIN_PASS="${WIDA_ADMIN_PASS:-ChangeMe!2024}"
ADMIN_EMAIL="${WIDA_ADMIN_EMAIL:-admin@wida.sa}"
DB_NAME="${WIDA_DB_NAME:-wida_academy_db}"
DB_USER="${WIDA_DB_USER:-root}"
DB_PASS="${WIDA_DB_PASS:-}"
WP_DIR="${WIDA_WP_DIR:-/var/www/html/wida-academy}"
THEME_DIR="$(dirname "$0")/wida-academy-theme"

echo ""
log_info "إعدادات التثبيت:"
echo "  • الموقع:    ${SITE_URL}"
echo "  • الاسم:     ${SITE_TITLE}"
echo "  • المجلد:    ${WP_DIR}"
echo "  • قاعدة البيانات: ${DB_NAME}"
echo ""

# =============================================
# Download WordPress
# =============================================
log_info "تحميل WordPress..."

if [ -f "${WP_DIR}/wp-login.php" ]; then
    log_warning "WordPress موجود بالفعل في ${WP_DIR}"
else
    mkdir -p "${WP_DIR}"
    curl -sL "https://wordpress.org/latest.tar.gz" | tar xz --strip-components=1 -C "${WP_DIR}"
    log_success "تم تحميل WordPress"
fi

# =============================================
# Copy Theme
# =============================================
log_info "نسخ قالب أكاديمية وايدا..."
THEME_DEST="${WP_DIR}/wp-content/themes/wida-academy-theme"
mkdir -p "${THEME_DEST}"
cp -r "${THEME_DIR}/." "${THEME_DEST}/"
log_success "تم نسخ القالب إلى: ${THEME_DEST}"

# =============================================
# Create WordPress Config
# =============================================
log_info "إنشاء wp-config.php..."

if command -v wp >/dev/null 2>&1; then
    wp config create \
        --path="${WP_DIR}" \
        --dbname="${DB_NAME}" \
        --dbuser="${DB_USER}" \
        --dbpass="${DB_PASS}" \
        --dbhost="localhost" \
        --dbcharset="utf8mb4" \
        --dbcollate="utf8mb4_unicode_ci" \
        --dbprefix="wida_" \
        --extra-php <<PHP
define('DISALLOW_FILE_EDIT', true);
define('WP_MEMORY_LIMIT', '256M');
define('FORCE_SSL_ADMIN', false);
define('WP_DEBUG', false);
PHP
    log_success "تم إنشاء wp-config.php"

    # =============================================
    # Create Database & Install WordPress
    # =============================================
    log_info "تثبيت WordPress..."

    wp db create --path="${WP_DIR}" 2>/dev/null || log_warning "قاعدة البيانات موجودة بالفعل"

    wp core install \
        --path="${WP_DIR}" \
        --url="${SITE_URL}" \
        --title="${SITE_TITLE}" \
        --admin_user="${ADMIN_USER}" \
        --admin_password="${ADMIN_PASS}" \
        --admin_email="${ADMIN_EMAIL}" \
        --skip-email

    log_success "تم تثبيت WordPress"

    # =============================================
    # Configure WordPress
    # =============================================
    log_info "ضبط إعدادات WordPress..."

    # Set language to Arabic
    wp language core install ar --path="${WP_DIR}"
    wp site switch-language ar --path="${WP_DIR}"

    # Activate theme
    wp theme activate wida-academy-theme --path="${WP_DIR}"
    log_success "تم تفعيل قالب أكاديمية وايدا"

    # Set permalink structure
    wp rewrite structure '/%postname%/' --path="${WP_DIR}"
    wp rewrite flush --path="${WP_DIR}"

    # Set RTL direction
    wp option update WPLANG ar --path="${WP_DIR}"

    # Create pages
    log_info "إنشاء الصفحات الأساسية..."

    LOGIN_ID=$(wp post create \
        --path="${WP_DIR}" \
        --post_type=page \
        --post_title='تسجيل الدخول' \
        --post_name='login' \
        --post_status=publish \
        --post_content='' \
        --porcelain)
    wp post meta add "${LOGIN_ID}" _wp_page_template 'page-login.php' --path="${WP_DIR}"

    DASHBOARD_ID=$(wp post create \
        --path="${WP_DIR}" \
        --post_type=page \
        --post_title='لوحة البيانات' \
        --post_name='dashboard' \
        --post_status=publish \
        --post_content='' \
        --porcelain)

    # Set homepage to front-page
    wp option update show_on_front 'page' --path="${WP_DIR}"
    wp option update page_on_front "${DASHBOARD_ID}" --path="${WP_DIR}"

    # Set site options
    wp option update blogname 'أكاديمية وايدا' --path="${WP_DIR}"
    wp option update blogdescription 'منصة المعرفة لموظفي وايدا' --path="${WP_DIR}"
    wp option update wida_site_email_it 'IT@wida.sa' --path="${WP_DIR}"
    wp option update wida_site_email_hr 'HR@wida.sa' --path="${WP_DIR}"
    wp option update wida_site_email_info 'info@wida.sa' --path="${WP_DIR}"
    wp option update wida_site_url 'https://www.wida.sa' --path="${WP_DIR}"

    # Install recommended plugins
    log_info "تثبيت الإضافات الموصى بها..."
    PLUGINS=(
        "classic-editor"
        "wordfence"
        "wp-super-cache"
        "contact-form-7"
        "advanced-custom-fields"
    )
    for plugin in "${PLUGINS[@]}"; do
        wp plugin install "${plugin}" --activate --path="${WP_DIR}" 2>/dev/null && \
            log_success "تم تثبيت ${plugin}" || \
            log_warning "فشل تثبيت ${plugin}"
    done

    # =============================================
    # Add Sample Data
    # =============================================
    log_info "إضافة محتوى تجريبي..."

    # Sample courses
    COURSES=(
        "دورة تطوير المحتوى الرقمي للإنترنت"
        "شرح أداة Google Drive"
        "شرح منصة Jisr"
        "شرح أداة Hootsuite"
    )
    for course in "${COURSES[@]}"; do
        wp post create \
            --path="${WP_DIR}" \
            --post_type=wida_course \
            --post_title="${course}" \
            --post_status=publish \
            --post_content="محتوى الدورة: ${course}. تشمل هذه الدورة شرحاً تفصيلياً للمهارات والأدوات المطلوبة." \
            --post_excerpt="دورة تدريبية متخصصة لموظفي وايدا." \
            >/dev/null 2>&1
    done
    log_success "تم إضافة ${#COURSES[@]} دورات تجريبية"

    # Sample documents
    DOCS=(
        "دليل الهوية البصرية - وسائل التواصل الاجتماعي"
        "دليل الهوية البصرية"
    )
    for doc in "${DOCS[@]}"; do
        wp post create \
            --path="${WP_DIR}" \
            --post_type=wida_document \
            --post_title="${doc}" \
            --post_status=publish \
            --post_content="محتوى ${doc}" \
            >/dev/null 2>&1
    done
    log_success "تم إضافة ${#DOCS[@]} أدلة تجريبية"

    # Sample news
    NEWS_ITEMS=(
        "حضور المنتدى السعودي للإعلام"
        "إطلاق الهوية الجديدة لـ WIDÁ"
        "تكريم موظفي وشركاء وايدا"
    )
    for news in "${NEWS_ITEMS[@]}"; do
        wp post create \
            --path="${WP_DIR}" \
            --post_type=wida_news \
            --post_title="${news}" \
            --post_status=publish \
            --post_content="تفاصيل: ${news}" \
            >/dev/null 2>&1
    done
    log_success "تم إضافة ${#NEWS_ITEMS[@]} أخبار تجريبية"

else
    log_warning "WP-CLI غير متاح. يرجى ضبط الموقع يدوياً."
    cp "$(dirname "$0")/wp-config-sample.php" "${WP_DIR}/wp-config.php"
    log_info "تم نسخ wp-config-sample.php — قم بتعديل القيم في ${WP_DIR}/wp-config.php"
fi

# =============================================
# Set File Permissions
# =============================================
log_info "ضبط صلاحيات الملفات..."
find "${WP_DIR}" -type d -exec chmod 755 {} \;
find "${WP_DIR}" -type f -exec chmod 644 {} \;
chmod 600 "${WP_DIR}/wp-config.php" 2>/dev/null || true
log_success "تم ضبط الصلاحيات"

# =============================================
# Done
# =============================================
echo ""
echo "=========================================="
echo -e "${GREEN}✅ اكتمل التثبيت بنجاح!${NC}"
echo "=========================================="
echo ""
echo "  🌐 الموقع:         ${SITE_URL}"
echo "  🔑 لوحة التحكم:   ${SITE_URL}/wp-admin"
echo "  👤 المستخدم:      ${ADMIN_USER}"
echo "  🔒 كلمة المرور:   ${ADMIN_PASS}"
echo ""
echo -e "${YELLOW}⚠️  تأكد من تغيير كلمة المرور بعد أول تسجيل دخول!${NC}"
echo ""
