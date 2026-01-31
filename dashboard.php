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
require_once 'includes/core/Database.php';

$authService = new AuthService();
$authService->requireLogin();

$db = Database::getInstance();
$userId = $authService->getCurrentUserId();
$user = $authService->getCurrentUser();

$fullName = $user['full_name'] ?? ($user['emri'] ?? '') . ' ' . ($user['mbiemri'] ?? '');
$role = $user['role'] ?? 'user';

$eventsCount = 0;
$groupsCount = 0;
$nextEvent = null;
$myEvents = [];

try {
    $result = $db->fetch('SELECT COUNT(*) AS total FROM event_participants WHERE user_id = ?', [$userId]);
    $eventsCount = (int) ($result['total'] ?? 0);
} catch (Exception $e) {
    error_log('Dashboard eventsCount error: ' . $e->getMessage());
}

try {
    $result = $db->fetch('SELECT COUNT(*) AS total FROM group_members WHERE user_id = ?', [$userId]);
    $groupsCount = (int) ($result['total'] ?? 0);
} catch (Exception $e) {
    error_log('Dashboard groupsCount error: ' . $e->getMessage());
}

try {
    $nextEvent = $db->fetch(
        'SELECT e.title, e.event_date, e.location
         FROM events e
         INNER JOIN event_participants ep ON ep.event_id = e.id
         WHERE ep.user_id = ? AND e.event_date >= CURDATE()
         ORDER BY e.event_date ASC
         LIMIT 1',
        [$userId]
    );
} catch (Exception $e) {
    error_log('Dashboard nextEvent error: ' . $e->getMessage());
}

try {
    $myEvents = $db->fetchAll(
        'SELECT e.title, e.event_date, e.location
         FROM events e
         INNER JOIN event_participants ep ON ep.event_id = e.id
         WHERE ep.user_id = ?
         ORDER BY e.event_date ASC
         LIMIT 5',
        [$userId]
    );
} catch (Exception $e) {
    error_log('Dashboard myEvents error: ' . $e->getMessage());
}

function formatEventDate(?string $date): ?string {
    if (!$date) return null;
    try {
        $dt = new DateTime($date);
        return $dt->format('d M Y, H:i');
    } catch (Exception $e) {
        return $date;
    }
}

function getInitials(string $name): string {
    $parts = preg_split('/\s+/', trim($name));
    if (!$parts || $parts[0] === '') return 'U';
    $first = mb_substr($parts[0], 0, 1);
    $last = isset($parts[count($parts) - 1]) ? mb_substr($parts[count($parts) - 1], 0, 1) : '';
    return mb_strtoupper($first . $last);
}

