<?php

declare(strict_types=1);

namespace App\OrderApi\Tests\Unit;

use App\OrderApi\Dto\UpdateOrderInput;
use App\OrderApi\Services\UpdateOrder;
use App\OrderApi\Services\ValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UpdateOrderServiceTest extends WebTestCase
{
    public UpdateOrder $updateOrder;
    private EntityManagerInterface $entityManager;
    private ValidationService $validationService;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->validationService = $this->createMock(ValidationService::class);
        $this->updateOrder = new UpdateOrder($this->entityManager, $this->validationService);
    }

    public function testUpdatedOrder(): void
    {
        $orderInput = new UpdateOrderInput();
        $orderInput->setOrderId(1);
        $orderInput->setStatus('Completed');

        // call Completed Service
        $serviceResult = $this->updateOrder->updatedOrder($orderInput);
        $this->assertTrue($serviceResult);
    }
}
