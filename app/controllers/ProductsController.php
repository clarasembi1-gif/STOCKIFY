<?php

class ProductsController extends Controller
{
    private $product;

    public function __construct()
    {
        $this->product = $this->model('Product');
    }

    // Menampilkan produk
    public function index()
    {
        $keyword = trim($_GET['search'] ?? '');

        $products = $keyword !== ''
            ? $this->product->search($keyword)
            : $this->product->getAll();

        $data = [
            'title' => 'Products - Stockify',
            'products' => $products,
            'keyword' => $keyword
        ];

        $this->view('products/index', $data);
    }

    // Form tambah produk
    public function create()
    {
        $data = [
            'title' => 'Add Product - Stockify',
            'categories' => $this->product->getCategories(),
            'suppliers' => $this->product->getSuppliers()
        ];

        $this->view('products/create', $data);
    }

    // Menyimpan produk
    public function store()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method not allowed');
    }

    $data = $this->getFormData();

    if (!$this->validateProduct($data)) {
        exit('Data produk tidak valid. Periksa kembali input kamu.');
    }

    // Periksa SKU duplikat
    if ($this->product->skuExists($data['sku'])) {
        exit('SKU sudah digunakan. Gunakan SKU yang berbeda.');
    }

    try {
        $this->product->create($data);

        $this->redirect('products/index');

    } catch (PDOException $e) {
        exit('Gagal menyimpan produk. Periksa kembali data dan struktur database.');
    }
}

    // Form edit
    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            exit('ID produk tidak valid.');
        }

        $product = $this->product->getById($id);

        if (!$product) {
            http_response_code(404);
            exit('Produk tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Product - Stockify',
            'product' => $product,
            'categories' => $this->product->getCategories(),
            'suppliers' => $this->product->getSuppliers()
        ];

        $this->view('products/edit', $data);
    }

    // Memperbarui produk
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id || !$this->product->getById($id)) {
            http_response_code(404);
            exit('Produk tidak ditemukan.');
        }

        $data = $this->getFormData();

        if (!$this->validateProduct($data)) {
            exit('Data produk tidak valid.');
        }

        $this->product->update($id, $data);

        $this->redirect('products/index');
    }

    // Menghapus produk
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method not allowed');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            exit('ID produk tidak valid.');
        }

        try {
            $this->product->delete($id);
            $this->redirect('products/index');
        } catch (PDOException $e) {
            http_response_code(409);
            exit('Produk tidak dapat dihapus karena memiliki riwayat stok.');
        }
    }

    private function getFormData()
    {
        return [
            'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
            'supplier_id' => ($_POST['supplier_id'] ?? '') !== ''
                ? filter_var($_POST['supplier_id'], FILTER_VALIDATE_INT)
                : null,
            'sku' => trim($_POST['sku'] ?? ''),
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'purchase_price' => $_POST['purchase_price'] ?? '',
            'selling_price' => $_POST['selling_price'] ?? '',
            'stock_quantity' => $_POST['stock_quantity'] ?? '',
            'minimum_stock' => $_POST['minimum_stock'] ?? '',
            'unit' => trim($_POST['unit'] ?? '')
        ];
    }

    private function validateProduct($data)
    {
        return
            $data['category_id'] !== false &&
            $data['category_id'] !== null &&
            $data['sku'] !== '' &&
            $data['name'] !== '' &&
            $data['purchase_price'] !== '' &&
            is_numeric($data['purchase_price']) &&
            $data['purchase_price'] >= 0 &&
            $data['selling_price'] !== '' &&
            is_numeric($data['selling_price']) &&
            $data['selling_price'] >= 0 &&
            filter_var($data['stock_quantity'], FILTER_VALIDATE_INT) !== false &&
            $data['stock_quantity'] >= 0 &&
            filter_var($data['minimum_stock'], FILTER_VALIDATE_INT) !== false &&
            $data['minimum_stock'] >= 0 &&
            $data['unit'] !== '';
    }

    private function redirect($url)
    {
        header(
            'Location: index.php?url=' . urlencode($url)
        );
        exit;
    }
}