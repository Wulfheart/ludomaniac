<?php

namespace App\Forum\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ];
    }
}
