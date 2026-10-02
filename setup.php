<?php
/**
 * One-Time Admin Setup Script
 * Run this ONCE after first deployment to create the admin account.
 * This file self-deletes after successful account creation.
 *
 * Access: http://yourdomain.com/setup.php
 * DELETE this file or move it outside the webroot after use.
 */

require_once __DIR__ . '/config/db.php';

$error = '';
$success = false;

// Block if admin account already exists
$pdo = getDB();
if ($pdo) {
    $count = (int) $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    if ($count > 0) {
        die('<div style="font-family:monospace;padding:40px;background:#1a1a1a;color:#FF5F56;max-width:500px;margin:60px auto;border-radius:12px;border:1px solid #FF5F56;">
            <h2>⛔ Setup Already Complete</h2>
            <p>An admin account already exists. This setup script is no longer needed.</p>
            <p><strong>You should delete setup.php from your server immediately.</strong></p>
        </div>');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username'] ?? '');
    $password  = trim($_POST['password'] ?? '');
    $confirm   = trim($_POST['confirm'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');

    if (strlen($username) < 4 || strlen($username) > 30) {
        $error = 'Username must be 4–30 characters.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = 'Username may only contain letters, numbers, and underscores.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (empty($full_name)) {
        $error = 'Full name is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'A valid email address is required.';
    } elseif (!$pdo) {
        $error = 'Database connection failed. Check config/db.php.';
    } else {
        $hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password, full_name, email) VALUES (:u, :p, :n, :e)");
        $stmt->execute([':u' => $username, ':p' => $hashed, ':n' => $full_name, ':e' => $email]);
        $success = true;

        // Self-delete this file after successful setup
        @unlink(__FILE__);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Portfolio CMS — First-Time Setup</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #111; color: #eee; font-family: 'Segoe UI', sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
    .card { background: #1c1c1c; border: 1px solid #333; border-radius: 14px; padding: 40px; width: 100%; max-width: 460px; }
    h2 { font-size: 1.4rem; font-weight: 700; margin-bottom: 6px; color: #fff; }
    p.sub { font-size: 0.85rem; color: #888; margin-bottom: 28px; }
    label { display: block; font-size: 0.8rem; font-weight: 600; color: #aaa; margin-bottom: 5px; }
    input { width: 100%; background: #111; border: 1px solid #333; border-radius: 8px; padding: 10px 14px; color: #eee; font-size: 0.9rem; margin-bottom: 16px; }
    input:focus { outline: none; border-color: #5B695C; }
    button { width: 100%; background: #5B695C; color: #fff; border: none; border-radius: 8px; padding: 12px; font-weight: 700; font-size: 0.9rem; cursor: pointer; }
    button:hover { background: #4a5a4b; }
    .error { background: rgba(255,95,86,0.15); color: #FF5F56; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 600; }
    .success { background: rgba(91,105,92,0.2); color: #8fc78f; padding: 20px; border-radius: 8px; text-align: center; }
    .success h3 { font-size: 1.1rem; margin-bottom: 8px; }
    .success p { font-size: 0.85rem; color: #888; }
    .warn { background: rgba(255,200,0,0.1); border: 1px solid rgba(255,200,0,0.3); color: #ffc800; padding: 10px 14px; border-radius: 8px; font-size: 0.8rem; margin-bottom: 20px; }
  </style>
</head>
<body>
  <div class="card">
    <?php if ($success): ?>
      <div class="success">
        <h3>✅ Admin Account Created!</h3>
        <p>Setup file has been deleted automatically.</p>
        <p style="margin-top:12px;"><a href="admin/login.php" style="color:#8fc78f;">→ Go to Admin Login</a></p>
      </div>
    <?php else: ?>
      <h2>Portfolio CMS Setup</h2>
      <p class="sub">Create your admin account. Run this only once.</p>
      <div class="warn">⚠️ Delete this file from your server after setup is complete.</div>
      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required minlength="4" maxlength="30" placeholder="e.g. aljon_admin">
        <label>Password (min. 8 characters)</label>
        <input type="password" name="password" required minlength="8">
        <label>Confirm Password</label>
        <input type="password" name="confirm" required>
        <label>Full Name</label>
        <input type="text" name="full_name" required placeholder="Aljon Reyes">
        <label>Email Address</label>
        <input type="email" name="email" required placeholder="you@example.com">
        <button type="submit">Create Admin Account →</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
