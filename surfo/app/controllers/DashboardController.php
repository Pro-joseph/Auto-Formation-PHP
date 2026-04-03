<?php

class DashboardController
{
    private $studentModel;
    private $lessonModel;

    public function __construct()
    {
        $this->studentModel = new Student();
        $this->lessonModel  = new Lesson();
    }

    // Load data for the admin dashboard
    public function index()
    {
        $students   = $this->studentModel->getAll();
        $lessons    = $this->lessonModel->getAll();
        $avgStudents = $this->lessonModel->getAverageStudentsPerLesson();

        return [
            'students'    => $students,
            'lessons'     => $lessons,
            'avgStudents' => $avgStudents,
        ];
    }
}
