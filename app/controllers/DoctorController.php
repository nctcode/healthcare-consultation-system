<?php
/**
 * DoctorController - Chức năng bác sĩ
 */
class DoctorController extends Controller
{
    public function __construct() {}

    public function dashboard(): void
    {
        $this->requireRole('doctor');
        $doctor = (new Doctor())->findByUserId(Auth::id());
        $appointmentModel = new Appointment();

        $todayAppts = $doctor ? $appointmentModel->todayByDoctor($doctor['id']) : [];
        $allAppts = $doctor ? $appointmentModel->byDoctor($doctor['id']) : [];

        $this->view('doctor/dashboard', [
            'title'             => 'Dashboard bác sĩ',
            'doctor'            => $doctor,
            'todayAppointments' => $todayAppts,
            'totalAppointments' => count($allAppts),
            'completedToday'    => count(array_filter($todayAppts, fn($a) => $a['status'] === 'completed')),
        ], 'dashboard');
    }

    public function appointments(): void
    {
        $this->requireRole('doctor');
        $doctor = (new Doctor())->findByUserId(Auth::id());
        $appointments = $doctor ? (new Appointment())->byDoctor($doctor['id']) : [];

        $this->view('doctor/appointments', [
            'title'        => 'Danh sách lịch khám',
            'appointments' => $appointments,
        ], 'dashboard');
    }

    public function examine(string $id): void
    {
        $this->requireRole('doctor');
        $appointment = (new Appointment())->findFull((int)$id);

        if (!$appointment) { $this->redirect('/doctor/appointments'); return; }

        // Cập nhật trạng thái thành đang khám
        if ($appointment['status'] === 'confirmed') {
            (new Appointment())->update((int)$id, ['status' => 'in_progress']);
            $appointment['status'] = 'in_progress';
        }

        // Lấy bệnh án cũ
        $patient = (new Patient())->findWithUser($appointment['patient_id']);
        $medicalRecords = (new MedicalRecord())->byPatient($appointment['patient_id']);

        $this->view('doctor/examine', [
            'title'          => 'Khám bệnh - ' . $appointment['patient_name'],
            'appointment'    => $appointment,
            'patient'        => $patient,
            'medicalRecords' => $medicalRecords,
        ], 'dashboard');
    }

    public function medicalRecords(): void
    {
        $this->requireRole('doctor');
        $doctor = (new Doctor())->findByUserId(Auth::id());
        $records = $doctor ? (new MedicalRecord())->byDoctor($doctor['id']) : [];

        $this->view('doctor/medical_records', [
            'title'   => 'Bệnh án đã tạo',
            'records' => $records,
        ], 'dashboard');
    }

    public function patients(): void
    {
        $this->requireRole('doctor');
        $doctor = (new Doctor())->findByUserId(Auth::id());

        // Lấy danh sách bệnh nhân đã khám
        $patients = $doctor ? (new MedicalRecord())->query(
            "SELECT DISTINCT p.id, u.full_name, u.phone, u.email, p.date_of_birth, p.gender,
                    COUNT(mr.id) as visit_count, MAX(mr.created_at) as last_visit
             FROM medical_records mr
             JOIN patients p ON mr.patient_id = p.id
             JOIN users u ON p.user_id = u.id
             WHERE mr.doctor_id = ?
             GROUP BY p.id, u.full_name, u.phone, u.email, p.date_of_birth, p.gender
             ORDER BY last_visit DESC",
            [$doctor['id']]
        ) : [];

        $this->view('doctor/patients', [
            'title'    => 'Bệnh nhân của tôi',
            'patients' => $patients,
        ], 'dashboard');
    }
}
