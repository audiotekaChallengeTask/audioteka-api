<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Basket;
use App\Entity\Product;
use App\Model\PaginationRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository implements PublicEntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getEntityManager(): EntityManager
    {
        return parent::getEntityManager();
    }

    public function findForPagination(PaginationRequest $request): array
    {
        $qb = $this->createQueryBuilder('q')
                   ->setMaxResults($request->getLimit())
                   ->setFirstResult(($request->getPage() - 1) * $request->getLimit())
        ;

        return $qb->getQuery()->getResult();
    }

    public function fetchTotal(PaginationRequest $request): int
    {
        $qb = $this->createQueryBuilder('q')->select('COALESCE(COUNT(q), 0)');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function basketHasProduct(Product $product, Basket $basket): bool
    {
        $qb = $this->createQueryBuilder('q')
                   ->select('COALESCE(COUNT(q), 0)')
                   ->andWhere('q = :product')->setParameter('product', $product)
                   ->andWhere(':basket MEMBER OF q.baskets')->setParameter('basket', $basket)
        ;

        return 0 !== (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function getBasketProducts(Basket $basket): array
    {
        $qb = $this->createQueryBuilder('q')
                   ->andWhere(':basket MEMBER OF q.baskets')->setParameter('basket', $basket)
        ;

        return $qb->getQuery()->getResult();
    }
}
