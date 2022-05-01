<?php

namespace App\Repository;

use App\Entity\Beurre;
use App\Entity\Langue;
use Doctrine\ORM\ORMException;
use App\Entity\TraductionBeurre;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TraductionBeurre|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionBeurre|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionBeurre[]    findAll()
 * @method TraductionBeurre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionBeurreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionBeurre::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionBeurre $entity, bool $flush = true): void
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
    public function remove(TraductionBeurre $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return TraductionBeurre[] Returns an array of TraductionBeurre objects
    */
    
    public function findTraductionBeurre(Beurre $beurre, Langue $langue)
    {
        //récupération de ID
        $beurreID = $beurre -> getId();
        $langueID = $langue -> getId();


        return $this->createQueryBuilder('tb')
                    -> andWhere('tb.beurre = :beurreID')
                    -> setParameter('beurreID', $beurreID)
                    -> andWhere('tb.langue = :langueID')
                    -> setParameter('langueID', $langueID)            
                    -> getQuery()
                    -> getResult()
           
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?TraductionBeurre
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
