<?php

declare(strict_types=1);

namespace Modules\Payment;

interface PaymentGateway
{
    public function id(): PaymentProvider;

    public function charge(PaymentDetails $paymentDetails): SuccessfulPayment;
}
