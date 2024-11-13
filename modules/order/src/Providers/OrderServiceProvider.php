<?php

namespace Modules\Order\Providers;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'order');

        // Blade::anonymousComponentPath(__DIR__ . '/../../Ui/Views/components', 'order');
        // Blade::componentNamespace('Modules\\Order\\Ui\\ViewComponents', 'order');
    }
}
