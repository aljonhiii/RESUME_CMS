<?php
/**
 * Admin Header Include
 * Provides HTML <head>, fonts, CSS, JS, and admin layout wrapper.
 * 
 * Expected variables before inclusion:
 *   $page_title - (string) Page title for <title> tag
 */
$page_title = $page_title ?? 'Admin — Aljon Reyes Portfolio';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title) ?></title>
  <link rel="icon" type="image/png" href="../assets/images/favicon_ar.png?v=<?= time() ?>">
  <link rel="shortcut icon" type="image/png" href="../assets/images/favicon_ar.png?v=<?= time() ?>">
  <link rel="apple-touch-icon" href="../assets/images/favicon_ar.png?v=<?= time() ?>">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Oswald:wght@500;600;700&family=Playfair+Display:ital,wght@1,400;1,600;1,700&display=swap" rel="stylesheet">
  
  <!-- Styles: admin.css is self-contained; style.css excluded to prevent
       scroll-snap/transform rules leaking and causing admin card flicker -->
  <link rel="stylesheet" href="../assets/css/admin.css">
  
  <!-- Component Controller Script -->
  <script src="../assets/js/admin.js" defer></script>
</head>
<body>
  <div class="admin-wrapper">
