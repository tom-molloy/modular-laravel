<?php

declare(strict_types=1);

namespace Modules\Order;

use Modules\Payment\PaymentGateway;

readonly class PendingPayment
{
    public function __construct(
        public PaymentGateway $paymentGateway,
        public string $paymentToken
    ) {}
}
