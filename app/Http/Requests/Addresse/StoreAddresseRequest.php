<?php

namespace App\Http\Requests\Addresse;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddresseRequest extends FormRequest
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
            "owner" => [
                "required",
                "string",
                "max:255"
            ],
            "street" => [
                "required",
                "string",
                "max:255"
            ],
            "number" => [
                "required",
                "string",
                "max:50"
            ],
            "complement" => [
                "nullable",
                "string",
                "max:255"
            ],
            "neighborhood" => [
                "required",
                "string",
                "max:255"
            ],
            "city" => [
                "required",
                "string",
                "max:255"
            ],
            "federation_unit" => [
                "required",
                "string",
                "size:2"
            ],
            "zip_code" => [
                "required",
                "string",
                "max:20"
            ],
            "user_id" => [
                "required",
                "exists:users,id"
            ],
        ];
    }

    public function messages(): array
    {
         return [
            'owner.required' => 'The owner field is required when provided.',
            'street.required' => 'The street field is required when provided.',
            'number.required' => 'The number field is required when provided.',
            'neighborhood.required' => 'The neighborhood field is required when provided.',
            'city.required' => 'The city field is required when provided.',
            'federative_unit.required' => 'The federative unit field is required when provided.',
            'zip_code.required' => 'The zip code field is required when provided.',
        ];
    }
}
