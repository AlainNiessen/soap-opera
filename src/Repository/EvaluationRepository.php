<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Evaluation;
use App\Entity\Utilisateur;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Evaluation>
 *
 * @method Evaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluation[]    findAll()
 * @method Evaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Evaluation $entity, bool $flush = true): void
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
    public function remove(Evaluation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

       
    public function countStars(Article $article)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.article = :val')
            ->setParameter('val', $article)
            ->select('SUM(e.nombreEtoiles) as nombreEtoiles')
            ->getQuery()
            ->getSingleScalarResult();
        ;
    }
    
    public function countEvaluations(Article $article)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.article = :val')
            ->setParameter('val', $article)
            ->select('COUNT(e) as nombreEvaluations')
            ->getQuery()
            ->getSingleScalarResult();
        ;
    }

    public function findEvaluationsUtilisateur(Utilisateur $utilisateur)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.utilisateur = :val')
            ->setParameter('val', $utilisateur)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Evaluation
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
