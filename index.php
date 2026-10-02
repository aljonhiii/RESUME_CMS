<?php
/**
 * Aljon Reyes — 3D Developer Portfolio
 * Main Editorial Page (PHP 8+ & PDO DB Powered with Graceful Fallbacks)
 */

// Security Headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

require_once __DIR__ . '/config/db.php';

$pdo = getDB();

// Fallback Data Arrays if DB is initializing
$fallback_settings = [
    'hero_title_1' => 'FULL-STACK',
    'hero_title_accent' => '& SOFTWARE',
    'hero_title_2' => 'DEVELOPER',
    'hero_description' => 'Transforming ideas into practical digital experiences through web development, mobile applications, and creative technology.',
    'hero_portrait_img' => 'assets/images/aljon-face1.png',
    'about_heading' => 'BUILDING MEANINGFUL APPLICATIONS & DIGITAL EXPERIENCES',
    'about_p1' => 'Hey, I\'m Aljon, a Computer Science student specializing in Application Development at Western Mindanao State University (WMSU).',
    'about_p2' => 'Currently pursuing my degree at WMSU, I enjoy turning complex ideas into practical working systems, designing intuitive interfaces, and developing robust database-driven applications that solve real-world problems.',
    'about_p3' => 'My experience includes PHP 8+ and MySQL web architectures, REST APIs, cross-platform mobile development with React Native, 3D WebGL scenes, and software engineering principles.'
];

$site_settings = $fallback_settings;
$projects = [];
$skills = [];
$process_steps = [];

if ($pdo) {
    try {
        // Fetch Settings
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        while ($row = $stmt->fetch()) {
            $site_settings[$row['setting_key']] = $row['setting_value'];
        }

        // Fetch Projects
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY sort_order ASC, id ASC");
        $projects = $stmt->fetchAll();

        // Fetch Skills
        $stmt = $pdo->query("SELECT * FROM skills ORDER BY sort_order ASC, id ASC");
        $skills = $stmt->fetchAll();

        // Fetch Process Steps
        $stmt = $pdo->query("SELECT * FROM process_steps ORDER BY sort_order ASC, id ASC");
        $process_steps = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Use fallback if query fails
    }
}

// Default Projects Fallback
if (empty($projects)) {
    $projects = [
        [
            'id' => 1,
            'title' => 'Zamboanga Tour Guide Booking System',
            'category' => 'Web Application',
            'short_description' => 'A PHP and MySQL booking platform connecting tourists with local tour guides, featuring booking management, user roles, and guide profiles.',
            'full_description' => 'This platform enables tourists to browse verified local tour guides in Zamboanga, schedule bookings, manage itineraries, and provide ratings. Built with custom PHP backend architecture, PDO prepared statements, and Bootstrap 5 responsive layout.',
            'technologies' => 'PHP, MySQL, PDO, Bootstrap, JavaScript',
            'image_url' => 'assets/images/project1.svg'
        ],
        [
            'id' => 2,
            'title' => 'ERP Help Desk Ticketing System',
            'category' => 'Enterprise System',
            'short_description' => 'A web-based IT support system for managing help desk tickets, assignments, approvals, service requests, and ticket status tracking.',
            'full_description' => 'Designed for enterprise IT departments to streamline issue resolution. Includes automated ticket routing based on urgency, multi-tier admin approvals, real-time status updates, and reporting analytics.',
            'technologies' => 'Node.js, Express, MySQL, HTML, CSS, JavaScript',
            'image_url' => 'assets/images/project2.svg'
        ],
        [
            'id' => 3,
            'title' => 'LipatDorm Moving & Cargo-Sharing Platform',
            'category' => 'Mobile & Web App',
            'short_description' => 'A proposed mobile and web platform for affordable dormitory moving and cargo-sharing services.',
            'full_description' => 'LipatDorm solves student transport challenges by matching students moving to dormitories with registered cargo partners. Features route optimization, fare estimation, booking history, and real-time tracking concepts.',
            'technologies' => 'React Native, Node.js, Express, MySQL',
            'image_url' => 'assets/images/project3.svg'
        ],
        [
            'id' => 4,
            'title' => 'Student Attendance & Academic Performance Management System',
            'category' => 'Academic Software',
            'short_description' => 'An academic management system for tracking student attendance, grades, and identifying students with failing academic performance.',
            'full_description' => 'Built for educational institutions to monitor student attendance trends, compute weighted grades automatically, flag students at risk of academic failure, and generate comprehensive student report cards.',
            'technologies' => 'PHP, MySQL, HTML, CSS, JavaScript',
            'image_url' => 'assets/images/project4.svg'
        ],
    ];
}

