<?php

namespace App\OrderApi\Services;

use App\OrderApi\Dto\OrderInput;
use App\OrderApi\Entity\DeliveryOption;
use App\OrderApi\Entity\Order;
use App\OrderApi\Entity\OrderItem;
use App\OrderApi\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;

class CreateOrder
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {

    }
    public function createOrder(OrderInput $data): void
    {
        $order = new Order();
        $currentDate = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $deliveryDate = $currentDate->modify('+3 days');

        $orderItem = new OrderItem();
        $orderItem->setQuantity($data->getQuantity());
        $deliveryOption = $this->entityManager->getRepository(DeliveryOption::class)->findByName($data->getDeliveryOption());
        $orderStatus = $this->entityManager->getRepository(OrderStatus::class)->findByName($data->getOrderStatus());
        $order
            ->setName($data->getName())
            ->setDeliveryDate($deliveryDate)
            ->setDeliveryAddress($data->getDeliveryAddress())
            ->setDeliveryOption($deliveryOption)
            ->setOrderStatus($orderStatus)
            ->addOrderItem($orderItem)
        ;

        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}