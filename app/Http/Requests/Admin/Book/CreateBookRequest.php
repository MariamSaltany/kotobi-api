<?php

namespace App\Http\Requests\Admin\Book;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
        return [
                'title'        => 'required|string|max:255',
                'category_id'  => 'required|exists:categories,id',
                'isbn'         => 'required|string|unique:books,isbn',
                'price'        => 'required|numeric|min:0',
                'publish_year' => 'required|integer|min:1000|max:' . date('Y'),
                'stock'        => 'required|integer|min:0',
                'owner_id'     => ['required', 'exists:users,id'],
                'author_ids'   => ['nullable', 'array'],
                'author_ids.*' => ['exists:users,id', 'different:owner_id'],
                'cover'        => 'nullable|image|max:2048',
            ];
    }
}
