<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$pdo = getDB();
$message = '';
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($pdo) {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $message = "Project ID {$id} deleted successfully.";
    }
}

// Handle Add / Edit Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $full_description = trim($_POST['full_description'] ?? '');
    $technologies = trim($_POST['technologies'] ?? '');
    $image_url = trim($_POST['image_url'] ?? 'assets/images/project1.svg');

    if (!empty($title) && !empty($short_description)) {
        if ($pdo) {
            if ($id > 0) {
                // Update
                $stmt = $pdo->prepare("UPDATE projects SET title = :t, category = :c, short_description = :sd, full_description = :fd, technologies = :tech, image_url = :img WHERE id = :id");
                $stmt->execute([
                    ':t' => $title,
                    ':c' => $category,
                    ':sd' => $short_description,
                    ':fd' => $full_description,
                    ':tech' => $technologies,
                    ':img' => $image_url,
                    ':id' => $id
                ]);
                $message = "Project updated successfully.";
            } else {
                // Insert
                $stmt = $pdo->prepare("INSERT INTO projects (title, category, short_description, full_description, technologies, image_url) VALUES (:t, :c, :sd, :fd, :tech, :img)");
                $stmt->execute([
                    ':t' => $title,
                    ':c' => $category,
                    ':sd' => $short_description,
                    ':fd' => $full_description,
                    ':tech' => $technologies,
                    ':img' => $image_url
                ]);
                $message = "New project added successfully.";
            }
        }
    } else {
        $error = "Title and short description are required.";
    }
}

// Fetch Projects List
$projects = [];
if ($pdo) {
    $projects = $pdo->query("SELECT * FROM projects ORDER BY sort_order ASC, id ASC")->fetchAll();
}

// Edit project single fetch
$edit_project = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    if ($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id");
        $stmt->execute([':id' => $edit_id]);
        $edit_project = $stmt->fetch();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Projects — Admin</title>
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
        <li><a href="projects.php" class="active">📁 Manage Projects</a></li>
        <li><a href="skills.php">🛠️ Manage Skills</a></li>
        <li><a href="about.php">✍️ Edit Site Content</a></li>
        <li><a href="messages.php">📬 Messages</a></li>
        <li style="margin-top:40px;"><a href="logout.php" style="color:#FF5F56;">🚪 Logout</a></li>
      </ul>
    </aside>

    <main class="admin-content">
      <h1 class="panel-title" style="margin-bottom:24px;">PROJECT CRUD MANAGEMENT</h1>

      <?php if (!empty($message)): ?>
        <div style="background:#5B695C; color:#fff; padding:12px; border-radius:8px; margin-bottom:20px; font-weight:600;">
          <?= htmlspecialchars($message) ?>
        </div>
      <?php endif; ?>
      
      <?php if (!empty($error)): ?>
        <div style="background:#FF5F56; color:#fff; padding:12px; border-radius:8px; margin-bottom:20px; font-weight:600;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <!-- Add / Edit Form -->
      <div class="card">
        <h3><?= $edit_project ? 'EDIT PROJECT #' . htmlspecialchars($edit_project['id']) : 'ADD NEW PROJECT' ?></h3>
        <form method="POST" style="margin-top:20px;">
          <input type="hidden" name="id" value="<?= $edit_project['id'] ?? 0 ?>">
          
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
              <label>Project Title</label>
              <input type="text" name="title" required value="<?= htmlspecialchars($edit_project['title'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label>Category</label>
              <input type="text" name="category" placeholder="Web Application" value="<?= htmlspecialchars($edit_project['category'] ?? '') ?>">
            </div>
          </div>

          <div class="form-group">
            <label>Technologies Used (comma separated)</label>
            <input type="text" name="technologies" placeholder="PHP, MySQL, JavaScript" value="<?= htmlspecialchars($edit_project['technologies'] ?? '') ?>">
          </div>

          <div class="form-group">
            <label>Image URL</label>
            <input type="text" name="image_url" value="<?= htmlspecialchars($edit_project['image_url'] ?? 'assets/images/project1.svg') ?>">
          </div>

          <div class="form-group">
            <label>Short Description</label>
            <textarea name="short_description" rows="2" required><?= htmlspecialchars($edit_project['short_description'] ?? '') ?></textarea>
          </div>

          <div class="form-group">
            <label>Full Detailed Description</label>
            <textarea name="full_description" rows="4"><?= htmlspecialchars($edit_project['full_description'] ?? '') ?></textarea>
          </div>

          <button type="submit" class="btn-pill">
            <?= $edit_project ? 'UPDATE PROJECT' : 'CREATE PROJECT' ?> <span class="arrow">→</span>
          </button>
          <?php if ($edit_project): ?>
            <a href="projects.php" class="btn-pill" style="background:#5C5B56;">CANCEL</a>
          <?php endif; ?>
        </form>
      </div>

      <!-- Existing Projects Table -->
      <div class="card">
        <h3>EXISTING PROJECTS</h3>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Category</th>
              <th>Technologies</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($projects as $p): ?>
              <tr>
                <td>#<?= $p['id'] ?></td>
                <td><strong><?= htmlspecialchars($p['title']) ?></strong></td>
                <td><?= htmlspecialchars($p['category']) ?></td>
                <td><?= htmlspecialchars($p['technologies']) ?></td>
                <td>
                  <a href="projects.php?action=edit&id=<?= $p['id'] ?>" style="color:#5B695C; font-weight:700; margin-right:12px;">Edit</a>
                  <a href="projects.php?action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to delete this project?')" style="color:#FF5F56; font-weight:700;">Delete</a>
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
