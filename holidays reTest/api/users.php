<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'GET':
        if ($action === 'stats') {
            getStats();
        } elseif ($action === 'recent-orders') {
            getRecentOrders();
        } else {
            sendResponse('error', 'Invalid action');
        }
        break;

    default:
        sendResponse('error', 'Invalid request method');
}

function getStats() {
    global $pdo;
    try {
        $totalEmployers = $pdo->query("SELECT COUNT(*) as count FROM employers")->fetch()['count'];
        $totalDevices = $pdo->query("SELECT COUNT(*) as count FROM devices")->fetch()['count'];
        $activeEmployers = $pdo->query("SELECT COUNT(*) as count FROM employers WHERE status = 'Active'")->fetch()['count'];
        $activeDevices = $pdo->query("SELECT COUNT(*) as count FROM devices WHERE status = 'Active'")->fetch()['count'];
        
        sendResponse('success', 'Stats retrieved', [
            'total_employers' => $totalEmployers,
            'total_devices' => $totalDevices,
            'active_employers' => $activeEmployers,
            'active_devices' => $activeDevices
        ]);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}

function getRecentOrders() {
    global $pdo;
    try {
        $query = $pdo->query("
            SELECT d.id, d.device_name, e.name as employee_name, d.purchase_date, d.status
            FROM devices d
            LEFT JOIN employers e ON d.assigned_to = e.id
            ORDER BY d.created_at DESC
            LIMIT 10
        ");
        $orders = $query->fetchAll(PDO::FETCH_ASSOC);
        sendResponse('success', 'Recent orders retrieved', $orders);
    } catch (Exception $e) {
        sendResponse('error', $e->getMessage());
    }
}
?>