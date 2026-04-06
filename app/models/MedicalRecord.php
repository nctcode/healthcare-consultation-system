<?php
class MedicalRecord extends Model
{
    protected string $table = 'medical_records';

    public function findFull(int $id): ?array
    {
        return $this->queryOne(
            "SELECT mr.*, up.full_name as patient_name, ud.full_name as doctor_name,
                    s.name as specialty_name
             FROM medical_records mr
             JOIN patients p ON mr.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             JOIN doctors d ON mr.doctor_id = d.id
             JOIN users ud ON d.user_id = ud.id
             LEFT JOIN specialties s ON d.specialty_id = s.id
             WHERE mr.id = ?", [$id]
        );
    }

    public function byPatient(int $patientId): array
    {
        return $this->query(
            "SELECT mr.*, ud.full_name as doctor_name, s.name as specialty_name
             FROM medical_records mr
             JOIN doctors d ON mr.doctor_id = d.id
             JOIN users ud ON d.user_id = ud.id
             LEFT JOIN specialties s ON d.specialty_id = s.id
             WHERE mr.patient_id = ?
             ORDER BY mr.created_at DESC",
            [$patientId]
        );
    }

    public function byDoctor(int $doctorId): array
    {
        return $this->query(
            "SELECT mr.*, up.full_name as patient_name
             FROM medical_records mr
             JOIN patients p ON mr.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             WHERE mr.doctor_id = ?
             ORDER BY mr.created_at DESC",
            [$doctorId]
        );
    }
}
