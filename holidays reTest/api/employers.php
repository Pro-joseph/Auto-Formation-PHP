<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'GET':
        if ($action === 'list') {
            getEmployers();
        } elseif ($action === 'single') {
            getEmployer($_GET['id']);
        } else {
            sendResponse('error', 'Invalid action');
        }
        break;

    case 'POST':
        if ($action === 'add') {
            addEmployer();
        } elseif ($action === 'update') {
            updateEmployer();
        } else {
            sendResponse('error', 'Invalid action');
        }
        break;

    case 'DELETE':
        deleteEmployer($_GET['id']);
        break;

    default:
        sendResponse('error', 'Invalid request method');
}

function getEmployers() {
    global $pdo;
    try {
        $query = $pdo->query("SELECT * FROM employers ORDER BY id DESC");
        $employers = $query->fetchAll(PDO::FETCH_ASSOC);
        sendResponse('success', 'Employers retrieved', $employers);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function getEmployer($id) {
    global $pdo;
    try {
        $query = $pdo->prepare("SELECT * FROM employers WHERE id = ?");
        $query->execute([$id]);
        $employer = $query->fetch(PDO::FETCH_ASSOC);
        
        if (!$employer) {
            sendResponse('error', 'Employer not found');
        }
        sendResponse('success', 'Employer retrieved', $employer);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function addEmployer() {
    global $pdo;
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $query = $pdo->prepare("
            INSERT INTO employers (name, email, phone, position, department, status, hire_date, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $query->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['position'],
            $data['department'],
            $data['status'],
            $data['hire_date']
        ]);
        
        sendResponse('success', 'Employer added successfully', ['id' => $pdo->lastInsertId()]);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function updateEmployer() {
    global $pdo;
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $query = $pdo->prepare("
            UPDATE employers 
            SET name = ?, email = ?, phone = ?, position = ?, department = ?, status = ?, hire_date = ?
            WHERE id = ?
        ");
        
        $query->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['position'],
            $data['department'],
            $data['status'],
            $data['hire_date'],
            $data['id']
        ]);
        
        sendResponse('success', 'Employer updated successfully');
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function deleteEmployer($id) {
    global $pdo;
    try {
        $query = $pdo->prepare("DELETE FROM employers WHERE id = ?");
        $query->execute([$id]);
        
        sendResponse('success', 'Employer deleted successfully');
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}
?>