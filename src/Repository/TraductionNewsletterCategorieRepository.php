<?php

namespace App\Repository;

use Doctrine\ORM\ORMException;
use App\Entity\NewsletterCategorie;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\TraductionNewsletterCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<TraductionNewsletterCategorie>
 *
 * @method TraductionNewsletterCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionNewsletterCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionNewsletterCategorie[]    findAll()
 * @method TraductionNewsletterCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionNewsletterCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionNewsletterCategorie::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionNewsletterCategorie $entity, bool $flush = true): void
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
    public function remove(TraductionNewsletterCategorie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findTraduction(NewsletterCategorie $newsletterCategorie, $langue)
    {
        return $this    ->  createQueryBuilder('tnc')
                        ->  innerJoin('tnc.newsletterCategories', 'nc')
                        ->  addSelect('nc')  
                        ->  innerJoin('tnc.langue', 'l')
                        ->  addSelect('l')  
                        ->  andWhere('l.codeLangue LIKE :code')
                        ->  setParameter('code', $langue)
                        ->  andWhere('tnc.newsletterCategories = :objet')
                        ->  setParameter('objet', $newsletterCategorie)
                        ->  getQuery()
                        ->  getSingleResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?TraductionNewsletterCategorie
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
