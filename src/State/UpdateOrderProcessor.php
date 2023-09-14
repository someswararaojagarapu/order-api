<?php

namespace App\OrderApi\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\OrderApi\Services\UpdateOrder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UpdateOrder $createOrder
    ) {

    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): JsonResponse {
        $result = $this->createOrder->updatedOrder($data);
        if (is_array($result)) {
            return new JsonResponse(
                $result['type'] . ' allowed only' . json_encode($result['result']),
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            'Order updated successfully',
            Response::HTTP_CREATED
        );
    }
}