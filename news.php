<?php
require_once 'includes/db.php';

$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 9;
$offset = ($page - 1) * $perPage;

$limit = (int) $perPage;
$offset = (int) $offset;
if ($category !== '') {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM news WHERE category = ?');
    $stmt->execute([$category]);
    $total = (int) $stmt->fetchColumn();
    $stmt = $pdo->prepare('SELECT * FROM news WHERE category = ? ORDER BY created_at DESC LIMIT ' . $limit . ' OFFSET ' . $offset);
    $stmt->execute([$category]);
} else {
    $stmt = $pdo->query('SELECT COUNT(*) FROM news');
    $total = (int) $stmt->fetchColumn();
    $stmt = $pdo->query('SELECT * FROM news ORDER BY created_at DESC LIMIT ' . $limit . ' OFFSET ' . $offset);
}
$newsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = $total ? (int) ceil($total / $perPage) : 1;


?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lajmet - WeConnectKS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    <main class="section-padding">
        <div class="container">
            <div class="section-header-flex">
                <div>
                    <h2>Lajmet</h2>
                    <p class="text-muted">Lexoni lajmet dhe përditësimet e fundit nga komuniteti.</p>
                </div>
            </div>
            <?php if (!empty($categories)): ?>
            <nav class="filter-nav">
                <a href="news.php" class="<?php echo $category === '' ? 'active' : ''; ?>">Të gjitha</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="news.php?category=<?php echo urlencode($cat); ?>" class="<?php echo $category === $cat ? 'active' : ''; ?>"><?php echo htmlspecialchars($cat); ?></a>
                <?php endforeach; ?>
            </nav>
            <?php endif; ?>
            <div class="trending-grid">
                <?php foreach ($newsList as $item): ?>
                    <article class="card trending-card">
                        <?php if (!empty($item['image'])): ?>
                        <div class="card-image">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="">
                        </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <?php if (!empty($item['category'])): ?>
                                <span class="tag tag-art"><?php echo htmlspecialchars($item['category']); ?></span>
                            <?php endif; ?>
                            <h3><a href="news_detail.php?id=<?php echo (int)$item['id']; ?>"><?php echo htmlspecialchars($item['title']); ?></a></h3>
                            <p class="card-desc"><?php echo htmlspecialchars(mb_substr(strip_tags($item['content']), 0, 120)) . (mb_strlen(strip_tags($item['content'])) > 120 ? '...' : ''); ?></p>
                            <p class="card-meta text-muted"><?php echo date('d M Y', strtotime($item['created_at'])); ?></p>
                            <a href="news_detail.php?id=<?php echo (int)$item['id']; ?>" class="btn-arrow">Lexo më shumë →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php if (empty($newsList)): ?>
                <p class="text-muted text-center">Nuk ka lajme të shfaqura.</p>
            <?php endif; ?>
            <?php if ($totalPages > 1): ?>
            <nav class="pagination">
                <?php if ($page > 1): ?>
                    <a href="news.php?page=<?php echo $page - 1; ?><?php echo $category ? '&category=' . urlencode($category) : ''; ?>">← Para</a>
                <?php endif; ?>
                <span>Faqja <?php echo $page; ?> / <?php echo $totalPages; ?></span>
                <?php if ($page < $totalPages): ?>
                    <a href="news.php?page=<?php echo $page + 1; ?><?php echo $category ? '&category=' . urlencode($category) : ''; ?>">Tjetra →</a>
                <?php endif; ?>
            </nav>
            <?php endif; ?>
        </div>
    </main>
    <?php require_once 'includes/footer.php'; ?>
</body>
</html>
