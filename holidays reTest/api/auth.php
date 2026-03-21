<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'POST':
        if ($action === 'login') {
            login();
        } elseif ($action === 'register') {
            register();
        } elseif ($action === 'logout') {
            logout();
        } else {
            sendResponse('error', 'Invalid action');
        }
        break;

    default:
        sendResponse('error', 'Invalid request method');
}

function login() {
    global $pdo;
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['username']) || empty($data['password'])) {
            sendResponse('error', 'Username and password are required');
        }

        $query = $pdo->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND status = 'Active'");
        $query->execute([$data['username'], $data['username']]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($data['password'], $user['password'])) {
            sendResponse('error', 'Invalid username or password');
        }

        // Update last login
        $updateQuery = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $updateQuery->execute([$user['id']]);

        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];

        logActivity($user['id'], 'LOGIN', 'User logged in', 'auth');

        sendResponse('success', 'Login successful', [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'full_name' => $user['full_name']
        ]);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function register() {
    global $pdo;
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            sendResponse('error', 'All fields are required');
        }

        // Check if user exists
        $checkQuery = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $checkQuery->execute([$data['username'], $data['email']]);
        
        if ($checkQuery->rowCount() > 0) {
            sendResponse('error', 'Username or email already exists');
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $query = $pdo->prepare("
            INSERT INTO users (username, email, password, full_name, role, status)
            VALUES (?, ?, ?, ?, 'user', 'Active')
        ");
        
        $query->execute([
            $data['username'],
            $data['email'],
            $hashedPassword,
            $data['full_name'] ?? $data['username']
        ]);

        sendResponse('success', 'Registration successful. Please login.', ['id' => $pdo->lastInsertId()]);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function logout() {
    if (isset($_SESSION['user_id'])) {
        logActivity($_SESSION['user_id'], 'LOGOUT', 'User logged out', 'auth');
    }
    session_destroy();
    sendResponse('success', 'Logout successful');
}
?>