<?php

declare(strict_types=1);

namespace AlazziAz\Tamara\Tamara\Response\Order;

use AlazziAz\Tamara\Tamara\Model\Money;
use AlazziAz\Tamara\Tamara\Response\ClientResponse;
use DateTimeImmutable;

class AuthoriseOrderResponse extends ClientResponse
{
    private const ORDER_ID = 'order_id';

    private const STATUS = 'status';

    private const ORDER_EXPIRY_TIME = 'order_expiry_time';

    private const AUTHORIZED_AMOUNT = 'authorized_amount';

    private const PAYMENT_TYPE = 'payment_type';

    private const AUTO_CAPTURED = 'auto_captured';

    private const CAPTURE_ID = 'capture_id';

    /**
     * @var string|null
     */
    private $orderId;

    /**
     * @var string|null
     */
    private $orderStatus;

    /**
     * @var DateTimeImmutable
     */
    private $orderExpiryTime;

    /**
     * @var Money
     */
    private $authorizedAmount;

    /**
     * @var bool
     */
    private $autoCaptured;

    /**
     * @var string|null
     */
    private $captureId;

    /**
     * @var string|null
     */
    private $paymentType;

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function getOrderStatus(): ?string
    {
        return $this->orderStatus;
    }

    public function getOrderExpiryTime(): DateTimeImmutable
    {
        return $this->orderExpiryTime;
    }

    public function getAuthorizedAmount(): Money
    {
        return $this->authorizedAmount;
    }

    public function getAutoCaptured(): bool
    {
        return $this->autoCaptured;
    }

    public function getCaptureId(): ?string
    {
        return $this->captureId;
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    protected function parse(array $responseData): void
    {
        $this->orderId = $responseData[self::ORDER_ID];
        $this->orderStatus = $responseData[self::STATUS];
        $this->orderExpiryTime = new DateTimeImmutable($responseData[self::ORDER_EXPIRY_TIME]);
        $this->authorizedAmount = new Money($responseData[self::AUTHORIZED_AMOUNT][Money::AMOUNT], $responseData[self::AUTHORIZED_AMOUNT][Money::CURRENCY]);
        $this->autoCaptured = $responseData[self::AUTO_CAPTURED];
        $this->captureId = $responseData[self::CAPTURE_ID];
        $this->paymentType = $responseData[self::PAYMENT_TYPE];
    }
}
