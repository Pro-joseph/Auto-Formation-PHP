<?php

class StudentController
{
    private $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    // Get the list of all students (admin)
    public function index()
    {
        $students = $this->studentModel->getAll();
        return ['students' => $students];
    }

    // Load the edit form and handle its submission
    public function edit($id)
    {
        $error   = '';
        $success = '';

        $student = $this->studentModel->getById($id);

        if (!$student) {
            header('Location: students.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $level = $_POST['level'] ?? '';
            $allowedLevels = ['Débutant', 'Intermédiaire', 'Avancé'];

            if (!in_array($level, $allowedLevels)) {
                $error = 'Niveau invalide.';
            } else {
                $this->studentModel->updateLevel($id, $level);
                $success = 'Niveau mis à jour avec succès.';
                // Reload updated student data
                $student = $this->studentModel->getById($id);
            }
        }

        return [
            'student' => $student,
            'error'   => $error,
            'success' => $success,
        ];
    }
}
