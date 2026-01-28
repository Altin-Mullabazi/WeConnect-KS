<?php
require_once 'includes/db.php';

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$email = '';
$emailError = '';
$passwordError = '';
$successMessage = '';
$isSubmitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isSubmitted = true;
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (empty($email)) {
        $emailError = "Email-i nuk mund të jetë bosh";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Formati i email-it nuk është i vlefshëm";
    } else {
        try {
            
            $stmt = $pdo->prepare('SELECT id, full_name, email, PASSWORD, role FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                $emailError = "Email-i nuk ekziston në bazën e të dhënave";
            } else {
                if (empty($password)) {
                    $passwordError = "Fjalëkalimi nuk mund të jetë bosh";
                } elseif (!password_verify($password, $user['PASSWORD'])) {
                    $passwordError = "Fjalëkalimi është i pasaktë";
                } else {
                  
                    $_SESSION['user_id'] = (int) $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'] ?? 'user';

                    $successMessage = "Mirë se erdhët, " . htmlspecialchars($user['full_name']) . "!";
                    header("Location: dashboard.php");
                    exit;
                }
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $emailError = "Ndodhi një gabim në server. Ju lutem provoni përsëri.";
        }
    }
    
    if ($emailError && empty($password)) {
        $passwordError = "Fjalëkalimi nuk mund të jetë bosh";
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

                    <?php if ($successMessage): ?>
                        <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
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
                                class="<?php echo $emailError ? 'has-error' : ''; ?>"
                                required
                            >
                            <?php if ($emailError): ?>
                                <div class="error-message"><?php echo htmlspecialchars($emailError); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="password">Fjalekalimi</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Shkruani fjalekalimin"
                                autocomplete="current-password"
                                class="<?php echo $passwordError ? 'has-error' : ''; ?>"
                                required
                            >
                            <?php if ($passwordError): ?>
                                <div class="error-message"><?php echo htmlspecialchars($passwordError); ?></div>
                            <?php endif; ?>
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
