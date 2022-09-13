<?php

namespace App\Repository;

use App\Entity\Langue;
use App\Entity\Promotion;
use Doctrine\ORM\ORMException;
use App\Entity\TraductionPromotion;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TraductionPromotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionPromotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionPromotion[]    findAll()
 * @method TraductionPromotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionPromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionPromotion::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TraductionPromotion $entity, bool $flush = true): void
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
    public function remove(TraductionPromotion $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
