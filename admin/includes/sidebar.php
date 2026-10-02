<?php
/**
 * Admin Sidebar Navigation Include
 * 
 * Expected variables before inclusion:
 *   $current_page - (string) basename of the current page for active state highlighting
 */
$current_page = $current_page ?? '';
$unread_badge = get_unread_count();
?>
    <aside class="admin-sidebar">
      <div class="sidebar-brand">
        <h3>ALJON ADMIN</h3>
        <span class="sidebar-subtitle">Portfolio CMS</span>
      </div>
      <nav>
        <ul class="admin-nav">
          <li>
            <a href="index.php" class="<?= $current_page === 'index' ? 'active' : '' ?>">
              <span class="nav-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
              </span> 
              <span>Dashboard</span>
            </a>
          </li>
          <li>
            <a href="projects.php" class="<?= $current_page === 'projects' ? 'active' : '' ?>">
              <span class="nav-icon">
                <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
              </span>
              <span>Projects</span>
            </a>
          </li>
          <li>
            <a href="skills.php" class="<?= $current_page === 'skills' ? 'active' : '' ?>">
              <span class="nav-icon">
                <svg viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
              </span>
              <span>Skills</span>
            </a>
          </li>
          <li>
            <a href="process.php" class="<?= $current_page === 'process' ? 'active' : '' ?>">
              <span class="nav-icon">
                <svg viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
              </span>
              <span>Process Steps</span>
            </a>
          </li>
          <li>
            <a href="settings.php" class="<?= $current_page === 'settings' ? 'active' : '' ?>">
              <span class="nav-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
              </span>
              <span>Site Settings</span>
            </a>
          </li>
          <li>
            <a href="messages.php" class="<?= $current_page === 'messages' ? 'active' : '' ?>">
              <span class="nav-icon">
                <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              </span>
              <span>Messages</span>
              <?php if ($unread_badge > 0): ?>
                <span class="nav-badge"><?= $unread_badge ?></span>
              <?php endif; ?>
            </a>
          </li>
        </ul>
      </nav>
      <div class="sidebar-footer">
        <a href="../index.php" target="_blank" class="sidebar-link-muted">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
          <span>View Live Site</span>
        </a>
        <a href="logout.php" class="sidebar-link-danger">
          <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          <span>Logout</span>
        </a>
      </div>
    </aside>

    <main class="admin-content">
