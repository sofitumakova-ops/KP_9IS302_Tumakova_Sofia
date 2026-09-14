<!-- views/profile/index.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Добро пожаловать, <?= htmlspecialchars($user['username'] ?? 'Гость') ?>!</h2>
    <p>Ваш Email: <?= htmlspecialchars($user['email']) ?></p>

    <div class="card mt-4">
        <div class="card-header">Редактировать данные</div>
        <div class="card-body">
            <form method="POST" action="/profile/edit">
                <div class="mb-3">
                    <label>Имя для отображения</label>
                    <input type="text" name="username" class="form-control"
                           value="<?= htmlspecialchars($user['username'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label>Телефон</label>
                    <input type="text" name="phone" class="form-control"
                           value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </form>
        </div>
    </div>

    <a href="/logout" class="btn btn-danger mt-3">Выйти из системы</a>
</div>
</body>
</html>
