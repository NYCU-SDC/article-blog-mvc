<?php
namespace Models;

use PDO;
use PDOException;

class Database {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        // Build connection
        try {
            $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;";
            // Make a database connection
            $this->pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}
?>