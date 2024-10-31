<?php

use Modules\Order\Http\Controllers\CheckoutController;
use Modules\Order\Http\Controllers\OrderController;

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::get('/orders/checkout', [CheckoutController::class, 'create'])->name('orders.create');
Route::post('/orders/checkout', [CheckoutController::class, 'store'])->name('orders.checkout');
// Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
// Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
// Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
// Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
