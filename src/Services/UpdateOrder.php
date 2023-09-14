<?php

namespace App\OrderApi\Services;

use App\OrderApi\Dto\UpdateOrderInput;
use App\OrderApi\Entity\Order;
use App\OrderApi\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;

class UpdateOrder
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidationService $validationService
    ) {

    }
    public function updatedOrder(UpdateOrderInput $data): array | bool
    {
        $order = $this->entityManager->getRepository(Order::class)->find($data->getOrderId());
        $orderStatus = $this->entityManager->getRepository(OrderStatus::class)->findByName(['name' => $data->getStatus()]);
        $validationResult =  $this->validationService->handleDeliveryOptionOrderStatusEmpty([], $orderStatus);

        if (is_array($validationResult)) {
            return $validationResult;
        }
        $order->setOrderStatus($orderStatus);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return true;
    }
}