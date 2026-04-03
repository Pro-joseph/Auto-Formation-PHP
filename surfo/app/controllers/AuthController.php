<?php

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = 'Veuillez remplir tous les champs.';
            } else {
                $user = $this->userModel->login($email, $password);

                if ($user) {
                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];

                    if ($user['role'] === 'admin') {
                        header('Location: dashboard.php');
                    } else {
                        header('Location: my_lessons.php');
                    }
                    exit;
                } else {
                    $error = 'Email ou mot de passe incorrect.';
                }
            }
        }

        return ['error' => $error];
    }

    public function register()
    {
        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $country  = trim($_POST['country'] ?? '');
            $level    = $_POST['level'] ?? '';

            $allowedLevels = ['Débutant', 'Intermédiaire', 'Avancé'];
            
            if ($name === '' || $email === '' || $password === '' || $country === '' || $level === '') {
                $error = 'Veuillez remplir tous les champs.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse email invalide.';
            } elseif (!in_array($level, $allowedLevels)) {
                $error = 'Niveau invalide.';
            } elseif ($this->userModel->emailExists($email)) {
                $error = 'Cet email est déjà utilisé.';
            } else {

                $userId = $this->userModel->register($name, $email, $password, 'client');

                $studentModel = new Student();
                $studentModel->create($userId, $country, $level);

                $success = 'Compte créé avec succès ! Vous pouvez vous connecter.';
            }
        }

        return ['error' => $error, 'success' => $success];
    }

    public function logout()
    {
        session_destroy();
        header('Location: login.php');
        exit;
    }
}
