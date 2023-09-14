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
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidationService $validationService
    ) {

    }
    public function createOrder(OrderInput $data): array | bool
    {
        $order = new Order();
        $currentDate = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $deliveryDate = $currentDate->modify('+3 days');

        $orderItem = new OrderItem();
        $orderItem->setQuantity($data->getQuantity());
        $deliveryOption = $this->entityManager->getRepository(DeliveryOption::class)->findByName(['name' => $data->getDeliveryOption()]);
        $orderStatus = $this->entityManager->getRepository(OrderStatus::class)->findByName(['name' => $data->getOrderStatus()]);
        $validationResult =  $this->validationService->handleDeliveryOptionOrderStatusEmpty($deliveryOption, $orderStatus);

        if (is_array($validationResult)) {
            return $validationResult;
        }
        $order
            ->setName($data->getName())
            ->setDeliveryDate($deliveryDate)
            ->setDeliveryAddress($data->getDeliveryAddress())
            ->setDeliveryOption($deliveryOption[0])
            ->setOrderStatus($orderStatus[0])
            ->addOrderItem($orderItem)
        ;

        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return true;
    }
}