<?php
/**
 * PrescriptionController - Kê đơn thuốc
 */
class PrescriptionController extends Controller
{
    public function create(string $record_id): void
    {
        $this->requireRole('doctor');
        $record = (new MedicalRecord())->findFull((int)$record_id);
        $doctor = (new Doctor())->findByUserId(Auth::id());
        if (!$record || !$doctor) { $this->redirect('/doctor/medical-records'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/doctor/medical-records'); return; }

            $prescriptionModel = new Prescription();
            $prescriptionId = $prescriptionModel->create([
                'medical_record_id' => (int)$record_id,
                'patient_id'        => $record['patient_id'],
                'doctor_id'         => $doctor['id'],
                'notes'             => $this->input('notes'),
            ]);

            // Thêm items
            $itemModel = new PrescriptionItem();
            $medicines = $_POST['medicine_id'] ?? [];
            $quantities = $_POST['quantity'] ?? [];
            $dosages = $_POST['dosage'] ?? [];
            $durations = $_POST['duration'] ?? [];
            $instructions = $_POST['instructions'] ?? [];

            for ($i = 0; $i < count($medicines); $i++) {
                if (!empty($medicines[$i])) {
                    $itemModel->create([
                        'prescription_id' => $prescriptionId,
                        'medicine_id'     => $medicines[$i],
                        'quantity'        => $quantities[$i] ?? 1,
                        'dosage'          => $dosages[$i] ?? '',
                        'duration'        => $durations[$i] ?? '',
                        'instructions'    => $instructions[$i] ?? '',
                    ]);
                }
            }

            $_SESSION['flash_success'] = 'Kê đơn thuốc thành công.';
            $this->redirect('/doctor/appointments');
        }

        $this->view('doctor/create_prescription', [
            'title'     => 'Kê đơn thuốc',
            'record'    => $record,
            'medicines' => (new Medicine())->allActive(),
        ], 'dashboard');
    }
}
