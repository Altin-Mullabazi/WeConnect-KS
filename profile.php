<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'includes/services/AuthService.php';

$authService = new AuthService();
$authService->requireLogin();

$user = $authService->getCurrentUser();
$fullName = $user['full_name'] ?? ($user['emri'] ?? '') . ' ' . ($user['mbiemri'] ?? '');
$role = $user['role'] ?? 'user';
$email = $user['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profili im - WeConnectKS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body class="dashboard-body">

<?php require_once 'includes/header.php'; ?>

<main class="section-padding">
    <div class="container dashboard-layout">
        <?php require_once 'includes/sidebar.php'; ?>

        <section class="dashboard-main">
            <header class="dashboard-welcome">
                <p class="dashboard-eyebrow">PROFILI IM</p>
                <h1>Profili im</h1>
            </header>

            <section class="dashboard-cards">
                <article class="dashboard-card profile-card">
                    <h3>Informacionet e profilit</h3>
                    <p class="profile-field">
                        <span class="profile-field-label">Emri i plotë</span>
                        <span class="profile-field-value"><?php echo htmlspecialchars($fullName); ?></span>
                    </p>
                    <p class="profile-field">
                        <span class="profile-field-label">Email</span>
                        <span class="profile-field-value"><?php echo htmlspecialchars($email); ?></span>
                    </p>
                    <p class="profile-field">
                        <span class="profile-field-label">Roli</span>
                        <span class="profile-field-value">
                            <span class="role-pill role-<?php echo htmlspecialchars($role); ?>">
                                <?php echo htmlspecialchars(ucfirst($role)); ?>
                            </span>
                        </span>
                    </p>
                    <p class="dashboard-card-label">Ndryshimi i fjalëkalimit dhe të dhënave do të shtohet së shpejti.</p>
                </article>
            </section>
        </section>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>

<script>
    localStorage.setItem('isLoggedIn', '1');
    window.addEventListener('pageshow', function (event) {
        var navEntries = performance.getEntriesByType && performance.getEntriesByType('navigation');
        var isBackForward = navEntries && navEntries[0] && navEntries[0].type === 'back_forward';
        if (!localStorage.getItem('isLoggedIn') || event.persisted || (isBackForward && !localStorage.getItem('isLoggedIn'))) {
            window.location.replace('login.php');
        }
    });
</script>
</body>
</html>
