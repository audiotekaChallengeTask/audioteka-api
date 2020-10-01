<?php
declare(strict_types=1);

namespace App\Exception;

class ValidationException extends ApplicationException
{
    private array $errors;

    protected function __construct(string $message, array $errors, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public static function createForValidationErrors(array $errors): ValidationException
    {
        return new ValidationException('There\'s error within your request', $errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
