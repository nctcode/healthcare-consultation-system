<?php
class NurseAssignment extends Model
{
    protected string $table = 'nurse_assignments';

    public function byNurse(int $nurseId): array
    {
        return $this->query(
            "SELECT na.*, up.full_name as patient_name, up.phone as patient_phone
             FROM nurse_assignments na
             JOIN patients p ON na.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             WHERE na.nurse_id = ?
             ORDER BY na.created_at DESC",
            [$nurseId]
        );
    }

    public function activeByNurse(int $nurseId): array
    {
        return $this->query(
            "SELECT na.*, up.full_name as patient_name, up.phone as patient_phone
             FROM nurse_assignments na
             JOIN patients p ON na.patient_id = p.id
             JOIN users up ON p.user_id = up.id
             WHERE na.nurse_id = ? AND na.status = 'active'
             ORDER BY na.created_at DESC",
            [$nurseId]
        );
    }
}
