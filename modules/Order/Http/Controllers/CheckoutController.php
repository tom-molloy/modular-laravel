<?php

declare(strict_types=1);

namespace Modules\Order\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Modules\Order\Actions\PurchaseItems;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\PendingPayment;
use Modules\Payment\Exceptions\PaymentFailedException;
use Modules\Payment\PayBuddySdk;
use Modules\Payment\PaymentGateway;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;
use Modules\User\UserDto;

class CheckoutController
{
    private User $user;

    public function __construct(
        protected Guard $guard,
        protected ProductStockManager $productStockManager,
        protected PurchaseItems $purchaseItems,
        protected PaymentGateway $paymentGateway
    ) {
        if ($this->guard->user() instanceof User) {
            $this->user = $this->guard->user();
        }
    }

    public function __invoke(CheckoutRequest $checkoutRequest): JsonResponse
    {
        $cartItemCollection = CartItemCollection::fromCheckoutData((array) $checkoutRequest->input('products'));

        $pendingPayment = new PendingPayment(
            $this->paymentGateway,
            $checkoutRequest->string('payment_token')->value()
        );

        try {
            $order = $this->purchaseItems->handle(
                $cartItemCollection,
                $pendingPayment,
                UserDto::fromEloquentModel($this->user)
            );
        } catch (PaymentFailedException) {
            throw ValidationException::withMessages([
                'payment_token' => 'We could not complete your payment',
            ]);
        }

        return response()->json([
            'order_url' => $order->url,
        ], 201);
    }
}
