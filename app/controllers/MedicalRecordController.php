<?php
/**
 * MedicalRecordController - Quản lý bệnh án
 */
class MedicalRecordController extends Controller
{
    /** Tạo bệnh án mới */
    public function create(string $appointment_id): void
    {
        $this->requireRole('doctor');
        $appointment = (new Appointment())->findFull((int)$appointment_id);
        $doctor = (new Doctor())->findByUserId(Auth::id());

        if (!$appointment || !$doctor) { $this->redirect('/doctor/appointments'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/doctor/appointments'); return; }

            $recordId = (new MedicalRecord())->create([
                'appointment_id' => (int)$appointment_id,
                'patient_id'     => $appointment['patient_id'],
                'doctor_id'      => $doctor['id'],
                'diagnosis'      => $this->input('diagnosis'),
                'symptoms'       => $this->input('symptoms'),
                'treatment'      => $this->input('treatment'),
                'notes'          => $this->input('notes'),
                'follow_up_date' => $this->input('follow_up_date') ?: null,
            ]);

            // Cập nhật appointment thành hoàn thành
            (new Appointment())->update((int)$appointment_id, ['status' => 'completed']);

            // Notify patient
            $patient = (new Patient())->findWithUser($appointment['patient_id']);
            if ($patient) {
                Notification::send($patient['user_id'], 'Bệnh án mới',
                    'Bệnh án từ lần khám ngày ' . format_date($appointment['appointment_date']) . ' đã được cập nhật.',
                    'system', '/patient/medical-records/' . $recordId);
            }

            $_SESSION['flash_success'] = 'Tạo bệnh án thành công.';
            $this->redirect('/doctor/prescriptions/create/' . $recordId);
        }

        $this->view('doctor/create_record', [
            'title'       => 'Tạo bệnh án',
            'appointment' => $appointment,
        ], 'dashboard');
    }
}
