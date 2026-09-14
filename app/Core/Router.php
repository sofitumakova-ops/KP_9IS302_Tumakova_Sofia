<?php
// app/Core/Router.php

class Router {
    private array $routes = [];

    public function add(string $path, string $controller, string $action): void {
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }
        $this->routes[$path] = [
            'controller' => $controller,
            'action'     => $action,
        ];
    }

    public function dispatch(string $uri): void {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        if (!isset($this->routes[$path])) {
            http_response_code(404);
            echo "<h1>404 — Страница не найдена</h1>";
            echo "<p>Путь: <b>" . htmlspecialchars($path) . "</b></p>";
            echo "<p>Маршруты: <b>" . htmlspecialchars(implode(', ', array_keys($this->routes))) . "</b></p>";
            return;
        }

        $controller = $this->routes[$path]['controller'];
        $action     = $this->routes[$path]['action'];

        // __DIR__ — критично, чтобы не словить "controller not found"
        $controllerFile = __DIR__ . '/../Controllers/' . $controller . '.php';

        if (!file_exists($controllerFile)) {
            http_response_code(500);
            echo "Контроллер не найден: " . htmlspecialchars($controllerFile);
            return;
        }

        require_once $controllerFile;
        $instance = new $controller();
        $instance->$action();
    }
}