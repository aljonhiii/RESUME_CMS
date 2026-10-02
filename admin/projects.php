<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$pdo = getDB();
$page_title = 'Projects — Portfolio CMS';
$current_page = 'projects';
$message = '';
$error = '';

// Handle Delete via POST (CSRF-protected)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
    verify_csrf();
    $id = intval($_POST['id']);
    if ($pdo) {
        $stmt = $pdo->prepare("SELECT image_url FROM projects WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $proj = $stmt->fetch();
        if ($proj && strpos($proj['image_url'], 'assets/images/project_upload_') === 0) {
            $imgPath = __DIR__ . '/../' . $proj['image_url'];
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $message = "Project deleted successfully.";
    }
}

// Handle Add / Edit Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $id = intval($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    if (empty($category)) {
        $category = 'Uncategorized';
    }
    $short_description = trim($_POST['short_description'] ?? '');
    $full_description = trim($_POST['full_description'] ?? '');
    $technologies = trim($_POST['technologies'] ?? '');
    if (empty($technologies)) {
        $technologies = 'PHP, MySQL';
    }
    $image_url = trim($_POST['image_url'] ?? '');
    if (empty($image_url)) {
        $image_url = 'assets/images/project1.svg';
    }
    $demo_url = trim($_POST['demo_url'] ?? '');
    $github_url = trim($_POST['github_url'] ?? '');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $sort_order = intval($_POST['sort_order'] ?? 0);

    // Validation — only title and short_description are strictly required
    if (empty($title)) {
        $error = 'Project title is required.';
    } elseif (strlen($title) < 2 || strlen($title) > 150) {
        $error = 'Project title must be between 2 and 150 characters.';
    } elseif (empty($short_description)) {
        $error = 'Short description is required.';
    } elseif (strlen($short_description) < 5) {
        $error = 'Short description must be at least 5 characters long.';
    }

    if (empty($error)) {
        // Handle image upload
        if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['project_image']['tmp_name'];
        $fileName = $_FILES['project_image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = 'project_upload_' . time() . '_' . mt_rand(1000, 9999) . '.' . $fileExtension;
            $uploadDir = __DIR__ . '/../assets/images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $image_url = 'assets/images/' . $newFileName;
            }
        }
    }

    if (!empty($title) && !empty($short_description)) {
        if ($pdo) {
            if ($id > 0) {
                $stmt = $pdo->prepare("UPDATE projects SET title = :t, category = :c, short_description = :sd, full_description = :fd, technologies = :tech, image_url = :img, demo_url = :demo, github_url = :gh, featured = :feat, sort_order = :sort WHERE id = :id");
                $stmt->execute([
                    ':t' => $title,
                    ':c' => $category,
                    ':sd' => $short_description,
                    ':fd' => $full_description,
                    ':tech' => $technologies,
                    ':img' => $image_url,
                    ':demo' => $demo_url,
                    ':gh' => $github_url,
                    ':feat' => $featured,
                    ':sort' => $sort_order,
                    ':id' => $id
                ]);
                $message = "Project updated successfully.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO projects (title, category, short_description, full_description, technologies, image_url, demo_url, github_url, featured, sort_order) VALUES (:t, :c, :sd, :fd, :tech, :img, :demo, :gh, :feat, :sort)");
                $stmt->execute([
                    ':t' => $title,
                    ':c' => $category,
                    ':sd' => $short_description,
                    ':fd' => $full_description,
                    ':tech' => $technologies,
                    ':img' => $image_url,
                    ':demo' => $demo_url,
                    ':gh' => $github_url,
                    ':feat' => $featured,
                    ':sort' => $sort_order
                ]);
                $message = "New project added successfully.";
            }
        }
    }
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

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>

<div class="page-header">
  <div class="page-title">
    <h1>Project Management</h1>
    <p class="page-subtitle">Organize and showcase your work in your portfolio.</p>
  </div>
  <div class="page-actions">
    <button class="btn btn-primary" data-drawer-target="project-drawer" data-reset-form="true" data-drawer-title="Add New Project">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add New Project
    </button>
  </div>
</div>

<?php if (!empty($message)): ?>
  <div class="admin-toast admin-toast-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if (!empty($error)): ?>
  <div class="admin-toast admin-toast-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<!-- Projects Data Table -->
