<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetLogsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'event' => ['nullable', 'string', 'max:255'],
            'user_id' => ['nullable', 'string', 'uuid', 'max:255'],
            'from_date' => ['nullable', 'date', 'before_or_equal:to_date'],
            'to_date' => ['nullable', 'date'],

            'page' => ['integer', 'min:1'],
            'per_page' => ['integer', 'min:1', 'max:50'],
        ];
    }
}
