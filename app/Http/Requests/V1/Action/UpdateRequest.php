<?php

namespace App\Http\Requests\V1\Action;

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
            'comment' => ['nullable'],
        ];
    }
}
