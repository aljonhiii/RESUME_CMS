<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$pdo = getDB();
$page_title = 'Process Steps — Portfolio CMS';
$current_page = 'process';
$message = '';
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($pdo) {
        $stmt = $pdo->prepare("DELETE FROM process_steps WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $message = "Process step deleted successfully.";
    }
}

// Edit step single fetch
$edit_step = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    if ($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM process_steps WHERE id = :id");
        $stmt->execute([':id' => $edit_id]);
        $edit_step = $stmt->fetch();
    }
}

// Handle Add / Edit Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $id = intval($_POST['id'] ?? 0);
    $step_number = trim($_POST['step_number'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sort_order = intval($_POST['sort_order'] ?? 0);

    if (empty($step_number)) {
        $error = 'Step number is required.';
    } elseif (empty($title)) {
        $error = 'Step title is required.';
    } elseif (strlen($title) < 2 || strlen($title) > 150) {
        $error = 'Step title must be between 2 and 150 characters.';
    } elseif (empty($description)) {
        $error = 'Description is required.';
    }

    if (empty($error) && $pdo) {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE process_steps SET step_number = :sn, title = :t, description = :d, sort_order = :s WHERE id = :id");
            $stmt->execute([':sn' => $step_number, ':t' => $title, ':d' => $description, ':s' => $sort_order, ':id' => $id]);
            $message = "Process step updated successfully.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO process_steps (step_number, title, description, sort_order) VALUES (:sn, :t, :d, :s)");
            $stmt->execute([':sn' => $step_number, ':t' => $title, ':d' => $description, ':s' => $sort_order]);
            $message = "Process step added successfully.";
        }
        $edit_step = null;
    }
}