<div class="admin-card">
  <div class="card-header">
    <h3>Portfolio Projects</h3>
    <span class="badge badge-accent"><?= count($projects) ?> Total</span>
  </div>
  <div class="card-body" style="padding:0;">
    <?php if (!empty($projects)): ?>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th class="thumb-cell">Thumb</th>
              <th>Title</th>
              <th>Category</th>
              <th>Technologies</th>
              <th>Featured</th>
              <th>Order</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($projects as $p): ?>
              <tr>
                <td class="thumb-cell">
                  <img src="../<?= htmlspecialchars($p['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="" class="table-thumb" onerror="this.onerror=null; this.src='../assets/images/project1.svg';">
                </td>
                <td>
                  <strong><?= htmlspecialchars($p['title']) ?></strong>
                </td>
                <td><?= htmlspecialchars($p['category']) ?></td>
                <td>
                  <span class="badge badge-dark"><?= htmlspecialchars($p['technologies']) ?></span>
                </td>
                <td>
                  <?php if ($p['featured']): ?>
                    <span class="badge badge-success">Featured</span>
                  <?php else: ?>
                    <span class="badge badge-warning">Standard</span>
                  <?php endif; ?>
                </td>
                <td><?= $p['sort_order'] ?></td>
                <td>
                    <div class="table-actions">
                      <button class="btn btn-sm btn-secondary"
                        data-drawer-target="project-drawer"
                        data-drawer-title="Edit Project #<?= $p['id'] ?>"
                        data-id="<?= $p['id'] ?>"
                        data-title="<?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?>"
                        data-category="<?= htmlspecialchars($p['category'], ENT_QUOTES, 'UTF-8') ?>"
                        data-technologies="<?= htmlspecialchars($p['technologies'], ENT_QUOTES, 'UTF-8') ?>"
                        data-image_url="<?= htmlspecialchars($p['image_url'], ENT_QUOTES, 'UTF-8') ?>"
                        data-demo_url="<?= htmlspecialchars($p['demo_url'], ENT_QUOTES, 'UTF-8') ?>"
                        data-github_url="<?= htmlspecialchars($p['github_url'], ENT_QUOTES, 'UTF-8') ?>"
                        data-short_description="<?= htmlspecialchars($p['short_description'], ENT_QUOTES, 'UTF-8') ?>"
                        data-full_description="<?= htmlspecialchars($p['full_description'], ENT_QUOTES, 'UTF-8') ?>"
                        data-sort_order="<?= $p['sort_order'] ?>"
                        data-featured="<?= $p['featured'] ?>"
                        data-img-src="../<?= htmlspecialchars($p['image_url'], ENT_QUOTES, 'UTF-8') ?>">
                        Edit
                      </button>
                      <form method="POST" style="display:inline" data-confirm="Are you sure you want to delete this project?">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
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
        <p>No projects created yet. Click "Add New Project" to get started.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Slide-Over Drawer for Adding / Editing Projects -->
<div class="admin-drawer" id="project-drawer">
  <div class="drawer-header">
    <h3 class="drawer-title">Add New Project</h3>
    <button class="drawer-close" data-close-drawer>&times;</button>
  </div>
  <form method="POST" enctype="multipart/form-data" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
    <?= csrf_field() ?>
    <div class="drawer-body">
      <input type="hidden" name="id" value="<?= $edit_project['id'] ?? 0 ?>">

      <div class="form-group">
        <label class="form-label">Project Title</label>
        <input type="text" name="title" class="form-control" required placeholder="e.g. 3D Architectural Showcase" value="<?= htmlspecialchars($edit_project['title'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control" placeholder="Web Application, 3D Interactive, API" value="<?= htmlspecialchars($edit_project['category'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Technologies (comma separated)</label>
        <input type="text" name="technologies" class="form-control" placeholder="Three.js, PHP, WebGL, Tailwind" value="<?= htmlspecialchars($edit_project['technologies'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Upload Image / Thumbnail</label>
        <input type="file" name="project_image" class="form-control" accept="image/*" data-preview="#drawer-img-preview">
        <div class="img-preview-box">
          <img id="drawer-img-preview" class="img-preview" src="<?= !empty($edit_project['image_url']) ? '../' . htmlspecialchars($edit_project['image_url']) : '' ?>" style="<?= !empty($edit_project['image_url']) ? 'display:block;' : '' ?>" alt="Preview">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Or Image URL / Path</label>
        <input type="text" name="image_url" class="form-control" value="<?= htmlspecialchars($edit_project['image_url'] ?? 'assets/images/project1.svg') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Live Demo URL (Optional)</label>
        <input type="url" name="demo_url" class="form-control" placeholder="https://..." value="<?= htmlspecialchars($edit_project['demo_url'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">GitHub Repository URL (Optional)</label>
        <input type="url" name="github_url" class="form-control" placeholder="https://github.com/..." value="<?= htmlspecialchars($edit_project['github_url'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Short Description</label>
        <textarea name="short_description" class="form-control" rows="3" required><?= htmlspecialchars($edit_project['short_description'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Full Detailed Description</label>
        <textarea name="full_description" class="form-control" rows="5"><?= htmlspecialchars($edit_project['full_description'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="<?= htmlspecialchars($edit_project['sort_order'] ?? 0) ?>" min="0">
      </div>

      <div class="form-group">
        <label class="form-checkbox">
          <input type="checkbox" name="featured" value="1" <?= ($edit_project['featured'] ?? 1) ? 'checked' : '' ?>>
          <span>Display as Featured Project</span>
        </label>
      </div>
    </div>

    <div class="drawer-footer">
      <button type="button" class="btn btn-secondary" data-close-drawer>Cancel</button>
      <button type="submit" class="btn btn-accent">Save Project</button>
    </div>
  </form>
</div>

<?php if ($edit_project): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      AdminDrawer.open('project-drawer');
    });
  </script>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
