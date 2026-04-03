<?php

class Lesson
{
    // Private properties — encapsulation
    private $id;
    private $title;
    private $coach;
    private $dateTime;

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // --- Core methods ---

    // Create a new lesson
    public function create($title, $coach, $dateTime)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO lessons (title, coach, date_time) VALUES (:title, :coach, :date_time)'
        );

        $stmt->execute([
            ':title'     => $title,
            ':coach'     => $coach,
            ':date_time' => $dateTime,
        ]);

        return $this->pdo->lastInsertId();
    }

    // Get all lessons (for admin dashboard)
    public function getAll()
    {
        $stmt = $this->pdo->query(
            'SELECT * FROM lessons ORDER BY date_time ASC'
        );
        return $stmt->fetchAll();
    }

    // Get one lesson by id
    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM lessons WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Enroll a student in a lesson
    public function enrollStudent($lessonId, $studentId)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO enrollments (lesson_id, student_id) VALUES (:lesson_id, :student_id)'
        );

        $stmt->execute([
            ':lesson_id'  => $lessonId,
            ':student_id' => $studentId,
        ]);
    }

    // Get all lessons a given student is enrolled in, with payment status
    public function getLessonsForStudent($studentId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT lessons.id, lessons.title, lessons.coach, lessons.date_time,
                    enrollments.payment_status
             FROM lessons
             JOIN enrollments ON lessons.id = enrollments.lesson_id
             WHERE enrollments.student_id = :student_id
             ORDER BY lessons.date_time ASC'
        );
        $stmt->execute([':student_id' => $studentId]);
        return $stmt->fetchAll();
    }

    // Get students enrolled in a specific lesson
    public function getEnrolledStudents($lessonId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT students.id AS student_id, users.name, students.level, enrollments.payment_status
             FROM enrollments
             JOIN students ON enrollments.student_id = students.id
             JOIN users ON students.user_id = users.id
             WHERE enrollments.lesson_id = :lesson_id'
        );
        $stmt->execute([':lesson_id' => $lessonId]);
        return $stmt->fetchAll();
    }

    // Get one enrollment row for a given student + lesson
    public function getEnrollment($lessonId, $studentId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT enrollments.payment_status, users.name, lessons.title
             FROM enrollments
             JOIN students ON enrollments.student_id = students.id
             JOIN users    ON students.user_id = users.id
             JOIN lessons  ON enrollments.lesson_id = lessons.id
             WHERE enrollments.lesson_id = :lesson_id
               AND enrollments.student_id = :student_id
             LIMIT 1'
        );
        $stmt->execute([':lesson_id' => $lessonId, ':student_id' => $studentId]);
        return $stmt->fetch();
    }

    // Update the payment status for a student in a lesson
    public function updatePaymentStatus($lessonId, $studentId, $status)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE enrollments
             SET payment_status = :status
             WHERE lesson_id = :lesson_id AND student_id = :student_id'
        );
        $stmt->execute([
            ':status'     => $status,
            ':lesson_id'  => $lessonId,
            ':student_id' => $studentId,
        ]);
    }

    // Calculate the average number of students per lesson (bonus stat)
    public function getAverageStudentsPerLesson()
    {
        $stmt = $this->pdo->query(
            'SELECT COUNT(*) / (SELECT COUNT(*) FROM lessons) AS avg_students FROM enrollments'
        );
        $row = $stmt->fetch();

        if (!$row || $row['avg_students'] === null) {
            return 0;
        }

        return round($row['avg_students'], 1);
    }
}
