<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateProductRequest extends FormRequest
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
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'sometimes',
                'required',
                'string',
                'max:1000'
            ],
            'specifications' => [
                'sometimes',
                'required',
                'array',
            ],
            'price' => [
                'sometimes',
                'required',
                'numeric',
                'min:0',
            ],
            'slug' => [
                'sometimes',
                'required',
                'string',
                Rule::unique('products', 'slug')->ignore($this->route('product') ?? $this->route('id')),
            ],
            'stock' => [
                'sometimes',
                'nullable',
                'integer',
                'min:0',
            ],
            'category_id' => [
                'sometimes',
                'required',
                'exists:categories,id',
            ],
            'images' => [
                'sometimes',
                'nullable',
                'array',
            ]
        ];
    }
}
