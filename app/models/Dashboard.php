<?php

require_once __DIR__ . '/../core/Model.php';

class Dashboard extends Model
{
    // Dashboard Statistics
    public function getStatistics()
    {
        $query = "
            SELECT
                COUNT(*) AS total_products,
                COALESCE(SUM(stock_quantity), 0) AS total_stock,
                SUM(
                    CASE
                        WHEN stock_quantity <= minimum_stock
                        THEN 1 ELSE 0
                    END
                ) AS low_stock
            FROM products
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch();
    }

    // Recent Products
    public function getRecentProducts()
    {
        $query = "
            SELECT id, name, sku, stock_quantity
            FROM products
            ORDER BY id DESC
            LIMIT 5
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Low Stock Products
    public function getLowStockProducts()
    {
        $query = "
            SELECT name, sku, stock_quantity, minimum_stock
            FROM products
            WHERE stock_quantity <= minimum_stock
            ORDER BY stock_quantity ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}