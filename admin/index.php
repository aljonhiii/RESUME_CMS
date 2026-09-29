<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$pdo = getDB();
$project_count = 4;
$skill_count = 6;
$message_count = 0;
$unread_messages = 0;
$recent_messages = [];

if ($pdo) {
    try {
        $project_count = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        $skill_count = $pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn();
        $message_count = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
        $unread_messages = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'unread'")->fetchColumn();
        $recent_messages = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC LIMIT 5")->fetchAll();
    } catch (PDOException $e) {}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard — Aljon Reyes Portfolio</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .admin-wrapper {
      display: grid;
      grid-template-columns: 240px 1fr;
      min-height: 100vh;
    }
    .admin-sidebar {
      background: var(--bg-panel-dark);
      color: var(--text-light);
      padding: 30px 20px;
    }
    .admin-sidebar h3 {
      font-family: var(--font-heading);
      font-size: 1.2rem;
      margin-bottom: 30px;
    }
    .admin-nav {
      list-style: none;
    }
    .admin-nav li { margin-bottom: 12px; }
    .admin-nav a {
      color: #8A9A86;
      text-decoration: none;
      font-weight: 600;
      display: block;
      padding: 10px 14px;
      border-radius: 8px;
      transition: all 0.2s;
    }
    .admin-nav a:hover, .admin-nav a.active {
      background: rgba(255,255,255,0.1);
      color: #fff;
    }
    .admin-content {
      padding: 40px;
      background: var(--bg-canvas);
    }
    .stat-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 40px;
    }
    .stat-card {
      background: var(--bg-panel);
      padding: 24px;
      border-radius: 16px;
      border: 1px solid var(--border-subtle);
    }
    .table-card {
      background: var(--bg-panel);
      border-radius: 16px;
      padding: 30px;
      border: 1px solid var(--border-subtle);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid var(--border-subtle);
    }
  </style>
</head>
<body>
  <div class="admin-wrapper">
    <aside class="admin-sidebar">
      <h3>ALJON ADMIN</h3>
      <ul class="admin-nav">
        <li><a href="index.php" class="active">📊 Overview</a></li>
        <li><a href="projects.php">📁 Manage Projects</a></li>
        <li><a href="skills.php">🛠️ Manage Skills</a></li>
        <li><a href="about.php">✍️ Edit Site Content</a></li>
        <li><a href="messages.php">📬 Messages (<?= $unread_messages ?>)</a></li>
        <li style="margin-top:40px;"><a href="logout.php" style="color:#FF5F56;">🚪 Logout</a></li>
        <li><a href="../index.php" target="_blank" style="font-size:0.85rem; margin-top:10px;">🌐 View Main Site</a></li>
      </ul>
    </aside>

    <main class="admin-content">
      <h1 class="panel-title" style="margin-bottom:8px;">PORTFOLIO CONTROL CENTER</h1>
      <p class="panel-desc" style="margin-bottom:30px;">Welcome back, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Aljon Reyes') ?></p>

      <div class="stat-grid">
        <div class="stat-card">
          <span style="font-size:0.8rem; font-weight:700; color:var(--text-muted);">TOTAL PROJECTS</span>
          <h2 style="font-family:var(--font-heading); font-size:2.5rem; margin-top:6px;"><?= $project_count ?></h2>
        </div>
        <div class="stat-card">
          <span style="font-size:0.8rem; font-weight:700; color:var(--text-muted);">ACTIVE SKILLS</span>
          <h2 style="font-family:var(--font-heading); font-size:2.5rem; margin-top:6px;"><?= $skill_count ?></h2>
        </div>
        <div class="stat-card">
          <span style="font-size:0.8rem; font-weight:700; color:var(--text-muted);">MESSAGES RECEIVED</span>
          <h2 style="font-family:var(--font-heading); font-size:2.5rem; margin-top:6px;"><?= $message_count ?></h2>
        </div>
        <div class="stat-card">
          <span style="font-size:0.8rem; font-weight:700; color:#FF5F56;">UNREAD INQUIRIES</span>
          <h2 style="font-family:var(--font-heading); font-size:2.5rem; margin-top:6px;"><?= $unread_messages ?></h2>
        </div>
      </div>

      <div class="table-card">
        <h3 style="font-family:var(--font-heading); font-size:1.4rem;">RECENT MESSAGES</h3>
        <?php if (!empty($recent_messages)): ?>
          <table>
            <thead>
              <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recent_messages as $msg): ?>
                <tr>
                  <td><?= date('M d, Y H:i', strtotime($msg['created_at'])) ?></td>
                  <td><strong><?= htmlspecialchars($msg['name']) ?></strong></td>
                  <td><?= htmlspecialchars($msg['email']) ?></td>
                  <td><?= htmlspecialchars($msg['subject']) ?></td>
                  <td>
                    <span style="padding:4px 10px; border-radius:12px; font-size:0.75rem; font-weight:700; background:<?= $msg['status'] === 'unread' ? '#FF5F56' : '#5B695C' ?>; color:#fff;">
                      <?= strtoupper($msg['status']) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p style="margin-top:15px; color:var(--text-muted);">No messages received yet.</p>
        <?php endif; ?>
      </div>
    </main>
  </div>
</body>
</html>
