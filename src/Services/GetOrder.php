<?php

namespace App\OrderApi\Services;

use DateTime;

class GetOrder
{
    public function getOrderDetails(array &$data): array
    {
        $estimatedDeliveryDate = $data['estimated_delivery_date'] ?? '';
        $data['order_status'] = $data['order_status']['order_status'] ?? '';
        $data['delivery_option'] = $data['delivery_option']['delivery_option'] ?? '';
        $data['estimated_delivery_date'] = $this->getEstimatedDelivaryDate($estimatedDeliveryDate);
        $data['estimated_delivery_time'] = $this->getEstimatedDelivaryTime($estimatedDeliveryDate);

        return $data;
    }

    public function getOrders(array $orders): array
    {
        $result = [];
        foreach ($orders as $order) {
            $estimatedDeliveryDate = $order['estimated_delivery_date'] ?? '';
            $result[] = [
                'order_id' => $order['order_id'] ?? '',
                'name' => $order['name'] ?? '',
                'delivery_address' => $order['delivery_address'] ?? '',
                'order_items' => [
                    'id' => $order['order_item_id'] ?? '',
                    'quantity' => $order['order_quantity'] ?? ''
                ],
                'order_status' => $order['order_status'] ?? '',
                'delivery_option' => $order['delivery_option'] ?? '',
                'estimated_delivery_date' => $this->getEstimatedDelivaryDate($estimatedDeliveryDate),
                'estimated_delivery_time' => $this->getEstimatedDelivaryTime($estimatedDeliveryDate),
                'created_at' => $order['created_at'] ?? '',
                'last_saved_date' => $order['updated_at'] ?? '',
            ];
        }
        return $result;
    }

    private function getEstimatedDelivaryDate(string $datetimeString): string
    {
        $estimatedDeliveryDate = '';
        if (!empty($datetimeString)) {
            $dateTime = new DateTime($datetimeString);
            $estimatedDeliveryDate = $dateTime->format('Y-m-d');
        }

        return $estimatedDeliveryDate;
    }

    private function getEstimatedDelivaryTime(string $datetimeString): string
    {
        $estimatedDeliveryTime = '';
        if (!empty($datetimeString)) {
            $dateTime = new DateTime($datetimeString);
            $estimatedDeliveryTime = $dateTime->format('H:i:s');
        }

        return $estimatedDeliveryTime;
    }
}