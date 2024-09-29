<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CheckoutController;
use Modules\Order\Models\Order;

Route::middleware('auth')->group(function (): void {
    Route::post('checkout', CheckoutController::class)->name('checkout');

    Route::get('orders/{order}', fn (Order $order): \Modules\Order\Models\Order => $order)->name('orders.show');
});
