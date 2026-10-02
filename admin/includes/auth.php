<?php
/**
 * Admin Authentication Guard
 * Include this at the top of every protected admin page.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/db.php';

/**
 * Enforce admin authentication.
 * Redirects to login.php if the user is not authenticated.
 */
function require_admin_auth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Get admin display name from session.
 */
function get_admin_name() {
    return htmlspecialchars($_SESSION['admin_name'] ?? 'Admin');
}

/**
 * Get unread message count for sidebar badge.
 */
function get_unread_count() {
    $pdo = getDB();
    if ($pdo) {
        try {
            return (int) $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'unread'")->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
    return 0;
}

/**
 * CSRF Protection Helpers
 */
function csrf_token(): string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function verify_csrf(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $token = $_POST['csrf_token'] ?? '';
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        exit('CSRF token mismatch — request blocked.');
    }
}
?>
