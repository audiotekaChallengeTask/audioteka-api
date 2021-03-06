<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManager;

interface PublicEntityRepositoryInterface extends ServiceEntityRepositoryInterface
{
    public function getEntityManager(): EntityManager;
}
