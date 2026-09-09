<?php
// public/index.php — Диагностическая панель готовности стенда
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

$phpVersion = phpversion();
$dbStatus = 'Не подключена (требуется настройка config/db.php)';

// Если локально или на сервере создан боевой config/db.php
$configFile = __DIR__ . '/../config/db.php';
if (file_exists($configFile)) {
    $dbConfig = require $configFile;
    try {
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
        $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $dbStatus = '✅ Успешное подключение к MySQL (PDO)!';
    } catch (PDOException $e) {
        $dbStatus = '❌ Ошибка подключения к MySQL: ' . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Курсовой проект — Стенд готов</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; margin: 40px; background: #f4f6f8; }
        .card { background: white; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); max-width: 600px; }
        h1 { color: #1e293b; margin-top: 0; font-size: 20px; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-weight: bold; background: #e2e8f0; }
        .ok { color: #15803d; }
    </style>
</head>
<body>
    <div class="card">
        <h1>🚀 Курсовой проект: Стенд инициализирован</h1>
        <p><strong>Версия PHP на хостинге:</strong> <span class="badge"><?= htmlspecialchars($phpVersion) ?></span></p>
        <p><strong>Статус СУБД:</strong> <?= $dbStatus ?></p>
        <hr>
        <p><em>Профессиональный модуль ПМ.09 / МДК.09.01</em></p>
    </div>
</body>
</html>