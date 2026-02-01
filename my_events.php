<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$role = $_SESSION['role'] ?? 'user';
if ($role !== 'organizer' && $role !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'includes/services/AuthService.php';
require_once 'includes/services/EventService.php';

$authService = new AuthService();
$authService->requireLogin();

$eventService = new EventService();
$userId = $authService->getCurrentUserId();
$myEvents = $eventService->getByOrganizer($userId);

$fullName = ($authService->getCurrentUser()['emri'] ?? '') . ' ' . ($authService->getCurrentUser()['mbiemri'] ?? '');
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventet e mia - WeConnectKS</title>
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
                <p class="dashboard-eyebrow">ORGANIZATOR</p>
                <h1>Eventet e mia</h1>
                <p class="text-muted">Eventet që keni krijuar. <a href="create_event.php" class="link-blue">+ Krijo event të ri</a></p>
            </header>

            <div class="trending-grid">
                <?php if (!empty($myEvents)): ?>
                    <?php foreach ($myEvents as $event): ?>
                    <div class="card trending-card">
                        <div class="card-image">
                            <?php if (!empty($event['event_date'])): ?>
                                <span class="date-badge"><?php echo date('d M Y', strtotime($event['event_date'])); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($event['image'])): ?>
                                <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                            <?php else: ?>
                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 200px; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">📅</div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($event['category'])): ?>
                                <span class="tag tag-art"><?php echo htmlspecialchars($event['category']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($event['location'])): ?>
                                <span class="location-text"><?php echo htmlspecialchars($event['location']); ?></span>
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                            <p class="card-desc"><?php echo htmlspecialchars(mb_substr($event['description'] ?? '', 0, 120)) . (mb_strlen($event['description'] ?? '') > 120 ? '...' : ''); ?></p>
                            <div class="card-footer">
                                <a href="event.php?id=<?php echo (int)$event['id']; ?>" class="btn-arrow" aria-label="Shiko">→</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center" style="grid-column: 1 / -1; padding: 3rem;">
                        <p class="text-muted">Ende nuk keni krijuar evente.</p>
                        <a href="create_event.php" class="btn-primary" style="margin-top: 1rem;">Krijo eventin të parë</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>

<script>
    localStorage.setItem('isLoggedIn', '1');
</script>
</body>
</html>
