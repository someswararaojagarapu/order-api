<?php

declare(strict_types=1);

namespace App\OrderApi\Tests\Unit;

use App\OrderApi\Dto\OrderInput;
use App\OrderApi\Services\CreateOrder;
use App\OrderApi\Services\ValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateOrderServiceTest extends WebTestCase
{
    public CreateOrder $createOrder;
    private EntityManagerInterface $entityManager;
    private ValidationService $validationService;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->validationService = $this->createMock(ValidationService::class);
        $this->createOrder = new CreateOrder($this->entityManager, $this->validationService);
    }

    public function testCreateOrder(): void
    {
        $orderInput = new OrderInput();
        $orderInput->setName('test order');
        $orderInput->setDeliveryAddress('test address');
        $orderInput->setQuantity(1);
        $orderInput->setDeliveryOption('Standard Shipping');
        $orderInput->setOrderStatus('Completed');

        // call ApiResponseService Service
        $serviceResult =$this->createOrder->createOrder($orderInput);
        $this->assertTrue($serviceResult);
    }
}