// Fetch Steps
$steps = [];
if ($pdo) {
    $steps = $pdo->query("SELECT * FROM process_steps ORDER BY sort_order ASC, id ASC")->fetchAll();
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>

<div class="page-header">
  <div class="page-title">
    <h1>Development Process Steps</h1>
    <p class="page-subtitle">Manage the workflow steps shown on your portfolio homepage in an interactive gallery or sequence list.</p>
  </div>
  <div class="page-actions" style="display:flex; gap:10px; align-items:center;">
    <div class="btn-group" style="display:flex; gap:6px; background: rgba(28,28,26,0.06); padding:4px; border-radius:var(--radius-pill);">
      <button type="button" class="btn btn-sm btn-secondary" id="btn-view-carousel" style="background:var(--admin-panel-dark); color:#fff; border-radius:var(--radius-pill);" onclick="setProcessView('carousel')">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M7 12h10M12 7v10"/></svg>
        Gallery Carousel
      </button>
      <button type="button" class="btn btn-sm btn-secondary" id="btn-view-table" style="background:transparent; border-color:transparent; color:var(--admin-text-main); border-radius:var(--radius-pill);" onclick="setProcessView('table')">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        List Table
      </button>
    </div>
    <button class="btn btn-primary" data-drawer-target="process-drawer" data-reset-form="true" data-drawer-title="Add Process Step">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Process Step
    </button>
  </div>
</div>

<?php if (!empty($message)): ?>
  <div class="admin-toast admin-toast-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<!-- Process Steps Gallery Carousel View -->
<div id="process-carousel-view" class="process-carousel-wrapper">
  <?php if (!empty($steps)): ?>
    <div class="process-carousel-card" id="carousel-card">
      <div class="carousel-card-top">
        <div class="step-badge-group">
          <span class="carousel-step-num" id="slide-step-num">01</span>
          <span class="carousel-step-count" id="slide-step-count">Step 1 of <?= count($steps) ?></span>
        </div>
        <span class="carousel-sort-order" id="slide-sort-order">Sort Order: 0</span>
      </div>

      <div class="carousel-card-body">
        <h2 class="carousel-slide-title" id="slide-title">TITLE</h2>
        <p class="carousel-slide-desc" id="slide-desc">Description...</p>
      </div>

      <div class="carousel-card-actions">
        <button type="button" class="btn btn-secondary" id="slide-edit-btn" data-drawer-target="process-drawer">
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit Step
        </button>
        <a href="#" class="btn btn-danger" id="slide-delete-btn" data-confirm="Delete this process step?">
          Delete Step
        </a>
      </div>
    </div>

    <!-- Carousel Controls Bar -->
    <div class="carousel-controls-bar">
      <button type="button" class="carousel-nav-btn" id="prev-step-btn" onclick="stepCarousel(-1)" aria-label="Previous Step">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        <span>Prev</span>
      </button>

      <!-- Step Indicator Pills -->
      <div class="carousel-step-pills" id="carousel-pills-container">
        <?php foreach ($steps as $idx => $st): ?>
          <button type="button" class="step-pill-item <?= $idx === 0 ? 'active' : '' ?>" onclick="goToSlide(<?= $idx ?>)">
            Step <?= htmlspecialchars($st['step_number']) ?>
          </button>
        <?php endforeach; ?>
      </div>

      <button type="button" class="carousel-nav-btn" id="next-step-btn" onclick="stepCarousel(1)" aria-label="Next Step">
        <span>Next</span>
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>
  <?php else: ?>
    <div style="padding:50px; text-align:center; color: var(--admin-text-muted);">
      <p>No process steps defined yet. Click "Add Process Step" to create your first step.</p>
    </div>
  <?php endif; ?>
</div>

<!-- Process Steps Table View (Hidden by default) -->
<div id="process-table-view" class="admin-card" style="display:none;">
  <div class="card-header">
    <h3>Workflow Sequence</h3>
    <span class="badge badge-accent"><?= count($steps) ?> Steps</span>
  </div>
  <div class="card-body" style="padding:0;">
    <?php if (!empty($steps)): ?>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Step #</th>
              <th>Title</th>
              <th>Description</th>
              <th>Order</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($steps as $st): ?>
              <tr>
                <td>
                  <span class="badge badge-dark" style="font-size:0.9rem; font-family:var(--font-heading);">
                    <?= htmlspecialchars($st['step_number']) ?>
                  </span>
                </td>
                <td><strong><?= htmlspecialchars($st['title']) ?></strong></td>
                <td><?= htmlspecialchars($st['description']) ?></td>
                <td><?= $st['sort_order'] ?></td>
                <td>
                  <div class="table-actions">
                    <button class="btn btn-sm btn-secondary"
                      data-drawer-target="process-drawer"
                      data-drawer-title="Edit Step #<?= $st['id'] ?>"
                      data-id="<?= $st['id'] ?>"
                      data-step_number="<?= htmlspecialchars($st['step_number']) ?>"
                      data-title="<?= htmlspecialchars($st['title']) ?>"
                      data-description="<?= htmlspecialchars($st['description']) ?>"
                      data-sort_order="<?= $st['sort_order'] ?>">
                      Edit
                    </button>
                    <a href="process.php?action=delete&id=<?= $st['id'] ?>" class="btn btn-sm btn-danger" data-confirm="Delete this process step?">Delete</a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div style="padding:40px; text-align:center; color: var(--admin-text-muted);">
        <p>No process steps defined. Click "Add Process Step" to create one.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Slide-Over Drawer for Adding / Editing Process Steps -->
<div class="admin-drawer" id="process-drawer">
  <div class="drawer-header">
    <h3 class="drawer-title">Add Process Step</h3>
    <button class="drawer-close" data-close-drawer>&times;</button>
  </div>
  <form method="POST" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
    <?= csrf_field() ?>
    <div class="drawer-body">
      <input type="hidden" name="id" value="<?= $edit_step['id'] ?? 0 ?>">

      <div class="form-group">
        <label class="form-label">Step Number / Identifier</label>
        <input type="text" name="step_number" class="form-control" required placeholder="e.g. 01, 02, 03" value="<?= htmlspecialchars($edit_step['step_number'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Step Title</label>
        <input type="text" name="title" class="form-control" required placeholder="e.g. DISCOVERY & ARCHITECTURE" value="<?= htmlspecialchars($edit_step['title'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label class="form-label">Detailed Description</label>
        <textarea name="description" class="form-control" rows="4" required placeholder="Explain the objectives, deliverables, and milestones of this stage."><?= htmlspecialchars($edit_step['description'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="<?= htmlspecialchars($edit_step['sort_order'] ?? 0) ?>" min="0">
      </div>
    </div>

    <div class="drawer-footer">
      <button type="button" class="btn btn-secondary" data-close-drawer>Cancel</button>
      <button type="submit" class="btn btn-accent">Save Process Step</button>
    </div>
  </form>
</div>

<!-- Process Steps Gallery Carousel Controller JS -->
<script>
  const processStepsData = <?= json_encode($steps) ?>;
  let currentSlideIndex = 0;

  function renderCarouselSlide(index) {
    if (!processStepsData || processStepsData.length === 0) return;
    if (index < 0) index = 0;
    if (index >= processStepsData.length) index = processStepsData.length - 1;

    currentSlideIndex = index;
    const step = processStepsData[index];
    const cardEl = document.getElementById('carousel-card');

    if (cardEl) {
      cardEl.classList.add('anim-fade');
      setTimeout(() => {
        document.getElementById('slide-step-num').textContent = step.step_number || (index + 1).toString().padStart(2, '0');
        document.getElementById('slide-step-count').textContent = `Step ${index + 1} of ${processStepsData.length}`;
        document.getElementById('slide-sort-order').textContent = `Sort Order: ${step.sort_order}`;
        document.getElementById('slide-title').textContent = step.title;
        document.getElementById('slide-desc').textContent = step.description;

        // Edit button data bindings
        const editBtn = document.getElementById('slide-edit-btn');
        if (editBtn) {
          editBtn.setAttribute('data-drawer-title', `Edit Step #${step.id}`);
          editBtn.setAttribute('data-id', step.id);
          editBtn.setAttribute('data-step_number', step.step_number || '');
          editBtn.setAttribute('data-title', step.title || '');
          editBtn.setAttribute('data-description', step.description || '');
          editBtn.setAttribute('data-sort_order', step.sort_order || 0);
        }

        // Delete button href binding
        const deleteBtn = document.getElementById('slide-delete-btn');
        if (deleteBtn) {
          deleteBtn.setAttribute('href', `process.php?action=delete&id=${step.id}`);
        }

        cardEl.classList.remove('anim-fade');
      }, 150);
    }

    // Update pill highlights
    const pills = document.querySelectorAll('#carousel-pills-container .step-pill-item');
    pills.forEach((pill, pIdx) => {
      if (pIdx === currentSlideIndex) {
        pill.classList.add('active');
      } else {
        pill.classList.remove('active');
      }
    });

    // Update prev/next button state
    const prevBtn = document.getElementById('prev-step-btn');
    const nextBtn = document.getElementById('next-step-btn');
    if (prevBtn) prevBtn.disabled = (index === 0);
    if (nextBtn) nextBtn.disabled = (index === processStepsData.length - 1);
  }

  function stepCarousel(delta) {
    renderCarouselSlide(currentSlideIndex + delta);
  }

  function goToSlide(index) {
    renderCarouselSlide(index);
  }

  function setProcessView(mode) {
    const carouselView = document.getElementById('process-carousel-view');
    const tableView = document.getElementById('process-table-view');
    const btnCarousel = document.getElementById('btn-view-carousel');
    const btnTable = document.getElementById('btn-view-table');

    if (mode === 'carousel') {
      carouselView.style.display = 'block';
      tableView.style.display = 'none';

      btnCarousel.style.background = 'var(--admin-panel-dark)';
      btnCarousel.style.color = '#fff';
      btnCarousel.style.borderColor = 'transparent';

      btnTable.style.background = 'transparent';
      btnTable.style.color = 'var(--admin-text-main)';
      btnTable.style.borderColor = 'transparent';
    } else {
      carouselView.style.display = 'none';
      tableView.style.display = 'block';

      btnTable.style.background = 'var(--admin-panel-dark)';
      btnTable.style.color = '#fff';
      btnTable.style.borderColor = 'transparent';

      btnCarousel.style.background = 'transparent';
      btnCarousel.style.color = 'var(--admin-text-main)';
      btnCarousel.style.borderColor = 'transparent';
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    if (processStepsData && processStepsData.length > 0) {
      renderCarouselSlide(0);
    }

    // Keyboard Arrow navigation for Carousel
    window.addEventListener('keydown', function(e) {
      const activeEl = document.activeElement;
      if (activeEl && ['INPUT', 'TEXTAREA', 'SELECT'].includes(activeEl.tagName)) return;
      if (document.querySelector('.admin-drawer.open')) return;

      const carouselView = document.getElementById('process-carousel-view');
      if (carouselView && carouselView.style.display !== 'none') {
        if (e.key === 'ArrowRight') {
          stepCarousel(1);
        } else if (e.key === 'ArrowLeft') {
          stepCarousel(-1);
        }
      }
    });
  });
</script>

<?php if ($edit_step): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      AdminDrawer.open('process-drawer');
    });
  </script>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
