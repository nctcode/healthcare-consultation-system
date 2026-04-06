<?php
/**
 * Auth - Quản lý xác thực người dùng
 * Session-based authentication + RBAC
 */
class Auth
{
    /**
     * Đăng nhập
     */
    public static function login(array $user): void
    {
        // Regenerate session ID để chống session fixation
        session_regenerate_id(true);

        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name']  = $user['full_name'];
        $_SESSION['user_role']  = $user['role_name'];
        $_SESSION['user_avatar'] = $user['avatar'] ?? null;
        $_SESSION['logged_in']  = true;
    }

    /**
     * Đăng xuất
     */
    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
    }

    /**
     * Kiểm tra đã đăng nhập chưa
     */
    public static function check(): bool
    {
        return !empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Lấy ID user hiện tại
     */
    public static function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Lấy thông tin user hiện tại
     */
    public static function user(): ?array
    {
        if (!self::check()) return null;
        return [
            'id'     => $_SESSION['user_id'],
            'email'  => $_SESSION['user_email'],
            'name'   => $_SESSION['user_name'],
            'role'   => $_SESSION['user_role'],
            'avatar' => $_SESSION['user_avatar'],
        ];
    }

    /**
     * Lấy role hiện tại
     */
    public static function role(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    /**
     * Kiểm tra có phải role cụ thể không
     */
    public static function isRole(string $role): bool
    {
        return self::role() === $role;
    }

    /**
     * Lấy URL dashboard theo role
     */
    public static function dashboardUrl(): string
    {
        return match (self::role()) {
            'admin'        => '/admin/dashboard',
            'director'     => '/director/dashboard',
            'doctor'       => '/doctor/dashboard',
            'patient'      => '/patient/dashboard',
            'nurse'        => '/nurse/dashboard',
            'receptionist' => '/receptionist/dashboard',
            default        => '/',
        };
    }
}
