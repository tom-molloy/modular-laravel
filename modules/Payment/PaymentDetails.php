<?php

declare(strict_types=1);

namespace Modules\Payment;

readonly class PaymentDetails
{
    public function __construct(
        public string $token,
        public int $amountInCents,
        public string $statementDescription
    ) {}
}
