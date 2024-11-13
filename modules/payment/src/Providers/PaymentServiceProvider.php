<?php

namespace Modules\Payment\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Payment\Interfaces\PaymentGateway;
use Modules\Payment\PayBuddyGateway;
use Modules\Payment\PayBuddySdk;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->app->bind(PaymentGateway::class, fn () => new PayBuddyGateway(new PayBuddySdk));
    }
}
