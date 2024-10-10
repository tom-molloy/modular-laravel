<?php

declare(strict_types=1);

namespace Modules\Order\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'order');

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        $this->loadViewsFrom(__DIR__.'/../Views', 'order');

        Blade::anonymousComponentPath(__DIR__.'/../Views/Components', 'order');
        Blade::componentNamespace('Modules\\Order\\ViewComponents', 'order');
    }
}
