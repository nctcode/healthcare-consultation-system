<?php
class PrescriptionItem extends Model
{
    protected string $table = 'prescription_items';

    public function byPrescription(int $prescriptionId): array
    {
        return $this->query(
            "SELECT pi.*, m.name as medicine_name, m.unit, m.price as medicine_price
             FROM prescription_items pi
             JOIN medicines m ON pi.medicine_id = m.id
             WHERE pi.prescription_id = ?",
            [$prescriptionId]
        );
    }
}
