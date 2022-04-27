<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Budget;
use App\Entity\Car;
use App\Entity\Model;
use App\Entity\Owner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    /**
     * constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * historical
     *
     * @param boolean $returnRows
     * @return Queribuilder|array
     */
    public function historical(bool $returnRows = false)
    {
        $qb = $this
            ->createQueryBuilder('car')
            // ->leftJoin(Budget::class, 'budget',  'WITH', 'car.id = budget.car')
            // ->leftJoin(Owner::class, 'owner',  'WITH', 'owner.id = car.owner')
            ->addOrderBy('car.patent', 'ASC')
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
    public function save(Car $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Car $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function index(bool $returnRows = false)
    {
        $qb = $this
            ->createQueryBuilder('car')
            ->leftJoin(Brand::class, 'brand',  'WITH', 'brand.id = car.brand' )
            ->leftJoin(Model::class, 'model',  'WITH', 'model.id = car.model' )
            ->leftJoin(Owner::class, 'owner',  'WITH', 'owner.id = car.owner' )
            ->addOrderBy('car.brand', 'ASC')
            ->addOrderBy('car.model', 'ASC')
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

    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Car
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
