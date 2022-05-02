<?php

namespace App\Repository;

use App\Entity\Langue;
use App\Entity\HuileEssentiel;
use Doctrine\ORM\ORMException;
use App\Entity\TraductionHuileEssentiel;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TraductionHuileEssentiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionHuileEssentiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionHuileEssentiel[]    findAll()
 * @method TraductionHuileEssentiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionHuileEssentielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionHuileEssentiel::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionHuileEssentiel $entity, bool $flush = true): void
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
    public function remove(TraductionHuileEssentiel $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return TraductionHuileEssentiel[] Returns an array of TraductionHuileEssentiel objects
    */
    public function findTraductionHuileEss($huilesEss, Langue $langue)
    {
        //récupération de ID langue        
        $langueID = $langue -> getId();


        $queryBuilder = $this   -> createQueryBuilder('the')                    
                                -> andWhere('the.langue = :langueID')
                                -> setParameter('langueID', $langueID);
                                
                                if(count($huilesEss) > 0) {
                                    $arr = []; 
                                    foreach($huilesEss as $huileEss) {
                                        //récupération de ID huile essentiel
                                        $huileEssID = $huileEss -> getId();

                                        $arr[] = $queryBuilder->expr()->orX("the.huileEssentiel = $huileEssID");                                    
                                    }
                                    $queryBuilder->andWhere(join(' OR ', $arr));
                                }
                    
                    
                                return $queryBuilder 
                                            ->getQuery()
                                            ->getResult();           
        ;
    }

    /*
    public function findOneBySomeField($value): ?TraductionHuileEssentiel
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
