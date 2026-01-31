<?php
require_once 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache");
header("Expires: 0"); 

$userId = (int) $_SESSION['user_id'];
$role = $_SESSION['role'] ?? 'user';
$fullName = $_SESSION['full_name'] ?? 'Përdorues';

if ($role !== 'organizer' && $role !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$successMessage = '';
$eventData = [
    'title' => '',
    'description' => '',
    'event_date' => '',
    'location' => '',
    'category' => '',
    'max_participants' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventData['title'] = trim($_POST['title'] ?? '');
    $eventData['description'] = trim($_POST['description'] ?? '');
    $eventData['event_date'] = $_POST['event_date'] ?? '';
    $eventData['location'] = trim($_POST['location'] ?? '');
    $eventData['category'] = trim($_POST['category'] ?? '');
    $eventData['max_participants'] = (int) ($_POST['max_participants'] ?? 0);

    if (empty($eventData['title']) || strlen($eventData['title']) < 3 || strlen($eventData['title']) > 200) {
        $errors[] = 'Titull duhet të jetë 3-200 karaktere';
    }

    if (empty($eventData['description']) || strlen($eventData['description']) < 10 || strlen($eventData['description']) > 5000) {
        $errors[] = 'Përshkrimi duhet të jetë 10-5000 karaktere';
    }

    if (empty($eventData['event_date'])) {
        $errors[] = 'Data e eventit nuk mund të jetë bosh';
    } else {
        $eventDateTime = new DateTime($eventData['event_date']);
        $now = new DateTime();
        if ($eventDateTime <= $now) {
            $errors[] = 'Data e eventit duhet të jetë në të ardhmen';
        }
    }

    if (empty($eventData['location']) || strlen($eventData['location']) < 3 || strlen($eventData['location']) > 255) {
        $errors[] = 'Lokacioni duhet të jetë 3-255 karaktere';
    }

    if (empty($eventData['category'])) {
        $errors[] = 'Kategoria është e detyrueshme';
    }

    if ($eventData['max_participants'] < 0 || $eventData['max_participants'] > 10000) {
        $errors[] = 'Numri maksimal i pjesëmarrësve duhet të jetë 0-10000';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO events (title, description, event_date, location, category, max_participants, organizer_id)
                VALUES (:title, :description, :event_date, :location, :category, :max_participants, :organizer_id)
            ");

            $stmt->execute([
                ':title' => $eventData['title'],
                ':description' => $eventData['description'],
                ':event_date' => $eventData['event_date'],
                ':location' => $eventData['location'],
                ':category' => $eventData['category'],
                ':max_participants' => $eventData['max_participants'],
                ':organizer_id' => $userId
            ]);

            $eventId = $pdo->lastInsertId();

            $stmt = $pdo->prepare("
                INSERT INTO event_participants (event_id, user_id)
                VALUES (:event_id, :user_id)
            ");
            $stmt->execute([
                ':event_id' => $eventId,
                ':user_id' => $userId
            ]);

            $successMessage = 'Eventi u krijua me sukses!';
            $eventData = [
                'title' => '',
                'description' => '',
                'event_date' => '',
                'location' => '',
                'category' => '',
                'max_participants' => ''
            ];

            header("refresh:2;url=event.php?id=$eventId");

        } catch (PDOException $e) {
            error_log('Create event error: ' . $e->getMessage());
            $errors[] = 'Ndodhi një gabim në server. Provoni përsëri.';
        }
    }
}

$categories = ['Teknologji', 'Sport', 'Kultura', 'Biznes', 'Edukimi', 'Muzikë', 'Arte', 'Të tjera'];
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krijo Event - WeConnectKS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/create_event.css">
</head>
<body class="create-event-body">
<?php require_once 'includes/header.php'; ?>

<main class="section-padding">
    <div class="container create-event-container">
        <section class="create-event-form-section">
            <header class="form-header">
                <h1>Krijo një Event të ri</h1>
                <p>Plotëso detajet e eventit dhe ruaj atë për përdoruesit e interesuarë.</p>
            </header>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <strong>Gabime:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success">
                    ✓ <?php echo htmlspecialchars($successMessage); ?> Duke të çuar në event...
                </div>
            <?php endif; ?>

            <form method="POST" class="create-event-form" id="eventForm">
                <div class="form-group">
                    <label for="title">Titull i Eventit *</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        placeholder="p.sh. Konferenca e Teknologjisë 2026"
                        value="<?php echo htmlspecialchars($eventData['title']); ?>"
                        minlength="3"
                        maxlength="200"
                        required
                    >
                    <small>3-200 karaktere</small>
                </div>

                <div class="form-group">
                    <label for="description">Përshkrimi *</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        placeholder="Përshkruaj eventmin me detaje..."
                        minlength="10"
                        maxlength="5000"
                        rows="5"
                        required
                    ><?php echo htmlspecialchars($eventData['description']); ?></textarea>
                    <small>10-5000 karaktere</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="event_date">Data dhe Ora e Eventit *</label>
                        <input 
                            type="datetime-local" 
                            id="event_date" 
                            name="event_date" 
                            value="<?php echo htmlspecialchars($eventData['event_date']); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="location">Lokacioni *</label>
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            placeholder="p.sh. Prishtinë, Kosovë"
                            value="<?php echo htmlspecialchars($eventData['location']); ?>"
                            minlength="3"
                            maxlength="255"
                            required
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Kategoria *</label>
                        <select id="category" name="category" required>
                            <option value="">-- Zgjidh Kategorinë --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option 
                                    value="<?php echo htmlspecialchars($cat); ?>"
                                    <?php echo $eventData['category'] === $cat ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($cat); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="max_participants">Numri Maksimal i Pjesëmarrësve</label>
                        <input 
                            type="number" 
                            id="max_participants" 
                            name="max_participants" 
                            placeholder="0 = pa limit"
                            min="0"
                            max="10000"
                            value="<?php echo $eventData['max_participants']; ?>"
                        >
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Krijo Eventin</button>
                    <a href="dashboard.php" class="btn-secondary">Anullo</a>
                </div>
            </form>
        </section>

        <aside class="create-event-preview">
            <h2>Pamja e Eventit</h2>
            <div class="preview-card">
                <div class="preview-title" id="previewTitle">Titull i Eventit</div>
                <div class="preview-meta">
                    <span class="preview-label">📅 Data:</span>
                    <span id="previewDate">Data nuk është vendosur</span>
                </div>
                <div class="preview-meta">
                    <span class="preview-label">📍 Lokacioni:</span>
                    <span id="previewLocation">Lokacioni nuk është vendosur</span>
                </div>
                <div class="preview-meta">
                    <span class="preview-label">🏷️ Kategoria:</span>
                    <span id="previewCategory">Kategoria nuk është vendosur</span>
                </div>
                <div class="preview-description" id="previewDescription">Përshkrimi i eventit do të shfaqet këtu...</div>
            </div>
        </aside>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>

<script src="assets/js/create_event.js" defer></script>
<script>
(function(){
    localStorage.setItem('isLoggedIn', '1');
    window.addEventListener('pageshow', function(e) {
        if (!localStorage.getItem('isLoggedIn') || e.persisted) {
            window.location.replace('login.php');
        }
    });
})();
</script>
</body>
</html>
