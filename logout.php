<?php
require_once 'includes/services/AuthService.php';

$authService = new AuthService();
$authService->logout();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dalje - WeConnect Kosova</title>
</head>
<body>
<script>
    localStorage.removeItem('isLoggedIn');
    sessionStorage.clear();
    window.location.replace('login.php');
</script>
</body>
</html>
