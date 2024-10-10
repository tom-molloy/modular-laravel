<?php

declare(strict_types=1);

namespace Modules\Payment;

use Modules\Payment\Exceptions\PaymentFailedException;
use RuntimeException;

class PayBuddyGateway implements PaymentGateway
{
    public function __construct(protected PayBuddySdk $payBuddySdk) {}

    public function id(): PaymentProvider
    {
        return PaymentProvider::PayBuddy;
    }

    public function charge(PaymentDetails $paymentDetails): SuccessfulPayment
    {
        try {
            $charge = $this->payBuddySdk->charge(
                $paymentDetails->token,
                $paymentDetails->amountInCents,
                $paymentDetails->statementDescription
            );
        } catch (RuntimeException) {
            throw PaymentFailedException::dueToInvalidToken();
        }

        return new SuccessfulPayment(
            $charge['id'],
            $charge['amount_in_cents'],
            $this->id()
        );
    }
}
