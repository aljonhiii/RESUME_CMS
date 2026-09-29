<?php
require_once __DIR__ . '/config/db.php';
$pdo = getDB();
if ($pdo) {
    for ($i = 1; $i <= 4; $i++) {
        $stmt = $pdo->prepare("UPDATE projects SET image_url = :img WHERE id = :id");
        $stmt->execute([
            ':img' => "assets/images/project{$i}.svg",
            ':id' => $i
        ]);
    }
    echo "Updated DB image URLs successfully!\n";
} else {
    echo "DB connection failed in update_db.php\n";
}
?>
