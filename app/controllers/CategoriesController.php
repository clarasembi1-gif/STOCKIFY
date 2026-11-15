<?php

class CategoriesController extends Controller
{
    private $category;

    public function __construct()
    {
        $this->category = $this->model('Category');
    }

    // Menampilkan kategori
    public function index()
    {
        $keyword = trim($_GET['search'] ?? '');

        $categories = $keyword !== ''
            ? $this->category->search($keyword)
            : $this->category->getAll();

        $data = [
            'title' => 'Categories - Stockify',
            'categories' => $categories,
            'keyword' => $keyword
        ];

        $this->view('categories/index', $data);
    }

    // Form tambah kategori
    public function create()
    {
        $data = [
            'title' => 'Add Category - Stockify'
        ];

        $this->view('categories/create', $data);
    }

    // Menyimpan kategori
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name === '' || mb_strlen($name) > 100) {
            exit('Nama kategori wajib diisi dan maksimal 100 karakter.');
        }

        if ($this->category->nameExists($name)) {
            exit('Nama kategori sudah digunakan.');
        }

        $this->category->create([
            'name' => $name,
            'description' => $description
        ]);

        $this->redirect('categories/index');
    }

    // Form edit kategori
    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            exit('ID kategori tidak valid.');
        }

        $category = $this->category->getById($id);

        if (!$category) {
            http_response_code(404);
            exit('Kategori tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Category - Stockify',
            'category' => $category
        ];

        $this->view('categories/edit', $data);
    }

    // Memperbarui kategori
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id || !$this->category->getById($id)) {
            http_response_code(404);
            exit('Kategori tidak ditemukan.');
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name === '' || mb_strlen($name) > 100) {
            exit('Nama kategori tidak valid.');
        }

        if ($this->category->nameExists($name, $id)) {
            exit('Nama kategori sudah digunakan.');
        }

        $this->category->update($id, [
            'name' => $name,
            'description' => $description
        ]);

        $this->redirect('categories/index');
    }

    // Menghapus kategori
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            exit('ID kategori tidak valid.');
        }

        try {
            $this->category->delete($id);
            $this->redirect('categories/index');

        } catch (PDOException $e) {
            http_response_code(409);
            exit('Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }
    }

    private function redirect($url)
    {
        header('Location: index.php?url=' . urlencode($url));
        exit;
    }
}