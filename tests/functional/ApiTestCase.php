<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use ApiTestCase\JsonApiTestCase;

class ApiTestCase extends JsonApiTestCase
{
    /** @var array */
    protected static $defaultHeaders = [
        'CONTENT_TYPE' => 'application/json',
    ];

}
