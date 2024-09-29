<?php

declare(strict_types=1);

namespace Modules\Order\Exceptions;

class PaymentFailedException extends \Exception
{
    public static function dueToInvalidToken(): self
    {
        return new self('The given payment token is invalid');
    }
}
