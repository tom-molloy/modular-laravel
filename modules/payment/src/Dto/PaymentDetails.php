<?php

namespace Modules\Payment\Dto;

readonly class PaymentDetails
{
    public function __construct(
        public string $token,
        public int $amountInCents,
        public string $statementDescription
    ) {}
}
