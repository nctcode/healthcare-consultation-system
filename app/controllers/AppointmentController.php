<?php
/**
 * AppointmentController - Đặt lịch khám
 */
class AppointmentController extends Controller
{
    /** Đặt lịch khám */
    public function book(): void
    {
        $this->requireRole('patient');
        $patient = (new Patient())->findByUserId(Auth::id());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/patient/appointments/book'); return; }

            $appointmentModel = new Appointment();
            $qrCode = generate_qr_token();

            $appointmentId = $appointmentModel->create([
                'patient_id'         => $patient['id'],
                'doctor_id'          => $this->input('doctor_id'),
                'service_id'         => $this->input('service_id') ?: null,
                'appointment_type_id'=> $this->input('appointment_type_id'),
                'appointment_date'   => $this->input('appointment_date'),
                'appointment_time'   => $this->input('appointment_time'),
                'symptoms'           => $this->input('symptoms'),
                'address'            => $this->input('address'),
                'qr_code'            => $qrCode,
                'status'             => 'pending',
            ]);

            // Tạo payment record
            $doctor = (new Doctor())->find((int)$this->input('doctor_id'));
            $service = $this->input('service_id') ? (new Service())->find((int)$this->input('service_id')) : null;
            $amount = ($doctor['consultation_fee'] ?? 0) + ($service['price'] ?? 0);

            (new Payment())->create([
                'appointment_id' => $appointmentId,
                'patient_id'     => $patient['id'],
                'amount'         => $amount,
                'status'         => 'pending',
            ]);

            // Notifications
            Notification::send(Auth::id(), 'Đặt lịch thành công',
                'Lịch khám ngày ' . format_date($this->input('appointment_date')) . ' đã được tạo.',
                'appointment', '/patient/appointments');

            // Notify doctor
            $doctorUser = (new User())->find($doctor['user_id']);
            if ($doctorUser) {
                Notification::send($doctorUser['id'], 'Lịch khám mới',
                    'Bạn có lịch khám mới ngày ' . format_date($this->input('appointment_date')),
                    'appointment', '/doctor/appointments');
            }

            $_SESSION['flash_success'] = 'Đặt lịch khám thành công! Mã QR: ' . $qrCode;
            $this->redirect('/patient/appointments');
        }

        $specialtyModel = new Specialty();
        $serviceModel = new Service();
        $appointmentTypes = (new Model())->query("SELECT * FROM appointment_types");

        $this->view('patient/book', [
            'title'            => 'Đặt lịch khám',
            'specialties'      => $specialtyModel->allActive(),
            'services'         => $serviceModel->allActive(),
            'appointmentTypes' => $appointmentTypes,
        ], 'dashboard');
    }

    /** API: Lấy bác sĩ theo chuyên khoa */
    public function doctorsBySpecialty(string $id): void
    {
        $doctors = (new Doctor())->bySpecialty((int)$id);
        $this->json(['doctors' => $doctors]);
    }

    /** API: Lấy lịch bác sĩ */
    public function doctorSchedule(string $doctor_id): void
    {
        $schedules = (new DoctorSchedule())->byDoctor((int)$doctor_id);
        $this->json(['schedules' => $schedules]);
    }
}
