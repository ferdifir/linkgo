<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVillageProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:160'],
            'location' => ['required', 'string', 'max:160'],
            'category' => ['nullable', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:3000'],
            'name' => ['nullable', 'string', 'max:120'],
            'contact' => ['nullable', 'string', 'max:160'],
            'website' => ['nullable', 'string', 'max:500'],
        ];
    }
}
