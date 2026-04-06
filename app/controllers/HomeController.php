<?php
/**
 * HomeController - Trang công khai
 */
class HomeController extends Controller
{
    /** Trang chủ */
    public function index(): void
    {
        $doctorModel = new Doctor();
        $specialtyModel = new Specialty();
        $reviewModel = new Review();

        $this->view('home/index', [
            'title'       => APP_NAME . ' - ' . APP_DESCRIPTION,
            'doctors'     => $doctorModel->topRated(4),
            'specialties' => $specialtyModel->withDoctorCount(),
            'reviews'     => $reviewModel->latestReviews(4),
        ]);
    }

    /** Danh sách bác sĩ */
    public function doctors(): void
    {
        $doctorModel = new Doctor();
        $specialtyModel = new Specialty();
        $specialtyId = $this->query('specialty');

        $doctors = $specialtyId
            ? $doctorModel->bySpecialty((int)$specialtyId)
            : $doctorModel->allWithInfo();

        $this->view('home/doctors', [
            'title'       => 'Đội ngũ bác sĩ',
            'doctors'     => $doctors,
            'specialties' => $specialtyModel->allActive(),
            'currentSpecialty' => $specialtyId,
        ]);
    }

    /** Chi tiết bác sĩ */
    public function doctorDetail(string $id): void
    {
        $doctorModel = new Doctor();
        $reviewModel = new Review();
        $scheduleModel = new DoctorSchedule();

        $doctor = $doctorModel->findFull((int)$id);
        if (!$doctor) {
            $this->redirect('/bac-si');
            return;
        }

        $this->view('home/doctor_detail', [
            'title'     => 'BS. ' . $doctor['full_name'],
            'doctor'    => $doctor,
            'reviews'   => $reviewModel->byDoctor((int)$id),
            'schedules' => $scheduleModel->byDoctor((int)$id),
        ]);
    }

    /** Danh sách chuyên khoa */
    public function specialties(): void
    {
        $specialtyModel = new Specialty();
        $this->view('home/specialties', [
            'title'       => 'Chuyên khoa',
            'specialties' => $specialtyModel->withDoctorCount(),
        ]);
    }
}
