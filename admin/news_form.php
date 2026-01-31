<?php
require_once 'auth.php';
require_once __DIR__ . '/../includes/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$item = null;
if ($id > 0) {
    $stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $image = trim($_POST['image'] ?? '');
    if (strlen($title) < 2) $errors[] = 'Titulli duhet te kete te pakten 2 karaktere.';
    if (strlen($content) < 10) $errors[] = 'Permbajtja duhet te kete te pakten 10 karaktere.';
    if (empty($errors)) {
        $userId = (int) ($_SESSION['user_id'] ?? 0);
        if ($id > 0) {
            try {
                $stmt = $pdo->prepare('UPDATE news SET title = ?, content = ?, category = ?, image = ? WHERE id = ?');
                $stmt->execute([$title, $content, $category, $image ?: null, $id]);
            } catch (PDOException $e) {
                $stmt = $pdo->prepare('UPDATE news SET title = ?, content = ?, image = ? WHERE id = ?');
                $stmt->execute([$title, $content, $image ?: null, $id]);
            }
        } else {
            try {
                $stmt = $pdo->prepare('INSERT INTO news (title, content, category, image, user_id) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$title, $content, $category, $image ?: null, $userId]);
            } catch (PDOException $e) {
                $stmt = $pdo->prepare('INSERT INTO news (title, content, image, user_id) VALUES (?, ?, ?, ?)');
                $stmt->execute([$title, $content, $image ?: null, $userId]);
            }
        }
        header('Location: news_list.php');
        exit;
    }
}

$pageTitle = $item ? 'Ndrysho lajmin' : 'Lajm i ri';
require_once 'header.php';
?>
<div class="admin-top">
    <h1><?php echo $item ? 'Ndrysho lajmin' : 'Lajm i ri'; ?></h1>
    <a href="news_list.php" class="btn-sm btn-secondary">Kthehu</a>
</div>
<?php if (!empty($errors)): ?>
<ul style="color: #dc2626; margin-bottom: 1rem;">
<?php foreach ($errors as $e): ?>
<li><?php echo htmlspecialchars($e); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<form method="post" class="admin-form admin-card">
    <div class="form-group">
        <label for="title">Titulli</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($item['title'] ?? $_POST['title'] ?? ''); ?>" required>
    </div>
    <div class="form-group">
        <label for="content">Permbajtja</label>
        <textarea id="content" name="content" required><?php echo htmlspecialchars($item['content'] ?? $_POST['content'] ?? ''); ?></textarea>
    </div>
    <div class="form-group">
        <label for="category">Kategoria</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($item['category'] ?? $_POST['category'] ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="image">URL imazhi</label>
        <input type="url" id="image" name="image" value="<?php echo htmlspecialchars($item['image'] ?? $_POST['image'] ?? ''); ?>">
    </div>
    <button type="submit" class="btn-sm btn-primary">Ruaj</button>
</form>
<?php require_once 'footer.php'; ?>
