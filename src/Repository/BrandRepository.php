<?php

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Brand>
 *
 * @method Brand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brand[]    findAll()
 * @method Brand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Brand $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function choices(bool $returnRows = false)
    {
        $qb = $this->createQueryBuilder('brand')
                ->addOrderBy('brand.description', 'asc')
        ;

        if(false == $returnRows)
        {
            $zval = $qb;
        }
        else
        {
            $zval = $qb->getQuery()->getResult();
        }

        return($zval);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Brand $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function index(bool $returnRows = false)
    {
        $qb = $this->createQueryBuilder('brand')
                ->orderBy('brand.description', 'asc')
        ;

        
        if(false == $returnRows)
        {
            $zval = $qb->getQuery();
        }
        {
            $zval = $qb->getQuery()->getResult();
        }

        return($zval);
    }

    // /**
    //  * @return Brand[] Returns an array of Brand objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Brand
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
