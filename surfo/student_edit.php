<?php
session_start();

require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/Student.php';
require_once __DIR__ . '/app/controllers/StudentController.php';

// Only admin can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: dashboard.php');
    exit;
}

$controller = new StudentController();
$data       = $controller->edit($id);

extract($data); // makes $student, $error, $success available in the view

require_once __DIR__ . '/app/views/students/edit.php';
