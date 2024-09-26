<?php

declare(strict_types=1);

namespace Modules\Order\Tests\Http\Controllers;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Order\Models\Order;
use Modules\Order\Tests\OrderTestCase;
use Modules\Payment\PayBuddy;
use Modules\Product\Database\Factories\ProductFactory;
use Modules\Product\Models\Product;
use PHPUnit\Framework\Attributes\Test;

final class CheckoutControllerTest extends OrderTestCase
{
    use DatabaseMigrations;

    #[Test]
    public function it_successfuly_creates_an_order(): void
    {
        $user = UserFactory::new()->createOne();

        $products = Product::factory()->count(2)->createMany(
            [
                ['name' => 'Very expensive air fryer', 'price_in_cents' => 10000, 'stock' => 10],
                ['name' => 'Macbook Pro M3', 'price_in_cents' => 50000, 'stock' => 10],
            ]
        );

        $paymentToken = PayBuddy::validToken();

        $testResponse = $this->actingAs($user)
            ->post(route('order::checkout', [
                'payment_token' => $paymentToken,
                'products' => [
                    ['id' => $products->first()?->id, 'quantity' => 1],
                    ['id' => $products->last()?->id, 'quantity' => 1],
                ],
            ]));

        $order = Order::query()->latest('id')->first();

        $testResponse
            ->assertJson([
                'order_url' => $order?->url(),
            ])
            ->assertStatus(201);

        // Order
        $this->assertTrue($order?->user?->is($user));
        $this->assertSame(60000, $order->total_in_cents);

        // Payment
        $payment = $order->payments()->latest()->first();
        $this->assertNotNull($payment);
        $this->assertSame('paid', $payment->status);
        $this->assertSame('PayBuddy', $payment->payment_gateway);
        $this->assertSame(36, strlen($payment->payment_id));
        $this->assertSame(60000, $payment->total_in_cents);
        $this->assertTrue($payment->user?->is($user));

        // Order Lines
        $this->assertCount(2, $order->lines);

        foreach ($products as $product) {
            $orderLine = $order->lines->where('product_id', $product->id)->first();

            $this->assertSame($product->price_in_cents, $orderLine?->total_in_cents);
            $this->assertSame(1, $orderLine->quantity);
        }

        $products = $products->fresh();

        $this->assertSame(9, $products->first()?->stock);
        $this->assertSame(9, $products->last()?->stock);
    }

    #[Test]
    public function it_fails_with_an_invalid_token(): void
    {
        $user = UserFactory::new()->createOne();
        $product = ProductFactory::new()->createOne();
        $paymentToken = PayBuddy::invalidToken();

        $testResponse = $this->actingAs($user)
            ->postJson(route('order::checkout', [
                'payment_token' => $paymentToken,
                'products' => [
                    ['id' => $product->id, 'quantity' => 1],
                ],
            ]));

        $testResponse->assertStatus(422)
            ->assertJsonValidationErrors(['payment_token']);

        $this->assertSame(0, Order::query()->count());
    }
}
