<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Commentaire $entity, bool $flush = true): void
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
    public function remove(Commentaire $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Commentaire[] Returns an array of Commentaire objects
    //  */
    // fonction de recherche commentaires pour un article spécifique
    public function findCommentaires(Article $article)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.article = :val')
            ->setParameter('val', $article)
            ->andWhere('c.publication = true')
            ->orderBy('c.dateCommentaire', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // fonction de recherche commentaires pour un utilisateur spécifique
    public function findCommentairesUtilisateur(Utilisateur $utilisateur)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.utilisateur = :val')
            ->setParameter('val', $utilisateur)
            ->andWhere('c.publication = true')
            ->orderBy('c.dateCommentaire', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
