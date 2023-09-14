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