<?php

namespace App\Http\Requests;

use App\Enums\PropertyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // We return true because our auth middleware (in routes) will handle login checks.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Informações do Imóvel
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string'],

            // Toggle Estrutural
            'is_multi_unit' => ['required', 'in:yes,no'],

            // Validação se for "Imóvel Único" (Ignora estes se for Múltiplas Unidades)
            'bedrooms' => ['exclude_if:is_multi_unit,yes', 'nullable', 'integer', 'min:0'],
            'bathrooms' => ['exclude_if:is_multi_unit,yes', 'nullable', 'integer', 'min:0'],
            'status' => ['exclude_if:is_multi_unit,yes', 'required', 'string'],

            // Validação se for "Múltiplas Unidades" (Ignora estes se for Imóvel Único)
            'units' => ['exclude_if:is_multi_unit,no', 'required', 'array'],
            'units.*.name' => ['exclude_if:is_multi_unit,no', 'required', 'string', 'max:255'],
            'units.*.bedrooms' => ['exclude_if:is_multi_unit,no', 'nullable', 'integer', 'min:0'],
            'units.*.bathrooms' => ['exclude_if:is_multi_unit,no', 'nullable', 'integer', 'min:0'],
            'units.*.status' => ['exclude_if:is_multi_unit,no', 'required', 'string'],
        ];
    }
    /**
     * Custom error messages (Optional but great for UX)
     */
    public function messages(): array
    {
        return [
            'type.in' => 'Please select a valid property type.',
        ];
    }
}
