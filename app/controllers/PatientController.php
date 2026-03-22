<?php
/**
 * PatientController - Chức năng bệnh nhân
 */
class PatientController extends Controller
{
    public function __construct() {}

    public function dashboard(): void
    {
        $this->requireRole('patient');
        $patient = (new Patient())->findByUserId(Auth::id());
        $appointmentModel = new Appointment();
        $notifModel = new Notification();

        $this->view('patient/dashboard', [
            'title'         => 'Dashboard bệnh nhân',
            'patient'       => $patient,
            'appointments'  => $patient ? $appointmentModel->byPatient($patient['id']) : [],
            'unreadNotifs'  => $notifModel->unreadCount(Auth::id()),
        ], 'dashboard');
    }

    public function profile(): void
    {
        $this->requireRole('patient');
        $userModel = new User();
        $patientModel = new Patient();
        $user = $userModel->find(Auth::id());
        $patient = $patientModel->findByUserId(Auth::id());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/patient/profile'); return; }

            $userModel->update(Auth::id(), [
                'full_name' => $this->input('full_name'),
                'phone'     => $this->input('phone'),
            ]);

            $patientData = [
                'date_of_birth'    => $this->input('date_of_birth'),
                'gender'           => $this->input('gender'),
                'address'          => $this->input('address'),
                'blood_type'       => $this->input('blood_type'),
                'allergies'        => $this->input('allergies'),
                'insurance_number' => $this->input('insurance_number'),
                'emergency_contact'=> $this->input('emergency_contact'),
            ];

            if ($patient) {
                $patientModel->update($patient['id'], $patientData);
            }

            // Update session name
            $_SESSION['user_name'] = $this->input('full_name');
            $_SESSION['flash_success'] = 'Cập nhật hồ sơ thành công.';
            $this->redirect('/patient/profile');
        }

        $this->view('patient/profile', [
            'title'   => 'Hồ sơ cá nhân',
            'user'    => $user,
            'patient' => $patient,
        ], 'dashboard');
    }

    public function appointments(): void
    {
        $this->requireRole('patient');
        $patient = (new Patient())->findByUserId(Auth::id());
        $appointments = $patient ? (new Appointment())->byPatient($patient['id']) : [];

        $this->view('patient/appointments', [
            'title'        => 'Lịch khám của tôi',
            'appointments' => $appointments,
        ], 'dashboard');
    }

    public function appointmentDetail(string $id): void
    {
        $this->requireRole('patient');
        $appointment = (new Appointment())->findFull((int)$id);
        $this->view('patient/appointment_detail', [
            'title'       => 'Chi tiết lịch khám',
            'appointment' => $appointment,
        ], 'dashboard');
    }

    public function medicalRecords(): void
    {
        $this->requireRole('patient');
        $patient = (new Patient())->findByUserId(Auth::id());
        $records = $patient ? (new MedicalRecord())->byPatient($patient['id']) : [];

        $this->view('patient/medical_records', [
            'title'   => 'Hồ sơ bệnh án',
            'records' => $records,
        ], 'dashboard');
    }

    public function medicalRecordDetail(string $id): void
    {
        $this->requireRole('patient');
        $record = (new MedicalRecord())->findFull((int)$id);
        $images = (new MedicalImage())->byRecord((int)$id);

        $this->view('patient/medical_record_detail', [
            'title'  => 'Chi tiết bệnh án',
            'record' => $record,
            'images' => $images,
        ], 'dashboard');
    }

    public function prescriptions(): void
    {
        $this->requireRole('patient');
        $patient = (new Patient())->findByUserId(Auth::id());
        $prescriptions = $patient ? (new Prescription())->byPatient($patient['id']) : [];

        $this->view('patient/prescriptions', [
            'title'         => 'Đơn thuốc',
            'prescriptions' => $prescriptions,
        ], 'dashboard');
    }

    public function prescriptionDetail(string $id): void
    {
        $this->requireRole('patient');
        $prescription = (new Prescription())->findFull((int)$id);
        $items = (new PrescriptionItem())->byPrescription((int)$id);

        $this->view('patient/prescription_detail', [
            'title'        => 'Chi tiết đơn thuốc',
            'prescription' => $prescription,
            'items'        => $items,
        ], 'dashboard');
    }

    public function payments(): void
    {
        $this->requireRole('patient');
        $patient = (new Patient())->findByUserId(Auth::id());
        $payments = $patient ? (new Payment())->byPatient($patient['id']) : [];

        $this->view('patient/payments', [
            'title'    => 'Thanh toán',
            'payments' => $payments,
        ], 'dashboard');
    }
}
