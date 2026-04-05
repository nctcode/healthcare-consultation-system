<?php
/**
 * MessageController - Quản lý tin nhắn theo lịch khám
 */
class MessageController extends Controller
{
    /**
     * Hiển thị giao diện chat
     * GET /messages/{appointment_id}
     */
    public function chat(string $appointment_id): void
    {
        $this->requireRole('patient', 'doctor');

        $appointmentId = (int)$appointment_id;
        $userId = Auth::id();
        $userRole = Auth::role();

        // Lấy thông tin appointment
        $appointmentModel = new Appointment();
        $appointment = $appointmentModel->findFull($appointmentId);

        if (!$appointment) {
            http_response_code(404);
            echo '<div style="padding:20px; text-align:center;"><h2>Lịch khám không tồn tại</h2></div>';
            exit;
        }

        // Kiểm tra user có thuộc appointment này không
        $patientUserId = $this->getUserIdByPatientId($appointment['patient_id']);
        $doctorUserId = $this->getUserIdByDoctorId($appointment['doctor_id']);

        $isPatient = $userRole === 'patient' && $patientUserId === $userId;
        $isDoctor = $userRole === 'doctor' && $doctorUserId === $userId;

        if (!$isPatient && !$isDoctor) {
            http_response_code(403);
            echo '<div style="padding:20px; text-align:center;"><h2>Bạn không có quyền truy cập</h2></div>';
            exit;
        }

        // Lấy danh sách tin nhắn
        $messageModel = new Message();
        $messages = $messageModel->getByAppointment($appointmentId);

        // Mark messages as read
        $messageModel->markAsRead($appointmentId, $userId);

        // Xác định view theo role
        $view = $userRole === 'patient' ? 'patient/chat' : 'doctor/chat';

        $this->view($view, [
            'title' => 'Nhắn tin - ' . ($appointment['doctor_name'] ?? $appointment['patient_name']),
            'appointment' => $appointment,
            'messages' => $messages,
            'user_id' => $userId,
            'user_role' => $userRole,
        ], 'dashboard');
    }

    /**
     * Gửi tin nhắn
     * POST /messages/send
     */
    public function send(): void
    {
        $this->requireRole('patient', 'doctor');

        // Validate CSRF
        if (!$this->validateCSRF()) {
            $this->json(['success' => false, 'error' => 'CSRF token không hợp lệ'], 403);
        }

        $appointmentId = (int)($_POST['appointment_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');
        $userId = Auth::id();
        $userRole = Auth::role();

        // Validate content
        if (empty($content)) {
            $this->json(['success' => false, 'error' => 'Nội dung không được để trống'], 400);
        }

        if (strlen($content) > 5000) {
            $this->json(['success' => false, 'error' => 'Nội dung quá dài (tối đa 5000 ký tự)'], 400);
        }

        // Lấy appointment
        $appointmentModel = new Appointment();
        $appointment = $appointmentModel->find($appointmentId);

        if (!$appointment) {
            $this->json(['success' => false, 'error' => 'Lịch khám không tồn tại'], 404);
        }

        // Lấy patient user_id và doctor user_id
        $patientUserId = $this->getUserIdByPatientId($appointment['patient_id']);
        $doctorUserId = $this->getUserIdByDoctorId($appointment['doctor_id']);

        if (!$patientUserId || !$doctorUserId) {
            $this->json(['success' => false, 'error' => 'Không tìm thấy thông tin bệnh nhân hoặc bác sĩ'], 500);
        }

        // Kiểm tra quyền
        $isPatient = $userRole === 'patient' && $patientUserId === $userId;
        $isDoctor = $userRole === 'doctor' && $doctorUserId === $userId;

        if (!$isPatient && !$isDoctor) {
            $this->json(['success' => false, 'error' => 'Bạn không có quyền'], 403);
        }

        // Xác định receiver_id
        $receiverId = $isPatient ? $doctorUserId : $patientUserId;

        // Lưu message
        $messageModel = new Message();
        $result = $messageModel->create([
            'appointment_id' => $appointmentId,
            'sender_id' => $userId,
            'receiver_id' => $receiverId,
            'content' => $content,
            'message_type' => 'text',
        ]);

        if ($result) {
            $this->json(['success' => true, 'message' => 'Gửi tin thành công']);
        } else {
            $this->json(['success' => false, 'error' => 'Lỗi khi gửi tin'], 500);
        }
    }

    /**
     * Lấy danh sách tin nhắn (JSON)
     * GET /messages/fetch/{appointment_id}?last_id=0
     */
    public function fetch(string $appointment_id): void
    {
        $this->requireRole('patient', 'doctor');

        $appointmentId = (int)$appointment_id;
        $lastMessageId = (int)($this->query('last_id') ?? 0);
        $userId = Auth::id();
        $userRole = Auth::role();

        // Lấy thông tin appointment
        $appointmentModel = new Appointment();
        $appointment = $appointmentModel->find($appointmentId);

        if (!$appointment) {
            $this->json(['success' => false, 'messages' => []], 404);
        }

        // Lấy patient user_id và doctor user_id
        $patientUserId = $this->getUserIdByPatientId($appointment['patient_id']);
        $doctorUserId = $this->getUserIdByDoctorId($appointment['doctor_id']);

        // Kiểm tra quyền
        $isPatient = $userRole === 'patient' && $patientUserId === $userId;
        $isDoctor = $userRole === 'doctor' && $doctorUserId === $userId;

        if (!$isPatient && !$isDoctor) {
            $this->json(['success' => false, 'messages' => []], 403);
        }

        // Lấy tin nhắn mới
        $messageModel = new Message();
        $messages = $messageModel->getNewMessages($appointmentId, $lastMessageId);

        // Mark as read
        $messageModel->markAsRead($appointmentId, $userId);

        $this->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    /**
     * Helper: Lấy user_id từ doctor_id
     */
    private function getUserIdByDoctorId(int $doctorId): ?int
    {
        $doctor = (new Doctor())->find($doctorId);
        return $doctor['user_id'] ?? null;
    }

    /**
     * Helper: Lấy user_id từ patient_id
     */
    private function getUserIdByPatientId(int $patientId): ?int
    {
        $patient = (new Patient())->find($patientId);
        return $patient['user_id'] ?? null;
    }
}
