<?php

namespace App\OrderApi\Command;

use App\OrderApi\Entity\Order;
use App\OrderApi\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'order:update:status',
    description: 'Finding all processing orders that have passed their delivery time and updating their status to delayed',
)]
class OrderStatusCommand extends Command
{
    const PROCESSING_STATUS = 'Processing';
    const DELAYED = 'Delayed';

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('order:update:status');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $orders = $this->entityManager->getRepository(Order::class)->getOrdersByProcessing(self::PROCESSING_STATUS);
        foreach ($orders as $orderRes) {
            $deliveryDate = $orderRes['deliveryDate'] ?? '';
            $isDeliverDateLessThanCurrentDate = $this->compareDeliveryAndTodayDate($deliveryDate);
            if ($isDeliverDateLessThanCurrentDate) {
                /** @var Order $order */
                $order = $this->entityManager->getRepository(Order::class)->find($orderRes['id']);
                $status = $this->entityManager->getRepository(OrderStatus::class)->findByName(['name' => self::DELAYED]);
                $order->setOrderStatus($status[0]);
                $this->entityManager->persist($order);
                $this->entityManager->flush();
            }
        }
        $this->entityManager->clear();

        return Command::SUCCESS;
    }

    private function compareDeliveryAndTodayDate(string $dateString): bool
    {
        // Convert the date string to a DateTime object
        $dateTime = new \DateTime($dateString);
        // Get the current date as a DateTime object
        $currentDate = new \DateTime();
        // Compare the two DateTime objects
        if ($dateTime < $currentDate) {
            return true;
        }
        return false;
    }
}
