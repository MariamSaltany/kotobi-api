<?php

namespace App\Http\Requests\Admin\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $category = $this->route('category');
        $categoryId = $category instanceof \App\Models\Book\Category ? $category->id : $category;
        return [
            'name' => [
                'nullable', 
                'string', 
                'max:255', 
                "unique:categories,name,{$categoryId}" 
            ],
            'slug' => [
                'sometimes', 
                'string', 
                'max:255', 
                "unique:categories,slug,{$categoryId}" 
            ],
            'parent_id' => [
                'nullable', 
                'exists:categories,id',
                "not_in:{$categoryId}" 
            ],
    ];
    }
}
