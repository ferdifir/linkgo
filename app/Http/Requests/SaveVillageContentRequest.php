<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveVillageContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true && $this->user()?->is_active === true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:180'],
            'summary' => ['nullable', 'string', 'max:300'],
            'body' => ['required', 'string', 'max:5000'],
            'category' => ['nullable', 'string', 'max:80'],
            'link' => ['nullable', 'url:http,https', 'max:500'],
            'imageUrl' => ['nullable', 'url:http,https', 'max:500'],
            'published' => ['required', 'boolean'],
            'sortOrder' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'publishedAt' => ['nullable', 'date_format:Y-m-d'],
            'profile' => ['nullable', 'array:address,phone,email,officeHours,headName,hamlets,rw,rt,indexYear,indexScore,indexStatus,indexSource,indexVerifiedAt,indexBasicServices,indexSocial,indexEconomic,indexEnvironment,indexAccessibility,indexGovernance'],
            'profile.address' => ['nullable', 'string', 'max:255'],
            'profile.phone' => ['nullable', 'string', 'max:40'],
            'profile.email' => ['nullable', 'email', 'max:180'],
            'profile.officeHours' => ['nullable', 'string', 'max:160'],
            'profile.headName' => ['nullable', 'string', 'max:180'],
            'profile.hamlets' => ['nullable', 'integer', 'min:0', 'max:10000'],
            'profile.rw' => ['nullable', 'integer', 'min:0', 'max:10000'],
            'profile.rt' => ['nullable', 'integer', 'min:0', 'max:10000'],
            'profile.indexYear' => ['nullable', 'integer', 'min:2025', 'max:2100'],
            'profile.indexScore' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'profile.indexStatus' => ['nullable', 'in:Mandiri,Maju,Berkembang,Tertinggal,Sangat Tertinggal'],
            'profile.indexSource' => ['nullable', 'url:http,https', 'max:500'],
            'profile.indexVerifiedAt' => ['nullable', 'date_format:Y-m-d'],
            'profile.indexBasicServices' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'profile.indexSocial' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'profile.indexEconomic' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'profile.indexEnvironment' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'profile.indexAccessibility' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'profile.indexGovernance' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
