<?php

class Student
{
    // Private properties — encapsulation
    private $id;
    private $userId;
    private $country;
    private $level;

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // --- Getters ---

    public function getId()
    {
        return $this->id;
    }

    public function getLevel()
    {
        return $this->level;
    }

    // --- Core methods ---

    // Create a student profile linked to a user account
    public function create($userId, $country, $level)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO students (user_id, country, level) VALUES (:user_id, :country, :level)'
        );

        $stmt->execute([
            ':user_id'  => $userId,
            ':country'  => $country,
            ':level'    => $level,
        ]);

        return $this->pdo->lastInsertId();
    }

    // Get all students with their user name and country (for admin)
    public function getAll()
    {
        $stmt = $this->pdo->query(
            'SELECT students.id, users.name, students.country, students.level
             FROM students
             JOIN users ON students.user_id = users.id
             ORDER BY users.name ASC'
        );

        return $stmt->fetchAll();
    }

    // Get one student row by student id
    public function getById($id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT students.id, users.name, students.country, students.level, students.user_id
             FROM students
             JOIN users ON students.user_id = users.id
             WHERE students.id = :id
             LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Find the student row that belongs to a given user_id
    public function getByUserId($userId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM students WHERE user_id = :user_id LIMIT 1'
        );
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch();
    }

    // Update the level of a student
    public function updateLevel($id, $level)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE students SET level = :level WHERE id = :id'
        );

        $stmt->execute([
            ':level' => $level,
            ':id'    => $id,
        ]);
    }

    // Get all students not yet enrolled in a given lesson
    public function getNotEnrolledInLesson($lessonId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT students.id, users.name, students.level
             FROM students
             JOIN users ON students.user_id = users.id
             WHERE students.id NOT IN (
                 SELECT student_id FROM enrollments WHERE lesson_id = :lesson_id
             )
             ORDER BY users.name ASC'
        );
        $stmt->execute([':lesson_id' => $lessonId]);
        return $stmt->fetchAll();
    }
}
