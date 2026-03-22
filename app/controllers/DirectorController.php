<?php
/**
 * DirectorController - Ban Giám đốc (Read-only view)
 */
class DirectorController extends Controller
{
    public function __construct()
    {
    }

    /** Dashboard */
    public function dashboard(): void
    {
        $this->requireRole('director');

        $patientModel = new Patient();
        $doctorModel = new Doctor();
        $appointmentModel = new Appointment();
        $paymentModel = new Payment();
        $medicineModel = new Medicine();
        $reviewModel = new Review();

        $year = date('Y');

        $this->view('director/dashboard', [
            'title'           => 'Bảng điều khiển',
            'totalPatients'   => $patientModel->countAll(),
            'totalDoctors'    => $doctorModel->countAll(),
            'todayAppointments' => $appointmentModel->countToday(),
            'totalRevenue'    => $paymentModel->totalRevenue(),
            'todayRevenue'    => $paymentModel->todayRevenue(),
            'avgRating'       => $reviewModel->averageRating(),
            'onlineCount'     => $appointmentModel->countByType(2),
            'homeCount'       => $appointmentModel->countByType(3),
            'monthlyStats'    => json_encode($appointmentModel->monthlyStats($year)),
            'monthlyRevenue'  => json_encode($appointmentModel->monthlyRevenue($year)),
        ], 'dashboard');
    }

    /** Báo cáo doanh thu */
    public function reports(): void
    {
        $this->requireRole('director');
        $appointmentModel = new Appointment();
        $paymentModel = new Payment();

        $this->view('director/reports', [
            'title'          => 'Báo cáo doanh thu & Hoạt động',
            'totalRevenue'   => $paymentModel->totalRevenue(),
            'todayRevenue'   => $paymentModel->todayRevenue(),
            'totalAppts'     => $appointmentModel->count(),
            'completedAppts' => $appointmentModel->countByStatus('completed'),
            'cancelledAppts' => $appointmentModel->countByStatus('cancelled'),
            'onlineCount'    => $appointmentModel->countByType(2),
            'homeCount'      => $appointmentModel->countByType(3),
            'directCount'    => $appointmentModel->countByType(1),
        ], 'dashboard');
    }

    /** Danh sách bác sĩ (Read-only) */
    public function doctors(): void
    {
        $this->requireRole('director');
        $this->view('director/doctors', [
            'title'   => 'Danh sách bác sĩ',
            'doctors' => (new Doctor())->allWithInfo(),
        ], 'dashboard');
    }

    /** Danh sách bệnh nhân (Read-only) */
    public function patients(): void
    {
        $this->requireRole('director');
        $this->view('director/patients', [
            'title'    => 'Danh sách bệnh nhân',
            'patients' => (new Patient())->allWithUser(),
        ], 'dashboard');
    }

    /** Danh sách điều dưỡng (Read-only) */
    public function nurses(): void
    {
        $this->requireRole('director');
        $this->view('director/nurses', [
            'title'  => 'Danh sách điều dưỡng',
            'nurses' => (new Nurse())->allWithUser(),
        ], 'dashboard');
    }

    /** Danh sách lễ tân (Read-only) */
    public function receptionists(): void
    {
        $this->requireRole('director');
        $this->view('director/receptionists', [
            'title'         => 'Danh sách lễ tân',
            'receptionists' => (new Receptionist())->allWithUser(),
        ], 'dashboard');
    }
}
