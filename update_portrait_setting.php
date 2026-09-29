<?php
require_once __DIR__ . '/config/db.php';
$pdo = getDB();
if ($pdo) {
    $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES ('hero_portrait_img', 'assets/images/aljon-face-developer.svg') ON DUPLICATE KEY UPDATE setting_value = 'assets/images/aljon-face-developer.svg'");
    $stmt->execute();
    echo "Updated DB hero_portrait_img to aljon-face-developer.svg successfully!\n";
} else {
    echo "DB connection failed in update_portrait_setting.php\n";
}
?>
