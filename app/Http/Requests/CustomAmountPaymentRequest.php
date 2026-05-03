<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomAmountPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email:rfc,dns', 'max:255'],
            'amount' => ['required', 'numeric', 'min:5', 'max:999999.99'],
        ];
    }
}
