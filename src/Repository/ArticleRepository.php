<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Article $entity, bool $flush = true): void
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
    public function remove(Article $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return Article[] Returns an array of Article objects
    */    
    // fonction de recherche articles via barre de recherche
    public function findArticlesSearchBar($keywords = [])
    {
       
        // préparation lier les tables 
        $queryBuilder =  $this  ->createQueryBuilder('a')
                                ->leftJoin('a.traductionArticles', 'at')
                                ->addSelect('at')                                
                                ->leftJoin('a.categorie', 'c')
                                ->addSelect('c')
                                ->leftJoin('c.traductionCategories', 'ct')
                                ->addSelect('ct')
                                ->leftJoin('a.odeur', 'o')
                                ->addSelect('o')
                                ->leftJoin('o.traductionOdeurs', 'ot')
                                ->addSelect('ot')
                                ->leftJoin('a.huile', 'h')
                                ->addSelect('h')
                                ->leftJoin('h.traductionHuiles', 'ht')
                                ->addSelect('ht')
                                ->leftJoin('a.huileEssentiell', 'he')
                                ->addSelect('he')
                                ->leftJoin('he.traductionHuileEssentiels', 'het')
                                ->addSelect('het')
                                ->leftJoin('a.beurre', 'b')
                                ->addSelect('b')
                                ->leftJoin('b.traductionBeurres', 'bt')
                                ->addSelect('bt')
                                ->leftJoin('a.ingredientSupplementaire', 'ai')
                                ->addSelect('ai')
                                ->leftJoin('ai.traductionIngredientSupplementaires', 'ait')
                                ->addSelect('ait');                                
        
        // si le tableau de mot de clés n'est pas vide
        if(count($keywords) > 0) {
            $arr = [];    
            // boucle sur le tableau pour conditionner la requête
            foreach($keywords as $keyword) {                          
                $arr[] = $queryBuilder->expr()->orX("at.nom LIKE '%".$keyword."%'");
                $arr[] = $queryBuilder->expr()->orX("at.description LIKE '%".$keyword."%'");
                $arr[] = $queryBuilder->expr()->orX("at.slogan LIKE '%".$keyword."%'");
                $arr[] = $queryBuilder->expr()->orX("ct.nom LIKE '%".$keyword."%'");
                $arr[] = $queryBuilder->expr()->orX("ct.description LIKE '%".$keyword."%'");
                $arr[] = $queryBuilder->expr()->orX("ot.nom LIKE '%".$keyword."%'");
                $arr[] = $queryBuilder->expr()->orX("ht.nom LIKE '%".$keyword."%'");
                $arr[] = $queryBuilder->expr()->orX("het.nom LIKE '%".$keyword."%'");
                $arr[] = $queryBuilder->expr()->orX("bt.nom LIKE '%".$keyword."%'");
                $arr[] = $queryBuilder->expr()->orX("ait.nom LIKE '%".$keyword."%'");               
            }        
            $queryBuilder->andWhere(join(' OR ', $arr));     
            
        }     

        // si rien a été rempli => pas des if => return automatique des tous les articles 
        return $queryBuilder 
                    ->getQuery()
                    ->getResult();                                   
                    
                   
        ;       
    }
    
    /**
    * @return Article[] Returns an array of Article objects
    */
    
    // fonction de recherche articles par categorie
    public function findArticlesByCategory($idCategorie)
    {
        // préparation lier les tables 
        $queryBuilder =  $this  ->createQueryBuilder('a')
                                ->leftJoin('a.categorie', 'c')
                                ->addSelect('c')
                                ->andWhere('c.id LIKE :idCategorie')
                                ->setParameter('idCategorie', $idCategorie);      
    
        return $queryBuilder                    
                    ->getQuery()
                    ->getResult();
        ;       
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    
    // fonction de recherche 3 Bestseller
    public function findArticlesBestseller($value)
    {
        // préparation lier les tables 
        return $this -> createQueryBuilder('a')
                     -> orderBy('a.nombreVentes', 'DESC')
                     -> setMaxResults($value) 
                     -> getQuery()
                     -> getResult();
        ;       
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    
    // fonction de recherche articles 6 nouveautés
    public function findNewArticles($value)
    {
        // préparation lier les tables 
        return $this -> createQueryBuilder('a')
                     -> orderBy('a.dateCreation', 'DESC')
                     -> setMaxResults($value) 
                     -> getQuery()
                     -> getResult();
        ;       
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    
    //fonction de recherche articles en promotion
    public function findArticlesInPromotion()
    {
        // préparation lier les tables 
        return $this    -> createQueryBuilder('a')
                        -> innerJoin('a.promotion', 'pa')
                        -> addSelect('pa') 
                        -> andWhere('pa.dateStart < :now')
                        -> andWhere('pa.dateEnd > :now')
                        -> setParameter('now', new \DateTime('now'))                                                                                 
                        -> getQuery()
                        -> getResult();
        ;       
    }

    // fonction pour récupérer le nombre total des articles
    public function countArticles()
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a) as nombreArticles')
            ->getQuery()
            ->getSingleScalarResult();
        ;
    }

    // fonction pour récupérer le nombre total des articles vendus
    public function countArticlesVendus()
    {
        return $this->createQueryBuilder('a')
            ->select('SUM(a.nombreVentes) as nombreArticlesVendus')
            ->getQuery()
            ->getSingleScalarResult();
        ;
    }

    // fonction pour récupérer le nombre total des articles par catégorie
    public function countArticlesCategorie(Categorie $categorie)
    {
        return $this->createQueryBuilder('a')
            ->select('SUM(a.nombreVentes) as nombreArticlesVendus')
            ->andWhere('a.categorie = :categorie')
            ->setParameter('categorie', $categorie)
            ->getQuery()
            ->getSingleScalarResult();
        ;
    }

    // fonction pour récupérer les bestseller par catégorie
    public function findBestsellerParCategorie(Categorie $categorie)
    {
        return $this->createQueryBuilder('a')
                    ->innerJoin('a.categorie', 'c')
                    ->addSelect('c')
                    ->andWhere('c = :categorie')
                    ->setParameter('categorie', $categorie)
                    ->orderBy('a.nombreVentes', 'DESC')
                    ->getQuery()
                    ->getResult();
        ;
    }
}
