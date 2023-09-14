<?php

namespace App\OrderApi\DataFixtures;

use App\OrderApi\Entity\OrderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
class OrderStatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create and persist entities
        foreach ($this->getOrderStatus() as $orderStatusName) {
            $orderStatus = new OrderStatus();
            $orderStatus->setName($orderStatusName);
            $manager->persist($orderStatus);
        }

        // Flush changes to the database
        $manager->flush();
    }

    private function getOrderStatus(): array
    {
        return  [
            'Pending Payment',
            'Processing',
            'Delayed',
            'Shipped',
            'Delivered',
            'Canceled',
            'Refunded',
            'On Hold',
            'Awaiting Pickup',
            'Completed',
            'Failed',
            'Payment Pending',
            'Payment Failed',
            'Payment Received',
            'Payment Refunded',
            'Reviewing',
            'Returned',
            'Exchanged',
            'Partially Shipped',
            'Backordered',
            'Pending Fulfillment',
            'Pending Pickup',
            'In Transit',
            'Out for Delivery',
            'Arrived at Destination',
            'Ready for Pickup',
            'Waiting for Customer Pickup',
            'Pending Review',
            'Payment Authorized',
            'Payment Captured',
            'Payment Declined',
            'Awaiting Payment',
            'Payment Expired',
            'Verification Required',
            'Suspended',
            'Closed',
            'Disputed',
            'Partially Refunded',
            'Awaiting Shipment',
            'Processing Return',
            'Awaiting Exchange',
            'Processing Refund',
            'Processing Cancellation',
            'Partially Returned',
            'Partially Exchanged',
            'Pending Resolution'
        ];
    }
}