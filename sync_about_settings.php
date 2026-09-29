<?php
require_once __DIR__ . '/config/db.php';
$pdo = getDB();
if ($pdo) {
    $settings = [
        'about_heading' => 'BUILDING MEANINGFUL APPLICATIONS & DIGITAL EXPERIENCES',
        'about_p1' => "Hey, I'm Aljon, a Computer Science student specializing in Application Development at Western Mindanao State University (WMSU).",
        'about_p2' => "Currently pursuing my degree at WMSU, I enjoy turning complex ideas into practical working systems, designing intuitive interfaces, and developing robust database-driven applications that solve real-world problems.",
        'about_p3' => "My experience includes PHP 8+ and MySQL web architectures, REST APIs, cross-platform mobile development with React Native, 3D WebGL scenes, and software engineering principles."
    ];

    foreach ($settings as $k => $v) {
        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = :v");
        $stmt->execute([':k' => $k, ':v' => $v]);
    }
    // Remove old extra keys if existing
    $pdo->exec("DELETE FROM site_settings WHERE setting_key IN ('about_p4', 'about_p5', 'about_p6')");
    echo "SUCCESS: site_settings table updated with new About Me content!\n";
} else {
    echo "NOTICE: DB connection not active, fallback settings will be used.\n";
}
