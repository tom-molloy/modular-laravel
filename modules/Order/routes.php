<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CheckoutController;

Route::middleware('auth')->group(function (): void {
    Route::post('checkout', CheckoutController::class)->name('checkout');
});
