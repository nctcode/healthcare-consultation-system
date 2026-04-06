<?php
class Patient extends Model
{
    protected string $table = 'patients';

    /** Lấy patient kèm thông tin user */
    public function findWithUser(int $id): ?array
    {
        return $this->queryOne(
            "SELECT p.*, u.email, u.full_name, u.phone, u.avatar, u.status 
             FROM patients p JOIN users u ON p.user_id = u.id 
             WHERE p.id = ?", [$id]
        );
    }

    /** Tìm patient theo user_id */
    public function findByUserId(int $userId): ?array
    {
        return $this->findBy('user_id', $userId);
    }

    /** Lấy tất cả patients kèm user info */
    public function allWithUser(): array
    {
        return $this->query(
            "SELECT p.*, u.email, u.full_name, u.phone, u.avatar, u.status 
             FROM patients p JOIN users u ON p.user_id = u.id 
             ORDER BY p.created_at DESC"
        );
    }

    /** Đếm tổng bệnh nhân */
    public function countAll(): int
    {
        return $this->count();
    }
}
