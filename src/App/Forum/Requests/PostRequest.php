<?php

namespace App\Forum\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'body' => ['required', 'string'],
        ];
    }
}
