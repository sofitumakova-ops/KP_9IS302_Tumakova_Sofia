<?php
// app/Controllers/AuthController.php

class AuthController {

    // ---------- LOGIN ----------
    public function login(): void {
        global $pdo;

        if (isset($_SESSION['user_id'])) {
            header('Location: /profile');
            exit;
        }

        $errorMsg = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $pass  = $_POST['password'] ?? '';

            if (empty($email) || empty($pass)) {
                $errorMsg = 'Заполните все поля!';
            } else {
                $stmt = $pdo->prepare("SELECT id, password_hash, role FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($pass, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role']    = $user['role'];
                    header('Location: /profile');
                    exit;
                }
                $errorMsg = 'Неверный логин или пароль.';
            }
        }

        require_once __DIR__ . '/../../views/auth/login.php';
    }

    // ---------- REGISTER (дописываем сами — в методичке пусто) ----------
    public function register(): void {
        global $pdo;

        if (isset($_SESSION['user_id'])) {
            header('Location: /profile');
            exit;
        }

        $errorMsg   = '';
        $successMsg = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email       = trim($_POST['email'] ?? '');
            $pass        = $_POST['password'] ?? '';
            $passConfirm = $_POST['password_confirm'] ?? '';

            if (empty($email) || empty($pass)) {
                $errorMsg = 'Заполните все поля!';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMsg = 'Некорректный формат Email!';
            } elseif ($pass !== $passConfirm) {
                $errorMsg = 'Пароли не совпадают!';
            } else {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $sql  = "INSERT INTO users (email, password_hash, role) VALUES (:email, :hash, 'client')";
                $stmt = $pdo->prepare($sql);

                try {
                    $stmt->execute([':email' => $email, ':hash' => $hash]);
                    $successMsg = 'Регистрация успешна! <a href="/login">Войти</a>';
                } catch (PDOException $e) {
                    if ((int)$e->getCode() === 23000) {
                        $errorMsg = 'Такой email уже зарегистрирован.';
                    } else {
                        $errorMsg = 'Ошибка БД: ' . $e->getMessage();
                    }
                }
            }
        }

        require_once __DIR__ . '/../../views/auth/register.php';
    }

    // ---------- LOGOUT ----------
    public function logout(): void {
        $_SESSION = [];
        session_destroy();
        header('Location: /login');
        exit;
    }
}