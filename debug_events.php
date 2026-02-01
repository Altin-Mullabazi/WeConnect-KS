<?php
require_once 'includes/db.php';

echo "<h2>Events në databazë:</h2>";
echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>ID</th><th>Title</th><th>Image Path</th><th>Image Exists?</th></tr>";

$stmt = $pdo->query('SELECT id, title, image FROM events ORDER BY id DESC LIMIT 10');
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($events as $event) {
    $imagePath = $event['image'];
    $exists = !empty($imagePath) && file_exists($imagePath) ? '✅ Po' : '❌ Jo';
    echo "<tr>";
    echo "<td>" . $event['id'] . "</td>";
    echo "<td>" . htmlspecialchars($event['title']) . "</td>";
    echo "<td>" . htmlspecialchars($imagePath ?? 'NULL') . "</td>";
    echo "<td>" . $exists . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>Skedarët në uploads/events/:</h2>";
$files = glob('uploads/events/*');
echo "<ul>";
foreach ($files as $file) {
    echo "<li>" . $file . "</li>";
}
echo "</ul>";
