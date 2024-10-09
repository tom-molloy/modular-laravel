<?php

declare(strict_types=1);

namespace Modules\Payment\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Payment\PayBuddyGateway;
use Modules\Payment\PayBuddySdk;
use Modules\Payment\PaymentGateway;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        // $this->mergeConfigFrom(__DIR__.'/../config.php', 'order');

        // $this->app->register(RouteServiceProvider::class);

        $this->app->bind(PaymentGateway::class, fn () => new PayBuddyGateway(PayBuddySdk::make()));
    }
}
