<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('product-test', fn (): string => 'Hello Product!');
