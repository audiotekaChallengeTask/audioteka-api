<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Basket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Basket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Basket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Basket[]    findAll()
 * @method Basket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BasketRepository extends ServiceEntityRepository implements PublicEntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Basket::class);
    }

    public function getEntityManager(): EntityManager
    {
        return parent::getEntityManager();
    }

    public function selectSumOfPriceOfBasketProducts(Basket $basket): float
    {
        $qb = $this->createQueryBuilder('q')
                   ->select('SUM(p.price)')
                   ->leftJoin('q.products', 'p')
                   ->andWhere('q = :basket')->setParameter('basket', $basket)
        ;

        return (float) $qb->getQuery()->getSingleScalarResult();
    }
}
