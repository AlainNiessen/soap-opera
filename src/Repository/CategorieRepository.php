<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Categorie $entity, bool $flush = true): void
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
    public function remove(Categorie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return Categorie[] Returns an array of Categorie objects
    */
    
    //fonction de recherche catégorie en promotion
    public function findcategorieInPromotion()
    {
        //préparation lier les tables 
        return $this    -> createQueryBuilder('c')
                        -> innerJoin('c.promotion', 'pc')
                        -> addSelect('pc') 
                        -> andWhere('pc.dateStart < :now')
                        -> andWhere('pc.dateEnd > :now')
                        -> setParameter('now', new \DateTime('now'))                                                                                     
                        -> getQuery()
                        -> getResult();
        ;       
    }
}
