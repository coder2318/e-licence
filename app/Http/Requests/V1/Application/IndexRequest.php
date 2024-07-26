<?php

namespace App\Http\Requests\V1\Application;

use App\Http\Requests\ValidationRequest;

class IndexRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable'],
            'name' => ['nullable'],
            'address' => ['nullable'],
            'tin' => ['nullable'],
            'phone' => ['nullable'],
            'bank_requisite' => ['nullable'],
            'brand_name' => ['nullable'],
            'mxik' => ['nullable'],
            'contract_details' => ['nullable'],
            'manufactured_countries' => ['nullable']
        ];
    }
}
