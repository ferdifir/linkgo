<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreVillageAdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true
            && $this->user()?->is_active === true
            && $this->user()?->admin_role === 'owner';
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->input('name')) ? trim($this->input('name')) : $this->input('name'),
            'username' => is_string($this->input('username')) ? trim($this->input('username')) : $this->input('username'),
            'email' => is_string($this->input('email')) ? mb_strtolower(trim($this->input('email'))) : $this->input('email'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'min:3', 'max:60', 'regex:/^[a-zA-Z0-9._-]+$/', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:180', Rule::unique('users', 'email')],
            'password' => ['required', 'string', Password::min(12), 'confirmed'],
        ];
    }
}
