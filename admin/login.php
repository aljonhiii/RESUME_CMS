<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$error = '';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $pdo = getDB();
        if ($pdo) {
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = :u LIMIT 1");
            $stmt->execute([':u' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_name'] = $user['full_name'];
                header('Location: index.php');
                exit;
            } else {
                usleep(500000); // 0.5s delay — slows brute-force attacks
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Database connection unavailable.';
        }
    } else {
        $error = 'Please enter both username and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login — Aljon Reyes Portfolio</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: var(--bg-canvas);
    }
    .login-card {
      background: var(--bg-panel);
      padding: 40px;
      border-radius: var(--radius-lg);
      border: 1px solid var(--border-subtle);
      width: 100%;
      max-width: 420px;
      box-shadow: var(--shadow-overlap);
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h2 class="panel-title" style="margin-bottom:8px;">ADMIN PORTAL</h2>
    <p class="panel-desc" style="margin-bottom:24px;">Sign in to manage portfolio content and messages.</p>
    
    <?php if (!empty($error)): ?>
      <div style="background:rgba(255,95,86,0.15); color:#FF5F56; padding:12px; border-radius:8px; margin-bottom:20px; font-weight:600; font-size:0.85rem;">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Username" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit" class="btn-pill" style="width:100%; justify-content:center;">
        SIGN IN <span class="arrow">→</span>
      </button>
    </form>
    <p style="text-align:center; margin-top:20px; font-size:0.8rem; color:var(--text-muted);">
      <a href="../index.php" style="color:inherit;">← Return to Main Site</a>
    </p>
  </div>
</body>
</html>
