<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'required',
                'string',
                'max:1000'
            ],
            'specifications' => [
                'required',
                'array',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'slug' => [
                'required',
                'string',
                'unique:products,slug',
            ],
            'stock' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'images' => [
                'nullable',
                'array',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'description.required' => 'The product description is required.',
            'specifications.required' => 'The product specifications are required.',
            'price.required' => 'The product price is required.',
            'slug.required' => 'The product slug is required.',
            'slug.unique' => 'The product slug must be unique.',
            'category_id.required' => 'The category ID is required.',
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }
}
