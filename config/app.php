<?php
/**
 * Cấu hình ứng dụng
 * Hệ thống Tư vấn & Khám bệnh Online
 */

// Thông tin ứng dụng
define('APP_NAME', 'Smart Healthcare');
define('APP_DESCRIPTION', 'Consultation System');
define('APP_VERSION', '1.0.0');

// URL gốc (không có dấu / ở cuối)
define('BASE_URL', '/qlda');

// Múi giờ
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Đường dẫn thư mục
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');

// Upload
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

// Phân trang
define('ITEMS_PER_PAGE', 10);

// Session
define('SESSION_LIFETIME', 3600); // 1 giờ
