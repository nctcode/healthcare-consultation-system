<?php
/**
 * Front Controller
 * Điểm vào duy nhất của ứng dụng
 */

// Bật hiển thị lỗi (tắt trong production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load cấu hình
require_once dirname(__DIR__) . '/config/app.php';

// Session
session_start();

// Autoload classes
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/core/' . $class . '.php',
        APP_PATH . '/models/' . $class . '.php',
        APP_PATH . '/controllers/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Load helpers
require_once APP_PATH . '/helpers/functions.php';

// Kết nối Database
$dbConfig = require CONFIG_PATH . '/database.php';
try {
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $dbConfig['options']);
    Model::setDatabase($pdo);
} catch (PDOException $e) {
    die('Lỗi kết nối database: ' . $e->getMessage());
}

// Lấy URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// Load routes và dispatch
$router = new Router();
require_once ROOT_PATH . '/routes/web.php';
$router->dispatch($url);
