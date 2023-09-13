<?php

namespace App\OrderApi\Serializer;

use App\OrderApi\Entity\Order;
use App\OrderApi\Utils\OrderGroups;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OrderNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'ORDER_NORMALIZER_ALREADY_CALLED';

    public function __construct()
    {

    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;
        $data = [];
        if (!isset($context['groups'])) {
            return $data;
        }
        if (
            !in_array(OrderGroups::GET_ORDER, $context['groups'])
        ) {
            $data = $this->normalizer->normalize($object, $format, $context);
        }
        return $data;
    }
    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        // Make sure we're not called twice
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Order;
    }
}