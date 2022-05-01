<?php

namespace App\Repository;

use App\Entity\Beurre;
use App\Entity\Langue;
use App\Entity\Article;
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

    /**
    * @return Beurre[] Returns an array of Beurre objects
    */
    
    public function findBeurreFromArticle(Article $article, Langue $langue)
    {
        $langueID = $langue -> getId();
        return $this    -> createQueryBuilder('b')
                        -> join('b.traductionBeurres', 'bt')
                        -> addSelect('bt')
                        -> addSelect('bt.nom')
                        -> join('bt.langue', 'btl')
                        -> addSelect('btl')
                        -> andWhere(':article MEMBER OF b.articles')
                        -> setParameter('article', $article)
                        -> andWhere('bt.langue = :langue')
                        -> setParameter('langue', $langueID)            
                        -> getQuery()
                        -> getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Beurre
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
