<?php
session_start();

require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/User.php';
require_once __DIR__ . '/app/models/Student.php';
require_once __DIR__ . '/app/controllers/AuthController.php';

// If already logged in, redirect
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: dashboard.php');
    } else {
        header('Location: my_lessons.php');
    }
    exit;
}

$controller = new AuthController();
$data       = $controller->login();

extract($data); // makes $error available in the view

require_once __DIR__ . '/app/views/auth/login.php';
