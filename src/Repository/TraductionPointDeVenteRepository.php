<?php

namespace App\Repository;

use App\Entity\Langue;
use App\Entity\PointDeVente;
use Doctrine\ORM\ORMException;
use App\Entity\TraductionPointDeVente;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<TraductionPointDeVente>
 *
 * @method TraductionPointDeVente|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionPointDeVente|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionPointDeVente[]    findAll()
 * @method TraductionPointDeVente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionPointDeVenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionPointDeVente::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionPointDeVente $entity, bool $flush = true): void
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
    public function remove(TraductionPointDeVente $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findTraductionPointDeVente(PointDeVente $pointDeVente, Langue $langue)
    {
        
        return $this    -> createQueryBuilder('tp')                    
                        -> andWhere('tp.langue = :langue')
                        -> setParameter('langue', $langue)
                        -> andWhere('tp.pointDeVente = :pointDeVente')
                        -> setParameter('pointDeVente', $pointDeVente)                               
                        -> getQuery()
                        -> getSingleResult();
           
        ;
    }

    /*
    public function findOneBySomeField($value): ?TraductionPointDeVente
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
