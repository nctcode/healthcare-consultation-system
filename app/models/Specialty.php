<?php
class Specialty extends Model
{
    protected string $table = 'specialties';

    public function allActive(): array
    {
        return $this->where('status', 'active', 'name ASC');
    }

    /** Đếm bác sĩ theo chuyên khoa */
    public function withDoctorCount(): array
    {
        return $this->query(
            "SELECT s.*, COUNT(d.id) as doctor_count 
             FROM specialties s 
             LEFT JOIN doctors d ON s.id = d.specialty_id AND d.status = 'active'
             WHERE s.status = 'active'
             GROUP BY s.id 
             ORDER BY s.name ASC"
        );
    }
}
