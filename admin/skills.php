<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$pdo = getDB();
$message = '';

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($pdo) {
        $stmt = $pdo->prepare("DELETE FROM skills WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $message = "Skill deleted successfully.";
    }
}

$edit_skill = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    if ($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM skills WHERE id = :id");
        $stmt->execute([':id' => $edit_id]);
        $edit_skill = $stmt->fetch();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $proficiency = trim($_POST['proficiency_display'] ?? '90%');

    if (!empty($name) && $pdo) {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE skills SET name = :n, category = :c, proficiency_display = :p WHERE id = :id");
            $stmt->execute([':n' => $name, ':c' => $category, ':p' => $proficiency, ':id' => $id]);
            $message = "Skill updated successfully.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO skills (name, category, proficiency_display) VALUES (:n, :c, :p)");
            $stmt->execute([':n' => $name, ':c' => $category, ':p' => $proficiency]);
            $message = "Skill added successfully.";
        }
        $edit_skill = null;
    }
}

$skills = [];
if ($pdo) {
    $skills = $pdo->query("SELECT * FROM skills ORDER BY id ASC")->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Skills — Admin</title>
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
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { padding: 12px 16px; text-align: left; border-bottom: 1px solid var(--border-subtle); }
  </style>
</head>
<body>
  <div class="admin-wrapper">
    <aside class="admin-sidebar">
      <h3>ALJON ADMIN</h3>
      <ul class="admin-nav">
        <li><a href="index.php">📊 Overview</a></li>
        <li><a href="projects.php">📁 Manage Projects</a></li>
        <li><a href="skills.php" class="active">🛠️ Manage Skills</a></li>
        <li><a href="about.php">✍️ Edit Site Content</a></li>
        <li><a href="messages.php">📬 Messages</a></li>
        <li style="margin-top:40px;"><a href="logout.php" style="color:#FF5F56;">🚪 Logout</a></li>
        <li><a href="../index.php" target="_blank" style="font-size:0.85rem; margin-top:10px;">🌐 View Main Site</a></li>
      </ul>
    </aside>

    <main class="admin-content">
      <h1 class="panel-title" style="margin-bottom:24px;">SKILLS & METRICS MANAGEMENT</h1>

      <?php if (!empty($message)): ?>
        <div style="background:#5B695C; color:#fff; padding:12px; border-radius:8px; margin-bottom:20px; font-weight:600;">
          <?= htmlspecialchars($message) ?>
        </div>
      <?php endif; ?>

      <div class="card">
        <h3><?= $edit_skill ? 'EDIT SKILL #' . htmlspecialchars($edit_skill['id']) : 'ADD NEW SKILL INDICATOR' ?></h3>
        <form method="POST" style="margin-top:20px; display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:15px; align-items:end;">
          <input type="hidden" name="id" value="<?= $edit_skill['id'] ?? 0 ?>">
          <div class="form-group" style="margin-bottom:0;">
            <label>Skill Name</label>
            <input type="text" name="name" placeholder="PHP" required value="<?= htmlspecialchars($edit_skill['name'] ?? '') ?>">
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label>Category</label>
            <input type="text" name="category" placeholder="Backend Development" required value="<?= htmlspecialchars($edit_skill['category'] ?? '') ?>">
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label>Metric Display</label>
            <input type="text" name="proficiency_display" placeholder="95%" value="<?= htmlspecialchars($edit_skill['proficiency_display'] ?? '') ?>">
          </div>
          <div>
            <button type="submit" class="btn-pill" style="height:48px;"><?= $edit_skill ? 'UPDATE SKILL' : 'ADD SKILL' ?></button>
            <?php if ($edit_skill): ?>
              <a href="skills.php" class="btn-pill" style="height:48px; background:#5C5B56; text-decoration:none;">CANCEL</a>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <div class="card">
        <h3>ACTIVE SKILLS LIST</h3>
        <table>
          <thead>
            <tr>
              <th>Skill</th>
              <th>Category</th>
              <th>Metric Display</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($skills as $s): ?>
              <tr>
                <td><strong><?= htmlspecialchars($s['name']) ?></strong></td>
                <td><?= htmlspecialchars($s['category']) ?></td>
                <td><span style="font-family:var(--font-heading); font-size:1.2rem; font-weight:800;"><?= htmlspecialchars($s['proficiency_display']) ?></span></td>
                <td>
                  <a href="skills.php?action=edit&id=<?= $s['id'] ?>" style="color:#5B695C; font-weight:700; margin-right:12px;">Edit</a>
                  <a href="skills.php?action=delete&id=<?= $s['id'] ?>" onclick="return confirm('Delete this skill?')" style="color:#FF5F56; font-weight:700;">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
