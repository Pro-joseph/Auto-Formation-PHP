<?php

class LessonController
{
    private $lessonModel;
    private $studentModel;

    public function __construct()
    {
        $this->lessonModel  = new Lesson();
        $this->studentModel = new Student();
    }

    // Get the list of all lessons (admin)
    public function index()
    {
        $lessons = $this->lessonModel->getAll();
        return ['lessons' => $lessons];
    }

    // Handle lesson creation form
    public function create()
    {
        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title    = trim($_POST['title'] ?? '');
            $coach    = trim($_POST['coach'] ?? '');
            $dateTime = $_POST['date_time'] ?? '';

            if ($title === '' || $coach === '' || $dateTime === '') {
                $error = 'Veuillez remplir tous les champs.';
            } else {
                $this->lessonModel->create($title, $coach, $dateTime);
                $success = 'Cours créé avec succès.';
            }
        }

        return ['error' => $error, 'success' => $success];
    }

    // Load the enroll page and handle enrollment form
    public function enroll($lessonId)
    {
        $error   = '';
        $success = '';

        $lesson = $this->lessonModel->getById($lessonId);

        if (!$lesson) {
            header('Location: lessons.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentId = (int)($_POST['student_id'] ?? 0);

            if ($studentId <= 0) {
                $error = 'Veuillez sélectionner un élève.';
            } else {
                $this->lessonModel->enrollStudent($lessonId, $studentId);
                $success = 'Élève inscrit avec succès.';
            }
        }

        // Available students (not already enrolled)
        $availableStudents  = $this->studentModel->getNotEnrolledInLesson($lessonId);
        $enrolledStudents   = $this->lessonModel->getEnrolledStudents($lessonId);

        return [
            'lesson'            => $lesson,
            'availableStudents' => $availableStudents,
            'enrolledStudents'  => $enrolledStudents,
            'error'             => $error,
            'success'           => $success,
        ];
    }

    // Get lessons for the logged-in student
    public function myLessons($studentId)
    {
        $lessons = $this->lessonModel->getLessonsForStudent($studentId);
        return ['lessons' => $lessons];
    }

    // Load the payment edit form and handle its submission
    public function updatePayment($lessonId, $studentId)
    {
        $error   = '';
        $success = '';

        $enrollment = $this->lessonModel->getEnrollment($lessonId, $studentId);

        if (!$enrollment) {
            header('Location: dashboard.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['payment_status'] ?? '';
            $allowed = ['Payé', 'En attente'];

            if (!in_array($status, $allowed)) {
                $error = 'Statut invalide.';
            } else {
                $this->lessonModel->updatePaymentStatus($lessonId, $studentId, $status);
                $success = 'Statut de paiement mis à jour.';
                // Reload the updated enrollment
                $enrollment = $this->lessonModel->getEnrollment($lessonId, $studentId);
            }
        }

        return [
            'enrollment' => $enrollment,
            'lessonId'   => $lessonId,
            'studentId'  => $studentId,
            'error'      => $error,
            'success'    => $success,
        ];
    }
}
