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

    /** Chỉnh sửa bệnh án */
    public function edit(string $id): void
    {
        $this->requireRole('doctor');
        $recordModel = new MedicalRecord();
        $record = $recordModel->findFull((int)$id);

        // Kiểm tra bệnh án tồn tại
        if (!$record) { $this->redirect('/doctor/medical-records'); return; }

        // Kiểm tra doctor chỉ có thể sửa bệnh án của chính mình
        $doctor = (new Doctor())->findByUserId(Auth::id());
        if ($doctor['id'] != $record['doctor_id']) {
            $_SESSION['flash_error'] = 'Bạn không có quyền sửa bệnh án này.';
            $this->redirect('/doctor/medical-records');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/doctor/medical-records'); return; }

            // Cập nhật bệnh án
            $recordModel->update((int)$id, [
                'diagnosis'      => $this->input('diagnosis'),
                'symptoms'       => $this->input('symptoms'),
                'treatment'      => $this->input('treatment'),
                'notes'          => $this->input('notes'),
                'follow_up_date' => $this->input('follow_up_date') ?: null,
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);

            $_SESSION['flash_success'] = 'Cập nhật bệnh án thành công.';
            $this->redirect('/doctor/medical-records');
        } else {
            // Lấy bệnh án đầy đủ
            $record = $recordModel->findFull((int)$id);

            $this->view('doctor/medical_record_form', [
                'title'  => 'Chỉnh sửa bệnh án',
                'record' => $record,
            ], 'dashboard');
        }
    }

    /** Cập nhật bệnh án (deprecated - dùng edit thay) */
    public function update(string $id): void
    {
        // Delegate to edit
        $this->edit($id);
    }
}
