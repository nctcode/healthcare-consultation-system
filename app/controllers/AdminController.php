<?php
/**
 * AdminController - Quản trị hệ thống
 */
class AdminController extends Controller
{
    public function __construct()
    {
    }

    /** Dashboard */
    public function dashboard(): void
    {
        $this->requireRole('admin');

        $patientModel = new Patient();
        $doctorModel = new Doctor();
        $appointmentModel = new Appointment();
        $paymentModel = new Payment();
        $medicineModel = new Medicine();
        $reviewModel = new Review();

        $year = date('Y');

        $this->view('admin/dashboard', [
            'title'           => 'Admin Dashboard',
            'totalPatients'   => $patientModel->countAll(),
            'totalDoctors'    => $doctorModel->countAll(),
            'totalMedicines'  => $medicineModel->countAll(),
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

    /** Quản lý bác sĩ */
    public function doctors(): void
    {
        $this->requireRole('admin');
        $doctorModel = new Doctor();
        $this->view('admin/doctors', [
            'title'   => 'Quản lý bác sĩ',
            'doctors' => $doctorModel->allWithInfo(),
        ], 'dashboard');
    }

    /** Tạo bác sĩ */
    public function createDoctor(): void
    {
        $this->requireRole('admin');
        $specialtyModel = new Specialty();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/doctors'); return; }

            $userModel = new User();
            // Kiểm tra email
            if ($userModel->findByEmail($this->input('email'))) {
                $_SESSION['flash_error'] = 'Email đã tồn tại.';
                flash_old_input($_POST);
                $this->redirect('/admin/doctors/create');
                return;
            }

            $userId = $userModel->create([
                'role_id'   => 3,
                'email'     => $this->input('email'),
                'password'  => password_hash($this->input('password', 'doctor123'), PASSWORD_DEFAULT),
                'full_name' => $this->input('full_name'),
                'phone'     => $this->input('phone'),
            ]);

            $doctorModel = new Doctor();
            $doctorModel->create([
                'user_id'          => $userId,
                'specialty_id'     => $this->input('specialty_id'),
                'qualification'    => $this->input('qualification'),
                'experience_years' => $this->input('experience_years', 0),
                'bio'              => $this->input('bio'),
                'consultation_fee' => $this->input('consultation_fee', 0),
            ]);

            $_SESSION['flash_success'] = 'Thêm bác sĩ thành công.';
            $this->redirect('/admin/doctors');
        } else {
            $this->view('admin/doctor_form', [
                'title'       => 'Thêm bác sĩ',
                'specialties' => $specialtyModel->allActive(),
                'doctor'      => null,
            ], 'dashboard');
        }
    }

    /** Sửa bác sĩ */
    public function editDoctor(string $id): void
    {
        $this->requireRole('admin');
        $doctorModel = new Doctor();
        $specialtyModel = new Specialty();
        $doctor = $doctorModel->findFull((int)$id);

        if (!$doctor) { $this->redirect('/admin/doctors'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/doctors'); return; }

            $userModel = new User();
            $userData = [
                'full_name' => $this->input('full_name'),
                'phone'     => $this->input('phone'),
            ];
            if ($this->input('password')) {
                $userData['password'] = password_hash($this->input('password'), PASSWORD_DEFAULT);
            }
            $userModel->update($doctor['user_id'], $userData);

            $doctorModel->update((int)$id, [
                'specialty_id'     => $this->input('specialty_id'),
                'qualification'    => $this->input('qualification'),
                'experience_years' => $this->input('experience_years', 0),
                'bio'              => $this->input('bio'),
                'consultation_fee' => $this->input('consultation_fee', 0),
            ]);

            $_SESSION['flash_success'] = 'Cập nhật bác sĩ thành công.';
            $this->redirect('/admin/doctors');
        } else {
            $this->view('admin/doctor_form', [
                'title'       => 'Sửa thông tin bác sĩ',
                'specialties' => $specialtyModel->allActive(),
                'doctor'      => $doctor,
            ], 'dashboard');
        }
    }

    /** Xóa bác sĩ */
    public function deleteDoctor(string $id): void
    {
        $this->requireRole('admin');
        $doctorModel = new Doctor();
        $doctor = $doctorModel->find((int)$id);
        if ($doctor) {
            $userModel = new User();
            $userModel->delete($doctor['user_id']);
        }
        $_SESSION['flash_success'] = 'Đã xóa bác sĩ.';
        $this->redirect('/admin/doctors');
    }

    /** Quản lý bệnh nhân */
    public function patients(): void
    {
        $this->requireRole('admin');
        $patientModel = new Patient();
        $this->view('admin/patients', [
            'title'    => 'Quản lý bệnh nhân',
            'patients' => $patientModel->allWithUser(),
        ], 'dashboard');
    }

    /** Quản lý điều dưỡng */
    public function nurses(): void
    {
        $this->requireRole('admin');
        $nurseModel = new Nurse();
        $this->view('admin/nurses', [
            'title'  => 'Quản lý điều dưỡng',
            'nurses' => $nurseModel->allWithUser(),
        ], 'dashboard');
    }

    /** Quản lý lễ tân */
    public function receptionists(): void
    {
        $this->requireRole('admin');
        $receptionistModel = new Receptionist();
        $this->view('admin/receptionists', [
            'title'         => 'Quản lý lễ tân',
            'receptionists' => $receptionistModel->allWithUser(),
        ], 'dashboard');
    }

    /** Quản lý chuyên khoa */
    public function specialties(): void
    {
        $this->requireRole('admin');
        $specialtyModel = new Specialty();
        $this->view('admin/specialties', [
            'title'       => 'Quản lý chuyên khoa',
            'specialties' => $specialtyModel->all('name ASC'),
        ], 'dashboard');
    }

    public function createSpecialty(): void
    {
        $this->requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/specialties'); return; }
            $model = new Specialty();
            $model->create([
                'name'        => $this->input('name'),
                'description' => $this->input('description'),
                'icon'        => $this->input('icon', 'fas fa-stethoscope'),
                'status'      => $this->input('status', 'active'),
            ]);
            $_SESSION['flash_success'] = 'Thêm chuyên khoa thành công.';
            $this->redirect('/admin/specialties');
        } else {
            $this->view('admin/specialty_form', ['title' => 'Thêm chuyên khoa', 'specialty' => null], 'dashboard');
        }
    }

    public function editSpecialty(string $id): void
    {
        $this->requireRole('admin');
        $model = new Specialty();
        $specialty = $model->find((int)$id);
        if (!$specialty) { $this->redirect('/admin/specialties'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/specialties'); return; }
            $model->update((int)$id, [
                'name'        => $this->input('name'),
                'description' => $this->input('description'),
                'icon'        => $this->input('icon'),
                'status'      => $this->input('status'),
            ]);
            $_SESSION['flash_success'] = 'Cập nhật chuyên khoa thành công.';
            $this->redirect('/admin/specialties');
        } else {
            $this->view('admin/specialty_form', ['title' => 'Sửa chuyên khoa', 'specialty' => $specialty], 'dashboard');
        }
    }

    public function deleteSpecialty(string $id): void
    {
        $this->requireRole('admin');
        $model = new Specialty();
        $model->delete((int)$id);
        $_SESSION['flash_success'] = 'Đã xóa chuyên khoa.';
        $this->redirect('/admin/specialties');
    }

    /** Quản lý thuốc */
    public function medicines(): void
    {
        $this->requireRole('admin');
        $model = new Medicine();
        $this->view('admin/medicines', [
            'title'     => 'Quản lý thuốc',
            'medicines' => $model->all('name ASC'),
        ], 'dashboard');
    }

    public function createMedicine(): void
    {
        $this->requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/medicines'); return; }
            $model = new Medicine();
            $model->create([
                'name'         => $this->input('name'),
                'generic_name' => $this->input('generic_name'),
                'unit'         => $this->input('unit', 'Viên'),
                'price'        => $this->input('price', 0),
                'stock'        => $this->input('stock', 0),
                'description'  => $this->input('description'),
            ]);
            $_SESSION['flash_success'] = 'Thêm thuốc thành công.';
            $this->redirect('/admin/medicines');
        } else {
            $this->view('admin/medicine_form', ['title' => 'Thêm thuốc', 'medicine' => null], 'dashboard');
        }
    }

    public function editMedicine(string $id): void
    {
        $this->requireRole('admin');
        $model = new Medicine();
        $medicine = $model->find((int)$id);
        if (!$medicine) { $this->redirect('/admin/medicines'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/medicines'); return; }
            $model->update((int)$id, [
                'name'         => $this->input('name'),
                'generic_name' => $this->input('generic_name'),
                'unit'         => $this->input('unit'),
                'price'        => $this->input('price'),
                'stock'        => $this->input('stock'),
                'description'  => $this->input('description'),
                'status'       => $this->input('status'),
            ]);
            $_SESSION['flash_success'] = 'Cập nhật thuốc thành công.';
            $this->redirect('/admin/medicines');
        } else {
            $this->view('admin/medicine_form', ['title' => 'Sửa thuốc', 'medicine' => $medicine], 'dashboard');
        }
    }

    public function deleteMedicine(string $id): void
    {
        $this->requireRole('admin');
        (new Medicine())->delete((int)$id);
        $_SESSION['flash_success'] = 'Đã xóa thuốc.';
        $this->redirect('/admin/medicines');
    }

    /** Quản lý dịch vụ */
    public function services(): void
    {
        $this->requireRole('admin');
        $this->view('admin/services', [
            'title'    => 'Quản lý dịch vụ',
            'services' => (new Service())->all('name ASC'),
        ], 'dashboard');
    }

    public function createService(): void
    {
        $this->requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/services'); return; }
            (new Service())->create([
                'name'        => $this->input('name'),
                'description' => $this->input('description'),
                'price'       => $this->input('price', 0),
            ]);
            $_SESSION['flash_success'] = 'Thêm dịch vụ thành công.';
            $this->redirect('/admin/services');
        } else {
            $this->view('admin/service_form', ['title' => 'Thêm dịch vụ', 'service' => null], 'dashboard');
        }
    }

    public function editService(string $id): void
    {
        $this->requireRole('admin');
        $model = new Service();
        $service = $model->find((int)$id);
        if (!$service) { $this->redirect('/admin/services'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/services'); return; }
            $model->update((int)$id, [
                'name'        => $this->input('name'),
                'description' => $this->input('description'),
                'price'       => $this->input('price'),
                'status'      => $this->input('status'),
            ]);
            $_SESSION['flash_success'] = 'Cập nhật dịch vụ thành công.';
            $this->redirect('/admin/services');
        } else {
            $this->view('admin/service_form', ['title' => 'Sửa dịch vụ', 'service' => $service], 'dashboard');
        }
    }

    public function deleteService(string $id): void
    {
        $this->requireRole('admin');
        (new Service())->delete((int)$id);
        $_SESSION['flash_success'] = 'Đã xóa dịch vụ.';
        $this->redirect('/admin/services');
    }

    /** Quản lý lịch làm việc */
    public function schedules(): void
    {
        $this->requireRole('admin');
        $scheduleModel = new DoctorSchedule();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireRole('admin');
            if (!$this->validateCSRF()) { $this->redirect('/admin/schedules'); return; }
            $scheduleModel->create([
                'doctor_id'    => $this->input('doctor_id'),
                'day_of_week'  => $this->input('day_of_week'),
                'start_time'   => $this->input('start_time'),
                'end_time'     => $this->input('end_time'),
                'max_patients' => $this->input('max_patients', 20),
            ]);
            $_SESSION['flash_success'] = 'Thêm lịch làm việc thành công.';
            $this->redirect('/admin/schedules');
        }

        $this->view('admin/schedules', [
            'title'     => 'Lịch làm việc bác sĩ',
            'schedules' => $scheduleModel->allWithDoctor(),
            'doctors'   => (new Doctor())->allWithInfo(),
        ], 'dashboard');
    }

    /** Báo cáo */
    public function reports(): void
    {
        $this->requireRole('admin');
        $appointmentModel = new Appointment();
        $paymentModel = new Payment();

        $this->view('admin/reports', [
            'title'          => 'Báo cáo thống kê',
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

    /** API Stats (AJAX) */
    public function apiStats(): void
    {
        $this->requireRole('admin');
        $this->json([
            'todayAppointments' => (new Appointment())->countToday(),
            'todayRevenue'      => (new Payment())->todayRevenue(),
        ]);
    }

    /** Quản lý người dùng */
    public function users(): void
    {
        $this->requireRole('admin', 'director');
        $this->view('admin/users', [
            'title' => 'Quản lý người dùng',
            'users' => (new User())->allWithRole(),
        ], 'dashboard');
    }

    public function createUser(): void
    {
        $this->requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/users'); return; }
            $userModel = new User();
            if ($userModel->findByEmail($this->input('email'))) {
                $_SESSION['flash_error'] = 'Email đã tồn tại.';
                flash_old_input($_POST);
                $this->redirect('/admin/users/create');
                return;
            }
            $userModel->create([
                'role_id'   => $this->input('role_id'),
                'email'     => $this->input('email'),
                'password'  => password_hash($this->input('password', '123456'), PASSWORD_DEFAULT),
                'full_name' => $this->input('full_name'),
                'phone'     => $this->input('phone'),
            ]);
            $_SESSION['flash_success'] = 'Thêm người dùng thành công.';
            $this->redirect('/admin/users');
        } else {
            $this->view('admin/user_form', [
                'title' => 'Thêm người dùng',
                'user'  => null,
                'roles' => (new Role())->all('id ASC'),
            ], 'dashboard');
        }
    }

    public function editUser(string $id): void
    {
        $this->requireRole('admin');
        $userModel = new User();
        $user = $userModel->findWithRole((int)$id);
        if (!$user) { $this->redirect('/admin/users'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/admin/users'); return; }
            $data = [
                'full_name' => $this->input('full_name'),
                'phone'     => $this->input('phone'),
                'status'    => $this->input('status'),
                'role_id'   => $this->input('role_id'),
            ];
            if ($this->input('password')) {
                $data['password'] = password_hash($this->input('password'), PASSWORD_DEFAULT);
            }
            $userModel->update((int)$id, $data);
            $_SESSION['flash_success'] = 'Cập nhật thành công.';
            $this->redirect('/admin/users');
        } else {
            $this->view('admin/user_form', [
                'title' => 'Sửa người dùng',
                'user'  => $user,
                'roles' => (new Role())->all('id ASC'),
            ], 'dashboard');
        }
    }

    public function deleteUser(string $id): void
    {
        $this->requireRole('admin');
        (new User())->delete((int)$id);
        $_SESSION['flash_success'] = 'Đã xóa người dùng.';
        $this->redirect('/admin/users');
    }
}
