<?php

require_once __DIR__ . '/../core/Model.php';

class Category extends Model
{
    // Mengambil semua kategori
    public function getAll()
    {
        $query = "
            SELECT
                categories.*,
                COUNT(products.id) AS total_products
            FROM categories
            LEFT JOIN products
                ON categories.id = products.category_id
            GROUP BY categories.id
            ORDER BY categories.id DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Mengambil kategori berdasarkan ID
    public function getById($id)
    {
        $query = "
            SELECT * FROM categories
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    // Memeriksa nama kategori
    public function nameExists($name, $excludeId = null)
    {
        $query = "
            SELECT COUNT(*)
            FROM categories
            WHERE name = :name
        ";

        $params = ['name' => $name];

        if ($excludeId !== null) {
            $query .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchColumn() > 0;
    }

    // Menambahkan kategori
    public function create($data)
    {
        $query = "
            INSERT INTO categories (name, description)
            VALUES (:name, :description)
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    // Mengubah kategori
    public function update($id, $data)
    {
        $data['id'] = $id;

        $query = "
            UPDATE categories
            SET name = :name,
                description = :description
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    // Menghapus kategori
    public function delete($id)
    {
        $query = "
            DELETE FROM categories
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute(['id' => $id]);
    }

    // Pencarian kategori
    public function search($keyword)
    {
        $query = "
            SELECT
                categories.*,
                COUNT(products.id) AS total_products
            FROM categories
            LEFT JOIN products
                ON categories.id = products.category_id
            WHERE categories.name LIKE :keyword
            GROUP BY categories.id
            ORDER BY categories.id DESC
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'keyword' => '%' . $keyword . '%'
        ]);

        return $stmt->fetchAll();
    }
}