<?php
/**
 * Helper Functions
 * Các hàm tiện ích dùng chung
 */

/**
 * Escape HTML để chống XSS
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Tạo URL đầy đủ
 */
function url(string $path = ''): string
{
    return BASE_URL . $path;
}

/**
 * Tạo URL cho asset (CSS, JS, images)
 */
function asset(string $path): string
{
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

/**
 * Tạo CSRF token field cho form
 */
function csrf_field(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
}

/**
 * Lấy giá trị cũ của form (sau khi validate fail)
 */
function old(string $key, $default = ''): string
{
    return e($_SESSION['old_input'][$key] ?? $default);
}

/**
 * Lưu input cũ vào session
 */
function flash_old_input(array $data): void
{
    $_SESSION['old_input'] = $data;
}

/**
 * Xóa input cũ
 */
function clear_old_input(): void
{
    unset($_SESSION['old_input']);
}

/**
 * Set flash message
 */
function flash(string $type, string $message): void
{
    $_SESSION['flash_' . $type] = $message;
}

/**
 * Lấy và xóa flash message
 */
function get_flash(string $type): ?string
{
    $message = $_SESSION['flash_' . $type] ?? null;
    unset($_SESSION['flash_' . $type]);
    return $message;
}

/**
 * Format số tiền VND
 */
function format_money($amount): string
{
    return number_format((float)$amount, 0, ',', '.') . 'đ';
}

/**
 * Format ngày tiếng Việt
 */
function format_date(?string $date): string
{
    if (!$date) return '';
    return date('d/m/Y', strtotime($date));
}

/**
 * Format ngày giờ tiếng Việt
 */
function format_datetime(?string $datetime): string
{
    if (!$datetime) return '';
    return date('d/m/Y H:i', strtotime($datetime));
}

/**
 * Format giờ
 */
function format_time(?string $time): string
{
    if (!$time) return '';
    return date('H:i', strtotime($time));
}

/**
 * Tạo QR code token
 */
function generate_qr_token(): string
{
    return 'QR-' . strtoupper(bin2hex(random_bytes(8)));
}

/**
 * Hiển thị badge trạng thái
 */
function status_badge(string $status): string
{
    $map = [
        'active'      => ['Hoạt động', 'success'],
        'inactive'    => ['Ngừng', 'secondary'],
        'banned'      => ['Khóa', 'danger'],
        'pending'     => ['Chờ xử lý', 'warning'],
        'confirmed'   => ['Đã xác nhận', 'info'],
        'in_progress' => ['Đang khám', 'primary'],
        'completed'   => ['Hoàn thành', 'success'],
        'cancelled'   => ['Đã hủy', 'danger'],
        'dispensed'   => ['Đã cấp', 'success'],
        'failed'      => ['Thất bại', 'danger'],
        'refunded'    => ['Hoàn tiền', 'warning'],
    ];

    $info = $map[$status] ?? [$status, 'secondary'];
    return '<span class="badge bg-' . $info[1] . '">' . $info[0] . '</span>';
}

/**
 * Rút gọn text
 */
function truncate(string $text, int $length = 100): string
{
    if (mb_strlen($text) <= $length) return e($text);
    return e(mb_substr($text, 0, $length)) . '...';
}

/**
 * Tên thứ trong tuần
 */
function day_name(int $day): string
{
    $days = ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
    return $days[$day] ?? '';
}

/**
 * Hiển thị gender
 */
function gender_label(?string $gender): string
{
    return match($gender) {
        'male'   => 'Nam',
        'female' => 'Nữ',
        'other'  => 'Khác',
        default  => 'Chưa xác định',
    };
}

/**
 * Tính thời gian trước
 */
function time_ago(string $datetime): string
{
    $now = time();
    $time = strtotime($datetime);
    $diff = $now - $time;

    if ($diff < 60) return 'Vừa xong';
    if ($diff < 3600) return (int)($diff / 60) . ' phút trước';
    if ($diff < 86400) return (int)($diff / 3600) . ' giờ trước';
    if ($diff < 2592000) return (int)($diff / 86400) . ' ngày trước';
    return format_date($datetime);
}

/**
 * Nhãn hình thức khám
 */
function appointment_type_label(int $type): string
{
    return match($type) {
        1 => '<span class="badge bg-success"><i class="fas fa-hospital me-1"></i>Trực tiếp</span>',
        2 => '<span class="badge bg-info"><i class="fas fa-video me-1"></i>Online</span>',
        3 => '<span class="badge bg-warning"><i class="fas fa-home me-1"></i>Tại nhà</span>',
        default => '<span class="badge bg-secondary">Khác</span>',
    };
}
