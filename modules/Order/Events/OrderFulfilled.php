<?php

declare(strict_types=1);

namespace Modules\Order\Events;

use Modules\Order\OrderDto;
use Modules\User\UserDto;

class OrderFulfilled
{
    public function __construct(
        public OrderDto $orderDto,
        public UserDto $userDto,
    ) {}
}
