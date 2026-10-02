<?php
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');

require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Session-based rate limiting: 1 submission per 60 seconds
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['last_contact_submit']) && (time() - $_SESSION['last_contact_submit']) < 60) {
    echo json_encode(['status' => 'error', 'message' => 'Please wait a moment before sending another message.']);
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? 'General Inquiry');
$message = trim($_POST['message'] ?? '');

if (strlen($name) < 2 || strlen($name) > 100) {
    echo json_encode(['status' => 'error', 'message' => 'Name must be between 2 and 100 characters.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Valid email address required.']);
    exit;
}

if (strlen($message) < 10 || strlen($message) > 2000) {
    echo json_encode(['status' => 'error', 'message' => 'Message must be between 10 and 2000 characters.']);
    exit;
}

$pdo = getDB();
if (!$pdo) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection unavailable. Please try again later.']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':subject' => $subject,
        ':message' => $message
    ]);

    // Record submission time for rate limiting
    $_SESSION['last_contact_submit'] = time();

    echo json_encode(['status' => 'success', 'message' => 'Thank you, Aljon has received your message and will respond shortly!']);
} catch (PDOException $e) {
    // Log internally, never expose DB details to public
    error_log('[contact.php] DB error: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Unable to save your message. Please try again later.']);
}
?>
