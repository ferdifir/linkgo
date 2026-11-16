<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveProjectRequest extends FormRequest
{
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
            'title' => ['required', 'string', 'max:200'],
            'location' => ['required', 'string', 'max:200'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status' => ['nullable', 'string', 'max:120'],
            'summary' => ['nullable', 'string', 'max:500'],
            'details' => ['nullable', 'string', 'max:5000'],
            'volume' => ['nullable', 'string', 'max:200'],
            'funding' => ['nullable', 'string', 'max:200'],
            'executor' => ['nullable', 'string', 'max:200'],
            'schedule' => ['nullable', 'string', 'max:200'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'spent' => ['nullable', 'integer', 'min:0'],
            'source' => ['nullable', 'string', 'max:300'],
            'sourceUrl' => ['nullable', 'url:http,https', 'max:500'],
            'published' => ['nullable', 'boolean'],
        ];
    }
}
