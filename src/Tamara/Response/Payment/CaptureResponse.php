<?php

declare(strict_types=1);

namespace AlazziAz\Tamara\Tamara\Response\Payment;

use AlazziAz\Tamara\Tamara\Response\ClientResponse;

class CaptureResponse extends ClientResponse
{
    private const ORDER_ID = 'order_id';

    private const CAPTURE_ID = 'capture_id';

    /**
     * @var string|null
     */
    private $orderId;

    /**
     * @var string|null
     */
    private $captureId;

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function getCaptureId(): ?string
    {
        return $this->captureId;
    }

    protected function parse(array $responseData): void
    {
        $this->orderId = $responseData[self::ORDER_ID];
        $this->captureId = $responseData[self::CAPTURE_ID];
    }
}
