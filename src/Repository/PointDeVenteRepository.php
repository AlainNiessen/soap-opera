<?php

namespace App\Repository;

use App\Entity\PointDeVente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointDeVente>
 *
 * @method PointDeVente|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointDeVente|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointDeVente[]    findAll()
 * @method PointDeVente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointDeVenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointDeVente::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PointDeVente $entity, bool $flush = true): void
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
    public function remove(PointDeVente $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
