<?php

namespace App\Http\Requests\Category;

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
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'sometimes',
                'required',
                'string',
            ],

            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->route('category') ?? $this->route('id')),
            ],
            'is_active' => [
                'sometimes',
                'boolean',
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

            'is_active.boolean' => 'The is_active field must be true or false.',
        ];
    }
}
