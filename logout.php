<?php
session_start();

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

session_destroy();
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
