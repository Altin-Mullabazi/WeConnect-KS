<?php
require_once 'includes/services/EventService.php';
require_once 'includes/repositories/UserRepository.php';

$eventService = new EventService();
$userRepo = new UserRepository();

$eventId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($eventId <= 0) {
    header('Location: events.php');
    exit;
}

$event = $eventService->getById($eventId);

if (!$event) {
    header('Location: events.php');
    exit;
}

$organizer = null;
if (!empty($event['organizer_id'])) {
    $organizer = $userRepo->findById($event['organizer_id']);
}

$formattedDate = !empty($event['event_date']) ? date('d M Y', strtotime($event['event_date'])) : '';
$formattedTime = !empty($event['event_date']) ? date('H:i', strtotime($event['event_date'])) : '';
$isPast = !empty($event['event_date']) && strtotime($event['event_date']) < strtotime('today');
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title']); ?> - WeConnectKS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php require_once 'includes/header.php'; ?>

    <div class="section-padding">
        <div class="container">
            <a href="events.php" class="back-link">← Kthehu te Eventet</a>
            
            <div class="event-header">
                <?php if (!empty($event['image'])): ?>
                    <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="event-image">
                <?php else: ?>
                    <div class="event-image-placeholder" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; min-height: 400px;">
                        <div style="text-align: center;">
                            <div style="font-size: 4rem; margin-bottom: 1rem;">📅</div>
                            <div><?php echo htmlspecialchars($event['title']); ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="event-info">
                    <?php if (!empty($event['category'])): ?>
                        <span class="badge badge-art"><?php echo htmlspecialchars($event['category']); ?></span>
                    <?php endif; ?>
                    <h1><?php echo htmlspecialchars($event['title']); ?></h1>
                    <?php if (!empty($event['event_date']) || !empty($event['event_time'])): ?>
                        <p class="event-date">
                            <?php if (!empty($event['event_date'])): ?>
                                <?php echo $formattedDate; ?>
                            <?php endif; ?>
                            <?php if (!empty($event['event_time'])): ?>
                                <?php echo ', ' . $formattedTime; ?>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($event['location'])): ?>
                        <p class="event-location"><?php echo htmlspecialchars($event['location']); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="event-details">
                <div class="event-main">
                    <h2>Rreth Eventit</h2>
                    <div class="event-description">
                        <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                    </div>

                    <?php if ($isPast): ?>
                        <div style="background: #fee; padding: 1rem; border-radius: 8px; margin-top: 1.5rem;">
                            <strong>Ky event ka kaluar.</strong>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="event-sidebar">
                    <div class="event-card">
                        <h3>Detajet</h3>
                        <?php if (!empty($event['event_date'])): ?>
                        <div class="detail-item">
                            <strong>Data:</strong>
                            <span><?php echo $formattedDate; ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($event['event_time'])): ?>
                        <div class="detail-item">
                            <strong>Koha:</strong>
                            <span><?php echo $formattedTime; ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($event['location'])): ?>
                        <div class="detail-item">
                            <strong>Lokacioni:</strong>
                            <span><?php echo htmlspecialchars($event['location']); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="detail-item">
                            <strong>Cmimi:</strong>
                            <span>Falas</span>
                        </div>
                    </div>

                    <?php if (!$isPast): ?>
                    <a href="#" class="btn-primary-large" style="display: block; text-align: center; margin-top: 20px;">Bashkohu</a>
                    <?php endif; ?>

                    <?php if ($organizer): ?>
                    <div class="event-card" style="margin-top: 20px;">
                        <h3>Organizator</h3>
                        <p><?php echo htmlspecialchars($organizer['full_name'] ?? ($organizer['emri'] ?? '') . ' ' . ($organizer['mbiemri'] ?? '')); ?></p>
                        <?php if (!empty($organizer['email'])): ?>
                            <p class="text-muted"><?php echo htmlspecialchars($organizer['email']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

   <?php require_once 'includes/footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>
