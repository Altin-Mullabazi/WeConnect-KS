<?php
require_once 'includes/services/GroupService.php';
require_once 'includes/services/AuthService.php';

session_start();

$authService = new AuthService();
$groupService = new GroupService();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Metoda nuk lejohet']);
    exit;
}

if (!$authService->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Duhet të jeni të kyçur për të krijuar grup.']);
    exit;
}

$data = [
    'groupName' => trim($_POST['groupName'] ?? ''),
    'groupCategory' => trim($_POST['groupCategory'] ?? ''),
    'groupLocation' => trim($_POST['groupLocation'] ?? ''),
    'groupDescription' => trim($_POST['groupDescription'] ?? ''),
    'groupImage' => trim($_POST['groupImage'] ?? ''),
    'creator_id' => $authService->getCurrentUserId()
];

$result = $groupService->create($data);

if ($result['success']) {
    echo json_encode(['success' => true, 'group_id' => $result['group_id'], 'message' => 'Grupi u krijua me sukses!']);
} else {
    http_response_code(400);
    echo json_encode($result);
}
