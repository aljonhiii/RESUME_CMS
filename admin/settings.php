<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$pdo = getDB();
$page_title = 'Site Settings — Portfolio CMS';
$current_page = 'settings';
$message = '';

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    verify_csrf();

    // Handle text settings
    $setting_keys = [
        'hero_title_1', 'hero_title_accent', 'hero_title_2', 'hero_description',
        'hero_portrait_img',
        'about_heading', 'about_p1', 'about_p2', 'about_p3', 'about_p4',
        'internship_title', 'internship_desc', 'internship_img',
        'contact_email', 'github_url', 'linkedin_url', 'location_text'
    ];

    foreach ($setting_keys as $key) {
        if (isset($_POST[$key])) {
            $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
            $stmt->execute([':k' => $key, ':v' => trim($_POST[$key])]);
        }
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
                $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES ('hero_portrait_img', :v) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                $stmt->execute([':v' => $imgPath]);
                $message .= " Face photo uploaded successfully!";
            }
        }
    }

    // Handle Internship Image Upload
    if (isset($_FILES['internship_image_file']) && $_FILES['internship_image_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['internship_image_file']['tmp_name'];
        $fileName = $_FILES['internship_image_file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = 'internship-preview.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/../assets/images/';
            $destPath = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imgPath = 'assets/images/' . $newFileName;
                $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES ('internship_img', :v) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                $stmt->execute([':v' => $imgPath]);
                $message .= " Internship image uploaded successfully!";
            }
        }
    }

    $message = "Site settings updated successfully!" . $message;
}

// Load current settings with defaults
$settings = [
    'hero_title_1' => 'FULL-STACK',
    'hero_title_accent' => '& SOFTWARE',
    'hero_title_2' => 'DEVELOPER',
    'hero_description' => 'Transforming ideas into practical digital experiences through web development, mobile applications, and creative technology.',
    'hero_portrait_img' => 'assets/images/aljon-face1.png',
    'about_heading' => 'BUILDING MEANINGFUL APPLICATIONS & DIGITAL EXPERIENCES',
    'about_p1' => 'Hey, I\'m Aljon, a Computer Science student specializing in Application Development at Western Mindanao State University (WMSU).',
    'about_p2' => 'Currently pursuing my degree at WMSU, I enjoy turning complex ideas into practical working systems, designing intuitive interfaces, and developing robust database-driven applications that solve real-world problems.',
    'about_p3' => 'My experience includes PHP 8+ and MySQL web architectures, REST APIs, cross-platform mobile development with React Native, 3D WebGL scenes, and software engineering principles.',
    'about_p4' => 'Currently completing my internship training, where I apply software engineering principles, full-stack web development, and database architecture to real-world production environments.',
    'internship_title' => 'INTERNSHIP & PRACTICAL EXPERIENCE',
    'internship_desc' => 'Currently completing my internship training, where I apply software engineering principles, full-stack web development, and database architecture to real-world production environments.',
    'internship_img' => 'assets/images/internship_preview.png',
    'contact_email' => 'aljonreyes.dev@gmail.com',
    'github_url' => '#',
    'linkedin_url' => '#',
    'location_text' => 'Zamboanga City, Philippines'
];

