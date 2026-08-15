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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            // We ensure the type is one of our allowed ENUM values from the migration
            'type' => ['required', Rule::enum(PropertyType::class)],
            'notes' => ['nullable', 'string'],
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
