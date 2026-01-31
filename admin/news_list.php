<?php
require_once 'auth.php';
require_once __DIR__ . '/../includes/db.php';

$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 15;
$offset = ($page - 1) * $perPage;
$total = (int) $pdo->query('SELECT COUNT(*) FROM news')->fetchColumn();
$totalPages = $total ? (int) ceil($total / $perPage) : 1;

$stmt = $pdo->query('SELECT * FROM news ORDER BY created_at DESC LIMIT ' . $perPage . ' OFFSET ' . $offset);
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete']) && (int) $_GET['delete'] > 0) {
    $id = (int) $_GET['delete'];
    $pdo->prepare('DELETE FROM news WHERE id = ?')->execute([$id]);
    header('Location: news_list.php');
    exit;
}

$pageTitle = 'Lajmet';
require_once 'header.php';
?>
<div class="admin-top">
    <h1>Lajmet</h1>
    <a href="news_form.php" class="btn-sm btn-primary">+ Lajm i ri</a>
</div>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titulli</th>
            <th>Kategoria</th>
            <th>Data</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $row): ?>
        <tr>
            <td><?php echo (int) $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['category'] ?? ''); ?></td>
            <td><?php echo date('d.m.Y', strtotime($row['created_at'])); ?></td>
            <td>
                <a href="news_form.php?id=<?php echo (int) $row['id']; ?>" class="btn-sm btn-secondary">Ndrysho</a>
                <a href="news_list.php?delete=<?php echo (int) $row['id']; ?>" class="btn-sm btn-danger" onclick="return confirm('Fshi këtë lajm?');">Fshi</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (empty($list)): ?>
    <p class="text-muted">Nuk ka lajme.</p>
<?php endif; ?>
<?php if ($totalPages > 1): ?>
<p style="margin-top: 1rem;">
    <?php if ($page > 1): ?><a href="news_list.php?page=<?php echo $page - 1; ?>">Para</a> <?php endif; ?>
    Faqja <?php echo $page; ?> / <?php echo $totalPages; ?>
    <?php if ($page < $totalPages): ?> <a href="news_list.php?page=<?php echo $page + 1; ?>">Tjetra</a><?php endif; ?>
</p>
<?php endif; ?>
<?php require_once 'footer.php'; ?>
