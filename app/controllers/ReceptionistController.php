<?php
/**
 * ReceptionistController - Chức năng lễ tân
 */
class ReceptionistController extends Controller
{
    public function dashboard(): void
    {
        $this->requireRole('receptionist');
        $appointmentModel = new Appointment();
        $paymentModel = new Payment();

        $this->view('receptionist/dashboard', [
            'title'          => 'Dashboard lễ tân',
            'todayQueue'     => $appointmentModel->todayQueue(),
            'todayCount'     => $appointmentModel->countToday(),
            'todayRevenue'   => $paymentModel->todayRevenue(),
            'pendingPayments'=> count($paymentModel->pendingPayments()),
        ], 'dashboard');
    }

    public function appointments(): void
    {
        $this->requireRole('receptionist');
        $this->view('receptionist/appointments', [
            'title'        => 'Quản lý lịch hẹn',
            'appointments' => (new Appointment())->allFull(),
        ], 'dashboard');
    }

    public function createAppointment(): void
    {
        $this->requireRole('receptionist');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/receptionist/appointments/create'); return; }

            $patientId = (int)$this->input('patient_id', 0);
            $doctorId = (int)$this->input('doctor_id', 0);
            $typeId = (int)$this->input('appointment_type_id', 0);
            $appointmentDate = $this->input('appointment_date');
            $appointmentTime = $this->input('appointment_time');

            if ($patientId <= 0 || $doctorId <= 0 || $typeId <= 0 || !$appointmentDate || !$appointmentTime) {
                $_SESSION['flash_error'] = 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
                $this->redirect('/receptionist/appointments/create');
                return;
            }

            $appointmentModel = new Appointment();
            if ($appointmentModel->hasDoctorConflict($doctorId, $appointmentDate, $appointmentTime)) {
                $_SESSION['flash_error'] = 'Bác sĩ đã có lịch ở khung giờ này. Vui lòng chọn giờ khác.';
                $this->redirect('/receptionist/appointments/create');
                return;
            }

            $appointmentId = $appointmentModel->create([
                'patient_id'          => $patientId,
                'doctor_id'           => $doctorId,
                'service_id'          => $this->input('service_id') ?: null,
                'appointment_type_id' => $typeId,
                'appointment_date'    => $appointmentDate,
                'appointment_time'    => $appointmentTime,
                'symptoms'            => $this->input('symptoms'),
                'notes'               => $this->input('notes'),
                'address'             => $this->input('address'),
                'qr_code'             => generate_qr_token(),
                'status'              => 'confirmed',
            ]);

            $doctor = (new Doctor())->find($doctorId);
            $serviceId = (int)$this->input('service_id', 0);
            $service = $serviceId > 0 ? (new Service())->find($serviceId) : null;
            $amount = (float)($doctor['consultation_fee'] ?? 0) + (float)($service['price'] ?? 0);

            (new Payment())->create([
                'appointment_id' => $appointmentId,
                'patient_id'     => $patientId,
                'amount'         => $amount,
                'status'         => 'pending',
            ]);

            $patientUser = (new Patient())->findWithUser($patientId);
            if ($patientUser && !empty($patientUser['user_id'])) {
                Notification::send(
                    (int)$patientUser['user_id'],
                    'Lịch khám đã được tạo',
                    'Lễ tân đã tạo lịch khám cho bạn vào ngày ' . format_date($appointmentDate) . '.',
                    'appointment',
                    '/patient/appointments'
                );
            }

            if ($doctor && !empty($doctor['user_id'])) {
                Notification::send(
                    (int)$doctor['user_id'],
                    'Lịch khám mới',
                    'Bạn có lịch khám mới ngày ' . format_date($appointmentDate) . '.',
                    'appointment',
                    '/doctor/appointments'
                );
            }

            $_SESSION['flash_success'] = 'Tạo lịch hẹn thành công.';
            $this->redirect('/receptionist/appointments');
            return;
        }

