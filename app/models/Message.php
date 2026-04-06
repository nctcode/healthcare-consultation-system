<?php
class Message extends Model
{
    protected string $table = 'messages';

    public function byAppointment(int $appointmentId): array
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

    public function unreadCount(int $userId): int
    {
        return $this->count('receiver_id = ? AND is_read = 0', [$userId]);
    }

    public function markRead(int $appointmentId, int $userId): void
    {
        $stmt = $this->db()->prepare(
            "UPDATE messages SET is_read = 1 WHERE appointment_id = ? AND receiver_id = ?"
        );
        $stmt->execute([$appointmentId, $userId]);
    }
}
