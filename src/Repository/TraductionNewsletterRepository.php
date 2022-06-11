<?php

namespace App\Repository;

use App\Entity\Langue;
use Doctrine\ORM\ORMException;
use App\Entity\TraductionNewsletter;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TraductionNewsletter|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionNewsletter|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionNewsletter[]    findAll()
 * @method TraductionNewsletter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionNewsletterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionNewsletter::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionNewsletter $entity, bool $flush = true): void
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
    public function remove(TraductionNewsletter $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return TraductionNewsletter Returns an object of TraductionNewsletter
    */
    
    public function findTraductionNewsletter($newsletterID, Langue $langue)
    {
        //récupération de ID langue
        $langueID = $langue -> getId();

        return $this    -> createQueryBuilder('tn')                    
                        -> andWhere('tn.langue = :langueID')
                        -> setParameter('langueID', $langueID)
                        -> andWhere('tn.newsletter = :newsletterID')
                        -> setParameter('newsletterID', $newsletterID)                               
                        -> getQuery()
                        -> getSingleResult();
           
        ;
    }

    /*
    public function findOneBySomeField($value): ?TraductionNewsletter
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
