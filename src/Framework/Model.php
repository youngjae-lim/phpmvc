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

    abstract protected function validate(array $data): bool;

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
        // To use this method, you must implement the validate() method in the child class.
        if (! $this->validate($data)) {
            return false;
        }

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->getTable()} ($columns) VALUES ($placeholders)";

        $conn = $this->database->getConnection();

        $stmt = $conn->prepare($sql);

        $i = 1;

        foreach ($data as $value) {
            $type = match (gettype($value)) {
                'boolean' => PDO::PARAM_BOOL,
                'integer' => PDO::PARAM_INT,
                'null' => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };

            // Use switch instead of match for PHP below 8.0.
            // $valueType = gettype($value);
            // switch ($valueType) {
            //     case 'boolean':
            //         $type = PDO::PARAM_BOOL;
            //         break;
            //     case 'integer':
            //         $type = PDO::PARAM_INT;
            //         break;
            //     case 'NULL': // Note that gettype() returns 'NULL' for null values
            //         $type = PDO::PARAM_NULL;
            //         break;
            //     default:
            //         $type = PDO::PARAM_STR;
            // }

            $stmt->bindValue($i++, $value, $type);
        }

        return $stmt->execute();
    }
}
