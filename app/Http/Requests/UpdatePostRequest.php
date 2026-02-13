<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'tag' => 'nullable|string|max:50',
            'summary' => 'nullable|string|max:255',
            'content' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
        ];
    }
}