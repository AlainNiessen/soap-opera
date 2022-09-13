<?php

namespace App\Repository;

use App\Entity\Langue;
use App\Entity\Philosophie;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Philosophie>
 *
 * @method Philosophie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Philosophie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Philosophie[]    findAll()
 * @method Philosophie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhilosophieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Philosophie::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Philosophie $entity, bool $flush = true): void
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
    public function remove(Philosophie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // fonction de recherche pour trouver une traduction pour philosophie dans une langue spécifique
    public function findPhilosophie(Langue $langue)
    {
        //récupération de ID langue
        $langueID = $langue -> getId();

        return $this    -> createQueryBuilder('p')
                        -> select('p.philosophie')                    
                        -> andWhere('p.langue = :langueID')
                        -> setParameter('langueID', $langueID)                              
                        -> getQuery()
                        -> getSingleResult();
           
        ;
    }
}
