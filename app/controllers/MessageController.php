<?php
class MessageController extends Controller
{
    public function chat(string $appointment_id): void
    {
        $this->requireAuth();
        $appointment = (new Appointment())->findFull((int)$appointment_id);
        if (!$appointment) { $this->redirect('/'); return; }

        $messageModel = new Message();
        $messageModel->markRead((int)$appointment_id, Auth::id());
        $messages = $messageModel->byAppointment((int)$appointment_id);

        $layout = Auth::role() === 'patient' ? 'dashboard' : 'dashboard';
        $this->view('patient/chat', [
            'title'         => 'Chat - ' . ($appointment['doctor_name'] ?? $appointment['patient_name']),
            'appointment'   => $appointment,
            'messages'      => $messages,
            'appointment_id'=> $appointment_id,
        ], $layout);
    }

    public function apiMessages(string $appointment_id): void
    {
        $this->requireAuth();
        $messages = (new Message())->byAppointment((int)$appointment_id);
        $this->json(['messages' => $messages]);
    }

    public function apiSend(): void
    {
        $this->requireAuth();
        $messageModel = new Message();
        $messageModel->create([
            'appointment_id' => $this->input('appointment_id'),
            'sender_id'      => Auth::id(),
            'receiver_id'    => $this->input('receiver_id'),
            'content'        => $this->input('content'),
            'message_type'   => 'text',
        ]);
        $this->json(['success' => true]);
    }
}
