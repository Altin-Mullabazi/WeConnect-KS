<?php
require_once 'auth.php';
require_once __DIR__ . '/../includes/db.php';

$stats = [
    'news' => 0,
    'contacts' => 0,
    'users' => 0,
];
try {
    $stats['news'] = (int) $pdo->query('SELECT COUNT(*) FROM news')->fetchColumn();
} catch (PDOException $e) {}
try {
    $stats['contacts'] = (int) $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
} catch (PDOException $e) {}
try {
    $stats['users'] = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
} catch (PDOException $e) {}

$pageTitle = 'Përmbledhje';
require_once 'header.php';
?>
<div class="admin-top">
    <h1>Përmbledhje</h1>
</div>
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
    <div class="admin-card">
        <h3 style="margin-bottom: 0.5rem;">Lajmet</h3>
        <p style="font-size: 1.5rem; font-weight: 700;"><?php echo $stats['news']; ?></p>
        <a href="news_list.php" class="btn-sm btn-secondary">Shiko listën</a>
    </div>
    <div class="admin-card">
        <h3 style="margin-bottom: 0.5rem;">Kontaktet</h3>
        <p style="font-size: 1.5rem; font-weight: 700;"><?php echo $stats['contacts']; ?></p>
        <a href="contacts_list.php" class="btn-sm btn-secondary">Shiko listën</a>
    </div>
    <div class="admin-card">
        <h3 style="margin-bottom: 0.5rem;">Përdoruesit</h3>
        <p style="font-size: 1.5rem; font-weight: 700;"><?php echo $stats['users']; ?></p>
        <a href="users_list.php" class="btn-sm btn-secondary">Shiko listën</a>
    </div>
</div>
<?php require_once 'footer.php'; ?>
