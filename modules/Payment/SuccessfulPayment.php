<?php

declare(strict_types=1);

namespace Modules\Payment;

class SuccessfulPayment
{
    public function __construct(
        public string $id,
        public int $amountInCents,
        public PaymentProvider $paymentProvider
    ) {}
}
