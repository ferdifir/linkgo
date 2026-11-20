<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DraftVillageNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true
            && $this->user()?->is_active === true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'source' => ['required', 'string', 'max:3000'],
        ];
    }
}
