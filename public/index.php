<?php
// public_html/index.php
declare(strict_types=1);

// Отладка — УБРАТЬ после проверки!
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// __DIR__ — критично, чтобы не словить "db.php not found"
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/Core/Router.php';

$router = new Router();

// РЕГИСТРАЦИЯ МАРШРУТОВ
$router->add('/',             'HomeController',    'index');
$router->add('/login',        'AuthController',    'login');
$router->add('/register',     'AuthController',    'register');
$router->add('/logout',       'AuthController',    'logout');
$router->add('/profile',      'ProfileController', 'index');
$router->add('/profile/edit', 'ProfileController', 'edit');

// ЗАПУСК
$router->dispatch($_SERVER['REQUEST_URI']);