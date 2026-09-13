<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Доступ только авторизованным
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require __DIR__ . '/../config/db.php';

$stmt = $pdo->prepare("SELECT id, email, username, role, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Курсовой проект</a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-light btn-sm me-2">Главная</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Выход</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Личный кабинет</h4>
                </div>
                <div class="card-body">
                    <?php if ($user): ?>
                        <p><strong>ID:</strong> <?= htmlspecialchars((string)$user['id']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                        <p><strong>Имя:</strong> <?= htmlspecialchars($user['username'] ?? '—') ?></p>
                        <p><strong>Роль:</strong> <span class="badge bg-info"><?= htmlspecialchars($user['role']) ?></span></p>
                        <p><strong>Дата регистрации:</strong> <?= htmlspecialchars($user['created_at']) ?></p>
                    <?php else: ?>
                        <div class="alert alert-warning">Пользователь не найден.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>