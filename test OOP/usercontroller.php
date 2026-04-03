<?php
require_once "usermodel.php";

class AuthController {
    private $userModel;
    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['register'])) {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['psw'] ?? '';
            $passwordRepeat = $_POST['psw-repeat'] ?? '';

            if (!$email || !$password || !$passwordRepeat) {
                echo '<p style="color:red">All fields are required.</p>';
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo '<p style="color:red">Invalid email format.</p>';
                return;
            }

            if ($password !== $passwordRepeat) {
                echo '<p style="color:red">Passwords do not match.</p>';
                return;
            }

            if ($this->userModel->findUserByEmail($email)) {
                echo '<p style="color:red">Email already registered.</p>';
                return;
            }

            $passHash = password_hash($password, PASSWORD_DEFAULT);
            $success = $this->userModel->createUser($email, $passHash);

            if ($success) {
                echo '<p style="color:green">Registration successful. Please login.</p>';
                return;
            }

            echo '<p style="color:red">Could not create user. Try again later.</p>';
        }
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['login'])) {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['pswd'] ?? '';

            if (!$email || !$password) {
                echo '<p style="color:red">Email and password are required.</p>';
                return;
            }

            $user = $this->userModel->findUserByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                echo '<p style="color:red">Invalid credentials.</p>';
                return;
            }

            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'] ?? 'student'
            ];

            echo '<p style="color:green">Login successful. Welcome ' . htmlspecialchars($user['email']) . '!</p>';
            return;
        }
    }
}
