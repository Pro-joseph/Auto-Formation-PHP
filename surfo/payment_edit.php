<?php
session_start();

require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/Lesson.php';
require_once __DIR__ . '/app/models/Student.php';
require_once __DIR__ . '/app/controllers/LessonController.php';

// Only admin can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$lessonId  = (int)($_GET['lesson_id']  ?? 0);
$studentId = (int)($_GET['student_id'] ?? 0);

if ($lessonId <= 0 || $studentId <= 0) {
    header('Location: dashboard.php');
    exit;
}

$controller = new LessonController();
$data       = $controller->updatePayment($lessonId, $studentId);

extract($data); // makes $enrollment, $lessonId, $studentId, $error, $success available in the view

require_once __DIR__ . '/app/views/lessons/payment_edit.php';