// Default Skills Fallback
if (empty($skills)) {
    $skills = [
        ['name' => 'PHP', 'category' => 'Backend Development', 'proficiency_display' => '95%'],
        ['name' => 'MySQL', 'category' => 'Database Management', 'proficiency_display' => '90%'],
        ['name' => 'JavaScript', 'category' => 'Frontend Development', 'proficiency_display' => '92%'],
        ['name' => 'Three.js', 'category' => '3D Web Development', 'proficiency_display' => '85%'],
        ['name' => 'React Native', 'category' => 'Mobile Development', 'proficiency_display' => '88%'],
        ['name' => 'Node.js', 'category' => 'Backend & API Development', 'proficiency_display' => '90%']
    ];
}

// Default Process Steps Fallback
if (empty($process_steps)) {
    $process_steps = [
        ['step_number' => '01', 'title' => 'PLAN & ANALYZE', 'description' => 'Understand the problem, identify user needs, and define system requirements.'],
        ['step_number' => '02', 'title' => 'DESIGN & PROTOTYPE', 'description' => 'Create database structures, application layouts, and user-friendly interfaces.'],
        ['step_number' => '03', 'title' => 'DEVELOP & INTEGRATE', 'description' => 'Implement frontend functionality, PHP backend logic, APIs, and database integration.'],
        ['step_number' => '04', 'title' => 'TEST & IMPROVE', 'description' => 'Test system functionality, fix errors, and improve performance and usability.']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aljon Reyes — Full-Stack Developer & Software Engineering Portfolio</title>
  <meta name="description" content="Portfolio of Aljon Reyes, Computer Technology (Application Development) student and Full-Stack Developer specializing in PHP, MySQL, Three.js, and Mobile Development.">
  <link rel="icon" type="image/png" href="assets/images/favicon_ar.png?v=<?= time() ?>">
  <link rel="shortcut icon" type="image/png" href="assets/images/favicon_ar.png?v=<?= time() ?>">
  <link rel="apple-touch-icon" href="assets/images/favicon_ar.png?v=<?= time() ?>">
  <!-- CSS Stylesheets -->
  <link rel="stylesheet" href="assets/css/style.css">
  
  <!-- Three.js & GSAP CDN Dependencies -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>
<body>

  <!-- Floating Sticky Pill Navbar & Mobile Navigation Trigger -->
  <header class="top-header">
    <nav class="pill-navbar">
      <a href="#home" class="nav-item active" data-target="home">HOME</a>
      <a href="#skills" class="nav-item" data-target="skills">SKILLS</a>
      <a href="#about" class="nav-item" data-target="about">ABOUT ME</a>
      <a href="#timeline" class="nav-item" data-target="timeline">EXPERIENCE</a>
      <a href="#projects" class="nav-item" data-target="projects">PROJECTS</a>
      <a href="#contact" class="nav-item trigger-contact" data-target="contact">CONTACT</a>
    </nav>

    <!-- Mobile Hamburger Menu Button -->
    <button class="menu-trigger" id="menu-trigger" aria-label="Open Navigation Menu">
      <span>MENU</span>
      <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1 1H17M1 7H17M1 13H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>
  </header>

  <!-- One-Page Scroll Side Navigation Dots (8 Screens) -->
  <nav class="one-page-dots-nav" aria-label="One Page Navigation">
    <ul>
      <li><a href="#home" class="dot-item active" data-target="home"><span class="dot-circle"></span><span class="dot-label">01. Home</span></a></li>
      <li><a href="#skills" class="dot-item" data-target="skills"><span class="dot-circle"></span><span class="dot-label">02. Skills</span></a></li>
      <li><a href="#architecture" class="dot-item" data-target="architecture"><span class="dot-circle"></span><span class="dot-label">03. Ecosystem</span></a></li>
      <li><a href="#process" class="dot-item" data-target="process"><span class="dot-circle"></span><span class="dot-label">04. Process</span></a></li>
      <li><a href="#about" class="dot-item" data-target="about"><span class="dot-circle"></span><span class="dot-label">05. About</span></a></li>
      <li><a href="#timeline" class="dot-item" data-target="timeline"><span class="dot-circle"></span><span class="dot-label">06. Milestones</span></a></li>
      <li><a href="#projects" class="dot-item" data-target="projects"><span class="dot-circle"></span><span class="dot-label">07. Projects</span></a></li>
      <li><a href="#contact" class="dot-item" data-target="contact"><span class="dot-circle"></span><span class="dot-label">08. Contact</span></a></li>
    </ul>
  </nav>

  <!-- Main Editorial Content Container -->
  <main class="container">
    
    <!-- Unified Section 1: Hero Intro + 3D Workstation + Overview Panel + Core Principles -->
    <section class="hero-stage-container snap-section is-active" id="home">
      
      <div class="hero-stage">
        <!-- Left Hero Intro -->
        <div class="hero-intro">
          <p class="hero-subtitle">Hey. I'm Aljon,</p>
          <h1 class="hero-title">
            <?= htmlspecialchars($site_settings['hero_title_1'] ?? 'A FULL-STACK') ?>
            <span class="title-accent"><?= htmlspecialchars($site_settings['hero_title_accent'] ?? '& Software') ?></span>
            <?= htmlspecialchars($site_settings['hero_title_2'] ?? 'DEVELOPER') ?>
          </h1>
          <p class="hero-description">
            <?= htmlspecialchars($site_settings['hero_description']) ?>
          </p>
          <a href="#contact" class="btn-pill trigger-contact">
            CONTACT ME <span class="arrow">→</span>
          </a>
        </div>

        <!-- Center Stadium Arch Developer Hero Frame (Matching Reference Image 1) -->
        <div class="hero-portrait-arch-frame">
          <img src="<?= htmlspecialchars($site_settings['hero_portrait_img'] ?? 'assets/images/aljon-face1.png') ?>" alt="Aljon Reyes" class="hero-portrait-img" id="hero-portrait">
        </div>

        <!-- Right Developer Overview Panel -->
        <div class="hero-overview-panel">
          <h2 class="panel-title">CREATING PRACTICAL DIGITAL EXPERIENCES</h2>
          <p class="panel-desc">
            Building functional and user-friendly applications through clean code, thoughtful design, and modern development technologies.
          </p>

          <!-- 6 Skill Indicators Grid -->
          <div class="skills-metric-grid">
            <?php foreach ($skills as $skill): ?>
              <div class="skill-metric-item">
                <span class="metric-number"><?= htmlspecialchars($skill['proficiency_display']) ?></span>
                <span class="metric-label"><?= htmlspecialchars($skill['name']) ?></span>
                <span class="metric-sub"><?= htmlspecialchars($skill['category']) ?></span>
              </div>
            <?php endforeach; ?>
          </div>

          <a href="#contact" class="btn-pill trigger-contact">
            CONTACT ME <span class="arrow">→</span>
          </a>
        </div>
      </div>

      <!-- 4 Core Principles Strip (Merged directly into Section 1) -->
      <div class="hero-principles-grid">
        <div class="principle-card">
          <h3 class="principle-title">CLEAN & MAINTAINABLE CODE</h3>
          <p class="principle-desc">Well-structured PHP and JavaScript architecture adhering to OOP and modern software standards.</p>
        </div>
        <div class="principle-card">
          <h3 class="principle-title">DATABASE & API ARCHITECTURE</h3>
          <p class="principle-desc">Normalized MySQL relational schema design, PDO query optimization, and RESTful APIs.</p>
        </div>
        <div class="principle-card">
          <h3 class="principle-title">RESPONSIVE & MODERN UI</h3>
          <p class="principle-desc">Pixel-perfect, editorial user interfaces crafted for smooth performance on desktop and mobile.</p>
        </div>
        <div class="principle-card">
          <h3 class="principle-title">FULL-STACK INTEGRATION</h3>
          <p class="principle-desc">Seamless integration connecting intuitive frontend interfaces directly with PHP database logic.</p>
        </div>
      </div>

    </section>

    <!-- Interactive 3D Mechanical Keyboard Tech Stack Section -->
    <section class="tech-keyboard-section snap-section" id="skills">
      <div class="keyboard-section-header">
        <h2 class="keyboard-main-title">TECHNOLOGY SKILLS THAT I WORK WITH</h2>
        <span class="keyboard-hint-badge">(hint: press a key or hover)</span>
      </div>

      <div class="keyboard-workspace">
        <!-- Left Info Panel for Dynamic Hover Pop-up -->
        <div class="keyboard-info-panel" id="keyboard-info-panel">
          <span class="keyboard-tech-cat" id="tech-cat">TYPE-SAFE ARCHITECTURE</span>
          <h3 class="keyboard-tech-title" id="tech-title">TypeScript</h3>
          <p class="keyboard-tech-desc" id="tech-desc">
            "JavaScript's overachieving cousin who's always flexing type safety, interfaces, and zero runtime surprises."
          </p>
          <div class="keyboard-key-badge">
            <span class="badge-lbl">PRESS SHORTCUT:</span>
            <kbd class="key-shortcut-box" id="tech-key-kbd">T</kbd>
          </div>
        </div>

        <!-- Right 3D Mechanical Keyboard Canvas Container -->
        <div class="keyboard-3d-canvas-wrapper" id="keyboard-3d-container">
          <!-- Three.js 3D Macropad Canvas renders here -->
        </div>
      </div>
    </section>

    <!-- New Screen: System Architecture & Full-Stack Tech Stack Lab -->
    <section class="architecture-section snap-section" id="architecture">
      <div class="arch-section-header">
        <span class="arch-badge">SYSTEM DESIGN & ARCHITECTURE</span>
        <h2 class="arch-main-title">FULL-STACK TECH ECOSYSTEM</h2>
        <p class="arch-subtitle">Modular, scalable application layers built for reliability, clean code separation, and high performance.</p>
      </div>

      <div class="arch-layers-grid">
        <div class="arch-layer-card">
          <span class="layer-num">01</span>
          <h3 class="layer-title">PRESENTATION & UI LAYER</h3>
          <p class="layer-desc">Pixel-perfect responsive web & mobile UIs built with HTML5, CSS3, ES6+ JS, TypeScript, React Native, and Tailwind CSS.</p>
          <div class="layer-tech-tags">
            <span class="tech-tag">HTML5 / CSS3</span>
            <span class="tech-tag">TypeScript</span>
            <span class="tech-tag">React Native</span>
            <span class="tech-tag">Tailwind CSS</span>
          </div>
        </div>

        <div class="arch-layer-card">
          <span class="layer-num">02</span>
          <h3 class="layer-title">APPLICATION & API CORE</h3>
          <p class="layer-desc">Robust backend logic powered by custom PHP 8+ OOP services, PDO security, Node.js, Express RESTful endpoints, and async I/O.</p>
          <div class="layer-tech-tags">
            <span class="tech-tag">PHP 8+ (OOP)</span>
            <span class="tech-tag">Node.js</span>
            <span class="tech-tag">Express API</span>
            <span class="tech-tag">REST Architecture</span>
          </div>
        </div>

        <div class="arch-layer-card">
          <span class="layer-num">03</span>
          <h3 class="layer-title">DATABASE & STORAGE ENGINE</h3>
          <p class="layer-desc">ACID-compliant relational database management with MySQL & MariaDB, normalized schemas, indexed query optimization, and PDO security.</p>
          <div class="layer-tech-tags">
            <span class="tech-tag">MySQL / MariaDB</span>
            <span class="tech-tag">PDO Statements</span>
            <span class="tech-tag">Normalized Schemas</span>
            <span class="tech-tag">Query Optimization</span>
          </div>
        </div>

        <div class="arch-layer-card">
          <span class="layer-num">04</span>
          <h3 class="layer-title">3D GRAPHICS & AI TOOLING</h3>
          <p class="layer-desc">GPU-accelerated interactive 3D WebGL scenes using Three.js, Electron desktop packaging, Expo toolchains, and Anthropic Claude AI integration.</p>
          <div class="layer-tech-tags">
            <span class="tech-tag">Three.js / WebGL</span>
            <span class="tech-tag">Anthropic AI Tools</span>
            <span class="tech-tag">Electron Desktop</span>
            <span class="tech-tag">Git Version Control</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Development Process Section -->
    <section class="process-section snap-section" id="process">
      <div class="process-left">
        <div class="process-header">
          <h2 class="process-title">
            A STREAMLINED<br>DEVELOPMENT PROCESS<br>FOR PRACTICAL SOLUTIONS
          </h2>
          <p class="process-desc">
            From identifying a problem to developing a working application, I focus on building useful, reliable, and maintainable software.
          </p>
        </div>

        <div class="process-steps-list">
          <?php foreach ($process_steps as $step): ?>
            <div class="process-step-item">
              <h3 class="process-step-head">
                <span class="step-num"><?= htmlspecialchars($step['step_number']) ?></span> — <?= htmlspecialchars($step['title']) ?>
              </h3>
              <p class="process-step-body">
                <?= htmlspecialchars($step['description']) ?>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Right Editorial Portrait Arch Frame -->
      <div class="process-arch-frame">
        <img src="<?= htmlspecialchars($site_settings['hero_portrait_img'] ?? 'assets/images/aljon-face1.png') ?>" alt="Aljon Reyes Process" class="process-portrait-img">
      </div>
    </section>

    <!-- About Me Editorial Section -->
    <section class="about-section snap-section" id="about">
      <div class="about-top-grid">
        <h2 class="about-title">
          <?= htmlspecialchars($site_settings['about_heading']) ?>
        </h2>
        <div class="about-content">
          <p class="about-p-highlight">
            "<?= htmlspecialchars($site_settings['about_p1'] ?? '') ?>"
          </p>
          <p class="about-p-normal">
            <?= htmlspecialchars($site_settings['about_p2'] ?? '') ?>
          </p>
          <p class="about-p-normal">
            <?= htmlspecialchars($site_settings['about_p3'] ?? '') ?>
          </p>
        </div>
      </div>

      <!-- Two-Column Internship Feature Block (Text | Image) -->
      <div class="internship-two-col">
        <!-- Left: Text Column -->
        <div class="internship-text-col">
          <span class="internship-badge-tag">PRACTICAL EXPERIENCE</span>
          <h3 class="internship-bold-header">
            <?= htmlspecialchars($site_settings['internship_title'] ?? 'INTERNSHIP & PRACTICAL EXPERIENCE') ?>
          </h3>
          <p class="internship-bold-desc">
            <?= htmlspecialchars($site_settings['internship_desc'] ?? $site_settings['about_p4'] ?? '') ?>
          </p>
        </div>
        <!-- Right: Image Column -->
        <div class="internship-image-frame">
          <img src="<?= htmlspecialchars($site_settings['internship_img'] ?? 'assets/images/internship_preview.png') ?>" alt="Internship Experience" class="internship-feature-img" onerror="this.src='assets/images/aljon-face1.png'">
        </div>
      </div>
    </section>

    <!-- New Screen: Academic & Developer Experience Milestones -->
    <section class="timeline-section snap-section" id="timeline">
      <div class="timeline-section-header">
        <span class="timeline-badge">CAREER & ACADEMIC PATHWAY</span>
        <h2 class="timeline-main-title">DEVELOPMENT MILESTONES</h2>
        <p class="timeline-subtitle">Computer Technology (Application Development) specialization and software engineering experience.</p>
      </div>

      <div class="timeline-grid">
        <div class="timeline-item">
          <div class="timeline-year">WMSU — ACADEMIC FOUNDATION</div>
          <h3 class="timeline-title">BS Computer Science (Application Development)</h3>
          <p class="timeline-desc">Student at Western Mindanao State University (WMSU) specializing in Application Development. Mastering software engineering, OOP backend development, database management systems, and algorithms.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-year">MILESTONE 02</div>
          <h3 class="timeline-title">Full-Stack Web Systems & Enterprise Applications</h3>
          <p class="timeline-desc">Engineered full-stack platforms including the Zamboanga Tour Guide Booking System and web-based ERP Help Desk Ticketing software.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-year">MILESTONE 03</div>
          <h3 class="timeline-title">Cross-Platform Mobile App Engineering</h3>
          <p class="timeline-desc">Developed mobile applications using React Native and Expo, building solutions for student dormitory moving and logistics platforms.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-year">MILESTONE 04</div>
          <h3 class="timeline-title">Interactive 3D WebGL & AI Agent Integration</h3>
          <p class="timeline-desc">Pioneering creative 3D web experiences with Three.js graphics, GPU rendering, and Anthropic Claude AI prompt & agentic tooling.</p>
        </div>
      </div>
    </section>

    <!-- Museum Gallery Projects Section -->
    <section class="projects-section snap-section" id="projects">
      <div class="container">

        <!-- Museum-style header with year and category filters -->
        <div class="gallery-header">
          <div class="gallery-heading-row">
            <h2 class="gallery-heading">Selected Works</h2>
            <span class="gallery-year">— <?= date('Y') ?></span>
          </div>
          <div class="gallery-filter-row" id="gallery-filters">
            <button class="gallery-filter-btn active" data-filter="all">All</button>
            <?php
              $uniqueCategories = array_unique(array_column($projects, 'category'));
              foreach ($uniqueCategories as $cat):
            ?>
              <button class="gallery-filter-btn" data-filter="<?= htmlspecialchars($cat) ?>">
                <?= htmlspecialchars($cat) ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 3-up Museum Gallery Grid (3 cards per page) -->
        <div class="gallery-museum-grid" id="gallery-grid">
          <?php foreach ($projects as $idx => $project): ?>
            <article class="gallery-item<?= $idx >= 3 ? ' is-page-hidden' : '' ?>"
                     data-index="<?= $idx ?>"
                     data-category="<?= htmlspecialchars($project['category']) ?>">
              <div class="gallery-item-img">
                <img src="<?= htmlspecialchars($project['image_url']) ?>"
                     alt=""
                     loading="lazy"
                     onerror="this.style.display='none'">
              </div>
              <!-- Hover Reveal Overlay -->
              <div class="gallery-item-overlay">
                <span class="gallery-item-cat"><?= htmlspecialchars($project['category']) ?></span>
                <h3 class="gallery-item-title"><?= htmlspecialchars($project['title']) ?></h3>
                <div class="gallery-item-tags">
                  <?php foreach (array_slice(explode(',', $project['technologies']), 0, 4) as $tag): ?>
                    <span class="tech-pill"><?= htmlspecialchars(trim($tag)) ?></span>
                  <?php endforeach; ?>
                </div>
                <?php if (!empty($project['github_url']) && $project['github_url'] !== '#'): ?>
                <a href="<?= htmlspecialchars($project['github_url']) ?>"
                   class="btn-repo-pill" target="_blank" rel="noopener">
                  <svg class="repo-icon" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                    <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                  </svg>
                  <span>GitHub Repo</span>
                </a>
                <?php endif; ?>
              </div>
              <!-- Museum item number label -->
              <span class="gallery-item-num"><?= sprintf('%02d', $idx + 1) ?></span>
            </article>
          <?php endforeach; ?>
        </div>

        <!-- Pagination Row -->
        <div class="gallery-pagination" id="gallery-pagination">
          <button class="gallery-page-btn" id="gallery-prev" aria-label="Previous page" disabled>
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="15 18 9 12 15 6"/>
            </svg>
            <span>Prev</span>
          </button>
          <span class="gallery-page-counter" id="gallery-page-counter">1 / <?= ceil(count($projects) / 3) ?></span>
          <button class="gallery-page-btn" id="gallery-next" aria-label="Next page"
            <?= count($projects) <= 3 ? 'disabled' : '' ?>>
            <span>Next</span>
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="9 18 15 12 9 6"/>
            </svg>
          </button>
        </div>

      </div>
    </section>

  </main>

  <!-- Site Footer -->
  <footer class="site-footer snap-section" id="contact">
    <div class="container">
      <div class="footer-top">
        <div>
          <h2 class="footer-heading">
            LET'S BUILD SOMETHING <span class="accent">Exceptional</span> TOGETHER
          </h2>
          <p class="footer-sub">
            Available for software engineering roles, full-stack web projects, and application development opportunities.
          </p>
        </div>
        <div>
          <button class="btn-pill trigger-contact" style="padding:18px 36px; font-size:0.95rem;">
            START A CONVERSATION <span class="arrow">→</span>
          </button>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> ALJON REYES. COMPUTER TECHNOLOGY (APPLICATION DEVELOPMENT).</p>
      </div>
    </div>
  </footer>

  <!-- Fullscreen Navigation Drawer Modal -->
  <div class="nav-modal" id="nav-modal">
    <div class="nav-modal-card">
      <button class="nav-modal-close" id="nav-modal-close" aria-label="Close Menu">&times;</button>
      <ul class="nav-links-list">
        <li><a href="#home" data-target="home">01. HOME</a></li>
        <li><a href="#skills" data-target="skills">02. SKILLS</a></li>
        <li><a href="#architecture" data-target="architecture">03. ECOSYSTEM</a></li>
        <li><a href="#process" data-target="process">04. PROCESS</a></li>
        <li><a href="#about" data-target="about">05. ABOUT ME</a></li>
        <li><a href="#timeline" data-target="timeline">06. MILESTONES</a></li>
        <li><a href="#projects" data-target="projects">07. PROJECTS</a></li>
        <li><a href="#contact" class="trigger-contact" data-target="contact">08. CONTACT</a></li>
      </ul>
    </div>
  </div>

  <!-- Contact Form Modal -->
  <div class="modal-overlay" id="contact-modal">
    <div class="modal-card">
      <button class="modal-close-btn" id="contact-modal-close">&times;</button>
      <h3 class="panel-title" style="margin-bottom:8px;">GET IN TOUCH</h3>
      <p class="panel-desc" style="margin-bottom:24px;">Send a message regarding project inquiries or full-stack opportunities.</p>
      
      <form id="contact-form">
        <div class="form-group">
          <label for="c-name">Your Name</label>
          <input type="text" id="c-name" name="name" placeholder="John Doe" required>
        </div>
        <div class="form-group">
          <label for="c-email">Email Address</label>
          <input type="email" id="c-email" name="email" placeholder="john@example.com" required>
        </div>
        <div class="form-group">
          <label for="c-subject">Subject</label>
          <input type="text" id="c-subject" name="subject" placeholder="Project Inquiry / Hiring">
        </div>
        <div class="form-group">
          <label for="c-message">Message</label>
          <textarea id="c-message" name="message" rows="4" placeholder="Tell me about your project..." required></textarea>
        </div>
        <div id="form-status-msg" style="margin-bottom:15px; font-weight:600; font-size:0.9rem;"></div>
        <button type="submit" class="btn-pill" style="width:100%; justify-content:center;">
          SEND MESSAGE <span class="arrow">→</span>
        </button>
      </form>
    </div>
  </div>

  <!-- Project Details Modal -->
  <div class="modal-overlay" id="project-modal">
    <div class="modal-card" style="max-width:720px; padding:32px;">
      <button class="modal-close-btn" id="project-modal-close">&times;</button>
      <div style="width:100%; height:320px; background:#DCDBCF; border-radius:16px; overflow:hidden; margin-bottom:20px;">
        <img id="pm-img" src="" alt="" style="width:100%; height:100%; object-fit:cover;">
      </div>
      <h3 class="panel-title" style="margin-bottom:12px; font-size:1.35rem; line-height:1.2;">
        <span id="pm-category" style="color:var(--text-muted); font-weight:700;"></span>: <span id="pm-title"></span>
      </h3>
      <div id="pm-tech-tags" class="project-tech-tags" style="margin-bottom:14px;"></div>
      <p id="pm-desc" style="font-size:0.925rem; line-height:1.6; color:var(--text-muted); margin-bottom:24px;"></p>
      <div class="project-action" style="justify-content:center;">
        <a id="pm-repo" href="#" class="btn-repo-pill" target="_blank" rel="noopener">
          <svg class="repo-icon" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
          </svg>
          <span>Repo</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Custom Scripts -->
  <script src="assets/js/three-keyboard.js?v=<?= time() ?>"></script>
  <script src="assets/js/main.js?v=<?= time() ?>"></script>
</body>
</html>
