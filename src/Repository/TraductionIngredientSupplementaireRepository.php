<?php

namespace App\Repository;

use App\Entity\IngredientSupplementaire;
use App\Entity\Langue;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\TraductionIngredientSupplementaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TraductionIngredientSupplementaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionIngredientSupplementaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionIngredientSupplementaire[]    findAll()
 * @method TraductionIngredientSupplementaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionIngredientSupplementaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionIngredientSupplementaire::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionIngredientSupplementaire $entity, bool $flush = true): void
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
    public function remove(TraductionIngredientSupplementaire $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return TraductionIngredientSupplementaire[] Returns an array of TraductionIngredientSupplementaire objects
    */
    // fonction de recherche de traduction pour plusieurs ingrédients supplémentaires dans une langue spécifique
    public function findTraductionIngredientSupp($ingredientsSupp, Langue $langue)
    {
        //récupération de ID langue       
        $langueID = $langue -> getId();

        $queryBuilder =  $this  -> createQueryBuilder('tis')
                                -> andWhere('tis.langue = :langueID')
                                -> setParameter('langueID', $langueID);

                                if(count($ingredientsSupp) > 0) {
                                    $arr = []; 
                                    foreach($ingredientsSupp as $ingredientSupp) {
                                        //récupération de ID huile
                                        $ingredientSuppID = $ingredientSupp -> getId();

                                        $arr[] = $queryBuilder->expr()->orX("tis.ingredientSupplementaire = $ingredientSuppID");                                    
                                    }
                                    $queryBuilder->andWhere(join(' OR ', $arr));
                                }
                    
                    
                                return $queryBuilder 
                                ->getQuery()
                                ->getResult();           
        ;
    }
}
