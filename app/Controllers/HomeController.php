<?php
// app/Controllers/HomeController.php

class HomeController {
    public function index(): void {
        // В методичке нет home.php → просто отправляем на логин
        header('Location: /login');
        exit;
    }
}