<?php

namespace App\OrderApi\DataFixtures;

use App\OrderApi\Entity\DeliveryOption;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
class DeliveryOptionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create and persist entities
        $deliveryOption = new DeliveryOption();
        $deliveryOption->setName('test status');
        $manager->persist($deliveryOption);

        // Flush changes to the database
        $manager->flush();
    }
}