<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    protected $table;

    protected array $errors = [];

    public function __construct(private Database $database)
    {
    }

    protected function validate(array $data): void
    {
    }

    /**
     * Get the ID of the last inserted record.
     */
    public function getInsertID(): string
    {
        return $this->database->getConnection()->lastInsertId();
    }

    /**
     * Add an error message for the given field.
     */
    protected function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    /**
     * Get error messages.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

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
        // To validate the data, please implement the validate() method in the child class.
        $this->validate($data);

        if (! empty($this->errors)) {
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

    public function update(string $id, array $data): bool
    {
        $this->validate($data);

        if (! empty($this->errors)) {
            return false;
        }

        return true;
    }
}
