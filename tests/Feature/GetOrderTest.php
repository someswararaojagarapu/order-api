<?php

declare(strict_types=1);

namespace App\OrderApi\Tests\Feature;

use App\OrderApi\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetOrderTest extends ApiTestCase
{
    private const UPDATE_ORDER = '/api/order/%s';

    // This trait provided by AliceBundle will take care of refreshing the database content to a known state before each test
//    use RefreshDatabaseTrait;

    /**
     * @test
     * @dataProvider getOrderDataProvider
     */
    public function testGetOrder(
        $orderId,
        $contentType,
        $expectedResponse,
        $statusCode
    ): void {
        $url = sprintf(self::UPDATE_ORDER, $orderId);

        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createApiClient()->request(
            'GET',
            $url
        );

        $this->assertEquals($statusCode, $response->getStatusCode());
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', $contentType);
        if ($expectedResponse) {
            $result = $response->toArray();
            $this->assertIsArray($result);
        }
    }

    public static function getOrderDataProvider()
    {
        return [
            'Success scenario' => [
                1,
                'contentType' => 'application/json',
                Response::HTTP_OK
            ],
            'Failure scenario with wrong orderId' => [
                101,
                'contentType' => 'application/json',
                Response::HTTP_BAD_REQUEST
            ]
        ];
    }
}
