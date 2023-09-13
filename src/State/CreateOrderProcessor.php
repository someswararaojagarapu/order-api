<?php

namespace App\OrderApi\State;

use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;
use App\OrderApi\Services\CreateOrder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CreateOrder $createOrder
    ) {

    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): JsonResponse {

        $this->createOrder->createOrder($data);

        return new JsonResponse(
            'Order created successfully',
            Response::HTTP_CREATED
        );
    }
}