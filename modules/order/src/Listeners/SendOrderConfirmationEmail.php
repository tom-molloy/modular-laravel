<?php

namespace Modules\Order\Listeners;

use Modules\Order\Events\OrderStarted;

class SendOrderConfirmationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStarted $event): void
    {
        //
    }
}
