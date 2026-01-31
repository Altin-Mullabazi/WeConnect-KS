<?php
require_once 'auth.php';
require_once __DIR__ . '/../includes/db.php';

$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;
$total = (int) $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
$totalPages = $total ? (int) ceil($total / $perPage) : 1;

$stmt = $pdo->query('SELECT * FROM contacts ORDER BY created_at DESC LIMIT ' . $perPage . ' OFFSET ' . $offset);
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = 'Kontaktet';
require_once 'header.php';
?>
<div class="admin-top">
    <h1>Kontaktet</h1>
</div>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Emri</th>
            <th>Email</th>
            <th>Subjekti</th>
            <th>Data</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $row): ?>
        <tr>
            <td><?php echo (int) $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
            <td><?php echo htmlspecialchars($row['subject'] ?? ''); ?></td>
            <td><?php echo date('d.m.Y H:i', strtotime($row['created_at'])); ?></td>
            <td>
                <a href="contacts_list.php?view=<?php echo (int) $row['id']; ?>#m<?php echo (int) $row['id']; ?>" class="btn-sm btn-secondary">Shiko</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (empty($list)): ?>
<p class="text-muted">Nuk ka mesazhe kontakti.</p>
<?php endif; ?>
<?php if ($totalPages > 1): ?>
<p style="margin-top: 1rem;">
    <?php if ($page > 1): ?><a href="contacts_list.php?page=<?php echo $page - 1; ?>">Para</a> <?php endif; ?>
    Faqja <?php echo $page; ?> / <?php echo $totalPages; ?>
    <?php if ($page < $totalPages): ?> <a href="contacts_list.php?page=<?php echo $page + 1; ?>">Tjetra</a><?php endif; ?>
</p>
<?php endif; ?>
<?php
$viewId = isset($_GET['view']) ? (int) $_GET['view'] : 0;
if ($viewId > 0) {
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$viewId]);
    $view = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($view) {
        echo '<div id="m' . $viewId . '" class="admin-card" style="margin-top: 2rem;">';
        echo '<h3>Mesazhi #' . $viewId . '</h3>';
        echo '<p><strong>Emri:</strong> ' . htmlspecialchars($view['name']) . '</p>';
        echo '<p><strong>Email:</strong> ' . htmlspecialchars($view['email']) . '</p>';
        echo '<p><strong>Subjekti:</strong> ' . htmlspecialchars($view['subject'] ?? '') . '</p>';
        echo '<p><strong>Data:</strong> ' . date('d.m.Y H:i', strtotime($view['created_at'])) . '</p>';
        echo '<p><strong>Mesazhi:</strong></p><p>' . nl2br(htmlspecialchars($view['message'])) . '</p>';
        echo '</div>';
    }
}
?>
<?php require_once 'footer.php'; ?>
