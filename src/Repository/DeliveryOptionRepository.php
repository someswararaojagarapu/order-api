<?php

namespace App\OrderApi\Repository;

use App\OrderApi\Entity\DeliveryOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeliveryOption>
 *
 * @method DeliveryOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryOption[]    findAll()
 * @method DeliveryOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliveryOption::class);
    }

    /**
     * @return DeliveryOption[] Returns an array of DeliveryOption objects
     */
    public function findDeliveryOptionByName(string $name): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?DeliveryOption
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
