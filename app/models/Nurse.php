<?php
class Nurse extends Model
{
    protected string $table = 'nurses';

    public function findByUserId(int $userId): ?array
    {
        return $this->findBy('user_id', $userId);
    }

    public function allWithUser(): array
    {
        return $this->query(
            "SELECT n.*, u.email, u.full_name, u.phone, u.avatar, u.status 
             FROM nurses n JOIN users u ON n.user_id = u.id 
             ORDER BY n.created_at DESC"
        );
    }
}
