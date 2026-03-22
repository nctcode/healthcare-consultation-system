# HỆ THỐNG QUẢN LÝ PHÒNG KHÁM ĐA KHOA

## 1. Giới thiệu hệ thống

Hệ thống quản lý phòng khám đa khoa hỗ trợ quản lý toàn diện các hoạt động của phòng khám: đặt lịch, khám bệnh, quản lý bệnh nhân, nhân sự, thanh toán, quản lý thuốc, báo cáo, nhắn tin, thông báo, v.v. Hệ thống xây dựng theo mô hình MVC, sử dụng PHP thuần, tổ chức rõ ràng, dễ mở rộng.

## 2. Cấu trúc thư mục & thành phần hệ thống

- **app/controllers/**: Chứa các controller xử lý logic cho từng vai trò/nghiệp vụ (Admin, Doctor, Nurse, Patient, Receptionist, Director, Auth, Appointment, MedicalRecord, Prescription, Payment, Message, Notification, Review, v.v.)
- **app/models/**: Chứa các model tương ứng với các bảng dữ liệu chính (User, Role, Doctor, Nurse, Patient, Receptionist, Appointment, MedicalRecord, Prescription, Medicine, Payment, Service, Specialty, v.v.)
- **app/views/**: Giao diện cho từng vai trò (admin, doctor, nurse, patient, receptionist, director, home, layouts, auth, v.v.)
- **app/core/**: Các lớp lõi (Router, Controller, Model, Auth, Validator) phục vụ cho việc routing, xác thực, kiểm tra dữ liệu, v.v.
- **app/helpers/**: Các hàm hỗ trợ dùng chung.
- **routes/web.php**: Định nghĩa các route cho toàn bộ hệ thống.
- **config/**: Cấu hình ứng dụng và cơ sở dữ liệu.
- **database/**: File schema.sql (cấu trúc CSDL), seed.sql (dữ liệu mẫu).
- **public/**: File index.php (entrypoint), setup_db.php (khởi tạo CSDL), assets tĩnh (css, images).
- **assets/**: Chứa css, hình ảnh phục vụ giao diện.

## 3. Các module & chức năng chính

### 3.1. Quản lý người dùng & phân quyền
- Đăng ký, đăng nhập, phân quyền (Admin, Giám đốc, Bác sĩ, Y tá, Lễ tân, Bệnh nhân)
- Quản lý thông tin cá nhân, đổi mật khẩu

### 3.2. Quản lý nhân sự
- CRUD Bác sĩ, Y tá, Lễ tân, Giám đốc
- Quản lý lịch làm việc bác sĩ/y tá
- Phân công y tá

### 3.3. Quản lý bệnh nhân
- CRUD bệnh nhân
- Xem lịch sử khám, hồ sơ bệnh án, đơn thuốc

### 3.4. Đặt lịch & quản lý lịch hẹn
- Bệnh nhân đặt lịch khám, chọn bác sĩ, chuyên khoa
- Lễ tân xác nhận, quản lý lịch hẹn
- Bác sĩ xem lịch khám, cập nhật trạng thái

### 3.5. Khám bệnh & quản lý hồ sơ bệnh án
- Bác sĩ tạo, cập nhật hồ sơ bệnh án, chỉ định xét nghiệm, kê đơn thuốc
- Y tá cập nhật tình trạng sức khỏe, ghi chú chăm sóc

### 3.6. Quản lý đơn thuốc & thuốc
- CRUD thuốc, đơn thuốc, chi tiết đơn thuốc
- Quản lý kho thuốc

### 3.7. Thanh toán & quản lý hóa đơn
- Tạo, xác nhận, quản lý thanh toán cho từng lịch hẹn
- Quản lý các phương thức thanh toán

### 3.8. Quản lý dịch vụ & chuyên khoa
- CRUD dịch vụ khám chữa bệnh, chuyên khoa

### 3.9. Báo cáo & thống kê
- Báo cáo doanh thu, số lượng bệnh nhân, lịch hẹn, v.v.

### 3.10. Nhắn tin & thông báo
- Nhắn tin giữa bệnh nhân và bác sĩ
- Gửi thông báo cho các vai trò

### 3.11. Đánh giá & phản hồi
- Bệnh nhân đánh giá bác sĩ, dịch vụ

## 4. Các bảng dữ liệu chính (models)

- User, Role
- Doctor, Nurse, Receptionist, Director, Patient
- Appointment, DoctorSchedule, NurseAssignment
- MedicalRecord, MedicalImage
- Prescription, PrescriptionItem, Medicine
- Payment
- Service, Specialty
- Message, Notification, Review

## 5. Luồng nghiệp vụ tiêu biểu

- **Đặt lịch khám**: Bệnh nhân → Đặt lịch → Lễ tân xác nhận → Bác sĩ xem lịch → Khám bệnh → Tạo hồ sơ bệnh án, đơn thuốc → Thanh toán → Đánh giá
- **Quản lý nhân sự**: Admin/Director → Thêm/sửa/xóa nhân sự → Phân công lịch làm việc
- **Khám bệnh**: Bác sĩ → Xem lịch → Khám → Cập nhật hồ sơ bệnh án → Kê đơn thuốc → Y tá hỗ trợ chăm sóc
- **Thanh toán**: Lễ tân/Bệnh nhân → Xác nhận thanh toán → Quản lý hóa đơn
- **Nhắn tin**: Bệnh nhân ↔ Bác sĩ → Hỏi đáp, tư vấn

## 6. Công nghệ sử dụng

- PHP thuần (không framework)
- MySQL/MariaDB
- HTML, CSS, JavaScript (giao diện)
- Mô hình MVC tự xây dựng
- Routing, Auth, Validation tự phát triển

## 7. Hướng dẫn cài đặt & chạy dự án

1. **Yêu cầu hệ thống**:
   - PHP >= 7.4
   - MySQL/MariaDB
   - Apache/Nginx (khuyến nghị dùng WAMP/XAMPP trên Windows)

2. **Cài đặt**:
   - Clone source code về máy
   - Import file database/schema.sql vào MySQL để tạo CSDL
   - (Tùy chọn) Import database/seed.sql để có dữ liệu mẫu
   - Cấu hình kết nối CSDL trong config/database.php
   - Đảm bảo thư mục public/ là document root của web server

3. **Chạy dự án**:
   - Truy cập http://localhost/ (hoặc domain đã cấu hình)
   - Đăng nhập bằng tài khoản mẫu hoặc tự đăng ký

## 8. Lưu ý bảo mật & cấu hình

- Đổi mật khẩu mặc định sau khi cài đặt
- Cấu hình quyền truy cập thư mục public/ làm document root, tránh lộ mã nguồn
- Không commit file cấu hình chứa thông tin nhạy cảm lên repository công khai
- Sử dụng HTTPS cho môi trường production
- Kiểm tra, cập nhật các lỗ hổng bảo mật PHP (SQL Injection, XSS, CSRF, v.v.)

## 9. Thông tin bổ sung

- Dễ dàng mở rộng thêm module mới nhờ kiến trúc MVC rõ ràng
- Có thể tích hợp thêm API, các dịch vụ thanh toán, SMS, email, v.v.
- Hỗ trợ đa vai trò, phân quyền linh hoạt
