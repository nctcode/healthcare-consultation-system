<?php
class Prescription extends Model
{
    protected string $table = 'prescriptions';

    public function findFull(int $id): ?array
    {
        return $this->queryOne(
            "SELECT pr.*, up.full_name as patient_name, ud.full_name as doctor_name,
                    mr.diagnosis
             FROM prescriptions pr
             JOIN patients p ON pr.patient_id = p.id JOIN users up ON p.user_id = up.id
             JOIN doctors d ON pr.doctor_id = d.id JOIN users ud ON d.user_id = ud.id
             JOIN medical_records mr ON pr.medical_record_id = mr.id
             WHERE pr.id = ?", [$id]
        );
    }

    public function byPatient(int $patientId): array
    {
        return $this->query(
            "SELECT pr.*, ud.full_name as doctor_name, mr.diagnosis
             FROM prescriptions pr
             JOIN doctors d ON pr.doctor_id = d.id JOIN users ud ON d.user_id = ud.id
             JOIN medical_records mr ON pr.medical_record_id = mr.id
             WHERE pr.patient_id = ? ORDER BY pr.created_at DESC",
            [$patientId]
        );
    }

    public function byDoctor(int $doctorId): array
    {
        return $this->query(
            "SELECT pr.*, up.full_name as patient_name, mr.diagnosis
             FROM prescriptions pr
             JOIN patients p ON pr.patient_id = p.id JOIN users up ON p.user_id = up.id
             JOIN medical_records mr ON pr.medical_record_id = mr.id
             WHERE pr.doctor_id = ? ORDER BY pr.created_at DESC",
            [$doctorId]
        );
    }
}
