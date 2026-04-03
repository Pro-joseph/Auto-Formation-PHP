<?php
session_start();

require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/Student.php';
require_once __DIR__ . '/app/models/Lesson.php';
require_once __DIR__ . '/app/controllers/DashboardController.php';

// Only admin can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$controller = new DashboardController();
$data       = $controller->index();

extract($data); // makes $students, $lessons, $avgStudents available in the view

require_once __DIR__ . '/app/views/dashboard/index.php';
