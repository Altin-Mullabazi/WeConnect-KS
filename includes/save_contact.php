<?php
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metoda nuk lejohet']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

$errors = [];

if (empty($name) || strlen($name) < 2 || strlen($name) > 100) {
    $errors[] = 'Emri duhet të jetë 2-100 karaktere';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email adresa nuk është e vlefshme';
}

if (empty($message) || strlen($message) < 10 || strlen($message) > 2000) {
    $errors[] = 'Mesazhi duhet të jetë 10-2000 karaktere';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO contacts (name, email, message, created_at) 
        VALUES (:name, :email, :message, NOW())
    ");
    
    $stmt->execute([
        ':name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
        ':email' => $email,
        ':message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
    ]);
    
    echo json_encode(['success' => true, 'message' => 'Mesazhi u ruajt me sukses!']);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Gabim në server, provoni përsëri']);
}
?>
