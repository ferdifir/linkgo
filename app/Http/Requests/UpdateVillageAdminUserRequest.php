<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateVillageAdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true
            && $this->user()?->is_active === true
            && $this->user()?->admin_role === 'owner';
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role' => ['required', 'in:owner,editor'],
            'active' => ['required', 'boolean'],
            'password' => ['nullable', 'string', Password::min(12), 'confirmed'],
        ];
    }
}
