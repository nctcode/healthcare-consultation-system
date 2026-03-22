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
        $this->view('receptionist/queue', [
            'title' => 'Hàng chờ bệnh nhân',
            'queue' => (new Appointment())->todayQueue(),
        ], 'dashboard');
    }
}
