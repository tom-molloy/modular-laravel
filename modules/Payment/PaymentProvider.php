<?php

declare(strict_types=1);

namespace Modules\Payment;

enum PaymentProvider: string
{
    case PayBuddy = 'pay_buddy';
    case InMemory = 'in_memory';
}
