<?php

require_once 'app/models/User.php';

class AuthController
{
    

    public function showLoginForm()
    {
        require_once 'app/views/auth/login.php';
    }

    public function login()
    {
        $user = new User();
        $db_user = $user->findByUsername($_POST['username']);

        if ($db_user && password_verify($_POST['password'], $db_user['password'])) {
            $_SESSION['user_id'] = $db_user['id'];
            $_SESSION['full_name'] = $db_user['full_name'];
            $_SESSION['role'] = $db_user['role'];
            $_SESSION['profile_picture'] = $db_user['profile_picture'];
            header('Location: /energy-system/dashboard');
            exit();
        } else {
            $_SESSION['flash_message'] = 'Usuário ou senha inválidos.';
            header('Location: /energy-system/login');
            exit();
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /energy-system/login');
        exit();
    }

    public function changePassword()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /energy-system/login');
            exit();
        }

        $userModel = new User();
        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            $user = $userModel->findById($user_id);

            if (!$user || !password_verify($current_password, $user['password'])) {
                $error = "Senha atual incorreta.";
            } elseif ($new_password !== $confirm_password) {
                $error = "A nova senha e a confirmação não coincidem.";
            } elseif (empty($new_password) || strlen($new_password) < 6) { // Example: minimum 6 characters
                $error = "A nova senha deve ter pelo menos 6 caracteres.";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                if ($userModel->updatePassword($user_id, $hashed_password)) {
                    $message = "Senha alterada com sucesso!";
                } else {
                    $error = "Erro ao alterar a senha.";
                }
            }
        }

        require_once 'app/views/auth/change_password.php';
    }
}