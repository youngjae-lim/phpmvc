<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    protected $table;

    public function __construct(private Database $database)
    {
    }

    public function findAll(): array
    {
        $pdo = $this->database->getConnection();

        $sql = "SELECT * FROM {$this->table}";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): array|bool
    {
        $conn = $this->database->getConnection();

        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
