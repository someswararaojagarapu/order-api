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
        foreach ($this->deliveryOptions() as $deliveryOptionName) {
            $deliveryOption = new DeliveryOption();
            $deliveryOption->setName($deliveryOptionName);
            $manager->persist($deliveryOption);
        }
        // Flush changes to the database
        $manager->flush();
    }

    private function deliveryOptions():array
    {
        return [
            'Standard Shipping',
            'Express Shipping',
            'Same-Day or Next-Day Delivery',
            'Free Shipping',
            'Local Pickup',
            'Scheduled Delivery',
            'International Shipping',
            'Economy Shipping',
            'Premium Shipping',
            'Weekend Delivery'
        ];
    }
}