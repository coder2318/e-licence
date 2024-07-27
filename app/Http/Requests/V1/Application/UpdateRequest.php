<?php

namespace App\Http\Requests\V1\Application;

use App\Http\Requests\ValidationRequest;

class UpdateRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reason_rejected' => ['nullable'],
            'name' => ['nullable'],
            'address' => ['nullable'],
            'tin' => ['nullable'],
            'phone' => ['nullable'],
            'bank_requisite' => ['nullable'],
            'brand_name' => ['nullable'],
            'mxik' => ['nullable'],
            'contract_details' => ['nullable'],
            'manufactured_countries' => ['nullable'],
            'official_documents' => ['nullable', 'file', 'max:20000'],
            'at_least_country_documents' => ['nullable', 'file', 'max:20000'],
            'retail_documents' => ['nullable', 'file', 'max:20000'],
            'rent_building_documents' => ['nullable', 'file', 'max:20000'],
            'distributor_documents' => ['nullable', 'file', 'max:20000'],
            'website_documents' => ['nullable', 'file', 'max:20000'],
        ];
    }
}
