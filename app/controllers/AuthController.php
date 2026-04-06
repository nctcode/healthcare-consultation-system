<?php
/**
 * AuthController - Xác thực người dùng
 */
class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /** Đăng nhập */
    public function login(): void
    {
        // Nếu đã đăng nhập, redirect về dashboard
        if (Auth::check()) {
            $this->redirect(Auth::dashboardUrl());
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) {
                $this->redirect('/dang-nhap');
                return;
            }

            $email = $this->input('email');
            $password = $this->input('password');

            // Validate
            $validator = new Validator($_POST);
            $validator->validate('email', 'Email', 'required|email');
            $validator->validate('password', 'Mật khẩu', 'required|min:6');

            if ($validator->fails()) {
                $_SESSION['flash_error'] = $validator->firstError();
                flash_old_input($_POST);
                $this->redirect('/dang-nhap');
                return;
            }

            // Tìm user
            $user = $this->userModel->findByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                $_SESSION['flash_error'] = 'Email hoặc mật khẩu không đúng.';
                flash_old_input($_POST);
                $this->redirect('/dang-nhap');
                return;
            }

            // Kiểm tra trạng thái
            if ($user['status'] !== 'active') {
                $_SESSION['flash_error'] = 'Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.';
                $this->redirect('/dang-nhap');
                return;
            }

            // Đăng nhập thành công
            Auth::login($user);
            $_SESSION['flash_success'] = 'Đăng nhập thành công! Chào mừng ' . $user['full_name'];
            clear_old_input();
            $this->redirect(Auth::dashboardUrl());
        } else {
            $this->view('auth/login', ['title' => 'Đăng nhập'], 'auth');
        }
    }

    /** Đăng ký (bệnh nhân) */
    public function register(): void
    {
        if (Auth::check()) {
            $this->redirect(Auth::dashboardUrl());
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) {
                $this->redirect('/dang-ky');
                return;
            }

            $validator = new Validator($_POST);
            $validator->validate('full_name', 'Họ và tên', 'required|min:3|max:255');
            $validator->validate('email', 'Email', 'required|email|max:255');
            $validator->validate('phone', 'Số điện thoại', 'required|min:10|max:20');
            $validator->validate('password', 'Mật khẩu', 'required|min:6');
            $validator->validate('password_confirm', 'Xác nhận mật khẩu', 'required|match:password');

            if ($validator->fails()) {
                $_SESSION['flash_error'] = $validator->firstError();
                flash_old_input($_POST);
                $this->redirect('/dang-ky');
                return;
            }

            // Kiểm tra email đã tồn tại
            if ($this->userModel->findByEmail($this->input('email'))) {
                $_SESSION['flash_error'] = 'Email này đã được sử dụng.';
                flash_old_input($_POST);
                $this->redirect('/dang-ky');
                return;
            }

            // Tạo user (role = patient = 2)
            $userId = $this->userModel->create([
                'role_id'   => 2,
                'email'     => $this->input('email'),
                'password'  => password_hash($this->input('password'), PASSWORD_DEFAULT),
                'full_name' => $this->input('full_name'),
                'phone'     => $this->input('phone'),
            ]);

            // Tạo patient record
            $patient = new Patient();
            $patient->create([
                'user_id'       => $userId,
                'date_of_birth' => $this->input('date_of_birth'),
                'gender'        => $this->input('gender'),
                'address'       => $this->input('address'),
            ]);

            // Auto login
            $user = $this->userModel->findByEmail($this->input('email'));
            Auth::login($user);

            // Gửi thông báo
            Notification::send($userId, 'Chào mừng!', 'Chào mừng bạn đến với ' . APP_NAME . '. Hãy cập nhật hồ sơ cá nhân để được phục vụ tốt hơn.', 'system', '/patient/profile');

            $_SESSION['flash_success'] = 'Đăng ký thành công! Chào mừng bạn đến với ' . APP_NAME;
            clear_old_input();
            $this->redirect('/patient/dashboard');
        } else {
            $this->view('auth/register', ['title' => 'Đăng ký tài khoản'], 'auth');
        }
    }

    /** Đăng xuất */
    public function logout(): void
    {
        Auth::logout();
        session_start();
        $_SESSION['flash_success'] = 'Đăng xuất thành công.';
        $this->redirect('/dang-nhap');
    }
}
