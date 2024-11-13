<?php

namespace Modules\Order\Dto;

use Illuminate\Contracts\Auth\Authenticatable;

readonly class OrderStarted
{
    public function __construct(
        public Order $order,
        public Authenticatable $user,
        public PendingPayment $pendingPayment,
    ) {}
}
