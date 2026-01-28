<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? 'user';
?>

<aside class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner">
        <h3 class="dashboard-sidebar-title">Menu</h3>
        <ul class="dashboard-sidebar-nav">
            <li><a href="dashboard.php" class="active">Përmbledhje</a></li>
            <li><a href="events.php">Eventet</a></li>
            <li><a href="groups.php">Grupet</a></li>
            <li><a href="profile.php">Profili im</a></li>
        </ul>

        <div class="dashboard-sidebar-section">
            <h4>Roli juaj</h4>
            <p class="dashboard-role-pill"><?php echo htmlspecialchars($role); ?></p>
        </div>

        <?php if ($role === 'organizer'): ?>
            <div class="dashboard-sidebar-section">
                <h4>Organizer</h4>
                <ul class="dashboard-sidebar-nav">
                    <li><a href="create_event.php">Krijo Event</a></li>
                    <li><a href="my_events.php">Eventet e mia</a></li>
                </ul>
            </div>
        <?php elseif ($role === 'admin'): ?>
            <div class="dashboard-sidebar-section">
                <h4>Admin</h4>
                <ul class="dashboard-sidebar-nav">
                    <li><a href="admin_panel.php">Admin Panel</a></li>
                    <li><a href="manage_users.php">Menaxho Përdoruesit</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</aside>

