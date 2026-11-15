<?php

require_once __DIR__ . '/../core/Model.php';

class StockMovement extends Model
{
    // Mengambil seluruh produk
    public function getProducts()
    {
        $query = "
            SELECT id, name, sku, stock_quantity, unit
            FROM products
            ORDER BY name ASC
        ";

        return $this->db->query($query)->fetchAll();
    }

    // Mengambil riwayat transaksi
   public function getAll($filters = [])
{
    $sql = "
        SELECT
            sm.*,
            p.name AS product_name,
            p.sku,
            p.unit
        FROM stock_movements sm
        INNER JOIN products p ON sm.product_id = p.id
        WHERE 1=1
    ";

    $params = [];

    // SEARCH PRODUCT OR SKU
    if (!empty($filters['search'])) {
        $sql .= "
            AND (
                p.name LIKE :search_name
                OR p.sku LIKE :search_sku
            )
        ";

        $keyword = '%' . $filters['search'] . '%';

        $params['search_name'] = $keyword;
        $params['search_sku'] = $keyword;
    }

    // FILTER TRANSACTION TYPE
    if (!empty($filters['type'])) {
        $sql .= " AND sm.type = :type";
        $params['type'] = $filters['type'];
    }

    // FILTER START DATE
    if (!empty($filters['date_from'])) {
        $sql .= " AND DATE(sm.created_at) >= :date_from";
        $params['date_from'] = $filters['date_from'];
    }

    // FILTER END DATE
    if (!empty($filters['date_to'])) {
        $sql .= " AND DATE(sm.created_at) <= :date_to";
        $params['date_to'] = $filters['date_to'];
    }

    // ORDER BY LATEST TRANSACTION
    $sql .= " ORDER BY sm.created_at DESC, sm.id DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

    // Menyimpan transaksi stok
    public function createMovement(
        $productId,
        $type,
        $quantity,
        $notes = null
    ) {
        if (!in_array($type, ['in', 'out'], true)) {
            throw new InvalidArgumentException(
                'Jenis transaksi tidak valid.'
            );
        }

        if ($quantity <= 0) {
            throw new InvalidArgumentException(
                'Jumlah stok harus lebih dari nol.'
            );
        }

        try {
            $this->db->beginTransaction();

            // Mengunci data produk
            $query = "
                SELECT stock_quantity
                FROM products
                WHERE id = :id
                FOR UPDATE
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $productId]);

            $product = $stmt->fetch();

            if (!$product) {
                throw new RuntimeException(
                    'Produk tidak ditemukan.'
                );
            }

            $currentStock = (int) $product['stock_quantity'];

            // Validasi stok keluar
            if (
                $type === 'out' &&
                $quantity > $currentStock
            ) {
                throw new RuntimeException(
                    'Stok tidak mencukupi.'
                );
            }

            // Menghitung stok baru
            if ($type === 'in') {
                $newStock = $currentStock + $quantity;
            } else {
                $newStock = $currentStock - $quantity;
            }

            // Memasukkan riwayat transaksi
            $query = "
                INSERT INTO stock_movements
                (
                    product_id,
                    user_id,
                    type,
                    quantity,
                    notes
                )
                VALUES
                (
                    :product_id,
                    NULL,
                    :type,
                    :quantity,
                    :notes
                )
            ";

            $stmt = $this->db->prepare($query);

            $stmt->execute([
                'product_id' => $productId,
                'type' => $type,
                'quantity' => $quantity,
                'notes' => $notes
            ]);

            // Memperbarui stok produk
            $query = "
                UPDATE products
                SET stock_quantity = :stock
                WHERE id = :id
            ";

            $stmt = $this->db->prepare($query);

            $stmt->execute([
                'stock' => $newStock,
                'id' => $productId
            ]);

            $this->db->commit();

            return true;

        } catch (Throwable $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }
    }
}   