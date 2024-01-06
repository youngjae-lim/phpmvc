<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    protected $table;

    /**
     * Get the table name for the current model.
     */
    private function getTable(): string
    {
        if ($this->table !== null) {
            return $this->table;
        }

        $parts = explode('\\', $this::class);

        return strtolower(array_pop($parts));
    }

    public function __construct(private Database $database)
    {
    }

    /**
     * Get all records from the table.
     */
    public function findAll(): array
    {
        $pdo = $this->database->getConnection();

        $sql = "SELECT * FROM {$this->getTable()}";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find a record by its ID.
     */
    public function find(string $id): array|bool
    {
        $conn = $this->database->getConnection();

        $sql = "SELECT * FROM {$this->getTable()} WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insert a new record into the table.
     */
    public function insert(array $data): bool
    {
        $sql = 'INSERT INTO product (name, description) VALUES (?, ?)';

        $conn = $this->database->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(2, $data['description'], PDO::PARAM_STR);

        return $stmt->execute();
    }
}
