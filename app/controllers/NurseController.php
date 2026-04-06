<?php
/**
 * NurseController - Chức năng điều dưỡng
 */
class NurseController extends Controller
{
    public function dashboard(): void
    {
        $this->requireRole('nurse');
        $nurse = (new Nurse())->findByUserId(Auth::id());
        $assignments = $nurse ? (new NurseAssignment())->activeByNurse($nurse['id']) : [];

        $this->view('nurse/dashboard', [
            'title'       => 'Dashboard điều dưỡng',
            'nurse'       => $nurse,
            'assignments' => $assignments,
            'totalActive' => count($assignments),
        ], 'dashboard');
    }

    public function patients(): void
    {
        $this->requireRole('nurse');
        $nurse = (new Nurse())->findByUserId(Auth::id());
        $assignments = $nurse ? (new NurseAssignment())->byNurse($nurse['id']) : [];

        $this->view('nurse/patients', [
            'title'       => 'Bệnh nhân được phân công',
            'assignments' => $assignments,
        ], 'dashboard');
    }

    public function healthUpdate(string $id): void
    {
        $this->requireRole('nurse');
        $model = new NurseAssignment();
        $assignment = $model->find((int)$id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/nurse/patients'); return; }

            $metrics = json_encode([
                'blood_pressure' => $this->input('blood_pressure'),
                'temperature'    => $this->input('temperature'),
                'heart_rate'     => $this->input('heart_rate'),
                'spo2'           => $this->input('spo2'),
                'weight'         => $this->input('weight'),
                'note'           => $this->input('health_note'),
            ]);

            $model->update((int)$id, ['health_metrics' => $metrics]);
            $_SESSION['flash_success'] = 'Cập nhật chỉ số sức khỏe thành công.';
            $this->redirect('/nurse/patients');
        }

        $this->view('nurse/health_update', [
            'title'      => 'Cập nhật chỉ số sức khỏe',
            'assignment' => $assignment,
            'metrics'    => $assignment ? json_decode($assignment['health_metrics'] ?? '{}', true) : [],
        ], 'dashboard');
    }

    public function careNotes(string $id): void
    {
        $this->requireRole('nurse');
        $model = new NurseAssignment();
        $assignment = $model->find((int)$id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/nurse/patients'); return; }
            $model->update((int)$id, [
                'notes'  => $this->input('notes'),
                'status' => $this->input('status', 'active'),
            ]);
            $_SESSION['flash_success'] = 'Cập nhật ghi chú thành công.';
            $this->redirect('/nurse/patients');
        }

        $this->view('nurse/care_notes', [
            'title'      => 'Ghi chú chăm sóc',
            'assignment' => $assignment,
        ], 'dashboard');
    }
}
