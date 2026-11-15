<?php

class Router
{
    public function dispatch()
    {
        // Ambil URL
        $url = $_GET['url'] ?? 'dashboard/index';

        $url = trim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);

        $segments = explode('/', $url);

        $controllerName = ucfirst($segments[0]) . 'Controller';
        $method = $segments[1] ?? 'index';

        // Halaman yang boleh diakses tanpa login
        $publicRoutes = [
            'auth/login',
            'auth/authenticate'
        ];

        $currentRoute = strtolower($segments[0] . '/' . $method);

        // Periksa status login
        if (
            !isset($_SESSION['user']) &&
            !in_array($currentRoute, $publicRoutes, true)
        ) {
            header('Location: index.php?url=auth/login');
            exit;
        }

        // Lokasi file controller
        $controllerFile = __DIR__ .
            '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            http_response_code(404);
            die('Controller not found');
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            http_response_code(404);
            die('Invalid controller');
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            http_response_code(404);
            die('Method not found');
        }

        // Jalankan method controller
        $controller->$method();
    }
}