<?php
/**
 * Router - Điều hướng URL
 * Phân tích URI và gọi Controller@Action tương ứng
 */
class Router
{
    /** @var array Danh sách routes đã đăng ký */
    private array $routes = [];

    /**
     * Đăng ký route GET
     */
    public function get(string $uri, string $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Đăng ký route POST
     */
    public function post(string $uri, string $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Đăng ký route cho cả GET và POST
     */
    public function any(string $uri, string $action): void
    {
        $this->addRoute('GET', $uri, $action);
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Thêm route vào danh sách
     */
    private function addRoute(string $method, string $uri, string $action): void
    {
        // Chuyển {param} thành regex named group
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $uri);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method'  => $method,
            'pattern' => $pattern,
            'action'  => $action,
        ];
    }

    /**
     * Dispatch - Tìm route phù hợp và gọi controller
     */
    public function dispatch(string $url): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;

            if (preg_match($route['pattern'], $url, $matches)) {
                // Lấy params từ URL
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Tách Controller@action
                [$controllerName, $actionName] = explode('@', $route['action']);

                if (!class_exists($controllerName)) {
                    $this->error404("Controller {$controllerName} không tồn tại");
                    return;
                }

                $controller = new $controllerName();

                if (!method_exists($controller, $actionName)) {
                    $this->error404("Action {$actionName} không tồn tại");
                    return;
                }

                // Gọi action với params
                call_user_func_array([$controller, $actionName], $params);
                return;
            }
        }

        // Không tìm thấy route
        $this->error404();
    }

    /**
     * Hiển thị trang 404
     */
    private function error404(string $message = 'Trang không tồn tại'): void
    {
        http_response_code(404);
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>404</title>
        <style>body{font-family:Inter,sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;background:#f1f5f9;}
        .box{text-align:center;}.box h1{font-size:6rem;color:#2563eb;margin:0;}.box p{color:#64748b;font-size:1.2rem;}</style></head>
        <body><div class="box"><h1>404</h1><p>' . htmlspecialchars($message) . '</p>
        <a href="' . BASE_URL . '/" style="color:#2563eb;text-decoration:none;">← Về trang chủ</a></div></body></html>';
    }
}
