<?php

declare(strict_types=1);

namespace Modules\Order\ViewComponents;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(
        public string $message
    ) {}

    public function render(): View
    {
        return view('order::alert');
    }
}
