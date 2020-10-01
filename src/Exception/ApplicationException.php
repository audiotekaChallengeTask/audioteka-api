<?php
declare(strict_types=1);

namespace App\Exception;

abstract class ApplicationException extends \RuntimeException
{
    protected function __construct(string $message, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
