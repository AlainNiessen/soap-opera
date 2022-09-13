<?php

namespace App\Repository;

use App\Entity\HuileEssentiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HuileEssentiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method HuileEssentiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method HuileEssentiel[]    findAll()
 * @method HuileEssentiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HuileEssentielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HuileEssentiel::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(HuileEssentiel $entity, bool $flush = true): void
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
    public function remove(HuileEssentiel $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
