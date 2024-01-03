<?php

namespace App;

use PDO;

class Database
{
    /**
     * Get a connection to the database
     */
    public function getConnection(): PDO
    {
        $dsn = 'mysql:host=localhost;dbname=product_db;charset=utf8;port=3306';

        $pdo = new PDO($dsn, 'product_db_user', 'secret', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        return $pdo;
    }
}
