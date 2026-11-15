<?php

class Database
{
    private $host = 'localhost';
    private $dbname = 'stockify_db';
    private $username = 'root';
    private $password = '';

    protected $connection;

    public function connect()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->connection->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            return $this->connection;

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
