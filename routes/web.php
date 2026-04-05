<?php
/**
 * Routes - Định nghĩa tất cả URL routes
 * $router được tạo từ public/index.php
 */

// ==========================================
// PUBLIC ROUTES
// ==========================================
$router->get('', 'HomeController@index');
$router->get('bac-si', 'HomeController@doctors');
$router->get('bac-si/{id}', 'HomeController@doctorDetail');
$router->get('chuyen-khoa', 'HomeController@specialties');

// ==========================================
// AUTH ROUTES
// ==========================================
$router->any('dang-nhap', 'AuthController@login');
$router->any('dang-ky', 'AuthController@register');
$router->get('dang-xuat', 'AuthController@logout');

// ==========================================
// ADMIN ROUTES
// ==========================================
$router->get('admin/dashboard', 'AdminController@dashboard');
$router->any('admin/users', 'AdminController@users');
$router->any('admin/users/create', 'AdminController@createUser');
$router->any('admin/users/edit/{id}', 'AdminController@editUser');
$router->get('admin/users/delete/{id}', 'AdminController@deleteUser');

$router->any('admin/doctors', 'AdminController@doctors');
$router->any('admin/doctors/create', 'AdminController@createDoctor');
$router->any('admin/doctors/edit/{id}', 'AdminController@editDoctor');
$router->get('admin/doctors/delete/{id}', 'AdminController@deleteDoctor');

$router->any('admin/patients', 'AdminController@patients');
$router->any('admin/patients/create', 'AdminController@createPatient');
$router->any('admin/patients/edit/{id}', 'AdminController@editPatient');
$router->get('admin/patients/delete/{id}', 'AdminController@deletePatient');

$router->any('admin/nurses', 'AdminController@nurses');
$router->any('admin/receptionists', 'AdminController@receptionists');

$router->any('admin/specialties', 'AdminController@specialties');
$router->any('admin/specialties/create', 'AdminController@createSpecialty');
$router->any('admin/specialties/edit/{id}', 'AdminController@editSpecialty');
$router->get('admin/specialties/delete/{id}', 'AdminController@deleteSpecialty');

$router->any('admin/medicines', 'AdminController@medicines');
$router->any('admin/medicines/create', 'AdminController@createMedicine');
$router->any('admin/medicines/edit/{id}', 'AdminController@editMedicine');
$router->get('admin/medicines/delete/{id}', 'AdminController@deleteMedicine');

$router->any('admin/services', 'AdminController@services');
$router->any('admin/services/create', 'AdminController@createService');
$router->any('admin/services/edit/{id}', 'AdminController@editService');
$router->get('admin/services/delete/{id}', 'AdminController@deleteService');

$router->any('admin/schedules', 'AdminController@schedules');
$router->get('admin/reports', 'AdminController@reports');

// ==========================================
// DIRECTOR ROUTES
// ==========================================
$router->get('director/dashboard', 'DirectorController@dashboard');
$router->get('director/reports', 'DirectorController@reports');
$router->get('director/doctors', 'DirectorController@doctors');
$router->get('director/patients', 'DirectorController@patients');
$router->get('director/nurses', 'DirectorController@nurses');
$router->get('director/receptionists', 'DirectorController@receptionists');

// ==========================================
// PATIENT ROUTES
// ==========================================
$router->get('patient/dashboard', 'PatientController@dashboard');
$router->any('patient/profile', 'PatientController@profile');
$router->get('patient/appointments', 'PatientController@appointments');
$router->any('patient/appointments/book', 'AppointmentController@book');
$router->get('patient/appointments/{id}', 'PatientController@appointmentDetail');
$router->get('patient/medical-records', 'PatientController@medicalRecords');
$router->get('patient/medical-records/{id}', 'PatientController@medicalRecordDetail');
$router->get('patient/prescriptions', 'PatientController@prescriptions');
$router->get('patient/prescriptions/{id}', 'PatientController@prescriptionDetail');
$router->get('patient/payments', 'PatientController@payments');
$router->any('patient/payments/{id}', 'PaymentController@pay');
$router->any('patient/reviews/create/{appointment_id}', 'ReviewController@create');
$router->get('patient/notifications', 'NotificationController@index');
$router->any('patient/chat/{appointment_id}', 'MessageController@chat');

// ==========================================
// DOCTOR ROUTES
// ==========================================
$router->get('doctor/dashboard', 'DoctorController@dashboard');
$router->get('doctor/appointments', 'DoctorController@appointments');
$router->any('doctor/examine/{id}', 'DoctorController@examine');
$router->get('doctor/medical-records', 'DoctorController@medicalRecords');
$router->any('doctor/medical-records/create/{appointment_id}', 'MedicalRecordController@create');
$router->any('doctor/medical-records/edit/{id}', 'MedicalRecordController@edit');
$router->post('doctor/medical-records/update/{id}', 'MedicalRecordController@update');
$router->any('doctor/prescriptions/create/{record_id}', 'PrescriptionController@create');
$router->get('doctor/patients', 'DoctorController@patients');
$router->any('doctor/patients/create', 'DoctorController@createPatient');
$router->any('doctor/patients/edit/{id}', 'DoctorController@editPatient');
$router->get('doctor/patients/delete/{id}', 'DoctorController@deletePatient');
$router->any('doctor/chat/{appointment_id}', 'MessageController@chat');

// ==========================================
// NURSE ROUTES
// ==========================================
$router->get('nurse/dashboard', 'NurseController@dashboard');
$router->get('nurse/patients', 'NurseController@patients');
$router->any('nurse/health-update/{id}', 'NurseController@healthUpdate');
$router->any('nurse/care-notes/{id}', 'NurseController@careNotes');

// ==========================================
// RECEPTIONIST ROUTES
// ==========================================
$router->get('receptionist/dashboard', 'ReceptionistController@dashboard');
$router->any('receptionist/appointments', 'ReceptionistController@appointments');
$router->any('receptionist/appointments/edit/{id}', 'ReceptionistController@editAppointment');
$router->get('receptionist/appointments/cancel/{id}', 'ReceptionistController@cancelAppointment');
$router->any('receptionist/checkin', 'ReceptionistController@checkin');
$router->any('receptionist/payments', 'ReceptionistController@payments');
$router->any('receptionist/payments/confirm/{id}', 'ReceptionistController@confirmPayment');
$router->get('receptionist/queue', 'ReceptionistController@queue');

// ==========================================
// API ROUTES (AJAX)
// ==========================================
$router->get('api/notifications', 'NotificationController@apiList');
$router->post('api/notifications/read/{id}', 'NotificationController@markRead');
$router->get('api/messages/{appointment_id}', 'MessageController@apiMessages');
$router->post('api/messages/send', 'MessageController@apiSend');
$router->get('api/doctors/by-specialty/{id}', 'AppointmentController@doctorsBySpecialty');
$router->get('api/schedules/{doctor_id}', 'AppointmentController@doctorSchedule');
$router->post('api/checkin/verify', 'ReceptionistController@verifyCheckin');
$router->get('api/dashboard/stats', 'AdminController@apiStats');
