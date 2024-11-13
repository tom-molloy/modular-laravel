<?php

namespace Modules\Payment\Dto;

enum PaymentProvider: string
{
    case PayBuddy = 'pay_buddy';
    case InMemory = 'in_memory';
}
