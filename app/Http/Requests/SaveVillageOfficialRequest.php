<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveVillageOfficialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true && $this->user()?->is_active === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:180'],
            'position' => ['required', 'string', 'max:180'],
            'imageUrl' => ['nullable', 'url:http,https', 'max:500'],
            'published' => ['required', 'boolean'],
            'sortOrder' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
