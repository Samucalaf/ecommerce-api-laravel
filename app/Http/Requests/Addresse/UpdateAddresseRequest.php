<?php

namespace App\Http\Requests\Addresse;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddresseRequest extends FormRequest
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
                "sometimes",
                "required",
                "string",
                "max:255"
            ],
            "street" => [
                "sometimes",
                "required",
                "string",
                "max:255"
            ],
            "number" => [
                "sometimes",
                "required",
                "string",
                "max:50"
            ],
            "complement" => [
                "sometimes",
                "nullable",
                "string",
                "max:255"
            ],
            "neighborhood" => [
                "sometimes",
                "required",
                "string",
                "max:255"
            ],
            "city" => [
                "sometimes",
                "required",
                "string",
                "max:255"
            ],
            "federative_unit" => [
                "sometimes",
                "required",
                "string",
                "size:2"
            ],
            "zip_code" => [
                "sometimes",
                "required",
                "string",
                "max:20"
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
