<?php

declare(strict_types=1);

namespace App\OrderApi\Tests\Feature;

use App\OrderApi\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class UpdateOrderTest extends ApiTestCase
{
    private const UPDATE_ORDER = '/api/order/%s';

    // This trait provided by AliceBundle will take care of refreshing the database content to a known state before each test
//    use RefreshDatabaseTrait;

    /**
     * @test
     * @dataProvider getUpdateOrderDataProvider
     */
    public function testCreateOrder(
        $requestBody,
        $contentType,
        $expectedResponse,
        $statusCode
    ): void {
        $url = sprintf(self::UPDATE_ORDER, $requestBody['order_id']);

        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createApiClient()->request(
            'POST',
            $url,
            [
                'body' => json_encode($requestBody)
            ]
        );

        $this->assertEquals($statusCode, $response->getStatusCode());
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', $contentType);
        if ($expectedResponse) {
            $result = $response->toArray();
            $this->assertIsArray($result);
        }
    }

    public static function getUpdateOrderDataProvider()
    {
        return [
            'Success scenario' => [
                [
                    "order_id" => 1,
                    "status" => "Completed"
                ],
                'contentType' => 'application/json',
                Response::HTTP_OK
            ],
            'Failure scenario with wrong status' => [
                [
                    "order_id" => 1,
                    "status" => "Completed Test"
                ],
                'contentType' => 'application/json',
                Response::HTTP_BAD_REQUEST
            ],
            'Failure wrong input request payload key' => [
                [
                    "order_id_test" => 1,
                    "status" => "Completed"
                ],
                'contentType' => 'application/json',
                [],
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]
        ];
    }
}
