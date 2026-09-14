<!-- views/auth/register.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Регистрация</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($errorMsg)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($successMsg)): ?>
                        <div class="alert alert-success"><?= $successMsg ?></div>
                    <?php else: ?>
                        <form method="POST" action="/register">
                            <div class="mb-3">
                                <label class="form-label">Email адрес</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Пароль</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Подтверждение пароля</label>
                                <input type="password" name="password_confirm" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="/login">Уже есть аккаунт? Войти</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>