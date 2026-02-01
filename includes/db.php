<?php
$host = 'localhost';
$port = '3306';
$dbname = 'weconnect-ks';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Gabim ne lidhjen me databazene: " . $e->getMessage());
}
?>