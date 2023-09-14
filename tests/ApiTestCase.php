<?php

declare(strict_types=1);

namespace App\OrderApi\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase as ApiTestCaseCore;
use ApiPlatform\Symfony\Bundle\Test\Client;

abstract class ApiTestCase extends ApiTestCaseCore
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected \Doctrine\ORM\EntityManager $entityManager;

    protected static function createApiClient(array $kernelOptions = [], array $defaultOptions = []): Client
    {
        $defaultOptions['headers'] = array_merge($defaultOptions, ['Content-Type' => 'application/json', 'Accept' => 'application/json']);
        return static::createClient($kernelOptions, $defaultOptions);
    }

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
}