$eventsGoal = 5;
$eventsProgress = max(0, min(100, ($eventsCount / max(1, $eventsGoal)) * 100));
$profileProgress = 40;
$initials = getInitials($fullName);
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - WeConnectKS</title>
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
                <div>
                    <p class="dashboard-eyebrow">PANELI I PËRDORUESIT</p>
                    <h1>Mirë se erdhe, <?php echo htmlspecialchars($fullName); ?> 👋</h1>
                    <p class="dashboard-subtitle">
                        Roli juaj: <span class="role-pill role-<?php echo htmlspecialchars($role); ?>">
                            <?php echo htmlspecialchars(ucfirst($role)); ?>
                        </span>
                    </p>
                </div>
            </header>

            <section class="dashboard-cards">
                <article class="dashboard-card">
                    <span class="dashboard-card-icon">🗓️</span>
                    <h3>Eventet ku je regjistruar</h3>
                    <p class="dashboard-card-number"><?php echo $eventsCount; ?></p>
                    <p class="dashboard-card-label">Total evente aktive</p>
                    <div class="dashboard-progress">
                        <div class="dashboard-progress-bar" style="width: <?php echo (int) $eventsProgress; ?>%"></div>
                    </div>
                </article>

                <article class="dashboard-card">
                    <span class="dashboard-card-icon">👥</span>
                    <h3>Grupet ku je anëtar</h3>
                    <p class="dashboard-card-number"><?php echo $groupsCount; ?></p>
                    <p class="dashboard-card-label">Komunitete ku bën pjesë</p>
                </article>

                <article class="dashboard-card">
                    <span class="dashboard-card-icon">⭐</span>
                    <h3>Eventi i ardhshëm</h3>
                    <?php if ($nextEvent): ?>
                        <p class="dashboard-card-title">
                            <?php echo htmlspecialchars($nextEvent['title']); ?>
                        </p>
                        <p class="dashboard-card-meta">
                            <?php echo htmlspecialchars(formatEventDate($nextEvent['event_date'])); ?>
                            ·
                            <?php echo htmlspecialchars($nextEvent['location']); ?>
                        </p>
                    <?php else: ?>
                        <p class="dashboard-card-empty">Nuk ke ende evente të ardhshme.</p>
                    <?php endif; ?>
                </article>
            </section>

            <section class="dashboard-columns">
                <div class="dashboard-column">
                    <div class="dashboard-section-header">
                        <h2>Eventet e mia</h2>
                        <a href="my_events.php" class="dashboard-link">Shiko të gjitha</a>
                    </div>

                    <?php if (!empty($myEvents)): ?>
                        <ul class="dashboard-events-list">
                            <?php foreach ($myEvents as $event): ?>
                                <li class="dashboard-event-item">
                                    <div>
                                        <p class="event-title">
                                            <?php echo htmlspecialchars($event['title']); ?>
                                        </p>
                                        <p class="event-meta">
                                            <?php echo htmlspecialchars(formatEventDate($event['event_date'])); ?>
                                            ·
                                            <?php echo htmlspecialchars($event['location']); ?>
                                        </p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="dashboard-empty dashboard-empty-illustration">
                            <div class="empty-illustration-icon">✨</div>
                            <p>Nuk ka ende evente ku je bashkuar.</p>
                            <?php if ($role === 'organizer' || $role === 'admin'): ?>
                                <a href="create_event.php" class="quick-action-btn primary full-width">
                                    Krijo eventin tënd të parë
                                </a>
                            <?php else: ?>
                                <a href="events.php" class="quick-action-btn primary full-width">
                                    Shfleto eventet
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <aside class="dashboard-column profile-snapshot">
                    <h2>Profili im</h2>
                    <div class="profile-header">
                        <div class="profile-avatar"><?php echo htmlspecialchars($initials); ?></div>
                        <div>
                            <p class="profile-name"><?php echo htmlspecialchars($fullName); ?></p>
                            <p class="profile-role"><?php echo htmlspecialchars(ucfirst($role)); ?></p>
                        </div>
                    </div>
                    <p class="profile-field">
                        <span class="profile-field-label">📍 Lokacioni</span>
                        <span class="profile-field-value">Ende nuk është vendosur</span>
                    </p>
                    <p class="profile-field">
                        <span class="profile-field-label">⭐ Interesat</span>
                        <span class="profile-field-value">Ende nuk janë vendosur</span>
                    </p>
                    <div class="profile-progress">
                        <span>Profili i plotësuar <?php echo (int) $profileProgress; ?>%</span>
                        <div class="dashboard-progress">
                            <div class="dashboard-progress-bar" style="width: <?php echo (int) $profileProgress; ?>%"></div>
                        </div>
                    </div>
                    <a href="profile.php" class="quick-action-btn subtle full-width">Edito Profilin</a>
                </aside>
            </section>

            <section class="dashboard-role-info">
                <?php if ($role === 'admin'): ?>
                    <p>Si <strong>admin</strong>, ke qasje në panelin administrativ, menaxhimin e përdoruesve dhe eventeve.</p>
                <?php elseif ($role === 'organizer'): ?>
                    <p>Si <strong>organizer</strong>, mund të krijosh dhe menaxhosh eventet e tua, si dhe të shohësh pjesëmarrësit.</p>
                <?php else: ?>
                    <p>Si <strong>përdorues</strong>, mund të eksplorosh evente, të bashkohesh në komunitete dhe të menaxhosh profilin tënd.</p>
                <?php endif; ?>
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

        if (!localStorage.getItem('isLoggedIn') || event.persisted || isBackForward && !localStorage.getItem('isLoggedIn')) {
            window.location.replace('login.php');
        }
    });
</script>

</body>
</html>
