<?php

namespace App\OrderApi\Services;

use App\OrderApi\Entity\DeliveryOption;
use App\OrderApi\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;

class ValidationService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {

    }

    public function handleDeliveryOptionOrderStatusEmpty(array $deliveryOption, array $orderStatus): array | bool
    {
        if (empty($deliveryOption)) {
            return [
                'type' => 'Delivery options',
                'result' => $this->entityManager->getRepository(DeliveryOption::class)->findAllDeliveryOptions()
            ];
        }
        if (empty($orderStatus)) {
            return [
                'type' => 'Order status',
                'result' => $this->entityManager->getRepository(OrderStatus::class)->findAllOrderStatus()
            ];
        }

        return true;
    }
}