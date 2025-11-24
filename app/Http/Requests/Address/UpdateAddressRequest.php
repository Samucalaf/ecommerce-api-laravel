<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'owner' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'street' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'number' => [
                'sometimes',
                'required',
                'string',
                'max:50',
            ],
            'complement' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
            'neighborhood' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'city' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'federation_unit' => [
                'sometimes',
                'required',
                'string',
                'max:2',
            ],
            'zip_code' => [
                'sometimes',
                'required',
                'string',
                'max:20',
            ],
        ];
    }
}
