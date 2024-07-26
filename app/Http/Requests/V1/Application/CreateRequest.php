<?php

namespace App\Http\Requests\V1\Application;

use App\Http\Requests\ValidationRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'reason_rejected' => ['nullable'],
            'name' => ['required'],
            'address' => ['required'],
            'tin' => ['required'],
            'phone' => ['required'],
            'bank_requisite' => ['required'],
            'brand_name' => ['required'],
            'mxik' => ['required'],
            'contract_details' => ['required'],
            'manufactured_countries' => ['required'],
            'official_documents' => ['required', 'file', 'max:20000'],
            'at_least_country_documents' => ['required', 'file', 'max:20000'],
            'retail_documents' => ['required', 'file', 'max:20000'],
            'rent_building_documents' => ['required', 'file', 'max:20000'],
            'distributor_documents' => ['required', 'file', 'max:20000'],
            'website_documents' => ['required', 'file', 'max:20000'],
        ];
    }
}
