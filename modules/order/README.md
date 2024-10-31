## How this module was set up

```
dcr artisan make:model Order --factory --migration --seed --module order
dcr artisan make:model OrderLine --factory --migration --seed --module order
dcr artisan make:controller CheckoutController --module order
dcr artisan make:event OrderStarted --module order
dcr artisan make:listener SendOrderConfirmationEmail --module order
dcr artisan make:request CheckoutRequest --module order

dcr artisan make:event PaymentSucceeded --module order
dcr artisan make:event PaymentFailed --module order

dcr artisan make:listener CompleteOrder --module order
dcr artisan make:listener MarkOrderAsFailed --module order
dcr artisan make:listener NotifyUserOfPaymentFailure --module order

dcr artisan make:controller OrderController --module order

dcr artisan make:test GetOrdersTest --module order
```
