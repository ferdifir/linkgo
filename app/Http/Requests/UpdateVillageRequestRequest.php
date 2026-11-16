<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVillageRequestRequest extends FormRequest
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
        $villageSlug = (string) ($this->user()?->village_slug ?? '');

        return [
            'status' => ['required', 'in:Masuk,Ditinjau,Diproses,Selesai,Ditolak'],
            'adminNote' => ['nullable', 'string', 'max:3000'],
            'targetAt' => ['nullable', 'date_format:Y-m-d'],
            'assignedTo' => [
                'nullable', 'integer',
                Rule::exists('users', 'id')->where('is_admin', true)->where('is_active', true)->where('village_slug', $villageSlug),
            ],
        ];
    }
}
