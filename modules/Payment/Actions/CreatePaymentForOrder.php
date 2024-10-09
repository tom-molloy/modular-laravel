<?php

declare(strict_types=1);

namespace Modules\Payment\Actions;

use Modules\Order\Exceptions\PaymentFailedException;
use Modules\Payment\Models\Payment;
use Modules\Payment\PayBuddySdk;
use Modules\Payment\PaymentDetails;
use Modules\Payment\PaymentGateway;
use RuntimeException;

class CreatePaymentForOrder
{
    public function handle(
        string $orderId,
        int $userId,
        int $totalInCents,
        PaymentGateway $paymentGateway,
        string $paymentToken
    ): Payment {
        // try {
            $charge = $paymentGateway->charge(
                new PaymentDetails(
                    $paymentToken,
                    $totalInCents,
                    'Modularization'
                )
            );
        // } catch (RuntimeException) {
        //     throw PaymentFailedException::dueToInvalidToken();
        // }

        return Payment::query()->create([
            'order_id' => $orderId,
            'total_in_cents' => $totalInCents,
            'status' => 'paid',
            'payment_gateway' => $charge->paymentProvider,
            'payment_id' => $charge->id,
            'user_id' => $userId,
        ]);
    }
}
