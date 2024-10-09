<?php

declare(strict_types=1);

namespace Modules\Order\Events;

use Illuminate\Support\Facades\Mail;
use Modules\Order\OrderReceived;

class SendOrderConfirmationEmail
{
    public function handle(OrderFulfilled $orderFulfilled): void
    {
        Mail::to($orderFulfilled->userEmail)->send(
            new OrderReceived(
                $orderFulfilled->localisedTotal
            )
        );
    }
}
