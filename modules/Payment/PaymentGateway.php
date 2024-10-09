<?php

namespace Modules\Payment;

interface PaymentGateway
{
    public function id(): PaymentProvider;
    
    public function charge(PaymentDetails $paymentDetails): SuccessfulPayment;
}