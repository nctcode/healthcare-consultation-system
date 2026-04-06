<?php
/**
 * Base Controller
 * Cung cấp phương thức dùng chung cho tất cả controller
 */
class Controller
{
    /**
     * Render view với dữ liệu
     * @param string $view Đường dẫn view (vd: 'home/index')
     * @param array $data Dữ liệu truyền vào view
     * @param string $layout Layout sử dụng ('app', 'dashboard', 'auth', hoặc null)
     */
    protected function view(string $view, array $data = [], ?string $layout = 'app'): void
    {
        // Extract data thành biến
        extract($data);

        // Nội dung view
        $viewFile = APP_PATH . '/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die("View '{$view}' không tồn tại.");
        }

        if ($layout) {
            // Render view vào buffer
            ob_start();
            require $viewFile;
            $content = ob_get_clean();

            // Render layout (chứa $content)
            $layoutFile = APP_PATH . '/views/layouts/' . $layout . '.php';
            if (!file_exists($layoutFile)) {
                die("Layout '{$layout}' không tồn tại.");
            }
            require $layoutFile;
        } else {
            require $viewFile;
        }
    }

    /**
     * Trả về JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Redirect tới URL
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }

    /**
     * Yêu cầu đăng nhập
     */
    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            $_SESSION['flash_error'] = 'Vui lòng đăng nhập để tiếp tục.';
            $this->redirect('/dang-nhap');
        }
    }

    /**
     * Yêu cầu role cụ thể
     */
    protected function requireRole(string ...$roles): void
    {
        $this->requireAuth();
        if (!in_array(Auth::role(), $roles)) {
            http_response_code(403);
            echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>403</title>
            <style>body{font-family:Inter,sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;background:#f1f5f9;}
            .box{text-align:center;}.box h1{font-size:6rem;color:#ef4444;margin:0;}.box p{color:#64748b;font-size:1.2rem;}</style></head>
            <body><div class="box"><h1>403</h1><p>Bạn không có quyền truy cập trang này.</p>
            <a href="' . BASE_URL . '/" style="color:#2563eb;text-decoration:none;">← Về trang chủ</a></div></body></html>';
            exit;
        }
    }

    /**
     * Kiểm tra CSRF token
     */
    protected function validateCSRF(): bool
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!$token || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            $_SESSION['flash_error'] = 'Phiên làm việc đã hết hạn. Vui lòng thử lại.';
            return false;
        }
        return true;
    }

    /**
     * Lấy dữ liệu POST đã được sanitize
     */
    protected function input(string $key, $default = null)
    {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }

    /**
     * Lấy dữ liệu GET
     */
    protected function query(string $key, $default = null)
    {
        return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
    }
}
