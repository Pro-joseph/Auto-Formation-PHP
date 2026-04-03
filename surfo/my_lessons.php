<?php
session_start();

require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/Student.php';
require_once __DIR__ . '/app/models/Lesson.php';
require_once __DIR__ . '/app/controllers/LessonController.php';

// Only logged-in clients can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
    header('Location: login.php');
    exit;
}

// Find the student profile linked to this user
$studentModel = new Student();
$student      = $studentModel->getByUserId($_SESSION['user_id']);

if (!$student) {
    // Should not happen, but guard anyway
    session_destroy();
    header('Location: login.php');
    exit;
}

$controller = new LessonController();
$data       = $controller->myLessons($student['id']);

extract($data); // makes $lessons available in the view

require_once __DIR__ . '/app/views/students/my_lessons.php';
