<?php

namespace App\Repository;

use App\Entity\Langue;
use App\Entity\Categorie;
use Doctrine\ORM\ORMException;
use App\Entity\TraductionCategorie;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TraductionCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionCategorie[]    findAll()
 * @method TraductionCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionCategorie::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionCategorie $entity, bool $flush = true): void
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
    public function remove(TraductionCategorie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // fonction de recherche de traduction pour une catégorie spécifique dans une langue spécifique
    public function findTraductionCategorie($categorieID, Langue $langue)
    {
        //récupération de ID langue
        $langueID = $langue -> getId();

        return $this    -> createQueryBuilder('tc')                    
                        -> andWhere('tc.langue = :langueID')
                        -> setParameter('langueID', $langueID)
                        -> andWhere('tc.categorie = :categorieID')
                        -> setParameter('categorieID', $categorieID)                               
                        -> getQuery()
                        -> getSingleResult();
           
        ;
    }

       
    // fonction de recherche de traduction pour toutes les catégories dans une langue spécifique
    public function findTraductionCategories(Langue $langue)
    {
        //récupération de ID langue
        $langueID = $langue -> getId();

        return  $this   -> createQueryBuilder('tc')                    
                        -> andWhere('tc.langue = :langueID')
                        -> setParameter('langueID', $langueID)                            
                        -> getQuery()
                        -> getResult(); 
        ;       
    }    
}
