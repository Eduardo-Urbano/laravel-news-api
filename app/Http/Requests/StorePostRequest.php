<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'tag' => 'nullable|string|max:50',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}