<?php
// app/Controllers/ProfileController.php

class ProfileController {

    private function checkAuth(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    // GET /profile
    public function index(): void {
        $this->checkAuth();
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (!$user) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        require_once __DIR__ . '/../../views/profile/index.php';
    }

    // GET/POST /profile/edit
    public function edit(): void {
        $this->checkAuth();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $phone    = trim($_POST['phone'] ?? '');

            $sql  = "UPDATE users SET username = ?, phone = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username, $phone, $_SESSION['user_id']]);
        }

        // Всегда возвращаемся в профиль (форма там же)
        header('Location: /profile');
        exit;
    }
}