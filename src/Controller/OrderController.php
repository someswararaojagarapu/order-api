<?php

namespace App\OrderApi\Controller;

use App\OrderApi\Entity\Order;
use App\OrderApi\Services\GetOrder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly GetOrder $getOrder
    ) {

    }
    public function __invoke(Request $request): JsonResponse
    {
        $status =  $request->query->get('status');
        $orderIds = $this->entityManager->getRepository(Order::class)->getOrdersIdsByStatus($status);
        $orders = $this->entityManager->getRepository(Order::class)->findOrdersByOrderIds($orderIds);
        $result = $this->getOrder->getOrders($orders);

        return new JsonResponse($result);
    }
}