<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],
            
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:categories,slug',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.max' => 'The category name may not be greater than 255 characters.',
            'description.required' => 'The category description is required.',
            'description.string' => 'The category description must be a string.',
            'slug.required' => 'The category slug is required.',
            'slug.string' => 'The category slug must be a string.',
            'slug.max' => 'The category slug may not be greater than 255 characters.',
            'slug.unique' => 'The category slug has already been taken.',
        ];
    }
}