        $this->view('receptionist/appointment_create', [
            'title'            => 'Tạo lịch hẹn',
            'patients'         => (new Patient())->allWithUser(),
            'doctors'          => (new Doctor())->allWithInfo(),
            'services'         => (new Service())->allActive(),
            'appointmentTypes' => (new Model())->query('SELECT * FROM appointment_types ORDER BY id ASC'),
        ], 'dashboard');
    }

    public function editAppointment(string $id): void
    {
        $this->requireRole('receptionist');
        $model = new Appointment();
        $appointment = $model->findFull((int)$id);
        if (!$appointment) { $this->redirect('/receptionist/appointments'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/receptionist/appointments'); return; }
            $model->update((int)$id, [
                'status'           => $this->input('status'),
                'appointment_date' => $this->input('appointment_date'),
                'appointment_time' => $this->input('appointment_time'),
                'notes'            => $this->input('notes'),
            ]);

            // Gửi notification cho bệnh nhân
            $patientUser = (new Patient())->findWithUser($appointment['patient_id']);
            if ($patientUser) {
                Notification::send($patientUser['user_id'], 'Lịch khám cập nhật',
                    'Lịch khám của bạn đã được cập nhật. Vui lòng kiểm tra.',
                    'appointment', '/patient/appointments');
            }

            $_SESSION['flash_success'] = 'Cập nhật lịch hẹn thành công.';
            $this->redirect('/receptionist/appointments');
        }

        $this->view('receptionist/appointment_edit', [
            'title'       => 'Sửa lịch hẹn',
            'appointment' => $appointment,
        ], 'dashboard');
    }

    public function cancelAppointment(string $id): void
    {
        $this->requireRole('receptionist');
        (new Appointment())->update((int)$id, ['status' => 'cancelled']);
        $_SESSION['flash_success'] = 'Đã hủy lịch hẹn.';
        $this->redirect('/receptionist/appointments');
    }

    public function checkin(): void
    {
        $this->requireRole('receptionist');
        $result = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/receptionist/checkin'); return; }
            $qrCode = $this->input('qr_code');
            $appointmentModel = new Appointment();
            $appointment = $appointmentModel->findByQR($qrCode);

            if ($appointment) {
                if ($appointment['status'] === 'confirmed') {
                    $appointmentModel->update($appointment['id'], ['status' => 'in_progress']);
                    $result = ['success' => true, 'appointment' => $appointment, 'message' => 'Check-in thành công!'];
                } else {
                    $result = ['success' => false, 'message' => 'Lịch hẹn không ở trạng thái có thể check-in (trạng thái: ' . $appointment['status'] . ')'];
                }
            } else {
                $result = ['success' => false, 'message' => 'Không tìm thấy lịch hẹn với mã QR này.'];
            }
        }

        $this->view('receptionist/checkin', [
            'title'  => 'Check-in bệnh nhân',
            'result' => $result,
        ], 'dashboard');
    }

    /** API verify QR */
    public function verifyCheckin(): void
    {
        $this->requireRole('receptionist');
        $qrCode = $this->input('qr_code');
        $appointmentModel = new Appointment();
        $appointment = $appointmentModel->findByQR($qrCode);

        if (!$appointment) {
            $this->json(['success' => false, 'message' => 'Mã QR không hợp lệ.'], 404);
            return;
        }

        if ($appointment['status'] === 'confirmed') {
            $appointmentModel->update($appointment['id'], ['status' => 'in_progress']);
            $this->json(['success' => true, 'message' => 'Check-in thành công!', 'patient_name' => $appointment['patient_name']]);
        } else {
            $this->json(['success' => false, 'message' => 'Lịch hẹn không hợp lệ cho check-in.']);
        }
    }

    public function payments(): void
    {
        $this->requireRole('receptionist');
        $this->view('receptionist/payments', [
            'title'    => 'Quản lý thanh toán',
            'payments' => (new Payment())->pendingPayments(),
        ], 'dashboard');
    }

    public function confirmPayment(string $id): void
    {
        $this->requireRole('receptionist');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$this->validateCSRF()) {
            $this->redirect('/receptionist/payments');
            return;
        }

        $paymentModel = new Payment();
        $payment = $paymentModel->find((int)$id);

        if ($payment) {
            $paymentModel->update((int)$id, [
                'status'  => 'completed',
                'method'  => $this->input('method', 'cash') ?: 'cash',
                'paid_at' => date('Y-m-d H:i:s'),
            ]);

            // Notify patient
            $patient = (new Patient())->find($payment['patient_id']);
            if ($patient) {
                Notification::send($patient['user_id'], 'Thanh toán thành công',
                    'Hóa đơn ' . format_money($payment['amount']) . ' đã được thanh toán.',
                    'payment', '/patient/payments');
            }

            $_SESSION['flash_success'] = 'Xác nhận thanh toán thành công.';
        }
        $this->redirect('/receptionist/payments');
    }

    public function queue(): void
    {
        $this->requireRole('receptionist');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) {
                $this->redirect('/receptionist/queue');
                return;
            }

            $appointmentId = (int) $this->input('appointment_id', 0);
            $action = $this->input('action', '');
            $appointmentModel = new Appointment();
            $appointment = $appointmentModel->find($appointmentId);

            if (!$appointment || $appointment['appointment_date'] !== date('Y-m-d')) {
                $_SESSION['flash_error'] = 'Không tìm thấy lịch hẹn hợp lệ trong hàng đợi hôm nay.';
                $this->redirect('/receptionist/queue');
                return;
            }

            $transitions = [
                'call_next'      => ['from' => 'confirmed',   'to' => 'in_progress', 'message' => 'Đã gọi bệnh nhân vào khám.'],
                'complete'       => ['from' => 'in_progress', 'to' => 'completed',   'message' => 'Đã hoàn tất lượt khám.'],
                'mark_absent'    => ['from' => 'confirmed',   'to' => 'cancelled',   'message' => 'Đã đánh dấu bệnh nhân vắng mặt.'],
                'return_waiting' => ['from' => 'in_progress', 'to' => 'confirmed',   'message' => 'Đã chuyển bệnh nhân về trạng thái chờ khám.'],
            ];

            if (!isset($transitions[$action])) {
                $_SESSION['flash_error'] = 'Thao tác hàng đợi không hợp lệ.';
                $this->redirect('/receptionist/queue');
                return;
            }

            $rule = $transitions[$action];
            $updated = $appointmentModel->updateStatusByCurrent($appointmentId, $rule['from'], $rule['to']);

            if ($updated) {
                $patientUser = (new Patient())->findWithUser((int)$appointment['patient_id']);
                if ($patientUser && !empty($patientUser['user_id'])) {
                    Notification::send(
                        (int)$patientUser['user_id'],
                        'Cập nhật trạng thái khám',
                        $rule['message'],
                        'appointment',
                        '/patient/appointments'
                    );
                }
                $_SESSION['flash_success'] = $rule['message'];
            } else {
                $_SESSION['flash_error'] = 'Không thể cập nhật trạng thái. Vui lòng tải lại danh sách.';
            }

            $this->redirect('/receptionist/queue');
            return;
        }

        $this->view('receptionist/queue', [
            'title' => 'Hàng chờ bệnh nhân',
            'queue' => (new Appointment())->todayQueue(),
        ], 'dashboard');
    }
}
