<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$pdo = getDB();
$page_title = 'Skills — Portfolio CMS';
$current_page = 'skills';
$message = '';
$error = '';

// Handle Delete via POST (CSRF-protected)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
    verify_csrf();
    $id = intval($_POST['id']);
    if ($pdo) {
        $stmt = $pdo->prepare("DELETE FROM skills WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $message = "Skill deleted successfully.";
    }
}

// Edit skill single fetch
$edit_skill = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    if ($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM skills WHERE id = :id");
        $stmt->execute([':id' => $edit_id]);
        $edit_skill = $stmt->fetch();
    }
}

// Handle Add / Edit Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    if (empty($category)) {
        $category = 'General';
    }
    $proficiency = trim($_POST['proficiency_display'] ?? '');
    if (empty($proficiency)) {
        $proficiency = '90%';
    }
    $description = trim($_POST['description'] ?? '');
    $sort_order = intval($_POST['sort_order'] ?? 0);

    if (empty($name)) {
        $error = 'Skill name is required.';
    } elseif (strlen($name) < 2 || strlen($name) > 100) {
        $error = 'Skill name must be between 2 and 100 characters.';
    }

    if (empty($error) && $pdo) {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE skills SET name = :n, category = :c, proficiency_display = :p, description = :d, sort_order = :s WHERE id = :id");
            $stmt->execute([':n' => $name, ':c' => $category, ':p' => $proficiency, ':d' => $description, ':s' => $sort_order, ':id' => $id]);
            $message = "Skill updated successfully.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO skills (name, category, proficiency_display, description, sort_order) VALUES (:n, :c, :p, :d, :s)");
            $stmt->execute([':n' => $name, ':c' => $category, ':p' => $proficiency, ':d' => $description, ':s' => $sort_order]);
            $message = "Skill added successfully.";
        }
        $edit_skill = null;
    }
}

// Fetch Skills List
$skills = [];
if ($pdo) {
    $skills = $pdo->query("SELECT * FROM skills ORDER BY sort_order ASC, id ASC")->fetchAll();
}

// Group skills by category
$grouped = [];
foreach ($skills as $s) {
    $cat = $s['category'] ?: 'Uncategorized';
    $grouped[$cat][] = $s;
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>

<div class="page-header">
  <div class="page-title">
    <h1>Skills & Proficiency</h1>
    <p class="page-subtitle">Organize tech stack metrics by category.</p>
  </div>
  <div class="page-actions">
    <button class="btn btn-primary" data-drawer-target="skill-drawer" data-reset-form="true" data-drawer-title="Add New Skill">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add New Skill
    </button>
  </div>
</div>

<?php if (!empty($message)): ?>
  <div class="admin-toast admin-toast-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<!-- Grouped Skills Tables -->
<?php if (!empty($grouped)): ?>
  <?php foreach ($grouped as $category => $cat_skills): ?>
    <div class="admin-card">
      <div class="card-header">
        <h3><?= htmlspecialchars($category) ?></h3>
        <span class="badge badge-dark"><?= count($cat_skills) ?> Skills</span>
      </div>
      <div class="card-body" style="padding:0;">
        <div class="table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Skill Name</th>
                <th>Metric / Level</th>
                <th>Description</th>
                <th>Order</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cat_skills as $s): ?>
                <tr>
                  <td><strong><?= htmlspecialchars($s['name']) ?></strong></td>
                  <td>
                    <span class="badge badge-accent" style="font-size:0.85rem; font-family:var(--font-heading);">
                      <?= htmlspecialchars($s['proficiency_display']) ?>
                    </span>
                  </td>
                  <td><?= htmlspecialchars($s['description'] ?? '—') ?></td>
                  <td><?= $s['sort_order'] ?></td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-sm btn-secondary"
                        data-drawer-target="skill-drawer"
                        data-drawer-title="Edit Skill #<?= $s['id'] ?>"
                        data-id="<?= $s['id'] ?>"
                        data-name="<?= htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8') ?>"
                        data-category="<?= htmlspecialchars($s['category'], ENT_QUOTES, 'UTF-8') ?>"
                        data-proficiency_display="<?= htmlspecialchars($s['proficiency_display'], ENT_QUOTES, 'UTF-8') ?>"
                        data-description="<?= htmlspecialchars($s['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        data-sort_order="<?= $s['sort_order'] ?>">
                        Edit
                      </button>
                      <form method="POST" style="display:inline" data-confirm="Are you sure you want to delete this skill?">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="admin-card">
    <div style="padding:40px; text-align:center; color: var(--admin-text-muted);">
      <p>No skills created yet. Click "Add New Skill" to get started.</p>
    </div>
  </div>
<?php endif; ?>

<!-- Slide-Over Drawer for Adding / Editing Skills -->
<div class="admin-drawer" id="skill-drawer">
  <div class="drawer-header">
    <h3 class="drawer-title">Add New Skill</h3>
    <button class="drawer-close" data-close-drawer>&times;</button>
  </div>
  <form method="POST" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
    <?= csrf_field() ?>
    <div class="drawer-body">
      <input type="hidden" name="id" value="<?= $edit_skill['id'] ?? 0 ?>">

      <div class="form-group">
        <label class="form-label">Skill Name</label>
        <input type="text" name="name" class="form-control" required placeholder="e.g. PHP, Three.js, MySQL" value="<?= htmlspecialchars($edit_skill['name'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control" required placeholder="Backend Development, 3D & Interactive" value="<?= htmlspecialchars($edit_skill['category'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Metric / Display Badge</label>
        <input type="text" name="proficiency_display" class="form-control" placeholder="e.g. 95%, Expert, Advanced" value="<?= htmlspecialchars($edit_skill['proficiency_display'] ?? '90%') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Brief Description</label>
        <textarea name="description" class="form-control" rows="3" placeholder="OOP architecture, custom API design, database query optimization"><?= htmlspecialchars($edit_skill['description'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="<?= htmlspecialchars($edit_skill['sort_order'] ?? 0) ?>" min="0">
      </div>
    </div>

    <div class="drawer-footer">
      <button type="button" class="btn btn-secondary" data-close-drawer>Cancel</button>
      <button type="submit" class="btn btn-accent">Save Skill</button>
    </div>
  </form>
</div>

<?php if ($edit_skill): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      AdminDrawer.open('skill-drawer');
    });
  </script>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
