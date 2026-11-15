<?php

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Core MVC
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Router.php';

// Initialize Router
$router = new Router();

// Dispatch Request
$router->dispatch();