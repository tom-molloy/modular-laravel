<?php

declare(strict_types=1);

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @method mixed input(string|null $key, mixed $default = null)
 * @method \Illuminate\Support\Stringable string(string $key, mixed $default = null)
 */
class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'payment_token' => ['required', 'string'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'string'],
            'products.*.quantity' => ['required', 'numeric'],
        ];
    }
}
