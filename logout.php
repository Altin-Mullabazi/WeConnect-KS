<?php
session_start();
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'] ?? false, $p['httponly'] ?? false);
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
(function(){
    localStorage.removeItem('isLoggedIn');
    sessionStorage.clear();
    window.location.replace('login.php');
})();
</script>
<p>Duke dalë...</p>
</body>
</html>
