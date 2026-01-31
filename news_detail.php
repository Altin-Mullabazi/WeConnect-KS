<?php
require_once 'includes/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id < 1) {
    header('Location: news.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$item) {
    header('Location: news.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($item['title']); ?> - WeConnectKS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    <main class="section-padding">
        <div class="container event-header">
            <a href="news.php" class="back-link">← Kthehu te lajmet</a>
            <article class="event-info">
                <?php if (!empty($item['image'])): ?>
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="" class="event-image">
                <?php endif; ?>
                <?php if (!empty($item['category'] ?? '')): ?>
                    <span class="tag tag-art"><?php echo htmlspecialchars($item['category'] ?? ''); ?></span>
                <?php endif; ?>
                <h1><?php echo htmlspecialchars($item['title']); ?></h1>
                <p class="event-date"><?php echo date('d M Y', strtotime($item['created_at'])); ?></p>
                <div class="event-main">
                    <?php echo $item['content']; ?>
                </div>
            </article>
        </div>
    </main>
    <?php require_once 'includes/footer.php'; ?>
</body>
</html>
