<?php
class Receptionist extends Model
{
    protected string $table = 'receptionists';

    public function findByUserId(int $userId): ?array
    {
        return $this->findBy('user_id', $userId);
    }

    public function allWithUser(): array
    {
        return $this->query(
            "SELECT r.*, u.email, u.full_name, u.phone, u.avatar, u.status 
             FROM receptionists r JOIN users u ON r.user_id = u.id 
             ORDER BY r.created_at DESC"
        );
    }
}
