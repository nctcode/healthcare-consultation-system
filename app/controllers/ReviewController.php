<?php
class ReviewController extends Controller
{
    public function create(string $appointment_id): void
    {
        $this->requireRole('patient');
        $appointment = (new Appointment())->findFull((int)$appointment_id);
        $patient = (new Patient())->findByUserId(Auth::id());
        if (!$appointment || !$patient) { $this->redirect('/patient/appointments'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/patient/appointments'); return; }

            (new Review())->create([
                'patient_id'     => $patient['id'],
                'doctor_id'      => $appointment['doctor_id'],
                'appointment_id' => (int)$appointment_id,
                'rating'         => $this->input('rating', 5),
                'comment'        => $this->input('comment'),
            ]);

            // Cập nhật rating bác sĩ
            (new Doctor())->updateRating($appointment['doctor_id']);

            $_SESSION['flash_success'] = 'Cảm ơn bạn đã đánh giá!';
            $this->redirect('/patient/appointments');
        }

        $this->view('patient/review', [
            'title'       => 'Đánh giá bác sĩ',
            'appointment' => $appointment,
        ], 'dashboard');
    }
}
