<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$fullName = $_SESSION['full_name'] ?? null;
$role = $_SESSION['role'] ?? null;
?>

<nav class="navbar">
    <div class="container nav-container">
        <div class="logo">
            <div class="logo-badge">W</div>
            <div class="logo-text">
                <span class="logo-title">WeConnect</span>
                <span class="logo-subtitle">KOSOVA</span>
            </div>
        </div>

        <ul class="nav-links">
            <li><a href="index.php">Ballina</a></li>
            <li><a href="events.php">Eventet</a></li>
            <li><a href="news.php">Lajmet</a></li>
            <li><a href="groups.php">Grupet</a></li>
            <li><a href="about.php">Rreth Nesh</a></li>
            <li><a href="contacts.php">Kontakt</a></li>
        </ul>

        <div class="auth-buttons">
            <?php if ($fullName): ?>
                <span class="nav-user">
                    <?php echo htmlspecialchars($fullName); ?>
                    <?php if ($role): ?>
                        <span class="nav-role-badge"><?php echo htmlspecialchars($role); ?></span>
                    <?php endif; ?>
                </span>
                <a href="dashboard.php" class="btn-text">Dashboard</a>
                <a href="logout.php" class="btn-primary">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn-text">Hyni</a>
                <a href="register.php" class="btn-primary">Regjistrohu</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

