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
    // fonction de recherche de traduction pour plusieurs beurres dans une langue spécifique
    public function findTraductionBeurre($beurres, Langue $langue)
    {
        //récupération de ID langue
        $langueID = $langue -> getId();

        $queryBuilder =  $this  -> createQueryBuilder('tb')                    
                                -> andWhere('tb.langue = :langueID')
                                -> setParameter('langueID', $langueID);

                                if(count($beurres) > 0) {
                                    $arr = []; 
                                    foreach($beurres as $beurre) {
                                        //récupération de ID beurre
                                        $beurreID = $beurre -> getId();

                                        $arr[] = $queryBuilder->expr()->orX("tb.beurre = $beurreID");                                    
                                    }
                                    $queryBuilder->andWhere(join(' OR ', $arr));
                                }
                                
                                return $queryBuilder 
                                        ->getQuery()
                                        ->getResult(); 
           
        ;
    }
}
