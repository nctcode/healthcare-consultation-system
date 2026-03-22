<?php
class MedicalImage extends Model
{
    protected string $table = 'medical_images';

    public function byRecord(int $recordId): array
    {
        return $this->where('medical_record_id', $recordId, 'created_at DESC');
    }
}
