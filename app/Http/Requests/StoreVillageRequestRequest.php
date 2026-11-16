<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVillageRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kind' => ['required', 'in:layanan,pengaduan'],
            'title' => ['required', 'string', 'max:180'],
            'category' => ['nullable', 'string', 'max:120'],
            'name' => ['nullable', 'string', 'max:120'],
            'contact' => ['required', 'string', 'max:180'],
            'email' => ['nullable', 'required_if:notifyByEmail,1', 'email', 'max:180'],
            'notifyByEmail' => ['nullable', 'boolean'],
            'description' => ['required', 'string', 'max:3000'],
            'website' => ['nullable', 'string', 'max:500'],
        ];
    }
}
