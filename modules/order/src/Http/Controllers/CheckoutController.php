<?php

namespace Modules\Order\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\Order\Commands\PurchaseItems;
use Modules\Order\Dto\PendingPayment;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Payment\Exceptions\PaymentFailedException;
use Modules\Payment\Interfaces\PaymentGateway;
use Modules\Product\Collections\CartItemCollection;
use Modules\Product\Models\Product;

class CheckoutController
{
    public function __construct(
        protected PurchaseItems $purchaseItems,
        protected PaymentGateway $paymentGateway,
        protected Auth $auth
    ) {}

    public function create(): View
    {
        return view('order::create', ['products' => Product::all()]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $cartItems = CartItemCollection::fromCheckoutData($request->input('products'));
        $pendingPayment = new PendingPayment($this->paymentGateway, $request->string('payment_token'));

        // TODO: Proper auth
        // $userDto = $this->auth->user();
        $userDto = User::first();

        try {
            $this->purchaseItems->handle(
                $cartItems,
                $pendingPayment,
                $userDto
            );
        } catch (PaymentFailedException) {
            throw ValidationException::withMessages([
                'payment_token' => 'We could not complete your payment.',
            ]);
        }

        return redirect()->route('orders.index');
    }
}
