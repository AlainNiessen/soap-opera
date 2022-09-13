<?php

namespace App\Repository;

use App\Entity\Beurre;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Beurre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beurre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beurre[]    findAll()
 * @method Beurre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeurreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beurre::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Beurre $entity, bool $flush = true): void
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
    public function remove(Beurre $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }    
}
