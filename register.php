<?php
require_once 'includes/services/AuthService.php';
require_once 'includes/core/Validator.php';

$authService = new AuthService();

$fullName = '';
$email = '';
$success = false;
$successMessage = '';
$fieldErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';
    $terms = isset($_POST['terms']);

    $validator = new Validator($_POST);
    $validator
        ->required('fullName', 'Emri i plote nuk mund te jete bosh.')
        ->minLength('fullName', 3, 'Emri duhet te kete te pakten 3 karaktere.')
        ->maxLength('fullName', 100, 'Emri nuk mund te jete me i gjate se 100 karaktere.')
        ->required('email', 'Email-i nuk mund te jete bosh.')
        ->email('email', 'Email-i nuk eshte valid.')
        ->required('password', 'Fjalekalimi nuk mund te jete bosh.')
        ->minLength('password', 8, 'Fjalekalimi duhet te kete te pakten 8 karaktere.')
        ->required('confirmPassword', 'Konfirmimi i fjalekalimit nuk mund te jete bosh.')
        ->match('password', 'confirmPassword', 'Fjalekalimet nuk perputhen.');

    if (!$terms) {
        $fieldErrors['terms'] = 'Duhet te pranoj Termat & Politiken e Privatesise.';
    }

    if (!$validator->isValid()) {
        $fieldErrors = array_merge($fieldErrors, $validator->getErrors());
    }

    if (empty($fieldErrors)) {
        $nameParts = explode(' ', $fullName, 2);
        $emri = $nameParts[0];
        $mbiemri = $nameParts[1] ?? '';

        $result = $authService->register([
            'emri' => $emri,
            'mbiemri' => $mbiemri,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $confirmPassword
        ]);

        if ($result['success']) {
            $success = true;
            $successMessage = 'Regjistrim i sukseshem! Tani mund te hyni me kredencialet tuaja.';
            $fullName = '';
            $email = '';
        } else {
            $fieldErrors['general'] = $result['error'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeConnectKS - Regjistrimi</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="description" content="Regjistrohu ne WeConnectKS per te gjetur evente dhe komunitete ne Kosove">
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
                    <h2 id="authTitle" class="auth-title">Krijo Llogarine</h2>
                    <p class="text-muted auth-sub">Regjistrohuni dhe gjeni eventet dhe komunitetet tuaja.</p>

                    <?php if ($success): ?>
                        <div class="success-message show">
                            ✓ <?php echo htmlspecialchars($successMessage); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($fieldErrors['general'])): ?>
                        <div class="general-error">
                            ✗ <?php echo htmlspecialchars($fieldErrors['general']); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" novalidate>
                        <div class="form-group">
                            <label for="fullName">Emri i Plote</label>
                            <input 
                                type="text" 
                                id="fullName" 
                                name="fullName" 
                                autocomplete="name" 
                                placeholder="Emri dhe Mbiemri" 
                                value="<?php echo htmlspecialchars($fullName); ?>"
                                <?php echo isset($fieldErrors['fullName']) ? 'class="has-error"' : ''; ?>
                                required>
                            <?php if (isset($fieldErrors['fullName'])): ?>
                                <span class="error-message"><?php echo htmlspecialchars($fieldErrors['fullName']); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="email">Adresa e Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                autocomplete="email" 
                                placeholder="emri@email.com" 
                                value="<?php echo htmlspecialchars($email); ?>"
                                <?php echo isset($fieldErrors['email']) ? 'class="has-error"' : ''; ?>
                                required>
                            <?php if (isset($fieldErrors['email'])): ?>
                                <span class="error-message"><?php echo htmlspecialchars($fieldErrors['email']); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-row">
                            <div class="form-group half">
                                <label for="password">Fjalekalimi</label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    autocomplete="new-password" 
                                    minlength="8" 
                                    placeholder="Password" 
                                    <?php echo isset($fieldErrors['password']) ? 'class="has-error"' : ''; ?>
                                    required>
                                <?php if (isset($fieldErrors['password'])): ?>
                                    <span class="error-message"><?php echo htmlspecialchars($fieldErrors['password']); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group half">
                                <label for="confirmPassword">Konfirmo Fjalekalimin</label>
                                <input 
                                    type="password" 
                                    id="confirmPassword" 
                                    name="confirmPassword" 
                                    autocomplete="new-password" 
                                    minlength="8" 
                                    placeholder="Shkruaj prap fjalekalimin" 
                                    <?php echo isset($fieldErrors['confirmPassword']) ? 'class="has-error"' : ''; ?>
                                    required>
                                <?php if (isset($fieldErrors['confirmPassword'])): ?>
                                    <span class="error-message"><?php echo htmlspecialchars($fieldErrors['confirmPassword']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="terms" name="terms" required>
                                Degjoj dhe pranoj <a href="#">Termat & Politiken e Privatesise</a>
                            </label>
                            <?php if (isset($fieldErrors['terms'])): ?>
                                <span class="error-message"><?php echo htmlspecialchars($fieldErrors['terms']); ?></span>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn-primary auth-submit">Krijo Llogarine</button>
                    </form>

                    <p class="auth-footer">Keni tashme nje llogari? <a href="login.php">Hyni</a></p>
                </article>
            </div>
        </div>
    </main>

    <?php require_once 'includes/footer.php'; ?>

    <script src="script.js" defer></script>
    <script src="assets/js/register.js" defer></script>
</body>
</html>
