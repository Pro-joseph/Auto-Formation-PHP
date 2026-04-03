<?php
require_once "db.php";

class UserModel {
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function findUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($email, $passwordHash, $role = 'student') {
        $stmt = $this->conn->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }
}
