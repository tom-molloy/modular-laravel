<?php

declare(strict_types=1);

namespace Modules\Payment;

use Illuminate\Support\Str;

class InMemoryGateway implements PaymentGateway
{
    public function id(): PaymentProvider
    {
        return PaymentProvider::InMemory;
    }

    public function charge(PaymentDetails $paymentDetails): SuccessfulPayment
    {
        return new SuccessfulPayment(
            Str::uuid()->toString(),
            $paymentDetails->amountInCents,
            $this->id()
        );
    }
}
