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

    /** Tạo bệnh nhân */
    public function createPatient(): void
    {
        $this->requireRole('doctor');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/doctor/patients'); return; }

            $userModel = new User();
            // Kiểm tra email đã tồn tại
            if ($userModel->findByEmail($this->input('email'))) {
                $_SESSION['flash_error'] = 'Email đã tồn tại.';
                flash_old_input($_POST);
                $this->redirect('/doctor/patients/create');
                return;
            }

            // Tạo user (role_id = 2 là patient)
            $userId = $userModel->create([
                'role_id'   => 2,
                'email'     => $this->input('email'),
                'password'  => password_hash($this->input('password') ?: 'patient123', PASSWORD_DEFAULT),
                'full_name' => $this->input('full_name'),
                'phone'     => $this->input('phone'),
                'status'    => $this->input('status', 'active'),
            ]);

            // Tạo bệnh nhân
            (new Patient())->create([
                'user_id'             => $userId,
                'date_of_birth'       => $this->input('date_of_birth'),
                'gender'              => $this->input('gender'),
                'address'             => $this->input('address'),
                'blood_type'          => $this->input('blood_type'),
                'allergies'           => $this->input('allergies'),
                'insurance_number'    => $this->input('insurance_number'),
                'emergency_contact'   => $this->input('emergency_contact'),
            ]);

            $_SESSION['flash_success'] = 'Thêm bệnh nhân thành công.';
            $this->redirect('/doctor/patients');
        } else {
            $this->view('doctor/patient_form', [
                'title'   => 'Thêm bệnh nhân',
                'patient' => null,
            ], 'dashboard');
        }
    }

    /** Sửa bệnh nhân */
    public function editPatient(string $id): void
    {
        $this->requireRole('doctor');
        $patientModel = new Patient();
        $patient = $patientModel->findWithUser((int)$id);

        if (!$patient) { $this->redirect('/doctor/patients'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/doctor/patients'); return; }

            // Cập nhật user
            $userData = [
                'full_name' => $this->input('full_name'),
                'phone'     => $this->input('phone'),
                'status'    => $this->input('status'),
            ];
            if ($this->input('password')) {
                $userData['password'] = password_hash($this->input('password'), PASSWORD_DEFAULT);
            }
            (new User())->update($patient['user_id'], $userData);

            // Cập nhật bệnh nhân
            $patientModel->update((int)$id, [
                'date_of_birth'       => $this->input('date_of_birth'),
                'gender'              => $this->input('gender'),
                'address'             => $this->input('address'),
                'blood_type'          => $this->input('blood_type'),
                'allergies'           => $this->input('allergies'),
                'insurance_number'    => $this->input('insurance_number'),
                'emergency_contact'   => $this->input('emergency_contact'),
            ]);

            $_SESSION['flash_success'] = 'Cập nhật bệnh nhân thành công.';
            $this->redirect('/doctor/patients');
        } else {
            $this->view('doctor/patient_form', [
                'title'   => 'Sửa thông tin bệnh nhân',
                'patient' => $patient,
            ], 'dashboard');
        }
    }

    /** Xóa bệnh nhân */
    public function deletePatient(string $id): void
    {
        $this->requireRole('doctor');
        $patientModel = new Patient();
        $patient = $patientModel->find((int)$id);

        if ($patient) {
            // Xóa user (sẽ cascade xóa patient do foreign key)
            (new User())->delete($patient['user_id']);
        }

        $_SESSION['flash_success'] = 'Đã xóa bệnh nhân.';
        $this->redirect('/doctor/patients');
    }
}