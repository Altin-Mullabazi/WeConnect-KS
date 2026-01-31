<?php
require_once 'services/ContactService.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metoda nuk lejohet']);
    exit;
}

$contactService = new ContactService();

$data = [
    'name' => trim($_POST['name'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'message' => trim($_POST['message'] ?? ''),
    'subject' => trim($_POST['subject'] ?? '')
];

$result = $contactService->create($data);

if ($result['success']) {
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode($result);
}
?>
