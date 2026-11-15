<?php

class Supplier extends Model
{
    // Mengambil seluruh supplier
    public function getAll()
    {
        $query = "
            SELECT
                suppliers.*,
                COUNT(products.id) AS total_products
            FROM suppliers
            LEFT JOIN products
                ON suppliers.id = products.supplier_id
            GROUP BY suppliers.id
            ORDER BY suppliers.id DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Mengambil supplier berdasarkan ID
    public function getById($id)
    {
        $query = "
            SELECT *
            FROM suppliers
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    // Memeriksa nama supplier
    public function nameExists($name, $excludeId = null)
    {
        $query = "
            SELECT COUNT(*)
            FROM suppliers
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

    // Menambahkan supplier
    public function create($data)
    {
        $query = "
            INSERT INTO suppliers
            (name, contact_person, phone, email, address)
            VALUES
            (:name, :contact_person, :phone, :email, :address)
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    // Memperbarui supplier
    public function update($id, $data)
    {
        $data['id'] = $id;

        $query = "
            UPDATE suppliers
            SET
                name = :name,
                contact_person = :contact_person,
                phone = :phone,
                email = :email,
                address = :address
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    // Menghapus supplier
    public function delete($id)
    {
        $query = "
            DELETE FROM suppliers
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute(['id' => $id]);
    }

    // Mencari supplier
    public function search($keyword)
    {
        $query = "
            SELECT
                suppliers.*,
                COUNT(products.id) AS total_products
            FROM suppliers
            LEFT JOIN products
                ON suppliers.id = products.supplier_id
            WHERE
                suppliers.name LIKE :keyword
                OR suppliers.contact_person LIKE :keyword
                OR suppliers.email LIKE :keyword
            GROUP BY suppliers.id
            ORDER BY suppliers.id DESC
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'keyword' => '%' . $keyword . '%'
        ]);

        return $stmt->fetchAll();
    }
}