if ($pdo) {
    $rows = $pdo->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll();
    foreach ($rows as $r) {
        $settings[$r['setting_key']] = $r['setting_value'];
    }
    $skills_summary = $pdo->query("SELECT * FROM skills ORDER BY sort_order ASC, id ASC")->fetchAll();
} else {
    $skills_summary = [];
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>

<div class="page-header">
  <div class="page-title">
    <h1>Site Settings</h1>
    <p class="page-subtitle">Configure hero banner text, about section, face photo, and social links.</p>
  </div>
</div>

<?php if (!empty($message)): ?>
  <div class="admin-toast admin-toast-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<!-- Tabs -->
<div class="admin-tabs">
  <button type="button" class="tab-btn active" data-tab="hero">Hero & Portrait</button>
  <button type="button" class="tab-btn" data-tab="about">About Me</button>
  <button type="button" class="tab-btn" data-tab="contact">Contact & Social</button>
  <button type="button" class="tab-btn" data-tab="skills">Skills & Tech Stack</button>
</div>

<form method="POST" enctype="multipart/form-data" novalidate>
  <?= csrf_field() ?>

  <!-- Tab 1: Hero & Portrait -->
  <div class="tab-content active" id="tab-hero">
    <div class="admin-card">
      <div class="card-header">
        <h3>Developer Portrait Photo</h3>
      </div>
      <div class="card-body">
        <div style="display:flex; gap:24px; align-items:center; flex-wrap:wrap;">
          <div style="width:110px; height:130px; border-radius:var(--radius-md); overflow:hidden; border:2px solid var(--admin-border-strong); background-color:var(--admin-bg);">
            <img src="../<?= htmlspecialchars($settings['hero_portrait_img']) ?>" alt="Portrait" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='../assets/images/aljon-face1.png'">
          </div>
          <div style="flex:1; min-width:260px;">
            <div class="form-group">
              <label class="form-label">Upload Face Photo (PNG, JPG, WEBP, SVG)</label>
              <input type="file" name="portrait_image" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
              <label class="form-label">Or Custom Image URL / Path</label>
              <input type="text" name="hero_portrait_img" class="form-control" value="<?= htmlspecialchars($settings['hero_portrait_img']) ?>">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="card-header">
        <h3>Hero Intro Headlines</h3>
      </div>
      <div class="card-body">
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
          <div class="form-group">
            <label class="form-label">Hero Title Line 1</label>
            <input type="text" name="hero_title_1" class="form-control" value="<?= htmlspecialchars($settings['hero_title_1']) ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Accent Title (Serif Italic)</label>
            <input type="text" name="hero_title_accent" class="form-control" value="<?= htmlspecialchars($settings['hero_title_accent']) ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Hero Title Line 2</label>
            <input type="text" name="hero_title_2" class="form-control" value="<?= htmlspecialchars($settings['hero_title_2']) ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Hero Description</label>
          <textarea name="hero_description" class="form-control" rows="3"><?= htmlspecialchars($settings['hero_description']) ?></textarea>
        </div>
      </div>
    </div>
  </div>

  <!-- Tab 2: About Me -->
  <div class="tab-content" id="tab-about">
    <div class="admin-card">
      <div class="card-header">
        <h3>About Me Content</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label class="form-label">Main Heading</label>
          <input type="text" name="about_heading" class="form-control" value="<?= htmlspecialchars($settings['about_heading']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label">Paragraph 1 (Intro Callout)</label>
          <textarea name="about_p1" class="form-control" rows="3"><?= htmlspecialchars($settings['about_p1']) ?></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Paragraph 2 (Education & Background)</label>
          <textarea name="about_p2" class="form-control" rows="3"><?= htmlspecialchars($settings['about_p2']) ?></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Paragraph 3 (Technical Focus)</label>
          <textarea name="about_p3" class="form-control" rows="3"><?= htmlspecialchars($settings['about_p3']) ?></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Paragraph 4 (Internship & Practical Experience)</label>
          <textarea name="about_p4" class="form-control" rows="3"><?= htmlspecialchars($settings['about_p4']) ?></textarea>
        </div>
      </div>
    </div>

    <!-- Internship Feature Card Settings -->
    <div class="admin-card">
      <div class="card-header">
        <h3>Vertical Internship Feature Block (Header, Image & Description)</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label class="form-label">Internship Header Title</label>
          <input type="text" name="internship_title" class="form-control" value="<?= htmlspecialchars($settings['internship_title']) ?>">
        </div>

        <div style="display:flex; gap:24px; align-items:center; flex-wrap:wrap; margin-bottom:16px;">
          <div style="width:180px; height:110px; border-radius:var(--radius-md); overflow:hidden; border:2px solid var(--admin-border-strong); background-color:var(--admin-bg);">
            <img src="../<?= htmlspecialchars($settings['internship_img']) ?>" alt="Internship Image" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='../assets/images/aljon-face1.png'">
          </div>
          <div style="flex:1; min-width:260px;">
            <div class="form-group">
              <label class="form-label">Upload Internship Image (PNG, JPG, WEBP, SVG)</label>
              <input type="file" name="internship_image_file" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
              <label class="form-label">Or Custom Image URL / Path</label>
              <input type="text" name="internship_img" class="form-control" value="<?= htmlspecialchars($settings['internship_img']) ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Internship Bold Description</label>
          <textarea name="internship_desc" class="form-control" rows="3"><?= htmlspecialchars($settings['internship_desc']) ?></textarea>
        </div>
      </div>
    </div>
  </div>

  <!-- Tab 3: Contact & Social -->
  <div class="tab-content" id="tab-contact">
    <div class="admin-card">
      <div class="card-header">
        <h3>Contact & Location Info</h3>
      </div>
      <div class="card-body">
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:16px;">
          <div class="form-group">
            <label class="form-label">Contact Email Address</label>
            <input type="text" name="contact_email" class="form-control" value="<?= htmlspecialchars($settings['contact_email']) ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Location / City</label>
            <input type="text" name="location_text" class="form-control" value="<?= htmlspecialchars($settings['location_text']) ?>">
          </div>
          <div class="form-group">
            <label class="form-label">GitHub Profile Link</label>
            <input type="text" name="github_url" class="form-control" value="<?= htmlspecialchars($settings['github_url']) ?>">
          </div>
          <div class="form-group">
            <label class="form-label">LinkedIn Profile Link</label>
            <input type="text" name="linkedin_url" class="form-control" value="<?= htmlspecialchars($settings['linkedin_url']) ?>">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tab 4: Skills & Tech Stack -->
  <div class="tab-content" id="tab-skills">
    <div class="admin-card">
      <div class="card-header">
        <h3>Current Skills & Tech Stack (<?= count($skills_summary) ?> Total)</h3>
        <a href="skills.php" class="btn btn-sm btn-primary">
          <svg viewBox="0 0 24 24" style="width:14px;height:14px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Manage All Skills
        </a>
      </div>
      <div class="card-body">
        <?php if (!empty($skills_summary)): ?>
          <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:12px;">
            <?php foreach ($skills_summary as $sk): ?>
              <div style="padding:12px 16px; background-color:var(--admin-bg); border-radius:var(--radius-md); border:1px solid var(--admin-border); display:flex; justify-content:space-between; align-items:center;">
                <div>
                  <strong><?= htmlspecialchars($sk['name']) ?></strong>
                  <div style="font-size:0.75rem; color:var(--admin-text-muted);"><?= htmlspecialchars($sk['category']) ?></div>
                </div>
                <span class="badge badge-accent"><?= htmlspecialchars($sk['proficiency_display']) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p style="color:var(--admin-text-muted);">No skills added yet. Click "Manage All Skills" to add your skills.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div style="margin-top:20px;">
    <button type="submit" class="btn btn-accent btn-lg">
      <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
      Save All Changes
    </button>
  </div>
</form>

<script>
  document.querySelectorAll('.tab-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.tab-btn').forEach(function(b) { b.classList.remove('active'); });
      document.querySelectorAll('.tab-content').forEach(function(c) { c.classList.remove('active'); });
      btn.classList.add('active');
      document.getElementById('tab-' + btn.getAttribute('data-tab')).classList.add('active');
    });
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
