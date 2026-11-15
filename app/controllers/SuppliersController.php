<?php

class SuppliersController extends Controller
{
    private $supplier;

    public function __construct()
    {
        $this->supplier = $this->model('Supplier');
    }

    // Menampilkan supplier
    public function index()
    {
        $keyword = trim($_GET['search'] ?? '');

        $suppliers = $keyword !== ''
            ? $this->supplier->search($keyword)
            : $this->supplier->getAll();

        $data = [
            'title' => 'Suppliers - Stockify',
            'suppliers' => $suppliers,
            'keyword' => $keyword
        ];

        $this->view('suppliers/index', $data);
    }

    // Form tambah supplier
    public function create()
    {
        $data = [
            'title' => 'Add Supplier - Stockify'
        ];

        $this->view('suppliers/create', $data);
    }

    // Menyimpan supplier
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $data = $this->getSupplierData();

        $this->validateSupplier($data);

        if ($this->supplier->nameExists($data['name'])) {
            exit('Nama supplier sudah digunakan.');
        }

        $this->supplier->create($data);

        $this->redirect('suppliers/index');
    }

    // Form edit supplier
    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            exit('ID supplier tidak valid.');
        }

        $supplier = $this->supplier->getById($id);

        if (!$supplier) {
            http_response_code(404);
            exit('Supplier tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Supplier - Stockify',
            'supplier' => $supplier
        ];

        $this->view('suppliers/edit', $data);
    }

    // Memperbarui supplier
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id || !$this->supplier->getById($id)) {
            http_response_code(404);
            exit('Supplier tidak ditemukan.');
        }

        $data = $this->getSupplierData();

        $this->validateSupplier($data);

        if ($this->supplier->nameExists($data['name'], $id)) {
            exit('Nama supplier sudah digunakan.');
        }

        $this->supplier->update($id, $data);

        $this->redirect('suppliers/index');
    }

    // Menghapus supplier
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            exit('ID supplier tidak valid.');
        }

        try {
            $this->supplier->delete($id);
            $this->redirect('suppliers/index');

        } catch (PDOException $e) {
            http_response_code(409);
            exit('Supplier tidak dapat dihapus karena masih digunakan oleh produk.');
        }
    }

    // Mengambil data form
    private function getSupplierData()
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'contact_person' => trim($_POST['contact_person'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'address' => trim($_POST['address'] ?? '')
        ];
    }

    // Validasi supplier
    private function validateSupplier($data)
    {
        if ($data['name'] === '' || mb_strlen($data['name']) > 100) {
            exit('Nama supplier wajib diisi dan maksimal 100 karakter.');
        }

        if (
            $data['email'] !== ''
            && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        ) {
            exit('Format email tidak valid.');
        }
    }

    // Redirect
    private function redirect($url)
    {
        header('Location: index.php?url=' . urlencode($url));
        exit;
    }
}