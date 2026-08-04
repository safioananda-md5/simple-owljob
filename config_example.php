<?php
// config.php
$host = '';
$port = '';
$db   = '';
$user = '';
$pass = '';

try {
    // Tambahkan ;port=$port setelah $host
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()]));
}
