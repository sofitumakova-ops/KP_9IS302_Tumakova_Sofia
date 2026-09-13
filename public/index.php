<?php
declare(strict_types=1);
header('Content-Type: text/html; charset=utf-8');

// Временно — для отладки. Убрать после проверки!
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$phpVersion = phpversion();
$dbStatus   = '❌ Не подключена';

$configFile = __DIR__ . '/../config/db.php';

if (!file_exists($configFile)) {
    $dbStatus = '❌ Файл config/db.php не найден: ' . htmlspecialchars($configFile);
} else {
    try {
        require $configFile;        // создаёт $pdo
        $pdo->query('SELECT 1');    // проверка живости
        $dbStatus = '✅ Успешное подключение к MySQL (PDO)!';
    } catch (Throwable $e) {
        $dbStatus = '❌ Ошибка: ' . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Курсовой проект — Стенд готов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow" style="max-width: 640px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🚀 Курсовой проект: Стенд инициализирован</h4>
        </div>
        <div class="card-body">
            <p><strong>Версия PHP:</strong>
                <span class="badge bg-secondary"><?= htmlspecialchars($phpVersion) ?></span>
            </p>
            <p><strong>Статус СУБД:</strong> <?= $dbStatus ?></p>
            <hr>
            <div class="d-flex gap-2">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="btn btn-primary btn-sm">Профиль</a>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">Выход</a>
                <?php else: ?>
                    <a href="register.php" class="btn btn-success btn-sm">Регистрация</a>
                    <a href="login.php" class="btn btn-primary btn-sm">Вход</a>
                <?php endif; ?>
            </div>
            <p class="mt-3 mb-0"><em>ПМ.09 / МДК.09.01</em></p>
        </div>
    </div>
</div>
</body>
</html>