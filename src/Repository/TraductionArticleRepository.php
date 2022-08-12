<?php

namespace App\Repository;

use App\Entity\Langue;
use Doctrine\ORM\ORMException;
use App\Entity\TraductionArticle;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TraductionArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionArticle[]    findAll()
 * @method TraductionArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionArticle::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionArticle $entity, bool $flush = true): void
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
    public function remove(TraductionArticle $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return TraductionArticle Returns an object of TraductionArticle
    */
    
    public function findTraductionArticle($articleID, Langue $langue)
    {
        //récupération de ID langue
        $langueID = $langue -> getId();

        return $this    -> createQueryBuilder('ta')                    
                        -> andWhere('ta.langue = :langueID')
                        -> setParameter('langueID', $langueID)
                        -> andWhere('ta.article = :articleID')
                        -> setParameter('articleID', $articleID)                               
                        -> getQuery()
                        -> getSingleResult();
           
        ;
    }

    /**
    * @return TraductionArticle[] Returns an an array of objects of TraductionArticle
    */
    
    public function findTraductionArticles($articles, Langue $langue, $offset = null, $limit = null)
    {
        //récupération de ID langue
        $langueID = $langue -> getId();

        $queryBuilder =  $this   -> createQueryBuilder('ta')                    
                                -> andWhere('ta.langue = :langueID')
                                -> setParameter('langueID', $langueID);

                            if(count($articles) > 0) {
                                $arr = []; 
                                foreach($articles as $article) {
                                    //récupération de ID huile
                                    $articleID = $article -> getId();

                                    $arr[] = $queryBuilder->expr()->orX("ta.article = $articleID");                                    
                                }
                                $queryBuilder->andWhere(join(' OR ', $arr));
                            }   

                            if($offset):
                                $queryBuilder->setFirstResult($offset);
                            endif;
                            if($limit):
                                $queryBuilder->setMaxResults($limit);
                            endif;
                
                
                            return $queryBuilder 
                            ->getQuery()
                            ->getResult(); 
           
        ;
    }

    /*
    public function findOneBySomeField($value): ?TraductionArticle
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
