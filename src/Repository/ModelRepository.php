<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Model>
 *
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends ServiceEntityRepository
{
    /**
     * constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Model $entity, bool $flush = true): void
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
    public function remove(Model $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * choices
     *
     * @param boolean $returnRows
     * @return mixed
     */
    public function choices(bool $returnRows = false): mixed
    {
        $qb = $this->createQueryBuilder('model')
                ->addOrderBy('model.description', 'asc')
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
     * index
     *
     * @param boolean $returnRows
     * @return Qeurybuilder|array
     */
    public function index(bool $returnRows = false)
    {
        $qb = $this->createQueryBuilder('model')
                ->leftJoin(Brand::class, 'brand',  'WITH', 'brand.id = model.brand' )
                ->addOrderBy('brand.description', 'asc')
                ->addOrderBy('model.description', 'asc')
        ;

        if(false == $returnRows)
        {
            $zval = $qb->getQuery();
        }
        else
        {
            $zval = $qb->getQuery()->getResult();
        }

        return($zval);
    }   
}
