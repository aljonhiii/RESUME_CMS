<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$pdo = getDB();
$message = '';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($pdo) {
        if ($_GET['action'] === 'read') {
            $pdo->prepare("UPDATE contact_messages SET status = 'read' WHERE id = :id")->execute([':id' => $id]);
            $message = "Message marked as read.";
        } elseif ($_GET['action'] === 'delete') {
            $pdo->prepare("DELETE FROM contact_messages WHERE id = :id")->execute([':id' => $id]);
            $message = "Message deleted.";
        }
    }
}

$messages = [];
if ($pdo) {
    $messages = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC")->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Messages — Admin</title>
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
        <li><a href="skills.php">🛠️ Manage Skills</a></li>
        <li><a href="about.php">✍️ Edit Site Content</a></li>
        <li><a href="messages.php" class="active">📬 Messages</a></li>
        <li style="margin-top:40px;"><a href="logout.php" style="color:#FF5F56;">🚪 Logout</a></li>
      </ul>
    </aside>

    <main class="admin-content">
      <h1 class="panel-title" style="margin-bottom:24px;">CONTACT INQUIRIES & MESSAGES</h1>

      <?php if (!empty($message)): ?>
        <div style="background:#5B695C; color:#fff; padding:12px; border-radius:8px; margin-bottom:20px; font-weight:600;">
          <?= htmlspecialchars($message) ?>
        </div>
      <?php endif; ?>

      <div class="card">
        <h3>INCOMING MESSAGES</h3>
        <?php if (!empty($messages)): ?>
          <table>
            <thead>
              <tr>
                <th>Date</th>
                <th>Name & Email</th>
                <th>Subject</th>
                <th>Message Content</th>
                <th>Status / Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($messages as $m): ?>
                <tr style="<?= $m['status'] === 'unread' ? 'background:rgba(255,95,86,0.05); font-weight:600;' : '' ?>">
                  <td><?= date('M d, Y H:i', strtotime($m['created_at'])) ?></td>
                  <td>
                    <strong><?= htmlspecialchars($m['name']) ?></strong><br>
                    <a href="mailto:<?= htmlspecialchars($m['email']) ?>" style="color:#5B695C; font-size:0.85rem;"><?= htmlspecialchars($m['email']) ?></a>
                  </td>
                  <td><?= htmlspecialchars($m['subject']) ?></td>
                  <td style="max-width:300px; font-size:0.875rem;"><?= nl2br(htmlspecialchars($m['message'])) ?></td>
                  <td>
                    <?php if ($m['status'] === 'unread'): ?>
                      <a href="messages.php?action=read&id=<?= $m['id'] ?>" style="color:#27C93F; font-weight:700; margin-right:8px;">Mark Read</a>
                    <?php endif; ?>
                    <a href="messages.php?action=delete&id=<?= $m['id'] ?>" onclick="return confirm('Delete message?')" style="color:#FF5F56; font-weight:700;">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p style="margin-top:15px; color:var(--text-muted);">No inquiries in database yet.</p>
        <?php endif; ?>
      </div>
    </main>
  </div>
</body>
</html>
