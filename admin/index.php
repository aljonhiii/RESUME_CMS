<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$pdo = getDB();
$page_title = 'Dashboard — Portfolio CMS';
$current_page = 'index';

// Fetch statistics
$project_count = 0;
$skill_count = 0;
$process_count = 0;
$message_count = 0;
$unread_messages = 0;
$recent_messages = [];

if ($pdo) {
    try {
        $project_count = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        $skill_count = $pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn();
        $process_count = $pdo->query("SELECT COUNT(*) FROM process_steps")->fetchColumn();
        $message_count = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
        $unread_messages = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'unread'")->fetchColumn();
        $recent_messages = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC LIMIT 5")->fetchAll();
    } catch (PDOException $e) {}
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>

<div class="page-header">
  <div class="page-title">
    <h1>Dashboard</h1>
    <p class="page-subtitle">Welcome back, <?= htmlspecialchars(get_admin_name()) ?>. Here is your portfolio overview.</p>
  </div>
  <div class="page-actions">
    <a href="projects.php" class="btn btn-primary">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Project
    </a>
    <a href="messages.php" class="btn btn-secondary">
      <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      Inquiries (<?= $unread_messages ?>)
    </a>
  </div>
</div>

<!-- Stat Cards Grid -->
<div class="grid-stats">
  <div class="stat-card">
    <div class="stat-icon">
      <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-number"><?= $project_count ?></div>
      <div class="stat-label">Total Projects</div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon">
      <svg viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-number"><?= $skill_count ?></div>
      <div class="stat-label">Active Skills</div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon">
      <svg viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 17 22 12"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-number"><?= $process_count ?></div>
      <div class="stat-label">Process Steps</div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon" style="background-color: var(--admin-accent);">
      <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-number"><?= $unread_messages ?></div>
      <div class="stat-label">Unread Messages</div>
    </div>
  </div>
</div>

<!-- Recent Messages Card -->
<div class="admin-card">
  <div class="card-header">
    <h3>Recent Messages</h3>
    <a href="messages.php" class="btn btn-sm btn-secondary">View All Messages</a>
  </div>
  <div class="card-body" style="padding: 0;">
    <?php if (!empty($recent_messages)): ?>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Name</th>
              <th>Email</th>
              <th>Subject</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recent_messages as $msg): ?>
              <tr>
                <td><?= date('M d, Y', strtotime($msg['created_at'])) ?></td>
                <td><strong><?= htmlspecialchars($msg['name']) ?></strong></td>
                <td><?= htmlspecialchars($msg['email']) ?></td>
                <td><?= htmlspecialchars($msg['subject'] ?? 'No Subject') ?></td>
                <td>
                  <?php if ($msg['status'] === 'unread'): ?>
                    <span class="badge badge-warning">Unread</span>
                  <?php else: ?>
                    <span class="badge badge-success">Read</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="messages.php" class="btn btn-sm btn-secondary">View</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div style="padding: 32px; text-align: center; color: var(--admin-text-muted);">
        <p>No messages received yet.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
