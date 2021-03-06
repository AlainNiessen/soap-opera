<?php

namespace App\Repository;

use App\Entity\NewsletterCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsletterCategorie>
 *
 * @method NewsletterCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterCategorie[]    findAll()
 * @method NewsletterCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterCategorie::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(NewsletterCategorie $entity, bool $flush = true): void
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
    public function remove(NewsletterCategorie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }   
}
