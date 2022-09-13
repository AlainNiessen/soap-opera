<?php

namespace App\Repository;

use App\Entity\TraductionOdeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TraductionOdeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionOdeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionOdeur[]    findAll()
 * @method TraductionOdeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionOdeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionOdeur::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionOdeur $entity, bool $flush = true): void
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
    public function remove(TraductionOdeur $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
