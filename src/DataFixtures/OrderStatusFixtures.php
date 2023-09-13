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
        $orderStatus = new OrderStatus();
        $orderStatus->setName('test option');
        $manager->persist($orderStatus);

        // Flush changes to the database
        $manager->flush();
    }
}