<?php
header('Content-Type: application/json');
require_once '../config/database.php';

requireAdmin();

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'GET':
        if ($action === 'users') {
            getUsers();
        } elseif ($action === 'user') {
            getUser($_GET['id']);
        } elseif ($action === 'activity-logs') {
            getActivityLogs();
        } elseif ($action === 'stats') {
            getAdminStats();
        } else {
            sendResponse('error', 'Invalid action');
        }
        break;

    case 'POST':
        if ($action === 'add-user') {
            addUser();
        } elseif ($action === 'update-user') {
            updateUser();
        } elseif ($action === 'change-role') {
            changeUserRole();
        } else {
            sendResponse('error', 'Invalid action');
        }
        break;

    case 'DELETE':
        if ($action === 'user') {
            deleteUser($_GET['id']);
        } else {
            sendResponse('error', 'Invalid action');
        }
        break;

    default:
        sendResponse('error', 'Invalid request method');
}

function getUsers() {
    global $pdo;
    try {
        $query = $pdo->query("
            SELECT id, username, email, full_name, role, status, last_login, created_at
            FROM users
            ORDER BY created_at DESC
        ");
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        sendResponse('success', 'Users retrieved', $users);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function getUser($id) {
    global $pdo;
    try {
        $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $query->execute([$id]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            sendResponse('error', 'User not found');
        }
        sendResponse('success', 'User retrieved', $user);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function addUser() {
    global $pdo;
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            sendResponse('error', 'Username, email, and password are required');
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
            VALUES (?, ?, ?, ?, ?, 'Active')
        ");
        
        $query->execute([
            $data['username'],
            $data['email'],
            $hashedPassword,
            $data['full_name'] ?? $data['username'],
            $data['role'] ?? 'user'
        ]);

        logActivity($_SESSION['user_id'], 'CREATE_USER', "Created user: {$data['username']}", 'admin');
        sendResponse('success', 'User added successfully', ['id' => $pdo->lastInsertId()]);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function updateUser() {
    global $pdo;
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $query = $pdo->prepare("
            UPDATE users 
            SET username = ?, email = ?, full_name = ?, status = ?
            WHERE id = ?
        ");
        
        $query->execute([
            $data['username'],
            $data['email'],
            $data['full_name'],
            $data['status'],
            $data['id']
        ]);

        logActivity($_SESSION['user_id'], 'UPDATE_USER', "Updated user: {$data['username']}", 'admin');
        sendResponse('success', 'User updated successfully');
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function changeUserRole() {
    global $pdo;
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $query = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        $query->execute([$data['role'], $data['id']]);

        logActivity($_SESSION['user_id'], 'CHANGE_ROLE', "Changed role for user ID: {$data['id']}", 'admin');
        sendResponse('success', 'User role updated successfully');
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function deleteUser($id) {
    global $pdo;
    try {
        // Don't allow deleting the only admin
        $adminCount = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'")->fetch()['count'];
        
        $userRole = $pdo->prepare("SELECT role FROM users WHERE id = ?")->execute([$id]);
        $user = $pdo->query("SELECT role FROM users WHERE id = $id")->fetch();
        
        if ($user['role'] === 'admin' && $adminCount <= 1) {
            sendResponse('error', 'Cannot delete the only admin user');
        }

        $query = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $query->execute([$id]);

        logActivity($_SESSION['user_id'], 'DELETE_USER', "Deleted user ID: $id", 'admin');
        sendResponse('success', 'User deleted successfully');
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function getActivityLogs() {
    global $pdo;
    try {
        $limit = $_GET['limit'] ?? 50;
        $query = $pdo->query("
            SELECT al.*, u.username, u.full_name
            FROM activity_logs al
            LEFT JOIN users u ON al.user_id = u.id
            ORDER BY al.created_at DESC
            LIMIT $limit
        ");
        $logs = $query->fetchAll(PDO::FETCH_ASSOC);
        sendResponse('success', 'Activity logs retrieved', $logs);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function getAdminStats() {
    global $pdo;
    try {
        $totalUsers = $pdo->query("SELECT COUNT(*) as count FROM users")->fetch()['count'];
        $adminUsers = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'")->fetch()['count'];
        $activeUsers = $pdo->query("SELECT COUNT(*) as count FROM users WHERE status = 'Active'")->fetch()['count'];
        $totalEmployers = $pdo->query("SELECT COUNT(*) as count FROM employers")->fetch()['count'];
        $totalDevices = $pdo->query("SELECT COUNT(*) as count FROM devices")->fetch()['count'];
        
        sendResponse('success', 'Stats retrieved', [
            'total_users' => $totalUsers,
            'admin_users' => $adminUsers,
            'active_users' => $activeUsers,
            'total_employers' => $totalEmployers,
            'total_devices' => $totalDevices
        ]);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}
?>