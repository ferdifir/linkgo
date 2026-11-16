<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveBudgetRequest extends FormRequest
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
            'year' => [
                'required', 'integer', 'min:2000', 'max:2100',
                Rule::unique('budgets', 'year')->where('village_slug', $villageSlug)->ignore($this->route('id')),
            ],
            'revenue' => ['nullable', 'integer', 'min:0'],
            'expenditure' => ['nullable', 'integer', 'min:0'],
            'financing' => ['nullable', 'integer', 'min:0'],
            'villageFund' => ['nullable', 'integer', 'min:0'],
            'villageAllocation' => ['nullable', 'integer', 'min:0'],
            'taxRevenueShare' => ['nullable', 'integer', 'min:0'],
            'retributionShare' => ['nullable', 'integer', 'min:0'],
            'realized' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'sourceUrl' => ['nullable', 'url:http,https', 'max:500'],
            'published' => ['sometimes', 'boolean'],
        ];
    }
}
