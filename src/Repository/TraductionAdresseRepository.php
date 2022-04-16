<?php

namespace App\Repository;

use App\Entity\TraductionAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TraductionAdresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionAdresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionAdresse[]    findAll()
 * @method TraductionAdresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionAdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionAdresse::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionAdresse $entity, bool $flush = true): void
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
    public function remove(TraductionAdresse $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return TraductionAdresse[] Returns an array of TraductionAdresse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TraductionAdresse
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
