<?php
$host = 'localhost';
$db_name = 'dashboard_db';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

session_start();

// Helper function for responses
function sendResponse($status, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check user role
function hasRole($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

// Check if user is admin
function isAdmin() {
    return hasRole('admin');
}

// Log activity
function logActivity($user_id, $action, $description, $module) {
    global $pdo;
    try {
        $query = $pdo->prepare("
            INSERT INTO activity_logs (user_id, action, description, module)
            VALUES (?, ?, ?, ?)
        ");
        $query->execute([$user_id, $action, $description, $module]);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Redirect if not admin
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: index.php?error=unauthorized');
        exit;
    }
}
?>