<?php
class Appointment extends Model
{
    protected string $table = 'appointments';

    /** Lấy chi tiết appointment kèm thông tin liên quan */
    public function findFull(int $id): ?array
    {
        return $this->queryOne(
            "SELECT a.*, 
                    p.id as pid, up.full_name as patient_name, up.phone as patient_phone,
                    d.id as did, ud.full_name as doctor_name, 
                    s.name as specialty_name,
                    sv.name as service_name, sv.price as service_price,
                    at.display_name as type_name
             FROM appointments a
             JOIN patients p ON a.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             JOIN doctors d ON a.doctor_id = d.id
             JOIN users ud ON d.user_id = ud.id
             LEFT JOIN specialties s ON d.specialty_id = s.id
             LEFT JOIN services sv ON a.service_id = sv.id
             JOIN appointment_types at ON a.appointment_type_id = at.id
             WHERE a.id = ?", [$id]
        );
    }

    /** Appointments của bệnh nhân */
    public function byPatient(int $patientId): array
    {
        return $this->query(
            "SELECT a.*, ud.full_name as doctor_name, s.name as specialty_name,
                    at.display_name as type_name
             FROM appointments a
             JOIN doctors d ON a.doctor_id = d.id
             JOIN users ud ON d.user_id = ud.id
             LEFT JOIN specialties s ON d.specialty_id = s.id
             JOIN appointment_types at ON a.appointment_type_id = at.id
             WHERE a.patient_id = ?
             ORDER BY a.appointment_date DESC, a.appointment_time DESC",
            [$patientId]
        );
    }

    /** Appointments của bác sĩ */
    public function byDoctor(int $doctorId): array
    {
        return $this->query(
            "SELECT a.*, up.full_name as patient_name, up.phone as patient_phone,
                    at.display_name as type_name, sv.name as service_name
             FROM appointments a
             JOIN patients p ON a.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             JOIN appointment_types at ON a.appointment_type_id = at.id
             LEFT JOIN services sv ON a.service_id = sv.id
             WHERE a.doctor_id = ?
             ORDER BY a.appointment_date DESC, a.appointment_time DESC",
            [$doctorId]
        );
    }

    /** Appointments hôm nay của bác sĩ */
    public function todayByDoctor(int $doctorId): array
    {
        return $this->query(
            "SELECT a.*, up.full_name as patient_name, up.phone as patient_phone,
                    at.display_name as type_name
             FROM appointments a
             JOIN patients p ON a.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             JOIN appointment_types at ON a.appointment_type_id = at.id
             WHERE a.doctor_id = ? AND a.appointment_date = CURDATE()
             ORDER BY a.appointment_time ASC",
            [$doctorId]
        );
    }

    /** Tất cả appointments (cho lễ tân) */
    public function allFull(): array
    {
        return $this->query(
            "SELECT a.*, up.full_name as patient_name, ud.full_name as doctor_name,
                    at.display_name as type_name, s.name as specialty_name
             FROM appointments a
             JOIN patients p ON a.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             JOIN doctors d ON a.doctor_id = d.id
             JOIN users ud ON d.user_id = ud.id
             LEFT JOIN specialties s ON d.specialty_id = s.id
             JOIN appointment_types at ON a.appointment_type_id = at.id
             ORDER BY a.appointment_date DESC, a.appointment_time DESC"
        );
    }

    /** Hàng chờ hôm nay */
    public function todayQueue(): array
    {
        return $this->query(
            "SELECT a.*, up.full_name as patient_name, ud.full_name as doctor_name,
                    at.display_name as type_name, s.name as specialty_name
             FROM appointments a
             JOIN patients p ON a.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             JOIN doctors d ON a.doctor_id = d.id
             JOIN users ud ON d.user_id = ud.id
             LEFT JOIN specialties s ON d.specialty_id = s.id
             JOIN appointment_types at ON a.appointment_type_id = at.id
             WHERE a.appointment_date = CURDATE() AND a.status IN ('confirmed','in_progress')
             ORDER BY a.appointment_time ASC"
        );
    }

    /** Cập nhật trạng thái có kiểm tra trạng thái hiện tại */
    public function updateStatusByCurrent(int $id, string $currentStatus, string $newStatus): bool
    {
        $stmt = $this->db()->prepare(
            "UPDATE appointments
             SET status = ?, updated_at = CURRENT_TIMESTAMP
             WHERE id = ? AND status = ?"
        );

        $stmt->execute([$newStatus, $id, $currentStatus]);
        return $stmt->rowCount() > 0;
    }

    /** Tìm theo QR code */
    public function findByQR(string $qrCode): ?array
    {
        return $this->queryOne(
            "SELECT a.*, up.full_name as patient_name, ud.full_name as doctor_name
             FROM appointments a
             JOIN patients p ON a.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             JOIN doctors d ON a.doctor_id = d.id
             JOIN users ud ON d.user_id = ud.id
             WHERE a.qr_code = ?", [$qrCode]
        );
    }

    /** Đếm theo status */
    public function countByStatus(string $status): int
    {
        return $this->count('status = ?', [$status]);
    }

    /** Đếm hôm nay */
    public function countToday(): int
    {
        return $this->count('appointment_date = CURDATE()');
    }

    /** Đếm theo loại */
    public function countByType(int $typeId): int
    {
        return $this->count('appointment_type_id = ?', [$typeId]);
    }

    /** Thống kê theo tháng */
    public function monthlyStats(int $year): array
    {
        return $this->query(
            "SELECT MONTH(appointment_date) as month, COUNT(*) as total
             FROM appointments 
             WHERE YEAR(appointment_date) = ? AND status != 'cancelled'
             GROUP BY MONTH(appointment_date)
             ORDER BY month",
            [$year]
        );
    }

    /** Doanh thu tháng */
    public function monthlyRevenue(int $year): array
    {
        return $this->query(
            "SELECT MONTH(py.paid_at) as month, SUM(py.amount) as total
             FROM payments py
             WHERE YEAR(py.paid_at) = ? AND py.status = 'completed'
             GROUP BY MONTH(py.paid_at)
             ORDER BY month",
            [$year]
        );
    }

    /** Kiểm tra bác sĩ có trùng lịch hay không */
    public function hasDoctorConflict(int $doctorId, string $date, string $time): bool
    {
        $count = (int)$this->queryScalar(
            "SELECT COUNT(*)
             FROM appointments
             WHERE doctor_id = ?
               AND appointment_date = ?
               AND appointment_time = ?
               AND status IN ('pending','confirmed','in_progress')",
            [$doctorId, $date, $time]
        );

        return $count > 0;
    }
}
