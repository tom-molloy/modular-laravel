<?php

namespace Modules\Payment\Dto;

readonly class SuccessfulPayment
{
    public function __construct(
        public string $id,
        public int $amountInCents,
        public PaymentProvider $paymentProvider
    ) {}
}
