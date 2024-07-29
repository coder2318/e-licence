<?php

namespace App\Http\Requests\V1\Action;

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
            'application_id' => ['required', 'numeric', 'exists:applications,id'],
            'signed' => ['required', 'boolean'],
            'comment' => ['nullable', 'string'],
        ];
    }
}
