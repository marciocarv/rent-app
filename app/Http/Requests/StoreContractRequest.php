<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\PaymentMethod;

class StoreContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Convert BRL format (1.500,00) to standard numeric format (1500.00)
        $this->merge([
            'monthly_rent' => $this->monthly_rent ? str_replace(['.', ','], ['', '.'], $this->monthly_rent) : null,
            'security_deposit' => $this->security_deposit ? str_replace(['.', ','], ['', '.'], $this->security_deposit) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'unit_id' => ['required', 'exists:units,id'],
            'tenant_id' => ['required', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'monthly_rent' => ['required', 'numeric', 'min:0'],
            'security_deposit' => ['nullable', 'numeric', 'min:0'],
            'due_day' => ['required', 'integer', 'between:1,31'],
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)]
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after' => 'The lease end date must be after the start date.',
            'unit_id.exists' => 'The selected unit is invalid.',
        ];
    }
}
