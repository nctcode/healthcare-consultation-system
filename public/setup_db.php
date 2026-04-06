<?php
// Script to execute SQL files
$host = 'localhost';
$user = 'root';
$pass = ''; // default WAMP root password
$db = 'qlda_hospital';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Execute schema
    $schema = file_get_contents('d:\wamp64\www\qlda\database\schema.sql');
    $pdo->exec($schema);
    
    // Execute seed
    $pdo->exec('USE qlda_hospital');
    $seed = file_get_contents('d:\wamp64\www\qlda\database\seed.sql');
    $pdo->exec($seed);
    
    echo "Database re-initialized successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
