<?php
/**
 * Cấu hình kết nối Database
 * Hệ thống Tư vấn & Khám bệnh Online
 */

return [
    'host'     => 'localhost',
    'dbname'   => 'qlda_hospital',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8mb4',
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]
];
