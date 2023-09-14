<?php

namespace App\OrderApi\Dto;

use App\OrderApi\Utils\OrderGroups;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateOrderInput
{
    #[Groups([
        OrderGroups::PATCH_ORDER
    ])]
    #[SerializedName('order_id')]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(
                message: 'Order Id has not defined',
                groups: [
                    OrderGroups::PATCH_ORDER
                ]
            )
        ])
    ]
    private ?int $orderId = null;

    #[Groups([
        OrderGroups::PATCH_ORDER
    ])]
    #[SerializedName('status')]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(
                message: 'Status address has not defined',
                groups: [
                    OrderGroups::PATCH_ORDER
                ]
            )
        ])
    ]
    private ?string $status = null;

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(?int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }
}
