<?php

require_once __DIR__ . '/../core/Model.php';

class Product extends Model
{
    // Mengambil seluruh produk
    public function getAll()
    {
        $query = "
            SELECT
                products.*,
                categories.name AS category_name,
                suppliers.name AS supplier_name
            FROM products
            LEFT JOIN categories
                ON products.category_id = categories.id
            LEFT JOIN suppliers
                ON products.supplier_id = suppliers.id
            ORDER BY products.id DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Mengambil satu produk
    public function getById($id)
    {
        $query = "SELECT * FROM products WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    // Menambahkan produk
    public function create($data)
    {
        $query = "
            INSERT INTO products
            (
                category_id,
                supplier_id,
                sku,
                name,
                description,
                purchase_price,
                selling_price,
                stock_quantity,
                minimum_stock,
                unit
            )
            VALUES
            (
                :category_id,
                :supplier_id,
                :sku,
                :name,
                :description,
                :purchase_price,
                :selling_price,
                :stock_quantity,
                :minimum_stock,
                :unit
            )
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    // Mengubah produk
    public function update($id, $data)
    {
        $data['id'] = $id;

        $query = "
            UPDATE products SET
                category_id = :category_id,
                supplier_id = :supplier_id,
                sku = :sku,
                name = :name,
                description = :description,
                purchase_price = :purchase_price,
                selling_price = :selling_price,
                stock_quantity = :stock_quantity,
                minimum_stock = :minimum_stock,
                unit = :unit
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    // Menghapus produk
    public function delete($id)
    {
        $query = "DELETE FROM products WHERE id = :id";

        $stmt = $this->db->prepare($query);

        return $stmt->execute(['id' => $id]);
    }

    // Pencarian produk
    public function search($keyword)
    {
        $query = "
            SELECT
                products.*,
                categories.name AS category_name,
                suppliers.name AS supplier_name
            FROM products
            LEFT JOIN categories
                ON products.category_id = categories.id
            LEFT JOIN suppliers
                ON products.supplier_id = suppliers.id
            WHERE products.name LIKE :keyword
               OR products.sku LIKE :keyword
            ORDER BY products.id DESC
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'keyword' => '%' . $keyword . '%'
        ]);

        return $stmt->fetchAll();
    }

    // Mengambil kategori
    public function getCategories()
    {
        $stmt = $this->db->query(
            "SELECT * FROM categories ORDER BY name ASC"
        );

        return $stmt->fetchAll();
    }

    // Mengambil supplier
    public function getSuppliers()
    {
        $stmt = $this->db->query(
            "SELECT * FROM suppliers ORDER BY name ASC"
        );

        return $stmt->fetchAll();
    }
    // Memeriksa SKU sudah digunakan atau belum
public function skuExists($sku)
{
    $query = "SELECT COUNT(*) FROM products WHERE sku = :sku";

    $stmt = $this->db->prepare($query);
    $stmt->execute(['sku' => $sku]);

    return $stmt->fetchColumn() > 0;
}
}
