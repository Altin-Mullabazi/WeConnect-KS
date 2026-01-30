<?php
require_once 'includes/services/AuthService.php';

$authService = new AuthService();

if ($authService->isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$email = '';
$error = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    $result = $authService->login($email, $password);
    
    if ($result['success']) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = $result['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeConnectKS - Hyni</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <meta name="description" content="Hyni ne WeConnectKS per te gjetur evente dhe komunitete ne Kosove">
</head>

<body class="auth-page">

    <a class="skip-link" href="#main">Kaloni te permbajtja</a>

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
                <li><a href="groups.php">Grupet</a></li>
                <li><a href="about.php">Rreth Nesh</a></li>
                <li><a href="contacts.php">Kontakt</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="login.php" class="btn-text">Hyni</a>
                <a href="register.php" class="btn-primary">Regjistrohu</a>
            </div>
        </div>
    </nav>

    <main id="main" class="section-padding">
        <div class="container">
            <div class="auth-wrapper">
                <article class="auth-card">
                    <h2 class="auth-title">Hyni ne Llogari</h2>
                    <p class="text-muted auth-sub">
                        Hyni per te vazhduar ne WeConnectKS
                    </p>

                    <?php if ($error): ?>
                        <div class="error-message" style="margin-bottom: 1rem; padding: 0.75rem; background: #fee; border-radius: 6px; color: #c00;">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" novalidate>

                        <div class="form-group">
                            <label for="email">Adresa e Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="emri@email.com"
                                autocomplete="email"
                                value="<?php echo htmlspecialchars($email); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="password">Fjalekalimi</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Shkruani fjalekalimin"
                                autocomplete="current-password"
                                required
                            >
                        </div>

                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="rememberMe" name="rememberMe">
                                Me mbaj mend
                            </label>
                        </div>

                        <button type="submit" class="btn-primary auth-submit">
                            Hyni
                        </button>
                    </form>
                    <p class="auth-footer">
                        Nuk keni llogari?
                        <a href="register.php">Regjistrohu</a>
                    </p>

                </article>
            </div>
        </div>
    </main>

    <?php require_once 'includes/footer.php'; ?>

    <script src="assets/js/login.js" defer></script>
</body>
</html>
