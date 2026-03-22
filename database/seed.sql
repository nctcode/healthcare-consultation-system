-- =====================================================
-- SEED DATA - DỮ LIỆU MẪU
-- =====================================================
USE qlda_hospital;

-- Roles
INSERT INTO roles (id, name, display_name) VALUES
(1, 'admin', 'Quản trị viên'),
(2, 'patient', 'Bệnh nhân'),
(3, 'doctor', 'Bác sĩ'),
(4, 'nurse', 'Điều dưỡng'),
(5, 'receptionist', 'Lễ tân'),
(6, 'director', 'Ban Giám đốc');

-- Users (password hashes for: admin123, doctor123, patient123, nurse123, reception123, director123)
INSERT INTO users (id, role_id, email, password, full_name, phone, status) VALUES
(1, 1, 'admin@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn Admin', '0901000001', 'active'),
(2, 3, 'bsi.nguyen@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'TS. BS. Nguyễn Thanh Hùng', '0901000002', 'active'),
(3, 3, 'bsi.tran@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PGS. TS. Trần Minh Đức', '0901000003', 'active'),
(4, 3, 'bsi.le@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'BS. CKI. Lê Thị Hồng', '0901000004', 'active'),
(5, 3, 'bsi.pham@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ThS. BS. Phạm Quốc Bảo', '0901000005', 'active'),
(6, 2, 'bn.tran@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Văn Minh', '0912000001', 'active'),
(7, 2, 'bn.le@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lê Thị Hương', '0912000002', 'active'),
(8, 2, 'bn.hoang@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Hoàng Đức Nam', '0912000003', 'active'),
(9, 4, 'dd.le@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lê Thị Mai', '0903000001', 'active'),
(10, 5, 'lt.pham@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Phạm Thị Lan', '0904000001', 'active'),
(11, 6, 'giamdoc@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Văn Giám Đốc', '0909999999', 'active');

-- Specialties
INSERT INTO specialties (id, name, description, icon, status) VALUES
(1, 'Nội khoa', 'Khám và điều trị các bệnh nội khoa tổng quát', 'fas fa-heartbeat', 'active'),
(2, 'Nhi khoa', 'Chăm sóc sức khỏe trẻ em từ sơ sinh đến 16 tuổi', 'fas fa-baby', 'active'),
(3, 'Tim mạch', 'Chẩn đoán và điều trị bệnh lý tim mạch', 'fas fa-heart', 'active'),
(4, 'Da liễu', 'Điều trị các bệnh về da, tóc, móng', 'fas fa-allergies', 'active'),
(5, 'Thần kinh', 'Khám và điều trị các bệnh thần kinh', 'fas fa-brain', 'active'),
(6, 'Mắt', 'Khám và điều trị các bệnh về mắt', 'fas fa-eye', 'active'),
(7, 'Tai Mũi Họng', 'Điều trị bệnh tai, mũi, họng', 'fas fa-head-side-cough', 'active'),
(8, 'Sản phụ khoa', 'Chăm sóc sức khỏe phụ nữ và thai sản', 'fas fa-female', 'active');

-- Doctors
INSERT INTO doctors (id, user_id, specialty_id, qualification, experience_years, bio, consultation_fee, rating) VALUES
(1, 2, 1, 'Tiến sĩ Y khoa - Đại học Y Hà Nội', 15, 'Chuyên gia nội khoa hàng đầu với 15 năm kinh nghiệm, từng tu nghiệp tại Nhật Bản.', 300000, 4.80),
(2, 3, 3, 'Phó Giáo sư Tiến sĩ - Đại học Y Dược TP.HCM', 20, 'Chuyên gia tim mạch can thiệp, hơn 20 năm trong ngành.', 500000, 4.90),
(3, 4, 2, 'Bác sĩ Chuyên khoa I - Đại học Y Dược Huế', 10, 'Bác sĩ nhi khoa giàu kinh nghiệm, tận tâm với bệnh nhi.', 250000, 4.70),
(4, 5, 5, 'Thạc sĩ Y khoa - Đại học Y Hà Nội', 12, 'Chuyên gia thần kinh, nghiên cứu về đột quỵ và Alzheimer.', 350000, 4.60);

-- Patients
INSERT INTO patients (id, user_id, date_of_birth, gender, address, blood_type, insurance_number) VALUES
(1, 6, '1990-05-15', 'male', '123 Nguyễn Huệ, Quận 1, TP.HCM', 'A+', 'BH001234567'),
(2, 7, '1985-08-22', 'female', '456 Lê Lợi, Quận 3, TP.HCM', 'O+', 'BH002345678'),
(3, 8, '1992-12-01', 'male', '789 Trần Hưng Đạo, Quận 5, TP.HCM', 'B+', NULL);

-- Nurses
INSERT INTO nurses (id, user_id, department, shift) VALUES
(1, 9, 'Nội khoa', 'Sáng');

-- Receptionists
INSERT INTO receptionists (id, user_id, desk_number, shift) VALUES
(1, 10, 'Q01', 'Sáng');

-- Services
INSERT INTO services (id, name, description, price, status) VALUES
(1, 'Khám tổng quát', 'Khám sức khỏe tổng quát bao gồm các xét nghiệm cơ bản', 200000, 'active'),
(2, 'Khám chuyên khoa', 'Khám chuyên sâu theo từng chuyên khoa', 300000, 'active'),
(3, 'Xét nghiệm máu', 'Xét nghiệm công thức máu, sinh hóa', 150000, 'active'),
(4, 'Siêu âm', 'Siêu âm ổ bụng, tim, tuyến giáp', 250000, 'active'),
(5, 'Chụp X-quang', 'Chụp X-quang ngực, xương, khớp', 200000, 'active');

-- Appointment Types
INSERT INTO appointment_types (id, name, display_name, description) VALUES
(1, 'truc_tiep', 'Khám trực tiếp', 'Đến khám tại bệnh viện'),
(2, 'online', 'Khám online', 'Khám qua video call'),
(3, 'tai_nha', 'Khám tại nhà', 'Bác sĩ đến khám tại nhà');

-- Medicines
INSERT INTO medicines (id, name, generic_name, unit, price, stock, description, status) VALUES
(1, 'Paracetamol 500mg', 'Paracetamol', 'Viên', 2000, 1000, 'Giảm đau, hạ sốt', 'active'),
(2, 'Amoxicillin 500mg', 'Amoxicillin', 'Viên', 5000, 800, 'Kháng sinh nhóm Penicillin', 'active'),
(3, 'Omeprazole 20mg', 'Omeprazole', 'Viên', 3000, 600, 'Điều trị loét dạ dày', 'active'),
(4, 'Metformin 500mg', 'Metformin', 'Viên', 2500, 500, 'Điều trị đái tháo đường type 2', 'active'),
(5, 'Losartan 50mg', 'Losartan', 'Viên', 4000, 400, 'Điều trị tăng huyết áp', 'active'),
(6, 'Atorvastatin 20mg', 'Atorvastatin', 'Viên', 6000, 300, 'Giảm cholesterol', 'active'),
(7, 'Cetirizine 10mg', 'Cetirizine', 'Viên', 3000, 700, 'Chống dị ứng', 'active'),
(8, 'Ibuprofen 400mg', 'Ibuprofen', 'Viên', 3500, 500, 'Giảm đau, chống viêm', 'active'),
(9, 'Vitamin C 1000mg', 'Ascorbic Acid', 'Viên', 2000, 1000, 'Bổ sung Vitamin C', 'active'),
(10, 'Prednisolone 5mg', 'Prednisolone', 'Viên', 2500, 400, 'Chống viêm corticoid', 'active'),
(11, 'Salbutamol 2mg', 'Salbutamol', 'Viên', 3000, 300, 'Giãn phế quản', 'active'),
(12, 'Diazepam 5mg', 'Diazepam', 'Viên', 4000, 200, 'An thần, giảm lo âu', 'active'),
(13, 'Ciprofloxacin 500mg', 'Ciprofloxacin', 'Viên', 5500, 400, 'Kháng sinh nhóm Quinolone', 'active'),
(14, 'Domperidone 10mg', 'Domperidone', 'Viên', 2000, 600, 'Chống nôn, tăng nhu động ruột', 'active'),
(15, 'Bromhexine 8mg', 'Bromhexine', 'Viên', 2500, 500, 'Long đờm', 'active');

-- Doctor Schedules
INSERT INTO doctor_schedules (doctor_id, day_of_week, start_time, end_time, max_patients) VALUES
(1, 1, '08:00', '12:00', 20), (1, 2, '08:00', '12:00', 20),
(1, 3, '13:00', '17:00', 20), (1, 4, '08:00', '12:00', 20),
(1, 5, '08:00', '12:00', 20),
(2, 1, '13:00', '17:00', 15), (2, 3, '08:00', '12:00', 15),
(2, 5, '13:00', '17:00', 15),
(3, 2, '08:00', '12:00', 25), (3, 4, '08:00', '12:00', 25),
(3, 6, '08:00', '12:00', 25),
(4, 1, '08:00', '12:00', 18), (4, 3, '08:00', '12:00', 18),
(4, 5, '08:00', '12:00', 18);

-- Appointments (mixed statuses)
INSERT INTO appointments (id, patient_id, doctor_id, service_id, appointment_type_id, appointment_date, appointment_time, status, symptoms, qr_code) VALUES
(1, 1, 1, 1, 1, '2026-03-15', '08:30', 'confirmed', 'Đau đầu, mệt mỏi kéo dài 3 ngày', 'QR-APT-001'),
(2, 2, 2, 2, 1, '2026-03-15', '09:00', 'confirmed', 'Đau ngực, khó thở khi gắng sức', 'QR-APT-002'),
(3, 3, 3, 1, 2, '2026-03-15', '10:00', 'pending', 'Trẻ sốt cao 39 độ, ho nhiều', 'QR-APT-003'),
(4, 1, 4, 2, 3, '2026-03-16', '14:00', 'pending', 'Đau đầu dữ dội, chóng mặt', 'QR-APT-004'),
(5, 2, 1, 1, 1, '2026-03-10', '08:30', 'completed', 'Khám sức khỏe định kỳ', 'QR-APT-005'),
(6, 3, 2, 2, 1, '2026-03-08', '14:00', 'completed', 'Kiểm tra huyết áp', 'QR-APT-006'),
(7, 1, 3, 1, 2, '2026-03-05', '09:00', 'completed', 'Tư vấn dinh dưỡng cho trẻ', 'QR-APT-007'),
(8, 2, 4, 2, 1, '2026-03-03', '10:30', 'completed', 'Đau đầu mãn tính', 'QR-APT-008'),
(9, 3, 1, 1, 1, '2026-03-17', '08:30', 'pending', 'Ho kéo dài hơn 2 tuần', 'QR-APT-009'),
(10, 1, 2, 2, 2, '2026-03-18', '15:00', 'pending', 'Tái khám tim mạch', 'QR-APT-010');

-- Medical Records (for completed appointments)
INSERT INTO medical_records (id, appointment_id, patient_id, doctor_id, diagnosis, symptoms, treatment, notes, follow_up_date) VALUES
(1, 5, 2, 1, 'Sức khỏe tổng quát bình thường', 'Không có triệu chứng bất thường', 'Không cần điều trị, duy trì lối sống lành mạnh', 'Huyết áp bình thường, đường huyết ổn định', '2026-06-10'),
(2, 6, 3, 2, 'Tăng huyết áp giai đoạn 1', 'Huyết áp 145/95 mmHg', 'Dùng thuốc hạ áp, giảm muối, tập thể dục', 'Cần theo dõi huyết áp hàng ngày', '2026-04-08'),
(3, 7, 1, 3, 'Thiếu dinh dưỡng nhẹ', 'Trẻ chậm tăng cân', 'Bổ sung dinh dưỡng, vitamin', 'Tăng cường bữa ăn phụ', '2026-04-05'),
(4, 8, 2, 4, 'Đau đầu căng cơ', 'Đau đầu 2 bên thái dương, căng cơ vai gáy', 'Giảm đau, vật lý trị liệu', 'Do stress và tư thế ngồi làm việc', '2026-04-03');

-- Prescriptions
INSERT INTO prescriptions (id, medical_record_id, patient_id, doctor_id, notes, status) VALUES
(1, 2, 3, 2, 'Uống thuốc đều đặn, đo huyết áp sáng tối', 'dispensed'),
(2, 3, 1, 3, 'Cho trẻ ăn đa dạng thực phẩm', 'dispensed'),
(3, 4, 2, 4, 'Nghỉ ngơi đầy đủ, tránh stress', 'dispensed');

-- Prescription Items
INSERT INTO prescription_items (prescription_id, medicine_id, quantity, dosage, duration, instructions) VALUES
(1, 5, 30, '1 viên/ngày', '30 ngày', 'Uống sau bữa ăn sáng'),
(2, 9, 30, '1 viên/ngày', '30 ngày', 'Uống sau bữa ăn'),
(3, 1, 20, '1 viên x 2 lần/ngày', '10 ngày', 'Uống khi đau, sau ăn'),
(3, 8, 10, '1 viên x 2 lần/ngày', '5 ngày', 'Uống sau ăn no');

-- Payments
INSERT INTO payments (appointment_id, patient_id, amount, method, status, paid_at) VALUES
(5, 2, 200000, 'cash', 'completed', '2026-03-10 09:30:00'),
(6, 3, 300000, 'transfer', 'completed', '2026-03-08 15:00:00'),
(7, 1, 200000, 'ewallet', 'completed', '2026-03-05 10:00:00'),
(8, 2, 350000, 'cash', 'completed', '2026-03-03 11:30:00'),
(1, 1, 200000, 'cash', 'pending', NULL),
(2, 2, 500000, 'transfer', 'pending', NULL);

-- Reviews
INSERT INTO reviews (patient_id, doctor_id, appointment_id, rating, comment) VALUES
(2, 1, 5, 5, 'Bác sĩ rất tận tâm, khám kỹ lưỡng. Rất hài lòng!'),
(3, 2, 6, 5, 'Bác sĩ giải thích rõ ràng, tận tình hướng dẫn cách chăm sóc.'),
(1, 3, 7, 4, 'Bác sĩ nhẹ nhàng với trẻ, tư vấn rất chi tiết.'),
(2, 4, 8, 5, 'Chẩn đoán chính xác, phác đồ điều trị hiệu quả.'),
(1, 1, 5, 4, 'Dịch vụ tốt, sẽ quay lại khám.');

-- Notifications
INSERT INTO notifications (user_id, title, message, type, is_read, link) VALUES
(6, 'Xác nhận lịch khám', 'Lịch khám của bạn ngày 15/03/2026 lúc 08:30 đã được xác nhận.', 'appointment', 0, '/patient/appointments'),
(6, 'Nhắc lịch khám', 'Bạn có lịch khám vào ngày mai 15/03/2026. Vui lòng đến đúng giờ.', 'reminder', 0, '/patient/appointments'),
(7, 'Xác nhận lịch khám', 'Lịch khám của bạn ngày 15/03/2026 lúc 09:00 đã được xác nhận.', 'appointment', 0, '/patient/appointments'),
(2, 'Lịch khám mới', 'Bạn có lịch khám mới ngày 15/03/2026 lúc 08:30.', 'appointment', 0, '/doctor/appointments'),
(3, 'Lịch khám mới', 'Bạn có lịch khám mới ngày 15/03/2026 lúc 09:00.', 'appointment', 0, '/doctor/appointments'),
(6, 'Thanh toán', 'Hóa đơn khám bệnh 200.000đ đang chờ thanh toán.', 'payment', 0, '/patient/payments'),
(8, 'Kết quả khám', 'Bệnh án của bạn đã được cập nhật. Vui lòng xem chi tiết.', 'system', 1, '/patient/medical-records'),
(1, 'Hệ thống', 'Chào mừng bạn đến với hệ thống quản lý bệnh viện.', 'system', 1, NULL),
(9, 'Phân công mới', 'Bạn được phân công chăm sóc bệnh nhân Trần Văn Minh.', 'system', 0, '/nurse/patients'),
(10, 'Ca trực', 'Bạn có ca trực sáng ngày 15/03/2026.', 'system', 0, '/receptionist/dashboard');

-- Nurse Assignments
INSERT INTO nurse_assignments (nurse_id, patient_id, appointment_id, notes, health_metrics, status) VALUES
(1, 1, 1, 'Theo dõi huyết áp và nhiệt độ mỗi 4 giờ', '{"blood_pressure":"120/80","temperature":"37.2","heart_rate":"75","spo2":"98"}', 'active'),
(1, 2, 2, 'Bệnh nhân cần theo dõi nhịp tim', '{"blood_pressure":"145/95","temperature":"36.8","heart_rate":"88","spo2":"97"}', 'active');

-- Messages
INSERT INTO messages (appointment_id, sender_id, receiver_id, content, message_type, is_read) VALUES
(3, 8, 4, 'Chào bác sĩ, con tôi sốt từ tối qua ạ.', 'text', 1),
(3, 4, 8, 'Chào anh/chị, bé sốt bao nhiêu độ ạ? Có kèm ho hoặc sổ mũi không?', 'text', 1),
(3, 8, 4, 'Sốt 39 độ ạ, có ho nhiều, đặc biệt ban đêm.', 'text', 0),
(10, 6, 3, 'Chào bác sĩ, tôi muốn hỏi về tình trạng tim mạch.', 'text', 0);
