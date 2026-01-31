<?php
session_start();

// Kontrollo nëse përdoruesi është loguar
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Kontrollo nëse përdoruesi është admin
if (($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Parandalon që faqja të ruhet në cache (butoni back nuk funksionon)
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
