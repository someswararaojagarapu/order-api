<?php

namespace App\OrderApi\Dto;

use App\OrderApi\Utils\OrderGroups;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class OrderInput
{
    #[Groups([
        OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('name')]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(
                message: 'Order name has not defined',
                groups: [
                    OrderGroups::CREATE_ORDER
                ]
            ),
            new Assert\Length(
                min: 1,
                max: 255,
                minMessage: 'Order name must be at least 1 characters long',
                maxMessage: 'Order name cannot be longer than 255 characters',
                groups: [
                    OrderGroups::CREATE_ORDER
                ]
            )
        ])
    ]
    private ?string $name = null;

    #[Groups([
        OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('delivery_address')]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(
                message: 'Delivery address has not defined',
                groups: [
                    OrderGroups::CREATE_ORDER
                ]
            ),
            new Assert\Length(
                min: 1,
                max: 255,
                minMessage: 'Delivery address must be at least 1 characters long',
                maxMessage: 'Delivery address cannot be longer than 255 characters',
                groups: [
                    OrderGroups::CREATE_ORDER
                ]
            )
        ])
    ]
    private ?string $deliveryAddress = null;

    #[Groups([
        OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('quantity')]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(
                message: 'Quantity has not defined',
                groups: [
                    OrderGroups::CREATE_ORDER
                ]
            )
        ])
    ]
    private ?int $quantity = null;

    #[Groups([
        OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('delivery_option')]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(
                message: 'Delivery option has not defined',
                groups: [
                    OrderGroups::CREATE_ORDER
                ]
            )
        ])
    ]
    private ?string $deliveryOption = null;

    #[Groups([
        OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('status')]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(
                message: 'Order status has not defined',
                groups: [
                    OrderGroups::CREATE_ORDER
                ]
            )
        ])
    ]
    private ?string $orderStatus = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?string $deliveryAddress): void
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getDeliveryOption(): ?string
    {
        return $this->deliveryOption;
    }

    public function setDeliveryOption(?string $deliveryOption): void
    {
        $this->deliveryOption = $deliveryOption;
    }

    public function getOrderStatus(): ?string
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(?string $orderStatus): void
    {
        $this->orderStatus = $orderStatus;
    }

}
