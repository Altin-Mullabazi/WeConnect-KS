<?php
require_once 'includes/services/EventService.php';
require_once 'includes/services/AuthService.php';

session_start();

$authService = new AuthService();
$eventService = new EventService();

if (!$authService->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache");
header("Expires: 0"); 

$user = $authService->getCurrentUser();
$userId = $authService->getCurrentUserId();
$role = $user['role'] ?? 'user';
$fullName = $user['full_name'] ?? ($user['emri'] ?? '') . ' ' . ($user['mbiemri'] ?? '');

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
    'event_time' => '',
    'location' => '',
    'category' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventData['title'] = trim($_POST['title'] ?? '');
    $eventData['description'] = trim($_POST['description'] ?? '');
    $eventDateTime = $_POST['event_date'] ?? '';
    $eventData['location'] = trim($_POST['location'] ?? '');
    $eventData['category'] = trim($_POST['category'] ?? '');
    
    if (!empty($eventDateTime)) {
        $dateTime = new DateTime($eventDateTime);
        $eventData['event_date'] = $dateTime->format('Y-m-d');
        $eventData['event_time'] = $dateTime->format('H:i:s');
    }

    $imageFile = null;
    if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
        $imageFile = $_FILES['image'];
    }

    $data = [
        'title' => $eventData['title'],
        'description' => $eventData['description'],
        'event_date' => $eventData['event_date'],
        'event_time' => $eventData['event_time'],
        'location' => $eventData['location'],
        'category' => $eventData['category'],
        'user_id' => $userId
    ];

    $result = $eventService->create($data, $imageFile);

    if ($result['success']) {
        $eventId = $result['event_id'];
        $successMessage = 'Eventi u krijua me sukses!';
        $eventData = [
            'title' => '',
            'description' => '',
            'event_date' => '',
            'event_time' => '',
            'location' => '',
            'category' => ''
        ];
        header("refresh:2;url=event.php?id=$eventId");
    } else {
        $errors[] = $result['error'] ?? 'Ndodhi një gabim në server. Provoni përsëri.';
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

            <form method="POST" enctype="multipart/form-data" class="create-event-form" id="eventForm">
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
                    <label for="image">Imazhi i Eventit (opsionale)</label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        accept="image/*"
                    >
                    <small>Ngarko një imazh që përshkruan eventin. Formatet e lejuara: JPG, PNG, GIF, WebP (max 10MB)</small>
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
