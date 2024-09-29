<?php

declare(strict_types=1);

namespace Modules\Payment\Actions;

use Modules\Order\Exceptions\PaymentFailedException;
use Modules\Payment\Models\Payment;
use Modules\Payment\PayBuddy;

class CreatePaymentForOrder
{
    public function handle(
        string $orderId,
        int $userId,
        int $totalInCents,
        PayBuddy $payBuddy,
        string $paymentToken
    ): Payment {
        try {
            $charge = $payBuddy->charge(
                $paymentToken,
                $totalInCents,
                'Modularization'
            );
        } catch (\Exception) {
            throw PaymentFailedException::dueToInvalidToken();
        }

        return Payment::query()->create([
            'order_id' => $orderId,
            'total_in_cents' => $totalInCents,
            'status' => 'paid',
            'payment_gateway' => 'PayBuddy',
            'payment_id' => $charge['id'],
            'user_id' => $userId,
        ]);
    }
}
