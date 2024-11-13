<?php

namespace Modules\Order\Dto;

use Modules\Payment\Interfaces\PaymentGateway;

readonly class PendingPayment
{
    public function __construct(
        public PaymentGateway $provider,
        public string $paymentToken
    ) {}
}
