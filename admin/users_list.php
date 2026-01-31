<?php
require_once 'auth.php';
require_once __DIR__ . '/../includes/db.php';

$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;
$total = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$totalPages = $total ? (int) ceil($total / $perPage) : 1;

$stmt = $pdo->query('SELECT id, full_name, email, created_at, role FROM users ORDER BY created_at DESC LIMIT ' . $perPage . ' OFFSET ' . $offset);
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = 'Përdoruesit';
require_once 'header.php';
?>
<div class="admin-top">
    <h1>Përdoruesit</h1>
</div>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Emri</th>
            <th>Email</th>
            <th>Roli</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $row): ?>
        <tr>
            <td><?php echo (int) $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['full_name'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['role'] ?? 'user'); ?></td>
            <td><?php echo date('d.m.Y', strtotime($row['created_at'])); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (empty($list)): ?>
    <p class="text-muted">Nuk ka përdorues.</p>
<?php endif; ?>
<?php if ($totalPages > 1): ?>
<p style="margin-top: 1rem;">
    <?php if ($page > 1): ?><a href="users_list.php?page=<?php echo $page - 1; ?>">Para</a> <?php endif; ?>
    Faqja <?php echo $page; ?> / <?php echo $totalPages; ?>
    <?php if ($page < $totalPages): ?> <a href="users_list.php?page=<?php echo $page + 1; ?>">Tjetra</a><?php endif; ?>
</p>
<?php endif; ?>
<?php require_once 'footer.php'; ?>
