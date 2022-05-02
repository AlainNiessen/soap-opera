<?php

namespace App\Repository;

use App\Entity\Huile;
use App\Entity\Langue;
use Doctrine\ORM\ORMException;
use App\Entity\TraductionHuile;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TraductionHuile|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionHuile|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionHuile[]    findAll()
 * @method TraductionHuile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionHuileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionHuile::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionHuile $entity, bool $flush = true): void
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
    public function remove(TraductionHuile $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return TraductionHuile[] Returns an array of TraductionHuile objects
    */
    
    public function findTraductionHuile($huiles, Langue $langue)
    {
        //récupération de ID langue        
        $langueID = $langue -> getId();

        $queryBuilder =  $this  -> createQueryBuilder('th')                    
                                -> andWhere('th.langue = :langueID')
                                -> setParameter('langueID', $langueID);

                                if(count($huiles) > 0) {
                                    $arr = []; 
                                    foreach($huiles as $huile) {
                                        //récupération de ID huile
                                        $huileID = $huile -> getId();

                                        $arr[] = $queryBuilder->expr()->orX("th.huile = $huileID");                                    
                                    }
                                    $queryBuilder->andWhere(join(' OR ', $arr));
                                }   
                    
                    
                                return $queryBuilder 
                                ->getQuery()
                                ->getResult(); 
           
        ;
    }

    /*
    public function findOneBySomeField($value): ?TraductionHuile
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
