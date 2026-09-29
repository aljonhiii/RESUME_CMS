<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$pdo = getDB();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    // Handle text settings
    foreach ($_POST as $key => $val) {
        if ($key === 'submit') continue;
        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = :v");
        $stmt->execute([':k' => $key, ':v' => trim($val)]);
    }

    // Handle Face Photo Upload
    if (isset($_FILES['portrait_image']) && $_FILES['portrait_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['portrait_image']['tmp_name'];
        $fileName = $_FILES['portrait_image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = 'aljon-portrait.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/../assets/images/';
            $destPath = $uploadFileDir . $newFileName;
            
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imgPath = 'assets/images/' . $newFileName;
                $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES ('hero_portrait_img', :v) ON DUPLICATE KEY UPDATE setting_value = :v");
                $stmt->execute([':v' => $imgPath]);
                $message .= " Face photo uploaded successfully!";
            }
        }
    }

    $message = "Site content updated successfully!" . $message;
}

$settings = [
    'hero_title_1' => 'FULL-STACK',
    'hero_title_accent' => '& SOFTWARE',
    'hero_title_2' => 'DEVELOPER',
    'hero_description' => 'Transforming ideas into practical digital experiences through web development, mobile applications, and creative technology.',
    'hero_portrait_img' => 'assets/images/aljon-portrait.svg',
    'about_heading' => 'BUILDING MEANINGFUL APPLICATIONS & DIGITAL EXPERIENCES',
    'about_p1' => 'Hey, I\'m Aljon, a Computer Science student specializing in Application Development at Western Mindanao State University (WMSU).',
    'about_p2' => 'Currently pursuing my degree at WMSU, I enjoy turning complex ideas into practical working systems, designing intuitive interfaces, and developing robust database-driven applications that solve real-world problems.',
    'about_p3' => 'My experience includes PHP 8+ and MySQL web architectures, REST APIs, cross-platform mobile development with React Native, 3D WebGL scenes, and software engineering principles.'
];

if ($pdo) {
    $rows = $pdo->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll();
    foreach ($rows as $r) {
        $settings[$r['setting_key']] = $r['setting_value'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Site Content — Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .admin-wrapper { display: grid; grid-template-columns: 240px 1fr; min-height: 100vh; }
    .admin-sidebar { background: var(--bg-panel-dark); color: var(--text-light); padding: 30px 20px; }
    .admin-sidebar h3 { font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 30px; }
    .admin-nav { list-style: none; }
    .admin-nav li { margin-bottom: 12px; }
    .admin-nav a { color: #8A9A86; text-decoration: none; font-weight: 600; display: block; padding: 10px 14px; border-radius: 8px; }
    .admin-nav a:hover, .admin-nav a.active { background: rgba(255,255,255,0.1); color: #fff; }
    .admin-content { padding: 40px; background: var(--bg-canvas); }
    .card { background: var(--bg-panel); border-radius: 16px; padding: 30px; border: 1px solid var(--border-subtle); margin-bottom: 30px; }
  </style>
</head>
<body>
  <div class="admin-wrapper">
    <aside class="admin-sidebar">
      <h3>ALJON ADMIN</h3>
      <ul class="admin-nav">
        <li><a href="index.php">📊 Overview</a></li>
        <li><a href="projects.php">📁 Manage Projects</a></li>
        <li><a href="skills.php">🛠️ Manage Skills</a></li>
        <li><a href="about.php" class="active">✍️ Edit Site Content</a></li>
        <li><a href="messages.php">📬 Messages</a></li>
        <li style="margin-top:40px;"><a href="logout.php" style="color:#FF5F56;">🚪 Logout</a></li>
      </ul>
    </aside>

    <main class="admin-content">
      <h1 class="panel-title" style="margin-bottom:24px;">EDIT SITE TEXT & PORTRAIT PHOTO</h1>

      <?php if (!empty($message)): ?>
        <div style="background:#5B695C; color:#fff; padding:12px; border-radius:8px; margin-bottom:20px; font-weight:600;">
          <?= htmlspecialchars($message) ?>
        </div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="card">
          <h3 style="margin-bottom:20px;">DEVELOPER FACE / PORTRAIT PHOTO</h3>
          <div style="display:grid; grid-template-columns:120px 1fr; gap:20px; align-items:center;">
            <div style="width:110px; height:130px; background:#5B695C; border-radius:16px; overflow:hidden; border:2px solid var(--border-subtle);">
              <img src="../<?= htmlspecialchars($settings['hero_portrait_img'] ?? 'assets/images/aljon-portrait.svg') ?>" alt="Portrait" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div>
              <div class="form-group">
                <label>Upload Face Photo (PNG, JPG, WEBP, SVG)</label>
                <input type="file" name="portrait_image" accept="image/*">
              </div>
              <div class="form-group">
                <label>Or Set Custom Image Path / URL</label>
                <input type="text" name="hero_portrait_img" value="<?= htmlspecialchars($settings['hero_portrait_img'] ?? 'assets/images/aljon-portrait.svg') ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <h3 style="margin-bottom:20px;">HERO INTRO CONTENT</h3>
          <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:15px;">
            <div class="form-group">
              <label>Hero Title Line 1</label>
              <input type="text" name="hero_title_1" value="<?= htmlspecialchars($settings['hero_title_1']) ?>">
            </div>
            <div class="form-group">
              <label>Accent Title (Serif Italic)</label>
              <input type="text" name="hero_title_accent" value="<?= htmlspecialchars($settings['hero_title_accent']) ?>">
            </div>
            <div class="form-group">
              <label>Hero Title Line 2</label>
              <input type="text" name="hero_title_2" value="<?= htmlspecialchars($settings['hero_title_2']) ?>">
            </div>
          </div>
          <div class="form-group">
            <label>Hero Supporting Description</label>
            <textarea name="hero_description" rows="3"><?= htmlspecialchars($settings['hero_description']) ?></textarea>
          </div>
        </div>

        <div class="card">
          <h3 style="margin-bottom:20px;">ABOUT ME SECTION CONTENT</h3>
          <div class="form-group">
            <label>About Heading</label>
            <input type="text" name="about_heading" value="<?= htmlspecialchars($settings['about_heading']) ?>">
          </div>
          <div class="form-group">
            <label>Paragraph 1 (Highlight Serif)</label>
            <textarea name="about_p1" rows="2"><?= htmlspecialchars($settings['about_p1']) ?></textarea>
          </div>
          <div class="form-group">
            <label>Paragraph 2</label>
            <textarea name="about_p2" rows="3"><?= htmlspecialchars($settings['about_p2']) ?></textarea>
          </div>
          <div class="form-group">
            <label>Paragraph 3</label>
            <textarea name="about_p3" rows="3"><?= htmlspecialchars($settings['about_p3']) ?></textarea>
          </div>

          <button type="submit" name="submit" class="btn-pill">
            SAVE ALL CHANGES <span class="arrow">→</span>
          </button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
