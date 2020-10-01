<?php
declare(strict_types=1);

namespace App\Controller\Api;

interface ModelAwareControllerInterface
{
    public function getModelClassName(): string;
}
