<?php

require_once __DIR__ . '/../core/Model.php';

class User extends Model
{
    /**
     * Mencari pengguna berdasarkan email.
     */
    public function findByEmail($email)
    {
        $query = "SELECT id, name, email, password, role
                  FROM users
                  WHERE email = :email
                  LIMIT 1";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Mencari pengguna berdasarkan ID.
     */
    public function findById($id)
    {
        $query = "SELECT id, name, email, role
                  FROM users
                  WHERE id = :id
                  LIMIT 1";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Memverifikasi password pengguna.
     */
    public function verifyPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}