<?php
class User extends Model
{
    protected string $table = 'users';

    /** Tìm user theo email */
    public function findByEmail(string $email): ?array
    {
        return $this->queryOne(
            "SELECT u.*, r.name as role_name, r.display_name as role_display 
             FROM users u JOIN roles r ON u.role_id = r.id 
             WHERE u.email = ?", [$email]
        );
    }

    /** Lấy user kèm role */
    public function findWithRole(int $id): ?array
    {
        return $this->queryOne(
            "SELECT u.*, r.name as role_name, r.display_name as role_display 
             FROM users u JOIN roles r ON u.role_id = r.id 
             WHERE u.id = ?", [$id]
        );
    }

    /** Lấy tất cả users kèm role */
    public function allWithRole(): array
    {
        return $this->query(
            "SELECT u.*, r.name as role_name, r.display_name as role_display 
             FROM users u JOIN roles r ON u.role_id = r.id 
             ORDER BY u.created_at DESC"
        );
    }

    /** Đếm users theo role */
    public function countByRole(string $roleName): int
    {
        return (int) $this->queryScalar(
            "SELECT COUNT(*) FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name = ?",
            [$roleName]
        );
    }
}
