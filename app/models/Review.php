<?php
class Review extends Model
{
    protected string $table = 'reviews';

    public function byDoctor(int $doctorId): array
    {
        return $this->query(
            "SELECT r.*, up.full_name as patient_name
             FROM reviews r
             JOIN patients p ON r.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             WHERE r.doctor_id = ? ORDER BY r.created_at DESC",
            [$doctorId]
        );
    }

    public function latestReviews(int $limit = 5): array
    {
        return $this->query(
            "SELECT r.*, up.full_name as patient_name, ud.full_name as doctor_name
             FROM reviews r
             JOIN patients p ON r.patient_id = p.id JOIN users up ON p.user_id = up.id
             JOIN doctors d ON r.doctor_id = d.id JOIN users ud ON d.user_id = ud.id
             ORDER BY r.created_at DESC LIMIT {$limit}"
        );
    }

    public function averageRating(): float
    {
        return (float) $this->queryScalar("SELECT COALESCE(AVG(rating), 0) FROM reviews");
    }
}
