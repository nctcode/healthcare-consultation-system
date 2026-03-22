<?php
class Payment extends Model
{
    protected string $table = 'payments';

    public function findFull(int $id): ?array
    {
        return $this->queryOne(
            "SELECT py.*, up.full_name as patient_name, a.appointment_date, a.appointment_time,
                    ud.full_name as doctor_name
             FROM payments py
             JOIN patients p ON py.patient_id = p.id JOIN users up ON p.user_id = up.id
             JOIN appointments a ON py.appointment_id = a.id
             JOIN doctors d ON a.doctor_id = d.id JOIN users ud ON d.user_id = ud.id
             WHERE py.id = ?", [$id]
        );
    }

    public function byPatient(int $patientId): array
    {
        return $this->query(
            "SELECT py.*, a.appointment_date, ud.full_name as doctor_name
             FROM payments py
             JOIN appointments a ON py.appointment_id = a.id
             JOIN doctors d ON a.doctor_id = d.id JOIN users ud ON d.user_id = ud.id
             WHERE py.patient_id = ? ORDER BY py.created_at DESC",
            [$patientId]
        );
    }

    public function pendingPayments(): array
    {
        return $this->query(
            "SELECT py.*, up.full_name as patient_name, a.appointment_date, ud.full_name as doctor_name
             FROM payments py
             JOIN patients p ON py.patient_id = p.id JOIN users up ON p.user_id = up.id
             JOIN appointments a ON py.appointment_id = a.id
             JOIN doctors d ON a.doctor_id = d.id JOIN users ud ON d.user_id = ud.id
             WHERE py.status = 'pending' ORDER BY py.created_at DESC"
        );
    }

    public function totalRevenue(): float
    {
        return (float) $this->queryScalar(
            "SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status = 'completed'"
        );
    }

    public function todayRevenue(): float
    {
        return (float) $this->queryScalar(
            "SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status = 'completed' AND DATE(paid_at) = CURDATE()"
        );
    }
}
