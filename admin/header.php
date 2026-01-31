<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : ''; ?>Admin - WeConnectKS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<div class="admin-wrap">
    <aside class="admin-sidebar">
        <h2>Admin</h2>
        <ul>
            <li><a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'active' : ''; ?>">Përmbledhje</a></li>
            <li><a href="news_list.php" class="<?php echo (basename($_SERVER['PHP_SELF']) === 'news_list.php') ? 'active' : ''; ?>">Lajmet</a></li>
            <li><a href="contacts_list.php" class="<?php echo (basename($_SERVER['PHP_SELF']) === 'contacts_list.php') ? 'active' : ''; ?>">Kontaktet</a></li>
            <li><a href="users_list.php" class="<?php echo (basename($_SERVER['PHP_SELF']) === 'users_list.php') ? 'active' : ''; ?>">Përdoruesit</a></li>
        </ul>
        <p style="margin-top: 2rem;"><a href="../index.php" style="color: #94a3b8;">← Faqja kryesore</a></p>
        <p><a href="../logout.php" style="color: #94a3b8;">Dil</a></p>
    </aside>
    <main class="admin-main">
