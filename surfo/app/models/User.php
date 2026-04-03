<?php

class User
{
    // Private properties — encapsulation
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;

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

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRole()
    {
        return $this->role;
    }

    // --- Core methods ---

    // Register a new user and return the new user's id
    public function register($name, $email, $plainPassword, $role = 'client')
    {
        $hash = password_hash($plainPassword, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)'
        );

        $stmt->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':password' => $hash,
            ':role'     => $role,
        ]);

        return $this->pdo->lastInsertId();
    }

    // Find a user by email and verify the password. Returns user row or false.
    public function login($email, $plainPassword)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($plainPassword, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Check if an email is already taken
    public function emailExists($email)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }
}
