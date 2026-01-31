<?php
require_once 'auth.php';
require_once __DIR__ . '/../includes/services/NewsService.php';
require_once __DIR__ . '/../includes/core/Validator.php';

$newsService = new NewsService();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$item = null;
if ($id > 0) {
    $item = $newsService->getById($id);
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'content' => trim($_POST['content'] ?? ''),
        'category' => trim($_POST['category'] ?? ''),
        'user_id' => (int) ($_SESSION['user_id'] ?? 0)
    ];

    $imageFile = null;
    if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
        $imageFile = $_FILES['image'];
    } elseif (!empty($_POST['image'])) {
        $data['image'] = trim($_POST['image']);
    }

    $pdfFile = null;
    if (isset($_FILES['pdf_file']) && !empty($_FILES['pdf_file']['tmp_name'])) {
        $pdfFile = $_FILES['pdf_file'];
    }

    if ($id > 0) {
        $result = $newsService->update($id, $data, $imageFile, $pdfFile);
    } else {
        $result = $newsService->create($data, $imageFile, $pdfFile);
    }

    if ($result['success']) {
        header('Location: news_list.php');
        exit;
    } else {
        $errors[] = $result['error'] ?? 'Gabim në ruajtjen e lajmit.';
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
<form method="post" enctype="multipart/form-data" class="admin-form admin-card">
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
        <label for="image">Imazhi</label>
        <?php if (!empty($item['image'])): ?>
            <p style="margin-bottom: 0.5rem;">
                <img src="../<?php echo htmlspecialchars($item['image']); ?>" alt="Imazh aktual" style="max-width: 200px; height: auto; display: block; margin-bottom: 0.5rem;">
                <small>Imazh aktual</small>
            </p>
        <?php endif; ?>
        <input type="file" id="image" name="image" accept="image/*">
        <small style="display: block; margin-top: 0.5rem; color: #64748b;">Ose shkruani URL:</small>
        <input type="url" id="image_url" name="image" value="<?php echo htmlspecialchars($item['image'] ?? $_POST['image'] ?? ''); ?>" style="margin-top: 0.5rem;">
    </div>
    <div class="form-group">
        <label for="pdf_file">Skedar PDF (opsionale)</label>
        <?php if (!empty($item['pdf_file'])): ?>
            <p style="margin-bottom: 0.5rem;">
                <a href="../<?php echo htmlspecialchars($item['pdf_file']); ?>" target="_blank" style="color: #3b82f6;">Shiko PDF aktual</a>
            </p>
        <?php endif; ?>
        <input type="file" id="pdf_file" name="pdf_file" accept="application/pdf">
    </div>
    <button type="submit" class="btn-sm btn-primary">Ruaj</button>
</form>
<?php require_once 'footer.php'; ?>
