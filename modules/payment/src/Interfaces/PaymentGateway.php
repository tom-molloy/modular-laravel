<?php

namespace Modules\Payment\Interfaces;

use Modules\Payment\Dto\PaymentDetails;
use Modules\Payment\Dto\PaymentProvider;
use Modules\Payment\Dto\SuccessfulPayment;

interface PaymentGateway
{
    public function charge(PaymentDetails $details): SuccessfulPayment;

    public function id(): PaymentProvider;
}
