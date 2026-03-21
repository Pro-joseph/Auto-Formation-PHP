<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'GET':
        if ($action === 'list') {
            getDevices();
        } elseif ($action === 'single') {
            getDevice($_GET['id']);
        } else {
            sendResponse('error', 'Invalid action');
        }
        break;

    case 'POST':
        if ($action === 'add') {
            addDevice();
        } elseif ($action === 'update') {
            updateDevice();
        } else {
            sendResponse('error', 'Invalid action');
        }
        break;

    case 'DELETE':
        deleteDevice($_GET['id']);
        break;

    default:
        sendResponse('error', 'Invalid request method');
}

function getDevices() {
    global $pdo;
    try {
        $query = $pdo->query("
            SELECT d.*, e.name as assigned_to_name 
            FROM devices d 
            LEFT JOIN employers e ON d.assigned_to = e.id 
            ORDER BY d.id DESC
        ");
        $devices = $query->fetchAll(PDO::FETCH_ASSOC);
        sendResponse('success', 'Devices retrieved', $devices);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function getDevice($id) {
    global $pdo;
    try {
        $query = $pdo->prepare("
            SELECT d.*, e.name as assigned_to_name 
            FROM devices d 
            LEFT JOIN employers e ON d.assigned_to = e.id 
            WHERE d.id = ?
        ");
        $query->execute([$id]);
        $device = $query->fetch(PDO::FETCH_ASSOC);
        
        if (!$device) {
            sendResponse('error', 'Device not found');
        }
        sendResponse('success', 'Device retrieved', $device);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function addDevice() {
    global $pdo;
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $query = $pdo->prepare("
            INSERT INTO devices (device_name, device_type, serial_number, assigned_to, status, purchase_date, warranty_expiry, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $query->execute([
            $data['device_name'],
            $data['device_type'],
            $data['serial_number'],
            $data['assigned_to'],
            $data['status'],
            $data['purchase_date'],
            $data['warranty_expiry']
        ]);
        
        sendResponse('success', 'Device added successfully', ['id' => $pdo->lastInsertId()]);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function updateDevice() {
    global $pdo;
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $query = $pdo->prepare("
            UPDATE devices 
            SET device_name = ?, device_type = ?, serial_number = ?, assigned_to = ?, status = ?, purchase_date = ?, warranty_expiry = ?
            WHERE id = ?
        ");
        
        $query->execute([
            $data['device_name'],
            $data['device_type'],
            $data['serial_number'],
            $data['assigned_to'],
            $data['status'],
            $data['purchase_date'],
            $data['warranty_expiry'],
            $data['id']
        ]);
        
        sendResponse('success', 'Device updated successfully');
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function deleteDevice($id) {
    global $pdo;
    try {
        $query = $pdo->prepare("DELETE FROM devices WHERE id = ?");
        $query->execute([$id]);
        
        sendResponse('success', 'Device deleted successfully');
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}
?>