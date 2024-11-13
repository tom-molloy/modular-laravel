<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product_ids' => array_keys($this->get('products')),
            'products' => array_map(fn ($quantity) => intval($quantity), $this->get('products')),
            'payment_token' => Uuid::uuid4()->toString(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_ids' => 'exists:products,id',
            'products' => 'required|array|min:1',
            'products.*' => 'int',
            'payment_token' => 'required|uuid',
        ];
    }
}
