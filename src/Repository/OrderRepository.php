<?php

namespace App\OrderApi\Repository;

use App\OrderApi\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @return Order[] Returns an array of Order objects
     */
    public function getOrdersIdsByStatus($status): array
    {
        return $this->createQueryBuilder('o')
            ->select('o.id')
            ->leftJoin('o.orderStatus', 'os')
            ->andWhere('os.name = :status')
            ->setParameter('status', $status)
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getScalarResult()
        ;
    }

    public function findOrdersByOrderIds($orderIds): array
    {
        return $this->createQueryBuilder('o')
            ->select('o.id as order_id', 'o.name as name', 'o.deliveryAddress as delivery_address',
                'os.name as order_status', 'dp.name as delivery_option', 'oi.id as order_item_id', 'oi.quantity as order_quantity',
            'o.deliveryDate as estimated_delivery_date', 'o.createdAt as created_at', 'o.updatedAt as updated_at'
            )
            ->leftJoin('o.orderStatus', 'os')
            ->leftJoin('o.deliveryOption', 'dp')
            ->leftJoin('o.orderItems', 'oi')
            ->andWhere('o.id IN (:ids)')
            ->setParameter('ids', $orderIds)
            ->getQuery()
            ->getScalarResult()
        ;
    }
}
