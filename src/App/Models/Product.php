<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace App\Models;

use Framework\Model as BaseModel;
use PDO;

class Product extends BaseModel
{
    // Override the table name if it's different from the class name.
    // protected $table = 'product';

    /**
     * Validate the data and set the error messages.
     */
    protected function validate(array $data): void
    {
        if (empty($data['name'])) {
            $this->addError('name', 'Name is required');
        }
    }

    public function getTotal(): int
    {
        $sql = 'SELECT COUNT(*) AS total FROM product';
        $conn = $this->database->getConnection();
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) $row['total'];
    }
}
