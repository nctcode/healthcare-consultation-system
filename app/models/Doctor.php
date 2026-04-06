<?php
class Doctor extends Model
{
    protected string $table = 'doctors';

    /** Lấy doctor kèm user + specialty */
    public function findFull(int $id): ?array
    {
        return $this->queryOne(
            "SELECT d.*, u.email, u.full_name, u.phone, u.avatar, u.status as user_status,
                    s.name as specialty_name, s.icon as specialty_icon
             FROM doctors d 
             JOIN users u ON d.user_id = u.id 
             LEFT JOIN specialties s ON d.specialty_id = s.id 
             WHERE d.id = ?", [$id]
        );
    }

    /** Tìm doctor theo user_id */
    public function findByUserId(int $userId): ?array
    {
        return $this->findBy('user_id', $userId);
    }

    /** Lấy tất cả doctors kèm info */
    public function allWithInfo(): array
    {
        return $this->query(
            "SELECT d.*, u.email, u.full_name, u.phone, u.avatar, u.status as user_status,
                    s.name as specialty_name
             FROM doctors d 
             JOIN users u ON d.user_id = u.id 
             LEFT JOIN specialties s ON d.specialty_id = s.id 
             WHERE d.status = 'active'
             ORDER BY d.rating DESC"
        );
    }

    /** Doctors theo chuyên khoa */
    public function bySpecialty(int $specialtyId): array
    {
        return $this->query(
            "SELECT d.*, u.full_name, u.avatar, s.name as specialty_name
             FROM doctors d 
             JOIN users u ON d.user_id = u.id 
             LEFT JOIN specialties s ON d.specialty_id = s.id 
             WHERE d.specialty_id = ? AND d.status = 'active'
             ORDER BY d.rating DESC",
            [$specialtyId]
        );
    }

    /** Top doctors */
    public function topRated(int $limit = 4): array
    {
        return $this->query(
            "SELECT d.*, u.full_name, u.avatar, s.name as specialty_name
             FROM doctors d 
             JOIN users u ON d.user_id = u.id 
             LEFT JOIN specialties s ON d.specialty_id = s.id 
             WHERE d.status = 'active'
             ORDER BY d.rating DESC LIMIT {$limit}"
        );
    }

    /** Cập nhật rating trung bình */
    public function updateRating(int $doctorId): void
    {
        $avg = $this->queryScalar(
            "SELECT COALESCE(AVG(rating), 0) FROM reviews WHERE doctor_id = ?",
            [$doctorId]
        );
        $this->update($doctorId, ['rating' => round($avg, 2)]);
    }

    /** Đếm tổng bác sĩ */
    public function countAll(): int
    {
        return $this->count();
    }
}
