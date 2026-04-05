<?php
class Message extends Model
{
    protected string $table = 'messages';

    /**
     * Lấy danh sách tin nhắn của appointment
     */
    public function getByAppointment(int $appointmentId): array
    {
        return $this->query(
            "SELECT m.*, u.full_name as sender_name, u.avatar as sender_avatar
             FROM messages m
             JOIN users u ON m.sender_id = u.id
             WHERE m.appointment_id = ?
             ORDER BY m.created_at ASC",
            [$appointmentId]
        );
    }

    /**
     * Lấy tin nhắn mới (từ lastMessageId trở đi)
     */
    public function getNewMessages(int $appointmentId, int $lastMessageId = 0): array
    {
        return $this->query(
            "SELECT m.*, u.full_name as sender_name, u.avatar as sender_avatar
             FROM messages m
             JOIN users u ON m.sender_id = u.id
             WHERE m.appointment_id = ? AND m.id > ?
             ORDER BY m.created_at ASC",
            [$appointmentId, $lastMessageId]
        );
    }

    /**
     * Lấy số lượng tin chưa đọc
     */
    public function unreadCount(int $userId): int
    {
        return $this->count('receiver_id = ? AND is_read = 0', [$userId]);
    }

    /**
     * Đánh dấu tin nhắn đã đọc
     */
    public function markAsRead(int $appointmentId, int $userId): void
    {
        $stmt = $this->db()->prepare(
            "UPDATE messages SET is_read = 1 WHERE appointment_id = ? AND receiver_id = ?"
        );
        $stmt->execute([$appointmentId, $userId]);
    }

    /**
     * Alias for backward compatibility
     */
    public function byAppointment(int $appointmentId): array
    {
        return $this->getByAppointment($appointmentId);
    }

    /**
     * Alias for backward compatibility
     */
    public function markRead(int $appointmentId, int $userId): void
    {
        $this->markAsRead($appointmentId, $userId);
    }
}
