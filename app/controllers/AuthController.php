<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = $this->model('User');
    }

    /**
     * Menampilkan halaman login.
     */
    public function login()
    {
        // Jika sudah login, arahkan ke dashboard.
        if (isset($_SESSION['user'])) {
            header('Location: index.php?url=dashboard/index');
            exit;
        }

        $data = [
            'title' => 'Login - Stockify',
            'error' => $_SESSION['login_error'] ?? ''
        ];

        unset($_SESSION['login_error']);

        $this->view('auth/login', $data);
    }

    /**
     * Memproses autentikasi pengguna.
     */
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $_SESSION['login_error'] = 'Email atau password tidak valid.';
            header('Location: index.php?url=auth/login');
            exit;
        }

        $user = $this->user->findByEmail($email);

        if (!$user || !$this->user->verifyPassword($password, $user['password'])) {
            $_SESSION['login_error'] = 'Email atau password salah.';
            header('Location: index.php?url=auth/login');
            exit;
        }

        if (!in_array($user['role'], ['admin', 'staff'], true)) {
            $_SESSION['login_error'] = 'Role pengguna tidak valid.';
            header('Location: index.php?url=auth/login');
            exit;
        }

        // Membuat ID session baru setelah login.
        session_regenerate_id(true);

        // Simpan informasi pengguna ke session.
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        header('Location: index.php?url=dashboard/index');
        exit;
    }

    /**
     * Proses logout.
     */
    public function logout()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: index.php?url=auth/login');
        exit;
    }
}