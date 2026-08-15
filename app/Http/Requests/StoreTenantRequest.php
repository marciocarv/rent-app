<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Ensure the email is unique in the users table
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ];
    }
}
