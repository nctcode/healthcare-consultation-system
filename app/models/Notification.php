<?php
class Notification extends Model
{
    protected string $table = 'notifications';

    public function byUser(int $userId, int $limit = 20): array
    {
        return $this->query(
            "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT {$limit}",
            [$userId]
        );
    }

    public function unreadCount(int $userId): int
    {
        return $this->count('user_id = ? AND is_read = 0', [$userId]);
    }

    public function markRead(int $id): bool
    {
        return $this->update($id, ['is_read' => 1]);
    }

    public function markAllRead(int $userId): void
    {
        $stmt = $this->db()->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        $stmt->execute([$userId]);
    }

    /** Tạo notification tiện ích */
    public static function send(int $userId, string $title, string $message, string $type = 'system', ?string $link = null): void
    {
        $notif = new self();
        $notif->create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'link'    => $link,
        ]);
    }
}
