<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Convert BRL format (1.500,00) to standard numeric format (1500.00)
        if ($this->amount) {
            $this->merge([
                'amount' => str_replace(['.', ','], ['', '.'], $this->amount),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            // Ensure the unit exists AND belongs to the logged-in landlord
            'unit_id' => [
                'required',
                Rule::exists('units', 'id')->where('landlord_id', auth()->id())
            ],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,paid'],
        ];
    }
}
