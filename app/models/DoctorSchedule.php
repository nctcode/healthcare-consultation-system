<?php
class DoctorSchedule extends Model
{
    protected string $table = 'doctor_schedules';

    /** Lịch của bác sĩ */
    public function byDoctor(int $doctorId): array
    {
        return $this->query(
            "SELECT * FROM doctor_schedules WHERE doctor_id = ? ORDER BY day_of_week, start_time",
            [$doctorId]
        );
    }

    /** Lịch kèm tên bác sĩ */
    public function allWithDoctor(): array
    {
        return $this->query(
            "SELECT ds.*, u.full_name as doctor_name, s.name as specialty_name
             FROM doctor_schedules ds
             JOIN doctors d ON ds.doctor_id = d.id
             JOIN users u ON d.user_id = u.id
             LEFT JOIN specialties s ON d.specialty_id = s.id
             ORDER BY u.full_name, ds.day_of_week, ds.start_time"
        );
    }

    /** Kiểm tra bác sĩ có lịch vào ngày cụ thể không */
    public function availableSlots(int $doctorId, int $dayOfWeek): array
    {
        return $this->query(
            "SELECT * FROM doctor_schedules 
             WHERE doctor_id = ? AND day_of_week = ? AND status = 'active'",
            [$doctorId, $dayOfWeek]
        );
    }
}
