<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace App\Models;

use Framework\Model as BaseModel;

class Product extends BaseModel
{
    // Override the table name if it's different from the class name.
    // protected $table = 'product';

    protected array $errors = [];

    /**
     * Add an error message for the given field.
     */
    protected function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    /**
     * Validate the data and set the error messages.
     */
    protected function validate(array $data): bool
    {
        if (empty($data['name'])) {
            $this->addError('name', 'Name is required');
        }

        return empty($this->errors);
    }

    /**
     * Get error messages.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
