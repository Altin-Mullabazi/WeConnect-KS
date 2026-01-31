<?php
require_once 'includes/services/EventService.php';

$eventService = new EventService();

$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 12;

$categories = $eventService->getCategories();

if ($category !== '') {
    $events = $eventService->getByCategory($category);
    $total = count($events);
} else {
    $allEvents = $eventService->getAll();
    $total = count($allEvents);
    $offset = ($page - 1) * $perPage;
    $events = array_slice($allEvents, $offset, $perPage);
}

$totalPages = $total ? (int) ceil($total / $perPage) : 1;

session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$role = $_SESSION['role'] ?? 'user';
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventet - WeConnectKS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
     

    <section class="section-padding">
        <div class="container">
            <div class="section-header-flex">
                <div>
                    <h2>Te gjitha eventet dhe klubet</h2>
                    <p class="text-muted">Ketu gjen komunitetin tend. Nga book clubs dhe movie nights deri te festivalet dhe eventet speciale - krijo lidhje me njerez qe ndajne interesat e tua.</p>
                </div>
                <?php if ($isLoggedIn && ($role === 'organizer' || $role === 'admin')): ?>
                    <a href="create_event.php" class="btn-primary" style="align-self: center; white-space: nowrap;">+ Krijo Event</a>
                <?php endif; ?>
            </div>

            <?php if (!empty($categories)): ?>
            <nav class="filter-nav" style="margin-bottom: 2rem;">
                <a href="events.php" class="<?php echo $category === '' ? 'active' : ''; ?>">Të gjitha</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="events.php?category=<?php echo urlencode($cat); ?>" class="<?php echo $category === $cat ? 'active' : ''; ?>"><?php echo htmlspecialchars($cat); ?></a>
                <?php endforeach; ?>
            </nav>
            <?php endif; ?>

            <div class="trending-grid">
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                    <div class="card trending-card">
                        <div class="card-image">
                            <?php if (!empty($event['event_date'])): ?>
                                <span class="date-badge"><?php echo date('d M Y', strtotime($event['event_date'])); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($event['image'])): ?>
                                <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                            <?php else: ?>
                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 200px; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    📅
                                </div>
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
                            <p class="card-desc"><?php echo htmlspecialchars(mb_substr($event['description'], 0, 120)) . (mb_strlen($event['description']) > 120 ? '...' : ''); ?></p>
                            <div class="card-footer">
                                <span class="price">Falas</span>
                                <a href="event.php?id=<?php echo (int)$event['id']; ?>" class="btn-arrow" aria-label="Shfletoni me shume">→</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center" style="grid-column: 1 / -1; padding: 3rem;">
                        <p class="text-muted">Nuk ka evente të disponueshme.</p>
                        <?php if ($isLoggedIn && ($role === 'organizer' || $role === 'admin')): ?>
                            <a href="create_event.php" class="btn-primary" style="margin-top: 1rem;">Krijo Event të Parë</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($totalPages > 1 && $category === ''): ?>
            <nav class="pagination" style="margin-top: 2rem;">
                <?php if ($page > 1): ?>
                    <a href="events.php?page=<?php echo $page - 1; ?>">← Para</a>
                <?php endif; ?>
                <span>Faqja <?php echo $page; ?> / <?php echo $totalPages; ?></span>
                <?php if ($page < $totalPages): ?>
                    <a href="events.php?page=<?php echo $page + 1; ?>">Tjetra →</a>
                <?php endif; ?>
            </nav>
            <?php endif; ?>
        </div>
    </section>

    <?php require_once 'includes/footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>
