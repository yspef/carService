<?php

namespace App\Repository;

use App\Entity\Color;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Color>
 *
 * @method Color|null find($id, $lockMode = null, $lockVersion = null)
 * @method Color|null findOneBy(array $criteria, array $orderBy = null)
 * @method Color[]    findAll()
 * @method Color[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColorRepository extends ServiceEntityRepository
{
    /**
     * constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Color::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Color $entity, bool $flush = true): void
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
    public function remove(Color $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * index
     *
     * @param boolean $returnRows
     * @return Querybuilder|array
     */
    public function index(bool $returnRows = false)
    {
        $qb = $this->createQueryBuilder('color')
                ->orderBy('color.description', 'asc')
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
    //  * @return Color[] Returns an array of Color objects
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
    public function findOneBySomeField($value): ?Color
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
