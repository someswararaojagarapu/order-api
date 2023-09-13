<?php

namespace App\OrderApi\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\OrderApi\Dto\OrderInput;
use App\OrderApi\Entity\Traits\TimestampableTrait;
use App\OrderApi\Repository\OrderRepository;
use App\OrderApi\State\CreateOrderProcessor;
use App\OrderApi\Utils\OrderGroups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Index(columns: ['name'], name: 'order_name')]
#[ORM\Table(name:"orders")]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/order/{id}',
            formats: ['jsonld'],
            normalizationContext: ['groups' => [OrderGroups::GET_ORDER]],
            name: 'get_order',
            openapiContext: [
                'summary' => 'Order filtering properties',
                'description' => 'Filtering options included with querystring',
                'parameters' => self::GET_ORDER_ID_FILTER
            ]
        ),
        new Post(
            uriTemplate: '/order',
            openapiContext: [
                'summary' => 'Order Creation',
                'description' => 'Order Creation',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => [
                                        'type' => 'string',
                                        'example' => 'test order'
                                    ],
                                    'delivery_address' => [
                                        'type' => 'string',
                                        'example' => 'test address'
                                    ],
                                    'quantity' => [
                                        'type' => 'integer',
                                        'example' => 1
                                    ],
                                    'delivery_option' => [
                                        'type' => 'string',
                                        'example' => 'test option'
                                    ],
                                    'status' => [
                                        'type' => 'string',
                                        'example' => 'test status'
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            denormalizationContext: ['groups' => [OrderGroups::CREATE_ORDER]],
            validationContext: ['groups' => [OrderGroups::CREATE_ORDER]],
            input: OrderInput::class,
            processor: CreateOrderProcessor::class
        ),
        new Patch(
            uriTemplate: '/order',
            openapiContext: [
                'summary' => 'Update Order',
                'description' => 'Update Order',
                'requestBody' => [
                    'content' => [
                        'application/merge-patch+json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'order_id' => ['type' => 'integer', 'example' => 1],
                                    'status' => [
                                        'type' => 'string',
                                        'example' => 'Test Status'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            denormalizationContext: ['groups' => [OrderGroups::PATCH_ORDER]],
            input: OrderInput::class,
            processor: CreateOrderProcessor::class
        )
        ],
    normalizationContext: ['groups' => ['order:read']],
    denormalizationContext: ['groups' => ['order:write']]
)]
class Order
{
    use TimestampableTrait;

    const GET_ORDER_ID_FILTER = [
        [
            'name' => 'id',
            'type' => 'string',
            'in' => 'path',
            'required' => false,
            'example' => 1,
        ],
        [
            'name' => 'status',
            'type' => 'string',
            'in' => 'path',
            'required' => false,
            'example' => 'Completed',
        ]
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column]
    #[Groups([
        OrderGroups::GET_ORDER, OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('order_id')]
    #[ApiProperty(identifier: true)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        OrderGroups::GET_ORDER, OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('name')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        OrderGroups::GET_ORDER, OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('delivery_address')]
    private ?string $deliveryAddress = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class, cascade: ['persist', 'remove'])]
    #[Groups([
        OrderGroups::GET_ORDER, OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('order_items')]
    private Collection $orderItems;

    #[ORM\ManyToOne(inversedBy: 'orders', cascade: ['persist', 'remove'])]
    #[Groups([
        OrderGroups::GET_ORDER, OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('order_status')]
    private ?OrderStatus $orderStatus = null;

    #[ORM\ManyToOne(inversedBy: 'orders', cascade: ['persist', 'remove'])]
    #[Groups([
        OrderGroups::GET_ORDER, OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('delivery_option')]
    private ?DeliveryOption $deliveryOption = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        OrderGroups::GET_ORDER, OrderGroups::CREATE_ORDER
    ])]
    #[SerializedName('delivery_date')]
    private ?\DateTimeInterface $deliveryDate = null;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(string $deliveryAddress): static
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrder() === $this) {
                $orderItem->setOrder(null);
            }
        }

        return $this;
    }

    public function getOrderStatus(): ?OrderStatus
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(?OrderStatus $orderStatus): static
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    public function getDeliveryOption(): ?DeliveryOption
    {
        return $this->deliveryOption;
    }

    public function setDeliveryOption(?DeliveryOption $deliveryOption): static
    {
        $this->deliveryOption = $deliveryOption;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $deliveryDate): static
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }
}
