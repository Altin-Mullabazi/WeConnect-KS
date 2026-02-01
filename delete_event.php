<?php
require_once 'includes/services/EventService.php';
require_once 'includes/services/AuthService.php';

session_start();

$authService = new AuthService();
$eventService = new EventService();

header('Content-Type: application/json; charset=utf-8');

if (!$authService->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Duhet të jeni të kyçur.']);
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID e pavlefshme.']);
    exit;
}

$event = $eventService->getById($id);
if (!$event) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Eventi nuk u gjet.']);
    exit;
}

$userId = $authService->getCurrentUserId();
$user = $authService->getCurrentUser();
$isAdmin = ($user['role'] ?? '') === 'admin';
$isOrganizer = ($event['organizer_id'] ?? 0) == $userId;

if (!$isAdmin && !$isOrganizer) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Nuk keni leje për të fshirë këtë event.']);
    exit;
}

$result = $eventService->delete($id);
echo json_encode($result);
