<?php

declare(strict_types=1);

namespace App\OrderApi\Tests\Feature;

use App\OrderApi\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateOrderTest extends ApiTestCase
{
    private const CREATE_ORDER = '/api/order';
    // This trait provided by AliceBundle will take care of refreshing the database content to a known state before each test
//    use RefreshDatabaseTrait;

    /**
     * @test
     * @dataProvider getCreateOrderDataProvider
     */
    public function testCreateOrder(
        $requestBody,
        $contentType,
        $expectedResponse,
        $statusCode
    ): void {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createApiClient()->request(
            'POST',
            self::CREATE_ORDER,
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

    public static function getCreateOrderDataProvider()
    {
        return [
            'Success scenario' => [
                self::successPayload()['requestPayload'],
                'contentType' => 'application/json',
                self::successPayload()['expectedOutPut'],
                Response::HTTP_OK
            ],
            'Failure scenario with wrong delivery option' => [
                self::failurePayloadWithWrongDeliveryOption()['requestPayload'],
                'contentType' => 'application/json',
                Response::HTTP_BAD_REQUEST
            ],
            'Failure scenario with wrong order status' => [
                self::failurePayloadWithWrongOrderStatus()['requestPayload'],
                'contentType' => 'application/json',
                Response::HTTP_BAD_REQUEST
            ],
            'Failure wrong input request payload key' => [
                [
                    "nameTest" => "test order1",
                    "delivery_address" => "test address",
                    "quantity" => 1,
                    "delivery_option" => "Standard Shipping Test",
                    "status" => "Completed Test"
                ],
                'contentType' => 'application/json',
                [],
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]
        ];
    }

    public static function successPayload(): array
    {
        return [
            'requestPayload' => [
                "name" => "test order",
                "delivery_address" => "test address",
                "quantity" => 1,
                "delivery_option" => "Standard Shipping",
                "status" => "Completed"
            ],
            'expectedOutPut' => [
                "Order created successfully"
            ]
        ];
    }

    public static function failurePayloadWithWrongDeliveryOption(): array
    {
        return [
            'requestPayload' => [
                "name" => "test order1",
                "delivery_address" => "test address",
                "quantity" => 1,
                "delivery_option" => "Standard Shipping Test",
                "status" => "Completed"
            ]
        ];
    }

    public static function failurePayloadWithWrongOrderStatus(): array
    {
        return [
            'requestPayload' => [
                "name" => "test order1",
                "delivery_address" => "test address",
                "quantity" => 1,
                "delivery_option" => "Standard Shipping Test",
                "status" => "Completed Test"
            ]
        ];
    }
}
