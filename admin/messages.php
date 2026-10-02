<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$pdo = getDB();
$page_title = 'Messages — Portfolio CMS';
$current_page = 'messages';
$message = '';

// Handle Actions via POST only (CSRF-protected)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['id'])) {
    verify_csrf();
    $id = intval($_POST['id']);
    if ($pdo) {
        if ($_POST['action'] === 'read') {
            $pdo->prepare("UPDATE contact_messages SET status = 'read' WHERE id = :id")->execute([':id' => $id]);
            $message = "Message marked as read.";
        } elseif ($_POST['action'] === 'unread') {
            $pdo->prepare("UPDATE contact_messages SET status = 'unread' WHERE id = :id")->execute([':id' => $id]);
            $message = "Message marked as unread.";
        } elseif ($_POST['action'] === 'delete') {
            $pdo->prepare("DELETE FROM contact_messages WHERE id = :id")->execute([':id' => $id]);
            $message = "Message deleted successfully.";
        }
    }
}

// Fetch Messages
$messages_list = [];
if ($pdo) {
    $messages_list = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC")->fetchAll();
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>

<div class="page-header">
  <div class="page-title">
    <h1>Contact Inquiries</h1>
    <p class="page-subtitle">Read and reply to messages from your portfolio visitors.</p>
  </div>
</div>

<?php if (!empty($message)): ?>
  <div class="admin-toast admin-toast-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="admin-card">
  <div class="card-header">
    <h3>Inbox</h3>
    <span class="badge badge-accent"><?= count($messages_list) ?> Total</span>
  </div>
  <div class="card-body" style="padding:0;">
    <?php if (!empty($messages_list)): ?>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Sender</th>
              <th>Subject</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($messages_list as $m): ?>
              <tr>
                <td><?= date('M d, Y H:i', strtotime($m['created_at'])) ?></td>
                <td>
                  <strong><?= htmlspecialchars($m['name']) ?></strong><br>
                  <span style="font-size:0.82rem; color:var(--admin-text-muted);"><?= htmlspecialchars($m['email']) ?></span>
                </td>
                <td><?= htmlspecialchars($m['subject'] ?: 'No Subject') ?></td>
                <td>
                  <?php if ($m['status'] === 'unread'): ?>
                    <span class="badge badge-warning">Unread</span>
                  <?php else: ?>
                    <span class="badge badge-success">Read</span>
                  <?php endif; ?>
                </td>
                <td>
                    <div class="table-actions">
                      <button class="btn btn-sm btn-secondary"
                        data-modal-target="message-modal"
                        data-subject="<?= htmlspecialchars($m['subject'] ?: 'No Subject') ?>"
                        data-name="<?= htmlspecialchars($m['name']) ?>"
                        data-email="<?= htmlspecialchars($m['email']) ?>"
                        data-date="<?= date('F j, Y g:i A', strtotime($m['created_at'])) ?>"
                        data-body="<?= htmlspecialchars($m['message']) ?>">
                        Read Message
                      </button>
                      <?php if ($m['status'] === 'unread'): ?>
                        <form method="POST" style="display:inline">
                          <?= csrf_field() ?>
                          <input type="hidden" name="action" value="read">
                          <input type="hidden" name="id" value="<?= $m['id'] ?>">
                          <button type="submit" class="btn btn-sm btn-secondary">Mark Read</button>
                        </form>
                      <?php else: ?>
                        <form method="POST" style="display:inline">
                          <?= csrf_field() ?>
                          <input type="hidden" name="action" value="unread">
                          <input type="hidden" name="id" value="<?= $m['id'] ?>">
                          <button type="submit" class="btn btn-sm btn-secondary">Unread</button>
                        </form>
                      <?php endif; ?>
                      <form method="POST" style="display:inline" data-confirm="Are you sure you want to delete this message?">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $m['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                      </form>
                    </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div style="padding:40px; text-align:center; color: var(--admin-text-muted);">
        <p>No messages received yet.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Modal Overlay for Reading Message Content -->
<div class="admin-modal" id="message-modal">
  <div class="modal-header">
    <h3 class="modal-title" data-field="subject">Message Details</h3>
    <button class="drawer-close" data-close-modal>&times;</button>
  </div>
  <div class="modal-body">
    <div style="margin-bottom: 16px; border-bottom: 1px solid var(--admin-border); padding-bottom: 12px;">
      <div style="font-weight: 700; font-size: 1.1rem; color: var(--admin-text-main);" data-field="name">Sender Name</div>
      <div style="color: var(--admin-accent); font-size: 0.9rem;" data-field="email">sender@email.com</div>
      <div style="color: var(--admin-text-muted); font-size: 0.8rem; margin-top: 4px;" data-field="date">Date</div>
    </div>
    <div style="font-size: 0.95rem; line-height: 1.6; white-space: pre-wrap; color: var(--admin-text-main);" data-field="body">
      Message content body...
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-close-modal>Close</button>
    <a href="#" class="btn btn-accent" data-field="reply-link" target="_blank">
      <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      Reply via Email
    </a>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
