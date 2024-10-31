<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Order\Http\Requests\CheckoutRequest;

class CheckoutController
{
    public function create(): View
    {
        $products = [
            (object) [
                "name" =>  "Umbrella",
                "price" => 12
            ],
            (object) [
                "name" =>  "Raincoat",
                "price" => 80
            ],
            (object) [
                "name" =>  "Gumboots",
                "price" => 45
            ],
        ];

        return view('order::create', ['products' => $products]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        dd($request->input(), $request);

        // $cartItems = CartItemCollection::fromCheckoutData($request->input('products'));
        // $cartItems = CartItemCollection::fromCheckoutData($request->input('products'));
        // $pendingPayment = new PendingPayment($this->paymentGateway, $request->input('payment_token'));
        // $userDto = UserDto::fromEloquentModel($request->user());

        // try {
        //     $order = $this->purchaseItems->handle(
        //         $cartItems,
        //         $pendingPayment,
        //         $userDto
        //     );
        // } catch (PaymentFailedException) {
        //     throw ValidationException::withMessages([
        //         'payment_token' => 'We could not complete your payment.',
        //     ]);
        // }
        
        return redirect()->route('orders.index');
    }
}
