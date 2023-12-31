<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    private ?PDO $pdo = null;

    public function __construct(private string $host, private string $dbname, private string $username, private string $password)
    {
    }

    /**
     * Get a connection to the database
     */
    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8;port=3306";

            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        }

        return $this->pdo;
    }
}
